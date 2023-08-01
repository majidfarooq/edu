<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\PropertyImages;

class PropertiesController extends Controller
class PropertiesController extends Controller
{
    public function listings()
    {
        $properties = Property::OrderBy('id', 'DESC')->paginate(6);

        return view('frontend.properties.listing', compact('properties'));
    }

    public function search(Request $request)
    {
        $properties = Property::
        when($request->price != 0, function ($query) use ($request) {
            $query->where('price','<=', (int)$request->price);
        })->
        when($request->bed != 0, function ($query) use ($request) {
            $query->where('bed', (int)$request->bed);
        })->
        when($request->bath != 0, function ($query) use ($request) {
            $query->where('bath', (int)$request->bath);
        })->
        when($request->sqft != 0, function ($query) use ($request) {
            $query->where('sqft', (int)$request->sqft);
        })->
        when($request->building_type != 0, function ($query) use ($request) {
            $query->where('building_type', $request->building_type);
        })->
        when($request->title != 0, function ($query) use ($request) {
            $query->where('title', 'LIKE', '%' . $request->title .'%');
        })->get();
        return view('frontend.properties.search', compact('properties'));
    }

    public function detail($slug)
    {
        $property = Property::where('slug', $slug)->with('tags')->first();
        $images = PropertyImages::where('property_id', $property->id)->get();
        $featured_prop = Property::where('isFeatured', '1')->get();
        return view('frontend.properties.detail', compact('property', 'images', 'featured_prop'));

    }
}
