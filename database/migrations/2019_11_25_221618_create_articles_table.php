<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('articles'))
		Schema::create('articles', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('user_id')->unsigned();
			$table->string('mask')->length(61)->nullable();
			$table->foreign('user_id')->references('id')->on('users');
			$table->bigInteger('bible_version_id')->unsigned()->nullable();
			$table->foreign('bible_version_id')->references('id')->on('bible_versions');
			$table->integer('book_index')->nullable();
			$table->integer('chapter_index')->nullable();
			$table->string('meta')->length(500)->nullable();
			$table->string('title')->length(700)->nullable();
			$table->string('slug')->length(700)->nullable();
			$table->string('sample')->length(700)->nullable();
			$table->mediumText('content');
			$table->bigInteger('published_by')->unsigned()->nullable();
			$table->foreign('published_by')->references('id')->on('users');
			$table->timestamps();
			$table->softDeletes();
		});
	}
	// publicat de $article->publisher->name, autor ($article->translation_of ? $article->original->author->name : $article->author->name ), tradus de $article->author->name din limba $article->original->language
	/** publicat de admin, autor Jack Hensz, trad. Un Roman, eng
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('articles');
	}
}
