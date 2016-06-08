<?php

use Illuminate\Database\Migrations\Migration;

class CreateGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('galleries', function ($table) {

            $table->increments('id');
            $table->string("name")->index();
            $table->string("slug")->index();
            $table->string("author")->index();
            $table->timestamps();
            $table->integer("user_id")->index();

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('galleries');
    }
}
