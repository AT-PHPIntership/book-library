<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUniqueColumnCodeIdToQrcodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('qrcodes', function (Blueprint $table) {
            $table->unique('code_id', 'qrcodes_code_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('qrcodes', function (Blueprint $table) {
            $table->dropUnique('qrcodes_code_id_unique');
        });
    }
}
