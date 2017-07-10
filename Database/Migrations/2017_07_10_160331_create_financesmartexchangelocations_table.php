<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancesmartexchangelocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_smart_exchange_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('SL_ID')->nullable();
            $table->string('SP_ID')->nullable();
            $table->string('Location_Description')->nullable();
            $table->string('Group_Practice_Number')->nullable();
            $table->char('Country_Code', 3);
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
        Schema::dropIfExists('finance_smart_exchange_locations');
    }
}
