<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMpesaCallbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_mpesa_callbacks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('msisdn');
            $table->double('amount', 10, 2);
            $table->dateTime('mpesa_trx_date');
            $table->string('mpesa_trx_id');
            $table->string('trx_status');
            $table->string('return_code');
            $table->text('description');
            $table->string('merchant_transaction_id')->unique();
            $table->boolean('added')->default(false);
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
        Schema::dropIfExists('finance_mpesa_callbacks');
    }
}
