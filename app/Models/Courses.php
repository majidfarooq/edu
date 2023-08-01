<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    use HasFactory;



    public function programes()
    {
        return $this->belongsTo(CourseCategory::class,'category_id','id');
    }

}
