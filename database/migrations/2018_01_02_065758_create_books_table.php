<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('QRcode')->unique();
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')
                  ->references('id')->on('categories')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->integer('donator_id')->unsigned();
            $table->foreign('donator_id')
                    ->references('id')->on('donators')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->string('name');
            $table->string('author');
            $table->string('year');            
            $table->integer('price');            
            $table->longText('description');
            $table->string('image');
            $table->float('avg_rating')->default(0.0);
            $table->integer('total_rating')->default(0);
            $table->tinyInteger('status')->default(1)->comment="1: available; 0:borrowed";
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::dropIfExists('books');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
