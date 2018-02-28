<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationPaymentsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_evaluation_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('receipt')->unique();
            $table->integer('patient')->unsigned()->nullable();
            $table->integer('user')->unsigned();
            $table->integer('visit')->unsigned()->nullable();
            $table->integer('sale')->unsigned()->nullable();
            $table->boolean('deposit')->default(false);
            $table->string('dispensing')->nullable();
            $table->timestamps();

//            $table->foreign('patient')
//                ->references('id')
//                ->on('reception_patients')
//                ->onUpdate('cascade')
//                ->onDelete('cascade');
//
//            $table->foreign('user')
//                ->references('id')
//                ->on('users')
//                ->onUpdate('cascade')
//                ->onDelete('cascade');
//
//            $table->foreign('visit')
//                ->references('id')
//                ->on('evaluation_visits')
//                ->onUpdate('cascade')
//                ->onDelete('cascade');

//            $table->foreign('sale')
//                ->references('id')
//                ->on('inventory_batch_sales')
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
        Schema::dropIfExists('finance_evaluation_payments');
    }

}
