<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeletionRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('deletion_requests'))
        Schema::create('deletion_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('model_type');
            $table->bigInteger('model_id');
            $table->bigInteger('deadline')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deletion_requests');
    }
}
