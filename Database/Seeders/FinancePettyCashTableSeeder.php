<?php

use Illuminate\Database\Seeder;

class FinancePettyCashTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('finance_petty_cash')->insert([
            'amount' => 0.00,
        ]);
    }

}
