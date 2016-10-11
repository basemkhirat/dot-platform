<?php

use Illuminate\Database\Migrations\Migration;

class CreateGalleriesMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('galleries_media', function ($table) {

            $table->integer("gallery_id")->index();
            $table->integer("media_id")->index();
            $table->integer("order")->default(0)->index();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('galleries_media');
    }
}
