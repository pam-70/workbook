<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listtask extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'numer', 'klass','time','num_quest','purpose'
    ];
//, 'numer', 'klass','time','num_quest','purpose'
}
