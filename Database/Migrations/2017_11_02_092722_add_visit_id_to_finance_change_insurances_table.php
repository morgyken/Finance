<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVisitIdToFinanceChangeInsurancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try{
            Schema::table('finance_change_insurances', function (Blueprint $table) {
                $table->integer('visit_id')->unsigned();
//                $table->foreign('visit_id')
//                    ->references('id')
//                    ->on('evaluation_visits')
//                    ->onUpdate('cascade')
//                    ->onDelete('cascade');
            });
        }catch (\Exception $e){

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finance_change_insurances', function (Blueprint $table) {

        });
    }
}
