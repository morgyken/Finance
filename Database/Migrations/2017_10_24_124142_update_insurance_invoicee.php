<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInsuranceInvoicee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finance_insurance_invoices', function (Blueprint $table) {
            $table->unsignedInteger('scheme_id')->nullable()->after('visit');
            $table->unsignedInteger('company_id')->nullable()->after('visit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('finance_insurance_invoices', function (Blueprint $table) {
//            $table->dropColumn('company_id');
//            $table->dropColumn('scheme_id');
//        });
    }
}
