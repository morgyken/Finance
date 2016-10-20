<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientAccountsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('finance_patient_accounts', function(Blueprint $column) {
            $column->increments('id');
            $column->string('reference')->unique();
            $column->longText('details');
            $column->decimal('credit', 10, 2)->default(0);
            $column->decimal('debit', 10, 2)->default(0);
            $column->integer('patient')->unsigned();
            //$column->
            $column->timestamps();
            $column->foreign('patient')
                    ->references('id')
                    ->on('reception_patients')
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
        Schema::dropIfExists('finance_patient_accounts');
    }

}
