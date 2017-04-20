<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationPaymentsCardTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('finance_payments_card', function (Blueprint $column) {
            $column->increments('id');
            $column->integer('payment')->unsigned();
            $column->string('type')->nullable();
            $column->string('name')->nullable();
            $column->string('number')->nullable();
            $column->string('expiry')->nullable();
            $column->string('security')->defualt('000')->nullable();
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
        Schema::dropIfExists('finance_payments_card');
    }

}
