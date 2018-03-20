<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsTable extends Migration {

	public function up()
	{
		Schema::create('posts', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('title');
			$table->string('slug')->unique();
			$table->string('seo_title')->nullable();
			$table->text('excerpt')->nullable();
			$table->text('body')->nullable();
			$table->text('meta_description')->nullable();
			$table->text('meta_keywords')->nullable();
			$table->boolean('active')->default(true);
			$table->integer('user_id')->unsigned();
			$table->string('image')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('posts');
	}
}
