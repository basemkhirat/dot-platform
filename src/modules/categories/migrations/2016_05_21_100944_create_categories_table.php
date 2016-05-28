<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable("categories")) {

            Schema::create('categories', function ($table) {

                $table->increments('id');
                $table->integer("parent")->index();
                $table->string("name")->index();
                $table->string("slug")->index();
                $table->integer("image_id")->index();
                $table->integer("user_id")->index();
                $table->timestamps();

            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('categories');
    }
}
