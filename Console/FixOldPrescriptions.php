<?php

namespace Ignite\Finance\Console;

use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Evaluation\Entities\Visit;
use Ignite\Finance\Entities\InsuranceInvoice;
use Ignite\Inventory\Entities\InventoryProducts;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class FixOldPrescriptions extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'finance:fix-prescription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix prescriptions.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->info("Enumerating list");
        $list = Prescriptions::whereDoesntHave('payment')->get();
        $this->warn("Found stray prescriptions -- " . $list->count());
        foreach ($list as $prescription) {
            $visit = $prescription->visit;
            $cost = get_price_drug(Visit::find($visit),
                InventoryProducts::find($prescription->drug));
            $attributes = [
                'price' => $cost,
                'cost' => $cost,
                'quantity' => 1,
            ];
            $prescription->payment()->create($attributes);
            $this->info("Working....");
        }
        $this->info("Checking something else...");
        $_ins = InsuranceInvoice::all();
        foreach ($_ins as $one) {
            if (empty($one->scheme_id)) {
                $one->company_id = @$one->visits->patient_scheme->schemes->company;
                $one->scheme_id = @$one->visits->patient_scheme->schemes->id;
                $one->save();
            }
            if (empty($one->visit) || empty($one->company_id) || empty($one->scheme_id)) {
                $one->delete();
            }
        }
        $this->info("Done!, Thank you");
    }

}
