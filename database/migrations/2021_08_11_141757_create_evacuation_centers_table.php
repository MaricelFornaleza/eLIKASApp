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
            $table->unsignedBigInteger('camp_manager_id')->nullable();
            $table->string('name')->unique();
            $table->string('address');
            $table->float('latitude');
            $table->float('longitude');
            $table->integer('capacity');
            $table->string('characteristics');
            $table->timestamps();

        });

        Schema::create('stock_levels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('evacuation_center_id');
            $table->integer('food_packs')->default(0);
            $table->integer('water')->default(0);
            $table->integer('hygiene_kit')->default(0);
            $table->integer('medicine')->default(0);
            $table->integer('clothes')->default(0);
            $table->integer('emergency_shelter_assistance')->default(0);
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
        Schema::drop('stock_levels');
        Schema::dropIfExists('evacuation_centers');
    }
}
