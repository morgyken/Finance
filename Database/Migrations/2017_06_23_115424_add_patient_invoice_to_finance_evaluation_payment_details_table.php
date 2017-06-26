<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPatientInvoiceToFinanceEvaluationPaymentDetailsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('finance_evaluation_payment_details', function (Blueprint $table) {
            $table->integer('patient_invoice')
                    ->unsigned()
                    ->nullable()
                    ->after('visit');
            $table->integer('investigation')->unsigned()->nullable()->change();
            $table->decimal('price', 10, 2)->nullable()->change();

            $table->foreign('patient_invoice')
                    ->references('id')->on('finance_patient_invoices')
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
        Schema::table('finance_evaluation_payment_details', function (Blueprint $table) {
            dropCollumn('patient_invoice');
        });
    }

}
