<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use MercurySeries\Flashy\Flashy;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return redirect()->route('home')->with('userRegister', 2);
    }

    public function register(Request $request)
    {
        if ($request->role_id == 1) {
            $register = 1;
            $role_id = $data['role_id'] = $request->role_id;
            $data['first_name'] = $request->user_first_name;
            $data['last_name'] = $request->user_last_name;
            $data['email'] = $request->user_email;
            $data['email_confirmation'] = $request->user_email_confirmation;
            $data['password'] = $request->user_password;
            $data['password_confirmation '] = $request->user_password_confirmation;
        } elseif ($request->role_id == 2) {
            $register = 2;
            $role_id = $data['role_id'] = $request->role_id;
            $data['first_name'] = $request->vendor_first_name;
            $data['last_name'] = $request->vendor_last_name;
            $data['email'] = $request->vendor_email;
            $data['email_confirmation'] = $request->vendor_email_confirmation;
            $data['password'] = $request->vendor_password;
            $data['password_confirmation '] = $request->vendor_password_confirmation;
        }
        $validator = Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        if ($validator->fails()) {
            Flashy::error("Please Enter Correct Information!.");
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with(compact('register', 'role_id'));
        } else {
            $userProfile = 2;
            $countries = Country::where('id', 231)->with('states')->first();
            $user = User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'role_id' => $data['role_id'],
                'password' => Hash::make($data['password']),
            ]);
            $this->guard()->login($user);
            Flashy::success("User Register Successful.");

            return view('frontend.home.home', compact('countries','userProfile'));
//            return redirect()->route('home', compact('countries'))->with('userRegister', 2);
//            return redirect('/')->with('userProfile', 2);
        }
    }

    protected function registered(Request $request, $user)
    {
        Flashy::success("User Register Successful.");
    }

}
