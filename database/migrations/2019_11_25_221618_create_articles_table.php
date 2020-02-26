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
			$table->bigInteger('user_id')->unsigned();// la fel ca user_id
			$table->string('cite_from')->length(511)->nullable();
			$table->bigInteger('bible_version_id')->unsigned()->nullable();
			$table->integer('book_index')->nullable();
			$table->bigInteger('book_id')->unsigned()->nullable();
			$table->integer('chapter_index')->nullable();
			$table->bigInteger('chapter_id')->unsigned()->nullable();
			$table->string('meta')->length(500)->nullable();
			$table->string('title')->length(700)->nullable();
			$table->string('slug')->length(700)->nullable();
			$table->string('sample')->length(700)->nullable();
			$table->mediumText('content');
			$table->bigInteger('published_by')->unsigned()->nullable();
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('bible_version_id')->references('id')->on('bible_versions');
			$table->foreign('book_id')->references('id')->on('books');
			$table->foreign('chapter_id')->references('id')->on('chapters');
			$table->foreign('published_by')->references('id')->on('users');
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
