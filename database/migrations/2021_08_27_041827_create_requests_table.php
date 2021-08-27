<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('disaster_response_id');
            $table->unsignedBigInteger('camp_manager_id');
            $table->unsignedBigInteger('courier_id')->nullable();
            $table->date('date');
            $table->integer('food_packs');
            $table->integer('water');
            $table->integer('hygiene_kit');
            $table->integer('medicine');
            $table->integer('clothes');
            $table->integer('emergency_shelter_assistance');
            $table->text('note')->nullable();
            $table->string('status');
            $table->timestamps();

            $table->foreign('disaster_response_id')->references('id')->on('disaster_responses')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('camp_manager_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('courier_id')->references('id')->on('users')
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
        Schema::dropIfExists('requests');
    }
}
