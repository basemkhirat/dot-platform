<?php

use Illuminate\Database\Migrations\Migration;

class CreatePollsTable extends Migration
{

    public function up()
    {

        Schema::create('polls', function ($table) {
            $table->increments('id');
            $table->integer('parent')->default(0)->index();
            $table->string('title')->index();
            $table->string('slug')->index();
            $table->integer('status')->default(0)->index();
            $table->integer('image_id')->default(0);
            $table->integer('user_id')->default(0)->index();
            $table->integer('votes')->default(0)->index();
            $table->string('lang')->index();
            $table->timestamps();
        });

    }

    public function down()
    {

        Schema::dropIfExists('polls');

    }

}