<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('password_srtr')->nullable();
            $table->string('roles')->nullable();
            $table->string('school')->nullable();
            $table->string('klass')->nullable();
            $table->integer('numer')->nullable();
            $table->string('surname')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *   `id` int(10) UNSIGNED NOT NULL,
 

     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
