<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsuranceCopaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_insurance_copay', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('visit_id');
            $table->unsignedInteger('scheme_id');
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('procedure_id');
            $table->unsignedInteger('patient_id');
            $table->double('amount', 10, 2);
            $table->boolean('paid')->default(false);
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
        Schema::dropIfExists('finance_insurance_copay');
    }
}
