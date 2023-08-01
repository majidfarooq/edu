<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applications extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'uni_id',
        'season',
        'program_type',
        'course_id',
        'apply_via',
        'status',
        'isOffered',
        'isPopup',
        'notInterested',
        'offer_title',
        'offer_attachment',
        'offer_desc',
    ];

    public function university()
    {
        return $this->belongsTo(User::class,'uni_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function offer()
    {
        return $this->hasOne(ApplicationOffers::class,'application_id','id');
    }

    public function program()
    {
        return $this->belongsTo(CourseCategory::class,'program_type','id');
    }

    public function course()
    {
        return $this->belongsTo(Courses::class,'course_id','id');
    }

}
