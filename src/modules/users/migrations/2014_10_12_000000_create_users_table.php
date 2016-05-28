<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;


class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable("users")) {

            Schema::create('users', function (Blueprint $table) {
                $table->increments('id');
                $table->string('username')->unique();
                $table->string('password')->index();
                $table->string('email')->unique();
                $table->string('first_name')->index();
                $table->string('last_name')->index();
                $table->timestamps();
                $table->string('code')->index();
                $table->string('remember_token')->index();
                $table->integer('role_id')->index();
                $table->integer('last_login')->index();
                $table->integer('status')->index();
                $table->integer('root')->index();
                $table->integer('photo_id')->index();
                $table->string('lang', 5)->index();
                $table->text('about');
                $table->string('facebook')->index();
                $table->string('twitter')->index();
                $table->string('linked_in')->index();
                $table->string('google_plus')->index();
            });

            // create administrator user

            $user = new User();
            $user->username = "admin";
            $user->password = "admin";
            $user->email = "info@example.com";
            $user->first_name = "admin";
            $user->last_name = "";
            $user->lang = App::getLocale();
            $user->status = 1;
            $user->role_id = 1;
            $user->root = 1;
            $user->save();

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
