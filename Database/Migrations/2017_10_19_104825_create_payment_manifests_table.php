<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentManifestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_payment_manifests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->default('cash');
            $table->unsignedInteger('visit_id');
            $table->unsignedInteger('patient_id');
            $table->boolean('has_meds')->default(false);
            $table->double('amount', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finance_payment_manifests');
    }
}
