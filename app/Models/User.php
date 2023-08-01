<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, softDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'provider_id',
        'type',
        'image',
        'address1',
        'address2',
        'city',
        'state',
        'country',
        'zipcode',
        'phone',
        'facebook_url',
        'instagram_url',
        'interests',
        'website',
        'fullname',
        'role_id',
        'stripeId',
        'latitude',
        'longitude',
        'singup_steps',
        'isFeatured',
        'hbcu',
        'ethnicity',
        'isActive',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function haversine($coordinates)
    {
        return '(6371 * acos(cos(radians(' . $coordinates['latitude'] . '))
    * cos(radians(`lat`))
    * cos(radians(`lng`)
    - radians(' . $coordinates['longitude'] . '))
    + sin(radians(' . $coordinates['latitude'] . '))
    * sin(radians(`latitude`))))';
    }

    public function scopeWithinDistance($query, $haversine, $radius = 5)
    {
        return $query->select('*')
            ->selectRaw("{$haversine} AS distance")
            ->whereRaw("{$haversine} < ?", [$radius])
            ->orderBy('distance');
    }

    public function favouriteTrip()
    {
        return $this->hasMany(Favourite::class, 'user_id');
    }

    public function userInfo()
    {
        return $this->hasOne(UserInfo::class, 'user_id', 'id');
    }

    public function applications()
    {
        return $this->hasMany(Applications::class, 'uni_id', 'id');
    }

    public function getHasAppliedAttribute()
    {
        // return $this->applications->count();
        if (auth()->user()->id) {
            $application_count = $this->applications->where('user_id', auth()->user()->id)->count();
            return $application_count;
        } else {
            return 0;
        }
    }
    public function favourite()
    {
        return $this->hasOne(Favourites::class, 'uni_id', 'id');
    }

    public function favouriteGet()
    {
        return $this->hasOne(Favourites::class, 'uni_id', 'id');
    }

    public function courses()
    {
        return $this->hasMany(Courses::class, 'user_id', 'id')->orderBy('degree_program', 'ASC');
    }
}
