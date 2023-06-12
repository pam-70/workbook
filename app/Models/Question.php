<?php

namespace App\Models;
use App\Models\Answer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
          // $table->text('quest');//
       // $table->string('t_numer');//
       // $table->string('vid');//
       // $table->string('pict');//
       // $table->string('ball');//
        //$table->string('right_ansv');//
        protected $fillable = [
            'quest','t_numer','vid','pict','ball','right_ansv'
        ];
        public function answer()
        {
            return $this->hasMany(Answer::class,'question_id', 'id');
        }
        
        // {
        //     return $this->hasMany(Question::class, 'id', 'question_id');
        // }
}
