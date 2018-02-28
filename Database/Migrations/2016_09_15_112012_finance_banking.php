<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FinanceBanking extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('finance_banking', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('bank')->unsigned();
            $table->integer('account')->unsigned();
            $table->integer('user')->unsigned();
            $table->decimal('amount', 10, 2);
            $table->string('type');
            $table->string('mode');
            $table->timestamps();
//            $table->foreign('user')->references('id')->on('users')
//                    ->onDelete('cascade')
//                    ->onUpdate('cascade');
//            $table->foreign('bank')->references('id')->on('finance_banks')
//                    ->onDelete('cascade')
//                    ->onUpdate('cascade');
//            $table->foreign('account')->references('id')->on('finance_bank_accounts')
//                    ->onDelete('cascade')
//                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('finance_banking');
    }

}
