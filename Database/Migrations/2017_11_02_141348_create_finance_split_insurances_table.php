<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanceSplitInsurancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_split_insurances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('visit_id')->unsigned();
            $table->integer('scheme')->unsigned()->nullable();
            $table->boolean('status')->default(false);
            $table->integer('user_id')->unsigned()->nullable();
            $table->timestamps();

//            $table->foreign('visit_id')
//                ->references('id')
//                ->on('evaluation_visits')
//                ->onUpdate('cascade')
//                ->onDelete('cascade');
//
//            $table->foreign('scheme')
//                ->references('id')
//                ->on('reception_patient_schemes')
//                ->onUpdate('cascade')
//                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finance_split_insurances');
    }
}
