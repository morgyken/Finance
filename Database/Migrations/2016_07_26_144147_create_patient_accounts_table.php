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
        Schema::create('finance_patient_accounts', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('patient')->unsigned();
            $table->decimal('balance', 10, 2);
            //$column->
            $table->timestamps();
//            $table->foreign('patient')
//                    ->references('id')
//                    ->on('reception_patients')
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
        Schema::dropIfExists('finance_patient_accounts');
    }

}
