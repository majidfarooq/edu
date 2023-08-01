<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\ApplicationOffers;
use App\Models\Applications;
use App\Models\Booking;
use App\Models\Experience;
use App\Models\Page;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use MercurySeries\Flashy\Flashy;

class AdminController extends Controller
{
    use AuthenticatesUsers;

    public function loginSubmit(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function changePassword(Request $request)
    {
        $data = [];
        $data['request'] = $request->All();

        $validator = Validator::make($request->all(), [
            'current_password' => [
                'required', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, \Illuminate\Support\Facades\Auth::user()->password)) {
                        $fail('Current Password didn\'t match');
                    }
                },
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:30',
                'confirmed',
                'different:current_password',
            ],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $user = auth()->user();
            $user->update([
                'password' => Hash::make($data['request']['password'])
            ]);
            Auth::logout();
            Flashy::success('Password Has Changed Please Login with new Password');
            return redirect()->route('admin.login');
        }
    }

    public function basicInformation(Request $request)
    {
        $admin = Admin::where('id', $this->guard()->user()->id)->first();
        if (Auth::Check()) {
            $request_data = $request->only('name', 'image');
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'image' => 'mimes:jpg,bmp,png',
            ]);
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            } else {
                if ($request->hasFile('image') == null) {
                    $content = $admin->image;
                } else {
                    $imageFile = sprintf('admin_%s.jpg', random_int(1, 1000));
                    $path = $request->file('image')->storeAs('/images', $imageFile, 'public');
                    $content = '/storage/app/public/' . $path;
                }
                $admin->name = $request_data['name'];
                $admin->image = $content;
                if ($admin->update()) {
                    return redirect()->back()->with('success', 'Your Account Information Changed');
                }
            }
        }
    }


    public function login(){

        return view('backend.login.login');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function dashboard($slug=false)
    {
        if(!empty($slug)){
            if($slug=='week'){
                $start=Carbon::now()->startOfWeek();
                $end=Carbon::now()->endOfWeek();
            }else{
                $start=Carbon::now()->startOfMonth();
                $end=Carbon::now()->endOfMonth();
            }
            $data['total_applications'] = Applications::whereBetween('created_at',[$start, $end])->count();
            $data['applications_active'] = Applications::where('status','!=','approve_shortlist')->where('status','!=','rejected')->whereBetween('created_at',[$start, $end])->count();
            $data['accepted'] = Applications::whereHas('offer', function($q) {$q->where('isAccepted', 1);})->whereBetween('created_at',[$start, $end])->count();
            $data['rejected'] = Applications::where('status','rejected')->whereBetween('created_at',[$start, $end])->count();
            $data['approve_shortlist'] = Applications::where('status','approve_shortlist')->whereBetween('created_at',[$start, $end])->count();
            $data['isOffered'] = Applications::where('isOffered',1)->whereBetween('created_at',[$start, $end])->count();
            $data['university'] = User::where('type','university')->whereBetween('created_at',[$start, $end])->count();
            $data['university_active'] = User::where('type','university')->where('hbcu',1)->whereBetween('created_at',[$start, $end])->count();
            $data['student'] = User::where('type','student')->whereBetween('created_at',[$start, $end])->count();
            $data['student_active'] = User::whereHas('applications', function($q) {$q->where('status', 'mark_pending');})->whereBetween('created_at',[$start, $end])->count();
            $data['pages'] = Page::whereBetween('created_at',[$start, $end])->count();
        }else{
            $data['accepted'] = Applications::whereHas('offer', function($q) {$q->where('isAccepted', 1);})->count();
            $data['approve_shortlist'] = Applications::where('status','approve_shortlist')->count();
            $data['rejected'] = Applications::where('status','rejected')->count();
            $data['isOffered'] = Applications::where('isOffered',1)->count();
            $data['total_applications'] = Applications::count();
            $data['applications_active'] = Applications::where('status','!=','approve_shortlist')->where('status','!=','rejected')->count();
            $data['university'] = User::where('type','university')->count();
            $data['university_active'] = User::where('type','university')->where('hbcu',1)->count();
            $data['student'] = User::where('type','student')->count();
            $data['student_active'] = User::whereHas('applications', function($q) {$q->where('status', 'mark_pending');})->count();
            $data['pages'] = Page::count();
        }
        return view('backend.dashboard.dashboard', compact('data'));
    }

    public function applications(Request $request)
    {
        $data = $request->except(['_method', '_token']);
        $isSearch=false;
        if(!empty($data)){
            $isSearch=true;
            $applications = Applications::
            when($request->start_date, function($query) use ($request){
                $query->where('created_at','>=', $request->start_date);
            })
            ->when($request->end_date, function($query) use ($request){
                $query->where('created_at','<=', $request->end_date);
            })
            ->when($request->status, function($query) use ($request){
                $query->where('status', $request->status);
            })
            ->whereHas('university', function($q) use ($request){
                $q->when($request->title, function($query) use ($request){
                    $query->where('first_name', 'like', '%' . $request->title . '%');
                });
            })
            ->orderBy('id','DESC')
            ->get();
            return view('backend.applications.index',compact('applications','isSearch'));
        }
        $applications= Applications::with('university','user')->orderBy('id','DESC')->get();
        return view('backend.applications.index',compact('applications','isSearch'));
    }

    public function account()
    {
        return view('backend.admin.index');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

    protected function loggedOut(Request $request)
    {
        return redirect()->route('admin.login');
    }

    protected function authenticated(Request $request, $user)
    {
        Flashy::success("Login Successful.");
        return redirect()->route('admin.home');
    }

}
