<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable("roles")) {

            Schema::create("roles", function ($table) {
                $table->increments('id');
                $table->string('name')->unique();
            });

            // create superadmin role
            $role = new Role();
            $role->name = "superadmin";
            $role->save();

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('roles');
    }
}
