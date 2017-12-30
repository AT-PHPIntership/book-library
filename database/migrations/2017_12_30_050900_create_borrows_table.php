<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBorrowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrows', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('book_id')->unsigned();
            $table->foreign('book_id')
                  ->references('id')->on('books')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->string('user_id');
            $table->foreign('user_id')
                  ->references('employee_code')->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->datetime('from_date');
            $table->datetime('to_date');
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
        Schema::dropIfExists('borrows');
    }
}
