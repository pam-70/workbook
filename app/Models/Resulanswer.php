<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resulanswer extends Model
{
    use HasFactory;
    protected $fillable = [
        'resulquestion_id', 'answer_id', 'result_answer','right_answer','student_answer'
    ];
}
// $table->integer('resulquestion_id')->nullable();
// $table->integer('answer_id')->nullable();
// $table->string('result_answer')->nullable();//
// $table->string('right_answer')->nullable();//
// $table->string('student_answer')->nullable();//  