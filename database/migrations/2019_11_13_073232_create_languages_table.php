<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('languages'))
        Schema::create('languages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('value');
            $table->timestamps();
        });

        if (!Schema::hasTable('model_has_languages'))
        Schema::create('model_has_languages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('model_type');
            $table->bigInteger('model_id')->unsigned();
                $table->bigInteger('language_id')->unsigned();
                $table->foreign('language_id')
                    ->references('id')
                    ->on('languages');
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
        Schema::dropIfExists('model_has_languages');
        Schema::dropIfExists('languages');
    }
}
