<?php

namespace App\Models;

use App\Models\Klass;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;
    public function klass()
    {
        return $this->hasMany(Klass::class,"school_id","id");
    }
    protected $fillable = [
        'nameschool',
   ];
}
