<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo', function (Blueprint $table) {
            $table->integer('type');
            $table->integer('post_id');
            $table->string('meta_title', 255)->nullable()->comment('40-70');
            $table->string('meta_keywords', 255)->nullable();
            $table->string('focus_keyword', 255)->nullable();
            $table->string('meta_description', 255)->nullable()->comment('156');
            $table->string('facebook_title', 255)->nullable();
            $table->string('facebook_description', 255)->nullable();
            $table->string('facebook_image', 255)->nullable();
            $table->string('twitter_title', 255)->nullable();
            $table->string('twitter_description', 255)->nullable();
            $table->string('twitter_image', 255)->nullable();
            $table->tinyInteger('robots_index')->default(2);
            $table->tinyInteger('robots_follow')->default(1);
            $table->string('robots_advanced', 255)->nullable();
            $table->tinyInteger('in_sitemap')->default(1);
            $table->double('sitemap_priority', 8, 2)->default(0.90);
            $table->string('canonical_url', 255)->nullable();
            $table->string('seo_redirect', 255)->nullable();
            $table->char('score', 3)->nullable()->comment('bad,poor,ok,good');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seo');
    }
}
