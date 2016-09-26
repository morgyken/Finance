<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsuranceInvoicesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('finance_insurance_invoices', function(Blueprint $table) {
            $table->increments('id');
            $table->string('invoice_no')->unique();
            $table->integer('payment')->unsigned();
            $table->date('invoice_date')->nullable();
            $table->string('dispatch')->nullable();
            $table->integer('status')->default(1);
            //  $table->primary('invoice_no');
            /*     $table->foreign('payment')->references('id')->on('patient_payments')
              ->onDelete('cascade')
              ->onUpdate('cascade'); */
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('finance_insurance_invoices');
    }

}
