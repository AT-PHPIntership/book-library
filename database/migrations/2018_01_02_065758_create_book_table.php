<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book', function (Blueprint $table) {
            $table->increments('id');
            $table->string('QRcode');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')
                  ->references('id')->on('category')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->integer('donator_id')->unsigned();
            $table->foreign('donator_id')
                    ->references('id')->on('donator')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->string('name');
            $table->string('author');
            $table->string('year');            
            $table->string('price');            
            $table->string('description');
            $table->string('image');
            $table->float('avg_rating')->defautl(0.0);
            $table->integer('total_rating')->default(0);
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('book');
    }
}
