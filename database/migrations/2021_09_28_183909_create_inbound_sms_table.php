<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInboundSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inbound_sms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('time_sent');
            $table->string('destination_address');
            $table->string('sender_address');
            $table->string('message');
            $table->string('resource_url');
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
        Schema::dropIfExists('inbound_sms');
    }
}