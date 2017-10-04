<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePaymentDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finance_evaluation_payment_details', function (Blueprint $table) {
            $table->unsignedInteger('prescription_id')->nullable()->after('investigation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finance_evaluation_payment_details', function (Blueprint $table) {
            $table->dropColumn('prescription_id');
        });
    }
}
