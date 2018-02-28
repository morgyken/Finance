<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationInsurancePaymentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('finance_evaluation_insurance_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company')->unsigned();
            $table->double('amount', 10, 2);
            $table->integer('user')->unsigned();
            $table->timestamps();
//            $table->foreign('user')->references('id')->on('users')
//                    ->onDelete('cascade')
//                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('finance_evaluation_insurance_payments');
    }

}
