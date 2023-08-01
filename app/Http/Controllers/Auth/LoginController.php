<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use MercurySeries\Flashy\Flashy;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return redirect()->route('home')->with('userLogin', 3);
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
        Flashy::success("User logout Successful.");
        return redirect()->route('home');
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        $data = Socialite::driver('facebook')->user();
        $user = User::where('email', '=', $data->email)->first();
        if (!$user) {
            $user = new User();
            $user->first_name = $data->name;
            $user->email = $data->email;
            $user->provider_id = $data->id;
            $user->password = Hash::make(rand(10, 100));
            $user->image = $data->avatar;
            $user->role_id = 1;
            $user->save();
            Auth::login($user);
            Flashy::success("User Login Successful.");
            return redirect('/#')->with('userProfile', 2);
        } else {
            Auth::login($user);
            Flashy::success("Welcome Back.");
            return redirect('/#');
        }
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $data = Socialite::driver('google')->user();
        $user = User::where('email', '=', $data->email)->first();
        if (!$user) {
            $user = new User();
            $user->first_name = $data->name;
            $user->email = $data->email;
            $user->provider_id = $data->id;
            $user->password = Hash::make(rand(10, 100));
            $user->image = $data->avatar;
            $user->role_id = 1;
            $user->save();
            Auth::login($user);
            Flashy::success("User Login Successful.");
            return redirect('/#')->with('userProfile', 2);
        } else {
            Auth::login($user);
            Flashy::success("Welcome Back.");
            return redirect('/#');
        }

    }

    protected function authenticated(Request $request, $user)
    {
        Flashy::success("User Login Successful.");
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        Flashy::error("Please Provide Correct Information.");
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }
}
