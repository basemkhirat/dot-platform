<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("posts", function ($table) {
            $table->increments('id');
            $table->string('title')->index();
            $table->string('slug')->unique();
            $table->string('excerpt')->nullable()->index();
            $table->text('content')->nullable();
            $table->integer('image_id')->index();
            $table->integer('media_id')->index();
            $table->integer('user_id')->index();
            $table->integer('status')->index();
            $table->string("format")->index();
            $table->string("lang")->index();
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
        Schema::drop('posts');
    }
}
