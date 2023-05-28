<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
           // $table->integer('question_id');//таблица ответов
            $table->text('quest')->nullable();//
            $table->string('t_numer')->nullable();//
            $table->string('vid')->nullable();//
            $table->string('pict')->nullable();//
            $table->string('ball')->nullable();//
            $table->string('right_ansv')->nullable();//
            $table->string('pr')->nullable();//
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
        Schema::dropIfExists('questions');
    }
}
