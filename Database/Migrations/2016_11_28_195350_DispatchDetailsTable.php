<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DispatchDetailsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('finance_bill_dispatch_details', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('insurance_invoice')->unsigned();
            $table->integer('dispatch')->unsigned();
            $table->decimal('amount', 10, 2);
            $table->timestamps();
//            $table->foreign('insurance_invoice')->references('id')->on('finance_insurance_invoices')
//                    ->onDelete('cascade')
//                    ->onUpdate('cascade');
//            $table->foreign('dispatch')->references('id')->on('finance_bill_dispatches')
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
        Schema::dropIfExists('finance_bill_dispatch_details');
    }

}
