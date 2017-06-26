<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInvoiceAmountToFinanceEvaluationPaymentDetailsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('finance_evaluation_payment_details', function (Blueprint $table) {
            $table->decimal('patient_invoice_amount', 10, 2)
                    ->after('patient_invoice')
                    ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('finance_evaluation_payment_details', function (Blueprint $table) {
            dropColumn('patient_invoice_amount');
        });
    }

}
