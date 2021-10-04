<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReliefGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relief_goods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('field_officer_id');
            $table->unsignedBigInteger('disaster_response_id');
            $table->unsignedBigInteger('affected_resident_id');
            $table->date('date');
            $table->integer('food_packs');
            $table->integer('water');
            $table->integer('hygiene_kit');
            $table->integer('medicine');
            $table->integer('clothes');
            $table->integer('emergency_shelter_assistance');
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
        Schema::dropIfExists('relief_goods');
    }
}