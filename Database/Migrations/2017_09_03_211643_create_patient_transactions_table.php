<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_patient_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type',50);
            $table->decimal('amount', 10, 2)->default(0);
            $table->integer('patient_id')->unsigned();
            $table->longText('details')->nullable();
            $table->timestamps();

//            $table->foreign('patient_id')
//                ->references('id')
//                ->on('reception_patients')
//                ->onUpdate('cascade')
//                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_transactions');
    }
}
