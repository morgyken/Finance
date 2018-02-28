<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanceSplitInsuranceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_split_insurance_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned();
            $table->integer('visit_id')->unsigned();
            $table->integer('prescription_id')->unsigned()->nullable();
            $table->integer('investigation_id')->unsigned()->nullable();
            $table->string('mode')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();

//            $table->foreign('visit_id')
//                ->references('id')
//                ->on('evaluation_visits')
//                ->onUpdate('cascade')
//                ->onDelete('cascade');
//
//            $table->foreign('parent_id')
//                ->references('id')
//                ->on('finance_split_insurances')
//                ->onUpdate('cascade')
//                ->onDelete('cascade');
//
//            $table->foreign('prescription_id')
//                ->references('id')
//                ->on('evaluation_prescriptions')
//                ->onUpdate('cascade')
//                ->onDelete('cascade');
//
//            $table->foreign('investigation_id')
//                ->references('id')
//                ->on('evaluation_investigations')
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
        Schema::dropIfExists('finance_split_insurance_items');
    }
}
