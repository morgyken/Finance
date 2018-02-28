<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryGlTransactionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('finance_gl_transactions', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('account')->unsigned();
            $table->string('type');
            $table->decimal('amount', 10, 2);
            $table->timestamps();
//            $table->foreign('account')->references('id')->on('finance_gl_accounts')
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
        Schema::dropIfExists('finance_gl_transactions');
    }

}
