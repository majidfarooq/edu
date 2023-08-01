<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Experience;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::with('experiences.slots')->where('parent_id', null)->get();
        $cities = Experience::distinct()->get(['city']);
        return view('frontend.categories.index', compact('categories', 'cities'));
    }

    public function subCategories(Category $category)
    {
        $categories = Category::where('parent_id', $category->id)->with('subCatExperiences.slots')->get();
        $cat = Category::where('parent_id', null)->get();
        $cities = Experience::distinct()->get(['city']);
        return view('frontend.categories.sub_categories', compact('categories', 'cat', 'cities'));
    }

    public function subCategory(Category $category)
    {
        $cat = Category::where('parent_id', null)->get();
        $cities = Experience::distinct()->get(['city']);
        $category = Category::where('id', $category->id)->with('subCatExperiences.slots')->get();
        return view('frontend.categories.sub_category', compact('category', 'cat', 'cities'));
    }

    public function experienceCatSearch(Request $request)
    {
        $data = [];
        if (isset($request->category) && $request->category != 0) {
            $data['category'] = $category = $request->category;
        } else {
            $data['category'] = $category = 0;
        }

        $data['city'] = $city = $request->city;
        $data['date'] = $request->date;
        $from = date($request->date) . ' ' . '06:00:00';

        $day = date('l', strtotime($request->date));

        $next = date('Y-m-d', strtotime(' +1 day', strtotime($from)));
        $to = $next . ' ' . '06:00:00';
        $experiences = Experience::when($category != 0, function ($query) use ($category) {
            $query->where('cat_id', $category);
        })->
        when($city != null or $city != 0, function ($query) use ($city) {
            $query->where('city', $city);
        })->
        when($request->date != 0, function ($query) use ($day) {
            $query->whereRaw("FIND_IN_SET('$day',days)");
        })->with('slots')->get();

        $cat = Category::where('parent_id', null)->get();
        $cities = Experience::distinct()->get(['city']);
        return view('frontend.categories.search', compact('experiences', 'cat', 'cities', 'data'));

    }


}
