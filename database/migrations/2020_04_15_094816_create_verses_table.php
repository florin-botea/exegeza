<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVersesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('verses'))
        Schema::create('verses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('bible_version_id')->unsigned();
            $table->bigInteger('book_id')->unsigned();
            $table->bigInteger('chapter_id')->unsigned();

            $table->integer('book_index')->unsigned();
            $table->integer('chapter_index')->unsigned();
            $table->integer('index')->unsigned();
            $table->string('text')->length(900);
            $table->timestamps();

            $table->foreign('bible_version_id')->references('id')->on('bible_versions');
            $table->foreign('book_id')->references('id')->on('books');
            $table->foreign('chapter_id')->references('id')->on('chapters');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verses');
    }
}
