<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavigationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navigations', function ($table) {
            $table->increments('id');
            $table->string("name")->index();
            $table->string("link")->index()->nullable();
            $table->integer("parent")->default(0);
            $table->integer("order")->default(0);
            $table->string("type")->index()->nullable();
            $table->integer("type_id")->index()->default(0);
            $table->integer("menu")->index()->default(0);
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
        Schema::drop('navigations');
    }
}