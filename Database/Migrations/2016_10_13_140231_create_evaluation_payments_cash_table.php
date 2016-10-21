<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationPaymentsCashTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('finance_payments_cash', function (Blueprint $column) {
            $column->increments('id');
            $column->integer('payment')->unsigned();
            $column->double('amount', 10, 2);
            $column->timestamps();

            $column->foreign('payment')->references('id')->on('finance_evaluation_payments')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('finance_payments_cash');
    }

}
