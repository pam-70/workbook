<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resulquestion extends Model
{
    use HasFactory;
    protected $fillable = [
        'result_id', 'question_id', 'right_answer_str','student_answer_str','numerquestion'
    ];
}
// $table->integer('result_id')->nullable();
// $table->integer('question_id')->nullable();
// $table->string('right_answer_str')->nullable();//
// $table->string('student_answer_str')->nullable();//            
// $table->string('numerquestion')->nullable();//  
