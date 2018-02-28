<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInvestigationToFinancePatientInvoiceDetailsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('finance_patient_invoice_details', function (Blueprint $table) {
            $table->integer('investigation_id')
                    ->after('invoice_id')
                    ->unsigned()
                    ->nullable();
            $table->integer('dispensing_id')
                    ->after('investigation_id')
                    ->unsigned()
                    ->nullable();

//            $table->foreign('investigation_id')
//                    ->references('id')
//                    ->on('evaluation_investigations')
//                    ->onDelete('cascade')
//                    ->onUpdate('cascade');
//
//            $table->foreign('dispensing_id')
//                    ->references('id')
//                    ->on('inventory_evaluation_dispensing')
//                    ->onDelete('cascade')
//                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('finance_patient_invoice_details', function (Blueprint $table) {
            dropColumn(['investigation_id', 'dispensing_id']);
        });
    }

}
