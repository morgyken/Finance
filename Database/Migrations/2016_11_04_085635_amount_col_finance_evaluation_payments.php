<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AmountColFinanceEvaluationPayments extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('finance_evaluation_payments', function ($table) {
            $table->decimal('amount', 10, 2)->nullable()->after('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('finance_evaluation_payments', function ($table) {
            $table->dropColumn('amount');
        });
    }

}
