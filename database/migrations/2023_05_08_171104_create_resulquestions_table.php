<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResulquestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resulquestions', function (Blueprint $table) {
            $table->id();
            $table->integer('result_id')->nullable();
            $table->integer('question_id')->nullable();
            $table->string('right_answer_str')->nullable();//
            $table->string('student_answer_str')->nullable();//            
            $table->string('numerquestion')->nullable();//            
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
        Schema::dropIfExists('resulquestions');
    }
}
