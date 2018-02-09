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
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('pages');
            $table->dropColumn('language');
        });
    }
}
