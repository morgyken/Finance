<?php

namespace Ignite\Finance\Console;

use Ignite\Evaluation\Entities\Visit;
use Ignite\Finance\Entities\PaymentManifest;
use Ignite\Settings\Entities\Schemes;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class PreparePayments extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'finance:prepare-payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delegate payment processing to some job.';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $start = microtime(true);
        $this->info("Enumerating lists");
        /** @var Visit[] $visit_list */
        $visit_list = Visit::where(function (Builder $query) {
            $query->wherePaymentMode('cash')
                ->where(function (Builder $query) {
                    $query->where(function (Builder $query) {
                        $query->whereHas('investigations', function ($q3) {
                            $q3->doesntHave('payments');
                            $q3->doesntHave('removed_bills');
                        });
//                        $query->orWhereHas('dispensing', function ($q) {
//                            $q->doesntHave('removed_bills');
//                            $q->whereHas('details', function ($qd) {
//                                $qd->whereStatus(0);
//                            });
//                        });
                        $query->orWhere(function (Builder $query) {
                            $query->whereHas('prescriptions.payment', function (Builder $query) {
                                $query->wherePaid(false);
                            })->orWhereHas('prescriptions', function (Builder $builder) {
                                $builder->whereDoesntHave('payment');
                            });
                        });
                    });
                })
                ->orWhere(function (Builder $query) {
                    $query->whereHas('to_cash', function (Builder $query) {
                        $query->whereMode('cash');
                    });
                });
        })->orWhere(function (Builder $query) {
            $query->wherePaymentMode('insurance');
        })->orderBy('created_at', 'asc')
            ->get()
            ->reject(function ($value) {
                return empty($value->unpaid_amount);
            });
        $worker = 0;
        PaymentManifest::whereNotIn('visit_id', $visit_list->pluck('id'))->delete();
        foreach ($visit_list as $visit) {
            /** @var PaymentManifest $one */
            $one = PaymentManifest::firstOrNew(['visit_id' => $visit->id]);
            $one->patient_id = $visit->patient;
            $one->type = $visit->payment_mode;
            $one->amount = $visit->unpaid_amount;
            $one->has_meds = patient_has_pharmacy_bill($visit);
            if ($one->type === 'insurance') {
                $one->company_id = @$visit->patient_scheme->schemes->company;
                $one->scheme_id = @$visit->patient_scheme->schemes->id;
            }
            $one->save();
            $worker++;
        }
        $this->info("Updated - " . $worker);
        $time = microtime(true) - $start;
        $this->warn("Script took - " . $time);
    }

}
