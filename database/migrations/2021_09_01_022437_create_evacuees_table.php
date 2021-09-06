<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvacueesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evacuees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('relief_recipient_id');
            $table->timestamp('date_admitted');
            $table->timestamp('date_discharged')->nullable();
            $table->unsignedBigInteger('evacuation_center_id');
            $table->timestamps();

            $table->foreign('relief_recipient_id')->references('id')->on('relief_recipients')
                ->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('evacuees');
    }
}