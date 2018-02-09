<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnPageAndLanguageToBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->integer('pages')->unsigned()->nullable()->after('description');
            $table->string('language')->after('pages');
            $table->longText('description')->nullable()->change();
            $table->integer('price')->nullable()->change();
            $table->string('author')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('books', function (Blueprint $table) {
//            $table->longText('description')->default('null')->change();
//            $table->integer('price')->default(0)->change();
//            $table->string('author')->default('null')->change();
//        });
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('pages');
            $table->dropColumn('language');
//            $table->longText('description')->nullable(false)->change();
//            $table->integer('price')->nullable(false)->change();
//            $table->string('author')->nullable(false)->change();
        });
    }
}
