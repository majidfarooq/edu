<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourites extends Model
{

    use HasFactory;
    protected $fillable = [
        'student_id',
        'uni_id',
    ];


    public function university()
    {
        return $this->belongsTo(User::class,'uni_id','id');
    }

    public function application()
    {
        return $this->hasOne(Applications::class,'uni_id','uni_id');
    }

}
