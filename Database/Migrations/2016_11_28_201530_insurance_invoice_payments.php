<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsuranceInvoicePayments extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('finance_insurance_invoice_payments', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('insurance_invoice')->unsigned();
            $table->integer('user')->unsigned();
            $table->decimal('amount', 10, 2);
            $table->integer('batch')->unsigned()->nullable();
            $table->string('mode')->nullable();
            $table->timestamps();
            $table->foreign('user')->references('id')->on('users')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->foreign('insurance_invoice')->references('id')->on('finance_insurance_invoices')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->foreign('batch')->references('id')->on('finance_evaluation_insurance_payments')
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
        Schema::dropIfExists('finance_insurance_invoice_payments');
    }

}
