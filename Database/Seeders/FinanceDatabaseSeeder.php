<?php

namespace Ignite\Finance\Database\Seeders;

use Illuminate\Database\Seeder;

class FinanceDatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GLTableSeeder::class);
        $this->call(SmartInterfaceTableSeeder::class);
        // $this->call("OthersTableSeeder");
    }

}
