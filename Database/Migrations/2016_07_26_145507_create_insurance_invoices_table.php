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
            $table->integer('visit')->unsigned()->nullable();
            $table->integer('receipt')->unsigned()->nullable();
            $table->integer('payment')->unsigned()->nullable();
            $table->date('invoice_date')->nullable();
            $table->string('dispatch')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();

//            $table->foreign('visit')->references('id')->on('evaluation_visits')
//                    ->onUpdate('cascade')
//                    ->onDelete('cascade');
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
