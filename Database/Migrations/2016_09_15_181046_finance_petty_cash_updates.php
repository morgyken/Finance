<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FinancePettyCashUpdates extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('finance_petty_cash_updates', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user')->unsigned();
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('type'); //widthrawal or deposit
            $table->string('reason')->nullable();
            $table->timestamps();
            $table->foreign('user')->references('id')->on('users')
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
        Schema::dropIfExists('finance_petty_cash_updates');
    }

}
