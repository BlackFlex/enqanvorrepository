<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string  ('screen_name')->unique();
            $table->string  ('first_name')->default('First Name');
            $table->string  ('last_name')->default('Last Name');
            $table->date    ('date_of_birth')->nullable(true);
            $table->string  ('spec_in')->default('Specification');
            $table->string  ('avatar')->default('storage/avatars///default_image.jpg');
            $table->string  ('email')->unique();
            $table->string  ('password');
            $table->enum    ('role', array('expert', 'client', 'admin'));
            $table->boolean ('valid')->default(false);
            $table->string  ('horo_sign')->default(false);
            $table->string  ('newsletter')->default(false);
            $table->text    ('brief_intro')->nullable(true);
            $table->text    ('my_service')->nullable(true);
            $table->text    ('degree')->nullable(true);
            $table->text    ('exp')->nullable(true);
            $table->string  ('language')->nullable(true);
            $table->float   ('fee_chat')->default('0');
            $table->float   ('fee_email')->default('0');
            $table->string  ('is_typing')->default('notTyping');
            $table->string  ('is_active_now')->default('active');
            $table->text    ('user_title')->nullable(true);
            $table->string  ('facebook_id')->default('hasNot');
            $table->string  ('user_gender')->nullable(true);
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
