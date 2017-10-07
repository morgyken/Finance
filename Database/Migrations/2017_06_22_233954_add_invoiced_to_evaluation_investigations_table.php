<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInvoicedToEvaluationInvestigationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('evaluation_investigations', function (Blueprint $table) {
            $table->unsignedInteger('invoiced')->after('ordered')->default(false);
        });
        Schema::table('inventory_evaluation_dispensing_details', function (Blueprint $table) {
            $table->unsignedInteger('invoiced')->after('status')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('evaluation_investigations', function (Blueprint $table) {
            dropColumn('invoiced');
        });
        Schema::table('inventory_evaluation_dispensing_details', function (Blueprint $table) {
            dropColumn('invoiced');
        });
    }

}
