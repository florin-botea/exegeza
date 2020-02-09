<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBibleVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('bible_versions'))
        Schema::create('bible_versions', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->integer('index');
            $table->string('name')->length(61);
            $table->string('alias')->length(61);
            $table->string('slug')->length(61);
            $table->boolean('public')->default(false);
            $table->bigInteger('language_id')->unsigned()->nullable();
            $table->foreign('language_id')
                ->references('id')
                ->on('languages');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bible_versions');
    }
}
