<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancesmartexchangefilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_smart_exchange_files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Global_ID');
            $table->string('Member_Nr');
            $table->integer('Admit_ID')->unsigned()->default(0);
            $table->integer('Progress_Flag')->unsigned()->default(0);
            $table->string('Rejection_Reason')->nullable();
            $table->integer('Exchange_Type')->unsigned()->default(0);
            $table->integer('InOut_Type')->default(1)->unsigned();
            $table->string('Location_ID');
            $table->dateTime('Smart_Date');
            $table->binary('Smart_File');
            $table->dateTime('Exchange_Date');
            $table->binary('Exchange_File');
            $table->dateTime('Result_Date');
            $table->binary('Result_File');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finance_smart_exchange_files');
    }
}
