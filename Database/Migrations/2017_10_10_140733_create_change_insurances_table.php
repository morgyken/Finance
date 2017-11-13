<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChangeInsurancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_change_insurances', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('visit_id');
            $table->unsignedInteger('prescription_id')->nullable();
            $table->unsignedInteger('procedure_id')->nullable();
            $table->string('mode')->default('cash');
            $table->unsignedInteger('scheme_id')->nullable();
            $table->unsignedInteger('user_id');
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
        Schema::dropIfExists('finance_change_insurances');
    }
}
