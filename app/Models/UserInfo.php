<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'student_type',
        'education_level',
        'institutaion',
        'interest',
        'spring_dead_start',
        'spring_dead_end',
        'fall_dead_start',
        'fall_dead_end',
        'annual_in_state',
        'annual_out_state',
        'manda_in_state',
        'manda_out_state',
        'room_in_state',
        'room_out_state',
        'dis_in_state',
        'dis_out_state',
        'tyearly_in_state',
        'tyearly_out_state',
        'scholarship_info',
        'other_info',
        'pann_in_state',
        'pann_out_state',
        'pdis_in_state',
        'pdis_out_state',
        'pcredit_in_state',
        'pcredit_out_state',
    ];

}
