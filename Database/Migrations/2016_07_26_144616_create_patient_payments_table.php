<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientPaymentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('finance_payments', function(Blueprint $column) {
            $column->increments('id');
            $column->string('receipt')->unique();
            $column->integer('patient')->unsigned();
            $column->integer('scheme')->unsigned()->nullable();
            $column->binary('InsuranceAmount')->nullable();
            //cash
            $column->binary('CashAmount')->nullable();
            ;
            //mpesa
            $column->binary('MpesaReference')->nullable();
            $column->binary('MpesaAmount')->nullable();
            $column->binary('MpesaNumber')->nullable();
            $column->binary('paybil')->nullable();
            $column->binary('account')->nullable();
            //cheque
            $column->binary('ChequeName')->nullable();
            $column->binary('ChequeAmount')->nullable();
            $column->binary('ChequeNumber')->nullable();
            $column->binary('ChequeDate')->nullable();
            $column->binary('ChequeBank')->nullable();
            $column->binary('ChequeBankBranch')->nullable();
            //credit cards
            $column->binary('CardType')->nullable();
            $column->binary('CardName')->nullable();
            $column->binary('CardNumber')->nullable();
            $column->binary('CardExpiry')->nullable();
            $column->binary('CardSecurity')->nullable();
            $column->binary('CardAmount')->nullable();
            $column->text('description')->nullable();

            $column->integer('user')->unsigned();

            $column->timestamps();

            $column->foreign('patient')
                    ->references('id')
                    ->on('reception_patients')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $column->foreign('user')->references('id')->on('users')
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
        Schema::drop('finance_payments');
    }

}
