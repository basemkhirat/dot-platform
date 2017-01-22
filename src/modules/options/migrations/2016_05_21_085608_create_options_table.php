<?php

use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateOptionsTable
 */
class CreateOptionsTable extends Migration
{

    /**
     * default options
     * @var array
     */
    var $defaults = [
        "site_status" => "1",
        "site_email" => "dot@platform.dev",
        "site_title" => "Dot cms",
        "site_description" => "just a laravel cms",
        "site_keywords" => "",
        "site_robots" => "INDEX, FOLLOW",
        "site_author" => "dotcms",
        "offline_message" => "",
        "app.timezone" => "Etc/GMT",
        "date_format" => "relative",
        "site_logo" => "",
        "media.allowed_file_types" => "jpg,png,jpeg,bmp,gif,zip,doc,docx,rar,zip,pdf,txt,csv,xls",
        "media.max_file_size" => "23444344",
        "media.max_width" => "1200222",
        "media.cropping" => "0",
        "media.watermarking" => "0",
        "media.thumbnails" => "1",
        "media.s3_status" => "0",
        "media.s3.bucket" => "",
        "media.s3.region" => "",
        "media.s3.delete_locally" => "1",
        "site_copyrights" => "All Rights reserved © 2016",
        "site_slogan" => "",
        "sitemap_status" => "1",
        "sitemap_ping" => "1",
        "sitemap_google_ping" => "1",
        "sitemap_path" => "",
        "sitemap_limit" => "30",
        "sitemap_xml_status" => "1",
        "sitemap_html_status" => "0",
        "sitemap_txt_status" => "0",
        "sitemap_bing_ping" => "0",
        "sitemap_yahoo_ping" => "0",
        "sitemap_ask_ping" => "0",
        "sitemap_last_update" => "1461860729",
        "app.locale" => "ar",
        "facebook_page" => "",
        "twitter_page" => "",
        "googleplus_page" => "",
        "youtube_page" => "",
        "instagram_page" => "",
        "linkedin_page" => "",
        "soundcloud_page" => "",
        "sidebar" => "",

    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create("options", function ($table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->text("value");
        });

        $this->saveOptions();


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('options');
    }


    /**
     * save default options
     */
    private function saveOptions()
    {

        ksort($this->defaults);

        foreach ($this->defaults as $name => $value) {
            $option = new Option();
            $option->name = $name;
            $option->value = $value;
            $option->save();
        }

    }

}
