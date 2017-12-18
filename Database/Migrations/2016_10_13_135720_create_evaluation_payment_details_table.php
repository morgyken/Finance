<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationPaymentDetailsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_evaluation_payment_details', function (Blueprint $column) {
            $column->increments('id');
            $column->integer('payment')->unsigned();
            $column->integer('investigation')->unsigned();
            $column->integer('cs_id')->nullable()->unsigned();
            $column->integer('visit')->unsigned()->nullable();
            $column->double('cost', 10, 2)->nullable();
            $column->double('price', 10, 2);
            $column->text('description')->nullable();
            $column->timestamps();

            $column->foreign('payment')->references('id')->on('finance_evaluation_payments')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $column->foreign('investigation')->references('id')->on('evaluation_investigations')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finance_evaluation_payment_details');
    }

}
