<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvacuationCentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evacuation_centers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('address');
            $table->float('latitude');
            $table->float('longitude');
            $table->integer('capacity');
            $table->string('characteristics');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('stock_levels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('evacuation_center_id');
            $table->integer('food_packs');
            $table->integer('water');
            $table->integer('hygiene_kit');
            $table->integer('medicine');
            $table->integer('clothes');
            $table->integer('emergency_shelter_assistance');
            $table->timestamps();

            $table->foreign('evacuation_center_id')->references('id')->on('evacuation_centers')
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
        Schema::dropIfExists('evacuation_centers');
        Schema::dropIfExists('stock_levels');
    }
}
