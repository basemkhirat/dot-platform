<?php

use Illuminate\Database\Migrations\Migration;

class CreatePollsTagsTable extends Migration
{

    public function up()
    {

        Schema::create('polls_tags', function ($table) {
            $table->integer("poll_id")->index();
            $table->integer("tag_id")->index();
        });

    }

    public function down()
    {

        Schema::dropIfExists('polls_tags');

    }

}