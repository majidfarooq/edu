<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Libraries\Helpers;
use App\Models\Page;
use App\Models\Post;
use App\Models\State;
use App\Models\User;
use App\Services\PageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PageController extends Controller
{
    protected $page;

    public function __construct(PageService $page)
    {
        $this->page = $page;
    }

    public function home($auth = false)
    {
        if (!empty($auth)) {
            $auth_code = (new Helpers())->decrypt_string($auth);
            $user = User::where('remember_token', $auth_code)->first();
            if (!empty($user)) {
                $auth_code = $auth;
            } else {
                $auth_code = false;
            }
        } else {
            $auth_code = false;
        }
        $page = Page::where('is_home', 1)->with('pageSections.section.PageSubSections', 'pageSections.subsection.PageElements', 'pageSections.PageElements.element')->first();

        $data['posts'] = Post::all();
        $states = State::get();

        return view('frontend.pages.cms', compact('page', 'data', 'auth_code', 'states'));
    }


    public function index()
    {
        $pages = $this->page->index();
        $states = State::get();
        return view('backend.pages.index', compact('pages', 'states'));
    }

    public function search(Request $request)
    {
        $s = $request->GET('s');
        $posts = Post::where('title', 'LIKE', '%' . $s . '%')->orWhere('content', 'LIKE', '%' . $s . '%')->get();
        $posts->count = $posts->count();
        $posts->title = $s;
        $states = State::get();
        return view('frontend.posts.search', compact('posts', 'states'));
    }


    public function resetUserPassword($auth_code)
    {

        return view('frontend.pages.reset_password', compact('auth_code'));
    }

    function getLnt($zip)
    {

        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($zip) . ",US&key=AIzaSyAG6eAdW_1mCTdPUJSGVLrFB_UPMj0Y4Yg";
        $result_string = file_get_contents($url);
        $result = json_decode($result_string, true);
        if (isset($result['results'][0])) {
            $result1[] = $result['results'][0];
            $result2[] = $result1[0]['geometry'];
            $result3[] = $result2[0]['location'];
            return $result3[0];
        } else {
            return false;
        }
    }

    public function searchInform(Request $request)
    {
        $data = $request->except(['_method', '_token']);
        if (isset($data['zipcode']) && !empty($data['zipcode'])) {
            $latLongs = $this->getLnt($data['zipcode']);
        } else {
            $latLongs = false;
        }
        // dd($data);
        if (!empty($data)) {
            $universities = User::whereNested(
                function ($query) use ($data) {
                    if (isset($data['title']) && !empty($data['title'])) {
                        $query->where('fullname', 'like', '%' . $data['title'] . '%');
                    }
                    if (isset($data['state']) && !empty($data['state'])) {
                        $query->where('state', $data['state']);
                    }
                },
                'AND'
            )
                ->when(isset($data['from_fee']), function ($query) use ($data) {
                    return $query->WhereHas('userInfo', function ($query) use ($data) {
                        $query->whereBetween('tyearly_in_state', [preg_replace('/[^0-9]/', '', $data['from_fee']), preg_replace('/[^0-9]/', '', $data['to_fee'])]);
                    });
                })
                ->when(!empty($latLongs), function ($query) use ($latLongs) {
                    $query->select(
                        "users.*",
                        DB::raw("6371 * acos(cos(radians(" . $latLongs['lat'] . "))
                    * cos(radians(users.latitude))
                    * cos(radians(users.longitude) - radians(" . $latLongs['lng'] . "))
                    + sin(radians(" . $latLongs['lat'] . "))
                    * sin(radians(users.latitude))) AS distance")
                    )->having("distance", "<=", 100)
                        ->OrderBy("distance", "ASC");
                })
                ->when(!empty($latLongs), function ($query) use ($latLongs) {
                    $query->whereNotNull('latitude');
                })
                ->where('type', 'university')
                ->where('isActive', 1)
                ->when(isset(Auth::user()->id), function ($query) use ($data) {
                    return $query->with(['favouriteGet' => function ($query) {
                        $query->where('student_id', Auth::user()->id);
                    }]);
                })
                ->orderBy('id', 'DESC')->get();
        } else {
            $universities = null;
        }
        $states = State::get();
        session()->flashInput($request->input());
        return view('frontend.pages.search-inform', compact('universities', 'states'))->withInput($request->input());
    }

    public function show($slug)
    {
        $states = State::get();
        $page = Page::where('slug', $slug)->where('is_disabled', 0)->where('is_home', 0)->with('pageSections.section.PageSubSections', 'pageSections.subsection.PageElements', 'pageSections.PageElements')->first();
        if (!empty($page)) {
            return view('frontend.pages.cms', compact('page', 'states'));
        } else {
            abort(404);
        }
    }
}
