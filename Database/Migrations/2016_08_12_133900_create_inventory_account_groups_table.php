<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryAccountGroupsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('finance_gl_account_groups', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('type')->unsigned();
            $table->string('name');
            $table->longText('description');
            $table->timestamps();
//            $table->foreign('type')->references('id')->on('finance_gl_account_types')
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
        Schema::dropIfExists('finance_gl_account_groups');
    }

}
