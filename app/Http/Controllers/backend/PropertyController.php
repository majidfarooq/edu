<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Property;
use App\Models\PropertyImages;
use App\Models\Tag;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::all();
        return view('backend.properties.index', compact('properties'));
    }

    public function create()
    {
        $tags = Tag::all();
        return view('backend.properties.create', compact('tags'));
    }

    public function store(Request $req)
    {

        try {
            $property = new Property;
            $property->title = $req->title;
            $property->slug = Str::of($req->title)->slug('-');
            $property->price = $req->price;
            $property->address = $req->address;
            $property->bed = $req->bed;
            $property->bath = $req->bath;
            $property->sqft = $req->sqft;
            $property->desc = $req->desc;
            $property->building_type = $req->building_type;
            $property->prop_latitude = $req->prop_latitude;
            $property->prop_longitude = $req->prop_longitude;
            $property->isFeatured = random_int(0,1);

            if($property->save())
            {
                $images=$req->file('images');
                foreach($images as $key=>$image)
                {
                    $imageName = sprintf('property_%s.jpg', random_int(1, 1000));
                    $path = $image->storeAs('/properties', $imageName, 'public');
                    $content = '/public/storage/' . $path;
                    $property_img = new PropertyImages;
                    $property_img->property_id = $property->id;
                    $property_img->images = $content;
                    $property_img->is_main = '0';
                    $property_img->save();
                }

                if($req->hasFile('is_main') != null){
                    $imageFile = sprintf('property_%s.jpg', random_int(1, 1000));
                    $path = $req->file('is_main')->storeAs('/properties', $imageFile, 'public');
                    $content = '/public/storage/' . $path;
                }
                else
                {
                    $content = '';
                }
                $property_img = new PropertyImages;
                $property_img->property_id = $property->id;
                $property_img->images = $content;
                $property_img->is_main = '1';
                $property_img->save();

            }
            $property->tags()->attach($req->tags);
            return redirect(route('properties.index'))->with('message', 'Property Created Successfully.');
          }

          catch(\Exception $e) {

            return redirect(route('properties.index'))->with('status', $e->getMessage());
          }

    }

    public function show($slug)
    {
        $property = Property::where('slug', $slug)->with( )->first();
        return view('backend.properties.show', compact('property'));
    }

    public function edit($slug)
    {
        $property = Property::where('slug', $slug)->with('images')->first();
        $tags = Tag::all();
        $images = PropertyImages::where('property_id', $property->id)->where('is_main', '0')->get();
        $main_img = PropertyImages::where('property_id', $property->id)->where('is_main', '1')->first();

        return view('backend.properties.edit', compact('property', 'tags', 'images', 'main_img'));
    }

    public function update(Request $req ,$slug)
    {
        try {
            $property = Property::where('slug', $slug)->first();
            $property->title = $req->title;
            $property->slug = Str::of($req->title)->slug('-');
            $property->price = $req->price;
            $property->address = $req->address;
            $property->bed = $req->bed;
            $property->bath = $req->bath;
            $property->sqft = $req->sqft;
            $property->desc = $req->desc;
            $property->building_type = $req->building_type;
            $property->prop_latitude = $req->prop_latitude;
            $property->prop_longitude = $req->prop_longitude;
            $property->isFeatured = random_int(0,1);

            if($property->update())
            {
                if($req->file('images'))
                {
                    $images=$req->file('images');
                    foreach($images as $key=>$image)
                    {
                        $imageName = sprintf('property_%s.jpg', random_int(1, 1000));
                        $path = $image->storeAs('/properties', $imageName, 'public');
                        $content = '/public/storage/' . $path;
                        $property_img = new PropertyImages;
                        $property_img->property_id = $property->id;
                        $property_img->images = $content;
                        $property_img->is_main = '0';
                        $property_img->save();
                    }
                }

                if($req->hasFile('is_main')){
                    $imageFile = sprintf('property_%s.jpg', random_int(1, 1000));
                    $path = $req->file('is_main')->storeAs('/properties', $imageFile, 'public');
                    $content = '/public/storage/' . $path;
                    $property_img = new PropertyImages;
                    $property_img->property_id = $property->id;
                    $property_img->images = $content;
                    $property_img->is_main = '1';
                    $property_img->save();
                }

            }

            if($req->has('tags'))
            {
                // $tags = explode(',', $req->tags);
                $property->tags()->detach($property->tags);
                $property->tags()->attach($req->tags);
            }
            return redirect(route('properties.index'))->with('message', 'Property Updated Successfully.');
        }

        catch(\Exception $e) {
            return redirect(route('properties.index'))->with('status', $e->getMessage());
        }
    }

    public function destroy($slug)
    {
        $property = Property::where('slug', $slug)->with('images')->first();
        foreach($property->images as $img)
        {
            $img->delete();
        }

        $property->tags()->detach($property->tags);
        $property->delete();

        return redirect(route('properties.index'))->with('status', 'Property Deleted Successfully.');
    }

    public function delete_img(Request $req)
    {
        $property_id = $req->property_id;

        if($req->id)
        {
            $img_id = $req->id;
            $image = PropertyImages::where('id', $img_id)->where('property_id', $property_id)->first();
            $image->delete();
        }

        if($req->is_main)
        {
            $main = $req->is_main;
            $main_img = PropertyImages::where('id', $main)->where('property_id', $property_id)->first();
            dd($main_img);
            $main_img->delete();
        }
        return response()->json(['status', '']);
    }
}
