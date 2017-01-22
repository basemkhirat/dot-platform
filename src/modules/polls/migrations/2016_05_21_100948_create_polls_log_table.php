<?php

use Illuminate\Database\Migrations\Migration;

class CreatePollsLogTable extends Migration
{

    public function up()
    {

        Schema::create('polls_log', function ($table) {
            $table->integer("poll_id")->index();
            $table->string("ip");
            $table->timestamps();
        });

    }

    public function down()
    {

        Schema::dropIfExists('polls_log');

    }

}