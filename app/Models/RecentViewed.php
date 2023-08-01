<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecentViewed extends Model
{
    use HasFactory;

    protected $fillable = [
        'uni_id',
        'student_id',
    ];


    public function university()
    {
        return $this->belongsTo(User::class,'uni_id','id');
    }

}
