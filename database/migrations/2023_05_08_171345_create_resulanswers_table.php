<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResulanswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resulanswers', function (Blueprint $table) {
            $table->id();
            $table->integer('resulquestion_id')->nullable();
            $table->integer('answer_id')->nullable();
            $table->string('result_answer')->nullable();//
            $table->string('right_answer')->nullable();//
            $table->string('student_answer')->nullable();//            
            
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
        Schema::dropIfExists('resulanswers');
    }
}
