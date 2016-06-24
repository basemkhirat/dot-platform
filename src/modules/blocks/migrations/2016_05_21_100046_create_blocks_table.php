<?php

use Illuminate\Database\Migrations\Migration;

class CreateBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocks', function ($table) {

            $table->increments('id');
            $table->string("name")->index();
            $table->string("slug")->index();
            $table->string("type")->index();
            $table->integer("limit")->index();
            $table->string("lang")->index();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('blocks');
    }
}
