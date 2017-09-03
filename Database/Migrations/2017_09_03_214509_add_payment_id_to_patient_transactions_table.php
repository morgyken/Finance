<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentIdToPatientTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finance_patient_transactions', function (Blueprint $table) {
            $table->integer('payment_id')
                ->unsigned()
                ->after('amount')
                ->nullable();

            $table->foreign('payment_id')
                ->references('id')
                ->on('finance_evaluation_payments')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_transactions', function (Blueprint $table) {
        });
    }
}
