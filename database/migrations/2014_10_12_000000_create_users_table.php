<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('employee_code', 100)->unique();
            $table->string('name', 100);
            $table->string('email', 100)->unique();
            $table->string('team', 40);
            $table->string('avatar_url')->nullable();
            $table->tinyInteger('role')->default(0)->comment="1: admin; 0:user";            
            $table->string('access_token')->nullable();
            $table->datetime('expires_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
