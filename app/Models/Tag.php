<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Models\Property;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug','image'];

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_tags');
    }

}
