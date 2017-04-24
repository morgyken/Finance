<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemovedBillsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('finance_removed_bills', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('visit')->unsigned()->nullable();
            $table->integer('investigation')->unsigned()->nullable();
            $table->integer('dispensing')->unsigned()->nullable();
            $table->integer('sale')->unsigned()->nullable();
            $table->string('reason')->nullable();
            $table->integer('user')->unsigned();
            $table->integer('amount')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('visit')
                    ->references('id')
                    ->on('evaluation_visits')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->foreign('investigation')
                    ->references('id')
                    ->on('evaluation_investigations')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->foreign('dispensing')
                    ->references('id')
                    ->on('inventory_evaluation_dispensing')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->foreign('sale')
                    ->references('id')
                    ->on('inventory_batch_sales')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->foreign('user')
                    ->references('id')
                    ->on('users')
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
        Schema::dropIfExists('finance_removed_bills');
    }

}
