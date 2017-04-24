<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemovedBillsDetailsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('finance_removed_bill_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('batch')->unsigned();
            $table->integer('investigation')->unsigned()->nullable();
            $table->integer('product')->unsigned()->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('amount')->unsigned();
            $table->timestamps();


            $table->foreign('batch')->references('id')
                    ->on('finance_removed_bills')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->foreign('investigation')->references('id')
                    ->on('evaluation_investigations')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->foreign('product')->references('id')
                    ->on('inventory_products')
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
        Schema::dropIfExists('finance_removed_bills_details');
    }

}
