<?php

namespace App\Models;
use App\Models\Question;
use App\Models\Resulanswer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resulquestion extends Model
{
    use HasFactory;
    protected $fillable = [
        'result_id', 'question_id', 'right_answer_str','student_answer_str','numerquestion'
    ];
    public function question()
    {
        return $this->hasMany(Question::class, 'id', 'question_id');
    }
    public function resultanswer()
    {
        return $this->hasMany(Resulanswer::class, 'resulquestion_id','id');
    }
}
// $table->integer('result_id')->nullable();
// $table->integer('question_id')->nullable();
// $table->string('right_answer_str')->nullable();//
// $table->string('student_answer_str')->nullable();//            
// $table->string('numerquestion')->nullable();//  
