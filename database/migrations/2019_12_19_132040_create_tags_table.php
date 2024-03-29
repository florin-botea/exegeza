<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tags'))
        Schema::create('tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('value');
            $table->bigInteger('language_id')->unsigned();
            $table->foreign('language_id')->references('id')->on('languages');
            $table->timestamps();
        });

        if (!Schema::hasTable('model_has_tags'))
        Schema::create('model_has_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('model_type');
            $table->bigInteger('model_id');
            $table->bigInteger('tag_id')->unsigned();
            $table->foreign('tag_id')->references('id')->on('tags');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('model_has_tags');
        Schema::dropIfExists('tags');
    }
}
