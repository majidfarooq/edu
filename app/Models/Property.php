<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;
use App\Models\PropertyImages;


class Property extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'price',
        'address',
        'bed',
        'bath',
        'sqft',
        'desc',
        'isFeatured',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'property_tags');
    }

    public function images()
    {
        return $this->hasMany(PropertyImages::class);
    }

    public function getMainImageAttribute(){
        $img = $this->images->where('is_main','1')->first();
        
        if($img){  
            return $img->images;
        }else{
            return 'noimage.jpg';
        }
    }
}
