<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisasterResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disaster_responses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('date_started');
            $table->timestamp('date_ended')->nullable();
            $table->string('disaster_type');
            $table->string('description')->nullable();
            $table->string('photo');
            $table->timestamps();
        });

        Schema::create('affected_resident_stats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('disaster_response_id');
            $table->integer('no_of_evacuees')->default(0);
            $table->integer('no_of_non_evacuees')->default(0);
            $table->string('date');
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
        Schema::dropIfExists('affected_residents_stats');
        Schema::dropIfExists('disaster_responses');
    }
}