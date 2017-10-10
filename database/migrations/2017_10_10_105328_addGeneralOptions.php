<?php

use Illuminate\Database\Migrations\Migration;

/**
 * Class AddGeneralOptions
 */
class AddGeneralOptions extends Migration
{

    /**
     * General options
     * @var array
     */
    protected $options = [
        'site_name' => "Site Name",
        'site_slogan' => "Site Slogan",
        'site_email' => "dot@platform.com",
        'site_copyrights' => "All rights reserved",
        'site_timezone' => "Etc/GMT",
        'site_date_format' => "relative",
        'site_status' => 1,
        'site_offline_message' => NULL,
    ];

    /**
     * AddGeneralOptions constructor.
     */
    function __construct()
    {
        $this->options["site_locale"] = app()->getLocale();
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->options as $name => $value) {
            Option::set($name, $value);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->options as $name => $value) {
            Option::delete($name);
        }
    }
}
