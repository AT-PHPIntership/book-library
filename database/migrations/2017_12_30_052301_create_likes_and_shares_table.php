<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikesAndSharesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes_and_shares', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_id')->unsigned();
            $table->foreign('post_id')
                    ->references('id')->on('posts')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->string('user_id');
            $table->foreign('user_id')
                    ->references('employee_code')->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->integer('like');
            $table->integer('share');
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
        Schema::dropIfExists('likes_and_shares');

    }
}