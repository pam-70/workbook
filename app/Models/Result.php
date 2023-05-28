<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    public function resulquestion()
    {
      return $this->hasMany('App\Models\Resulquestion');
    }
    use HasFactory;
    protected $fillable = [
         'user_id', 't_numer','school','klass','numer','name','surname','mark'
    ];
                // $table->integer('user_id')->nullable();
            // $table->string('t_numer')->nullable();//
            // $table->string('school')->nullable();
            // $table->string('klass')->nullable();
            // $table->integer('numer')->nullable();
            // $table->string('name')->nullable();
            // $table->string('surname')->nullable();
            // $table->string('mark')->nullable();
}
