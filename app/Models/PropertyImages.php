<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Property;

class PropertyImages extends Model
{
    use HasFactory;
    protected $fillable=[
        'property_id',
        'images',
        'is_main',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
 
