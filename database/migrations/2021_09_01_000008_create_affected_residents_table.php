<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffectedResidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affected_residents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('family_code');
            $table->unsignedBigInteger('disaster_response_id');
            $table->string('affected_resident_type');
            $table->timestamps();

            $table->foreign('disaster_response_id')->references('id')->on('disaster_responses')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('affected_residents');
    }
}