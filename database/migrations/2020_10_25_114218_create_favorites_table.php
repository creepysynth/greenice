<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
//            $table->unsignedBigInteger('user_id');
//            $table->unsignedBigInteger('github_id');
            $table->string('name');
            $table->string('owner');
            $table->text('description')->nullable();
            $table->integer('stargazers');
            $table->string('url');
            $table->timestamps();

//            $table->index('github_id');
//            $table->foreign('user_id')
//                ->references('id')
//                ->on('users')
//                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorites');
    }
}
