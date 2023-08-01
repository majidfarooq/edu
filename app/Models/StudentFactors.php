<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentFactors extends Model
{

    use HasFactory;
    protected $fillable=[
        'uni_id',
        'student_id',
        'factorId',
        'rating',
    ];

}
