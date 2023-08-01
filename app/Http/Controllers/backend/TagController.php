<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use MercurySeries\Flashy\Flashy;

class TagController extends Controller
{

    public function index()
    {
        $tags = Tag::all();
        return view('backend.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('backend.tags.create');
    }

    public function store(Request $request)
    {
        try {
            $tag = new Tag;
            $tag->name = $request->name;
            $tag->slug = Str::of($request->name)->slug('-');
            if ($request->hasFile('image') != null) 
            {
                $imageFile = sprintf('tag_%s.jpg', random_int(1, 1000));
                $path = $request->file('image')->storeAs('/tags', $imageFile, 'public');
                $content = '/public/storage/' . $path;
            } 
            else 
            {
                $content = '';
            }
            $tag->image = $content;
            $tag->save();

            return redirect()->route('admin.tags.index')->with('message', 'Tag Created Successfully');
        }
        catch(\Exception $e) {
            return redirect(route('admin.tags.index'))->with('status', $e->getMessage());
        }
    }

    public function show($slug)
    {
        $tag = Tag::where('slug', $slug)->first();
        return view('backend.tags.show', compact('tag'));
    }

    public function edit($slug)
    {
        $tag = Tag::where('slug', $slug)->first();
        return view('backend.tags.edit', compact('tag'));
    }

    public function update(Request $request, $slug)
    {
        try{
            $tag = Tag::where('slug', $slug)->first();
            if ($request->hasFile('image') == null) {
                $content = $tag->image;
            } else {
                $imageFile = sprintf('tag_%s.jpg', random_int(1, 1000));
                $path = $request->file('image')->storeAs('/tags', $imageFile, 'public');
                $content = '/public/storage/' . $path;
            }
            $tag->name = $request->name;
            $tag->image = $content;
            $tag->save();

            return redirect()->route('admin.tags.index')->with('message', 'Tag Updated Successful.');
        }
        catch(\Exception $e) {
            return redirect()->route('admin.tags.index')->with('status', $e->getMessage());
        }

    }

    public function destroy($id)
    {
        $tag = Tag::where('id', $id)->first();
        $tag->delete();

        return redirect(route('admin.tags.index'))->with('message', 'Tag Deleted Successfully');
    }
}
