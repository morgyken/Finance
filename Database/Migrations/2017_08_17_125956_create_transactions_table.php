<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_mpesa_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user')->unsigned();
            $table->string('gateway')->default('mpesa');
            $table->string('account');
            $table->string('gateway_ref')->nullable();
            $table->double('amount', 10, 2);
            $table->integer('reference')->unique();
            $table->string('transaction')->unique();
            $table->text('extra')->nullable();
            $table->string('timestamp');
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('finance_mpesa_transactions');
    }
}
