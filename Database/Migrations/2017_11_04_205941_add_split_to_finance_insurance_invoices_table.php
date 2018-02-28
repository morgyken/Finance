<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSplitToFinanceInsuranceInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finance_insurance_invoices', function (Blueprint $table) {
            $table->unsignedInteger('split_id')->before('created_at')->nullable();
//            $table->foreign('split_id');
//                ->references('id')
//                ->on('finance_split_insurances')
//                ->onUpdate('cascade')
//                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finance_insurance_invoices', function (Blueprint $table) {

        });
    }
}
