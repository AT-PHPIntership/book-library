<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('book_id')->unsigned()->nullable();
            $table->foreign('book_id')
                  ->references('id')->on('books')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->string('user_id');
            $table->foreign('user_id')
                  ->references('employee_code')->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->tinyInteger('type');
            $table->string('content');
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
        Schema::dropIfExists('posts');
    }
}
