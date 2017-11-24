<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJambopayPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_jambo_pay_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('payment_id')->nullable();
            $table->string('Code');
            $table->string('RevenueStreamID');
            $table->string('BillNumber');
            $table->string('CustomerNames')->nullable();
            $table->string('PhoneNumber');
            $table->integer('PaymentStatus')->default(0);
            $table->string('PaymentStatusName')->nullable();
            $table->double('Amount', 10, 2)->default(0);
            $table->string('Narration')->nullable();
            $table->boolean('processed')->default(false);
            $table->boolean('complete')->default(false);
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
        Schema::dropIfExists('finance_jambo_pay_payments');
    }
}
