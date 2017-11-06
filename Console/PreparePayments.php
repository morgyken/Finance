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
     * @var int
     */
    private $worker = 0;


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
                        $query->orWhere(function (Builder $query) {
                            $query->whereHas('prescriptions.payment', function (Builder $query) {
                                $query->wherePaid(false);
                            });
                        });
                    });
                })
                ->orWhere(function (Builder $query) {
                    $query->whereHas('to_cash', function (Builder $query) {
                        $query->whereMode('cash');
                        $query->wherePaid(false);
                    });
                });
        })
            ->orderBy('created_at')
            ->orWhereHas('copay', function (Builder $query) {
                $query->whereNull('payment_id');
            })
            ->get()
            ->reject(function ($value) {
                return empty($value->unpaid_cash);
            });
        $this->add_visit($visit_list, 'cash');

        $visit_list = Visit::where(function (Builder $query) {
            $query->where(function (Builder $query) {
                $query->wherePaymentMode('insurance');
            });
            $query->orWhere(function (Builder $query) {
                $query->whereHas('to_cash', function (Builder $query) {
                    $query->whereMode('insurance');
                    $query->wherePaid(false);
                });
            });
        })->orderBy('created_at', 'asc')
            ->get()
            ->reject(function ($value) {
                return empty($value->unpaid_insurance);
            });
        $this->add_visit($visit_list, 'insurance');
        $this->info("Updated - " . $this->worker);
        $time = microtime(true) - $start;
        $this->warn("Script took - " . $time);
    }

    private function add_visit($visit_list, $mode)
    {
        PaymentManifest::whereType($mode)->whereNotIn('visit_id', $visit_list->pluck('id'))->delete();
        foreach ($visit_list as $visit) {
            /** @var PaymentManifest $one */
            $one = PaymentManifest::firstOrNew(['visit_id' => $visit->id, 'type' => $mode]);
            $one->patient_id = $visit->patient;
//            $one->type = $visit->payment_mode;
            $one->amount = $visit->{"unpaid_" . $mode};
            $one->has_meds = patient_has_pharmacy_bill($visit);
            if ($mode === 'insurance') {
                $one->company_id = @$visit->patient_scheme->schemes->company;
                $one->scheme_id = @$visit->patient_scheme->schemes->id;
            }
            $one->date = $visit->created_at->toDateString();
            $one->save();
            $this->worker++;
        }
    }
}
