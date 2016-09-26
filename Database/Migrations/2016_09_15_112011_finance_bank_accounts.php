<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FinanceBankAccounts extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('finance_bank_accounts', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('bank')->unsigned();
            $table->string('name')->nullable();
            $table->string('number');
            $table->decimal('balance', 10, 2);
            $table->timestamps();
            $table->foreign('bank')->references('id')->on('finance_banks')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('finance_bank_accounts');
    }

}
