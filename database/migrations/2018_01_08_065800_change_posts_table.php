<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['postable_id', 'postable_type']);
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->nullableMorphs('postable');
            $table->string('type')->after('user_id');
            $table->string('image')->after('content')->nullable();
        });
        Schema::table('posts', function (Blueprint $table) {
            DB::statement('ALTER TABLE posts CHANGE COLUMN postable_id postable_id INT(11) NULL 
            DEFAULT NULL AFTER user_id;');
            DB::statement('ALTER TABLE posts CHANGE COLUMN postable_type postable_type VARCHAR(20) NULL 
            DEFAULT NULL AFTER postable_id;');
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
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['type', 'image']);
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
