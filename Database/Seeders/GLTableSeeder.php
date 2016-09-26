<?php

/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: Collabmed Health Platform
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */

namespace Ignite\Finance\Database\Seeders;

use Ignite\Finance\Entities\FinanceAccountGroup;
use Ignite\Finance\Entities\FinanceAccountType;
use Illuminate\Database\Seeder;

class GLTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $types = ['Profit & Loss', 'Balance Sheet', 'Expenses'];
        foreach ($types as $type) {
            $in = new FinanceAccountType;
            $in->name = $type;
            $in->description = $type;
            $in->save();
        }
        $groups = ['Liabilities', 'Capital', 'Income', 'Assets', 'Costs and Expenses'];
        foreach ($groups as $group) {
            $in = new FinanceAccountGroup;
            $in->name = $group;
            $in->type = mt_rand(1, 3);
            $in->description = $group;
            $in->save();
        }
    }

}
