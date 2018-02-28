<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryGlAccountsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('finance_gl_accounts', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('group')->unsigned();
            $table->string('name');
            $table->timestamps();
//            $table->foreign('group')->references('id')->on('finance_gl_account_groups')
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
        Schema::dropIfExists('finance_gl_accounts');
    }

}
