<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('books'))
        Schema::create('books', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->integer('index');
            $table->string('name')->length(61);
            $table->string('alias')->length(61);
            $table->string('slug')->length(61);
            $table->string('version')->length(61);
            $table->tinyInteger('type');
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
        Schema::dropIfExists('books');
    }
}
