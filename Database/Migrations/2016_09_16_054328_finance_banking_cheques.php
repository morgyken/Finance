<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FinanceBankingCheques extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('finance_banking_cheques', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('banking')->unsigned();
            $table->string('holder_name');
            $table->string('cheque_number');
            $table->date('cheque_date');
            $table->string('bank');
            $table->string('branch');
            $table->timestamps();
            $table->foreign('banking')->references('id')->on('finance_banking')
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
        Schema::drop('finance_banking_cheques');
    }

}
