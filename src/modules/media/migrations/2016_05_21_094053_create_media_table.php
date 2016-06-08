<?php

use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('media', function ($table) {

            $table->increments('id');
            $table->string("type", 50)->index();
            $table->string("path")->index();
            $table->string("title")->index();
            $table->text("description");
            $table->timestamps();
            $table->string("provider", 50)->index();
            $table->string("provider_id")->index();
            $table->string("provider_image")->index();
            $table->integer("user_id")->index();
            $table->integer("length")->index();
            $table->string("hash")->index();

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('media');
    }
}
