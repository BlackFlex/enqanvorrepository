<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserEmailSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_email_settings', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id');
            $table->smallInteger('message_from_adv');
            $table->smallInteger('adv_response');
            $table->smallInteger('special_offers');
            $table->smallInteger('daily_horo');
            $table->smallInteger('weekly_horo');
            $table->smallInteger('monthly_horo');
            $table->smallInteger('monthly_career_horo');
            $table->smallInteger('articles_news_updates');

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
        Schema::dropIfExists('user_email_settings');
    }
}
