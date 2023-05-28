<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('t_numer')->nullable();//
            $table->string('school')->nullable();
            $table->string('klass')->nullable();
            $table->integer('numer')->nullable();
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('mark')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('results');
    }
}
