<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationPaymentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('finance_evaluation_payments', function (Blueprint $column) {
            $column->increments('id');
            $column->string('receipt')->unique();
            $column->integer('patient')->unsigned();
            $column->integer('user')->unsigned();
            $column->integer('visit')->unsigned();
            $column->timestamps();

            $column->foreign('patient')
                    ->references('id')
                    ->on('reception_patients')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $column->foreign('user')
                    ->references('id')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $column->foreign('visit')
                    ->references('id')
                    ->on('evaluation_visits')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('finance_evaluation_payments');
    }

}
