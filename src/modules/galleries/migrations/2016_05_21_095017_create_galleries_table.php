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
            $table->string("author")->nullable()->index();
            $table->string("lang")->index();
            $table->integer("user_id")->default(0)->index();
            $table->timestamp('created_at')->nullable()->index();
            $table->timestamp('updated_at')->nullable()->index();

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
