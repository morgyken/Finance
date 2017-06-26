<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancePatientInvoicesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('finance_patient_invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->unsigned();
            $table->integer('user_id')->unsigned()->nullable();
            $table->decimal('amount')->nullable();
            $table->longText('description')->nullable();
            $table->enum('status', ['unpaid', 'part_paid', 'paid'])->default('unpaid');
            $table->timestamps();

            $table->foreign('patient_id')
                    ->references('id')
                    ->on('reception_patients')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('finance_patient_invoices');
    }

}
