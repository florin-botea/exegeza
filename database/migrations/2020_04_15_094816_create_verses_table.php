<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

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
            $table->integer('book_index')->unsigned();
            $table->integer('chapter_index')->unsigned();
            $table->integer('index')->unsigned();
            $table->string('text')->length(900);
            $table->timestamps();
        });
        // $path = storage_path('app/sql/ntr.sql');
        // $sql = file_get_contents($path);
        // DB::unprepared($sql);
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
