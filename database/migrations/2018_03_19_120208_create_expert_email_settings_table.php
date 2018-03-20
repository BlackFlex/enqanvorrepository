<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpertEmailSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expert_email_settings', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('expert_id');
            $table->smallInteger('send_me_a_message');
            $table->smallInteger('anu_for_clients');
            $table->smallInteger('anu_for_psychics');
            $table->smallInteger('special_offers_for_clients');
            $table->smallInteger('special_offers_for_psychics');

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
        Schema::dropIfExists('expert_email_settings');
    }
}
