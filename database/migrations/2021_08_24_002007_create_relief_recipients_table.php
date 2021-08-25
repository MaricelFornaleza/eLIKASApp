<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReliefRecipientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relief_recipients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('family_code')->nullable();
            $table->integer('no_of_members');
            $table->string('address');
            $table->string('recipient_type');
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
        Schema::dropIfExists('relief_recipients');
    }
}
