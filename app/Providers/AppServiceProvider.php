<?php

namespace App\Providers;

use App\Models\Applications;
use App\Models\Favourites;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    public function boot()
    {
        $menus = Menu::orderBy('id', 'ASC')->get();
        View::share('menus', $menus);

        $header = Menu::whereId('1')->orderBy('id', 'ASC')->get();
        View::share('header', $header);

        $footer = Menu::whereId('2')->orderBy('id', 'ASC')->get();
        View::share('footer', $footer);

        $universities = User::where('type','university')->where('isActive',1)->inRandomOrder()->limit(5)->get();
        $university_list = view("frontend.universities.index", compact( 'universities'))->render();
        View::share('university_list', $university_list);
        view()->composer('*', function($view) {
            if(isset(Auth::user()->id)){
                if(Session::has('marked_no')){
                    $already_marked=Session::get('marked_no');
                    if($already_marked){
                        $outside=Applications::with('university')->where('user_id',Auth::user()->id)
                            ->where('isPopup',0)
                            ->where('notInterested',0)
                            ->whereIn('apply_via', ['apply_on_common_ap', 'apply_via_black_college_app','apply_directly_through_the_uni'])
                            ->whereNotIn('status', ['approve_shortlist', 'rejected','offer_extend'])
                            ->whereNotIn('id', $already_marked)
                        ->get();
                    }
                }else{
                    $outside=Applications::with('university')->where('user_id',Auth::user()->id)
                        ->where('isPopup',0)
                        ->where('notInterested',0)
                        ->whereIn('apply_via', ['apply_on_common_ap', 'apply_via_black_college_app','apply_directly_through_the_uni'])
                        ->whereNotIn('status', ['approve_shortlist', 'rejected','offer_extend'])
                        ->get();
                    if(!empty($outside)){
                        Session::put('outside_total', $outside->count());
                    }else{
                        Session::put('outside_total', 0);
                    }
                }
                $user_id=Auth::user()->id;
                $favourites=Favourites::with(['university.userInfo','application'=>function ($query) use ($user_id) {
                    $query->where('user_id', $user_id);
                }])->where('student_id',Auth::user()->id)->inRandomOrder()->limit(4)->get();

                View::share('favourites', $favourites);
                $outsideCount=Applications::with('university')->where('user_id',Auth::user()->id)
                    ->where('isPopup',0)
                    ->where('notInterested',0)
                    ->whereIn('apply_via', ['apply_on_common_ap', 'apply_via_black_college_app','apply_directly_through_the_uni'])
                    ->whereNotIn('status', ['approve_shortlist', 'rejected','offer_extend'])
                    ->count();
                View::share('outside', $outside);
                View::share('outsideCount', $outsideCount);

                $universitiesList = User::where('type','university')->with(['favouriteGet'=>function ($query) use ($user_id) {
                    $query->where('student_id', $user_id);
                }])->where('isActive',1)->inRandomOrder()->limit(20)->get();
                View::share('universitiesList', $universitiesList);
            }else{
                $universitiesList = User::where('type','university')->where('isActive',1)->inRandomOrder()->limit(20)->get();
                View::share('universitiesList', $universitiesList);
            }
        });

        $distinctStates = User::select('state')->whereNotNull('state')->groupBy('state')->orderby('state','ASC')->get();
        View::share('distinctStates', $distinctStates);
    }
}
