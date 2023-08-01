<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\State;
use App\Services\AdminService;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use MercurySeries\Flashy\Flashy;


class AdminController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $admin;
    public function __construct()
    {

    }
    public function index()
    {
        //
    }
    public function account()
    {
        return view('Backend.admin.index');
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

    public function login()
    {
        return view('backend.login.login');
    }
    public function deleteUser($userId){
        return $this->admin->deleteUser($userId);
    }
//    public function dashboard()
//    {
//        $users = "";
//        return view('backend.dashboard.dashboard',compact('users'));
//    }

    public function userDetail($userId)
    {
        $user = $this->admin->getUserDetail($userId);
        $getCriterias =$this->admin->getCriterias($userId);
        $myProperties =$this->admin->myProperties($userId);
        return view('backend.users.detail',compact('user','userId','getCriterias','myProperties'));
    }

    public function SignIn(Request $request)
    {
        $remember = false;
        if (isset($request['remember_me'])) {
            $remember = true;
        }
        $messages = [
            'email.required' => 'The email is required',
            'email.email' => 'The email provided is not an valid email'
        ];
        $rules = [
            'email' => 'email|required',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $credentials = $request->only('email', 'password');
        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            Flashy::success("Login Successfull.");
            return redirect()->route('dashboard');
        } else {
            $message = "Invalid credentials. Please try again";
            return redirect()->back()->with(['login_error' => $message]);
        }
    }

    public function getLogOut()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin')->with(['log_out' => 'You have successfully logged out!']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
