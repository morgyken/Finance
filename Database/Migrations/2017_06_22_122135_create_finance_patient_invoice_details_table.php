<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancePatientInvoiceDetailsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('finance_patient_invoice_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_id')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->string('item_name');
            $table->string('item_type')->nullable();
            $table->decimal('amount');
            $table->date('service_date')->nullable();
            $table->timestamps();

            $table->foreign('invoice_id')
                    ->references('id')
                    ->on('finance_patient_invoices')
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
        Schema::dropIfExists('finance_patient_invoice_details');
    }

}
