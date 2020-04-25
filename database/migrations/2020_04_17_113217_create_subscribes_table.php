<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscribesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('subscribes'))
        Schema::create('subscribes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            //$table->string('token');
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
        Schema::dropIfExists('subscribes');
    }
}
