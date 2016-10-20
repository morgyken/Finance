<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BillDispatches extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('finance_bill_dispatches', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('insurance_invoice')->unsigned();
            $table->integer('user')->unsigned();
            $table->decimal('amount', 10, 2);
            $table->timestamps();
            $table->foreign('user')->references('id')->on('users')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->foreign('insurance_invoice')->references('id')->on('insurance_invoices')
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
        Schema::dropIfExists('finance_bill_dispatches');
    }

}
