<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Libraries\Helpers;
use App\Models\Applications;
use App\Models\Category;
use App\Models\Courses;
use App\Models\Favourites;
use App\Models\Post;
use App\Models\RatingFactors;
use App\Models\RecentViewed;
use App\Models\State;
use App\Models\StudentFactors;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;
use Closure;
use Laravel\Socialite\Facades\Socialite;
use MercurySeries\Flashy\Flashy;
use Intervention\Image\Facades\Image;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $courses;
    protected $applications;
    protected $user;
    protected $favourite;
    protected $RatingFactors;
    protected $auth_id;
    protected $studentFactors;
    protected $recentViewed;
    public function __construct(Courses $courses)
    {
        $this->middleware('web');
        $this->courses = $courses;
        $this->applications = new Applications();
        $this->user = new User();
        $this->favourite = new Favourites();
        $this->RatingFactors = new RatingFactors();
        $this->studentFactors = new StudentFactors();
        $this->recentViewed = new RecentViewed();
    }

    public function setFullnames()
    {

        $users = User::where('type', 'university')->get();
        if ($users) {
            foreach ($users as $user) {
                $user->fullname = $user->first_name . ' ' . $user->last_name;
                $user->update();
            }
        }
    }

    public function updateProfile(Request $request)
    {

        $data = $request->except(['_method', '_token']);
        try {
            if ($data) {
                $user = $this->user->with('userInfo')->whereId($data['user_id'])->first();
                if (isset($data['first_name']) && !empty($data['first_name'])) {
                    $user->first_name = $data['first_name'];
                }
                if (isset($data['password']) && !empty($data['password'])) {
                    if (isset($data['cpassword']) && !empty($data['cpassword'])) {
                        $rules = array(
                            'password' => 'required',
                            'cpassword' => 'required|same:password'
                        );
                        $validator = Validator::make($data, $rules);
                        if ($validator->fails()) {
                            $messages = $validator->messages()->first();
                            return redirect()->back()->with(['error' => $messages]);
                        }
                        $user->password = Hash::make($data['password']);
                    }
                }
                if (isset($data['fullname']) && !empty($data['fullname'])) {
                    $user->fullname = $data['fullname'];
                }
                if (isset($data['last_name']) && !empty($data['last_name'])) {
                    $user->last_name = $data['last_name'];
                }
                if (isset($data['phone']) && !empty($data['phone'])) {
                    $user->phone = $data['phone'];
                }
                if (isset($data['gender']) && !empty($data['gender'])) {
                    $user->gender = $data['gender'];
                }
                if (isset($data['website']) && !empty($data['website'])) {
                    $user->website = $data['website'];
                }
                if (isset($data['dob']) && !empty($data['dob'])) {
                    $user->dob = $data['dob'];
                }
                if (isset($data['address1']) && !empty($data['address1'])) {
                    $user->address1 = $data['address1'];
                }
                if (isset($data['uni_email']) && !empty($data['uni_email'])) {
                    $user->uni_email = $data['uni_email'];
                }
                if (isset($data['address2']) && !empty($data['address2'])) {
                    $user->address2 = $data['address2'];
                }
                if (isset($data['city']) && !empty($data['city'])) {
                    $user->city = $data['city'];
                }
                if (isset($data['state']) && !empty($data['state'])) {
                    $user->state = $data['state'];
                }
                if (isset($data['zipcode']) && !empty($data['zipcode'])) {
                    $user->zipcode = $data['zipcode'];
                }
                if (isset($data['country']) && !empty($data['country'])) {
                    $user->country = $data['country'];
                }
                if (isset($data['latitude']) && !empty($data['latitude'])) {
                    $user->latitude = $data['latitude'];
                }
                if (isset($data['longitude']) && !empty($data['longitude'])) {
                    $user->longitude = $data['longitude'];
                }
                if (isset($data['other_info']) && !empty($data['other_info'])) {
                    $user->other_info = $data['other_info'];
                }
                if (isset($data['image']) && !empty($data['image'])) {
                    Storage::delete($user->image);
                    $height = Image::make($request['image'])->height();
                    $width = Image::make($request['image'])->width();
                    $height = ($height / $width * 750);
                    $image    = $request['image'];
                    $fileName = str_replace(' ', '', pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME));
                    $imageName = $fileName . "-" . time() . "." . $image->getClientOriginalExtension();
                    $image_resize = Image::make($image->getRealPath());
                    $image_resize->resize(750, $height);
                    $image_resize->save(public_path('storage/users/' . $imageName));
                    $uploadedImage = "public/users/" . $imageName;
                    $user->image = $uploadedImage;
                }
                if (isset($data['student_type']) && !empty($data['student_type'])) {
                    $user->userInfo->student_type = $data['student_type'];
                }
                if (isset($data['education_level']) && !empty($data['education_level'])) {
                    $user->userInfo->education_level = $data['education_level'];
                }
                if (isset($data['institution']) && !empty($data['institution'])) {
                    $user->userInfo->institution = $data['institution'];
                }
                if (isset($data['interest']) && !empty($data['interest'])) {
                    $user->userInfo->interest = implode(',', $data['interest']);
                }
                if (isset($data['spring_dead_start']) && !empty($data['spring_dead_start'])) {
                    $user->userInfo->spring_dead_start = Carbon::parse($data['spring_dead_start'])->format('Y-m-d');
                }
                if (isset($data['spring_dead_end']) && !empty($data['spring_dead_end'])) {
                    $user->userInfo->spring_dead_end = Carbon::parse($data['spring_dead_end'])->format('Y-m-d');
                }
                if (isset($data['fall_dead_start']) && !empty($data['fall_dead_start'])) {
                    $user->userInfo->fall_dead_start = Carbon::parse($data['fall_dead_start'])->format('Y-m-d');
                }
                if (isset($data['fall_dead_end']) && !empty($data['fall_dead_end'])) {
                    $user->userInfo->fall_dead_end = Carbon::parse($data['fall_dead_end'])->format('Y-m-d');
                }
                if (isset($data['annual_in_state']) && !empty($data['annual_in_state'])) {
                    $user->userInfo->annual_in_state = $this->cleanNumber2Dec($data['annual_in_state']);
                }
                if (isset($data['annual_out_state']) && !empty($data['annual_out_state'])) {
                    $user->userInfo->annual_out_state = $this->cleanNumber2Dec($data['annual_out_state']);
                }
                if (isset($data['manda_in_state']) && !empty($data['manda_in_state'])) {
                    $user->userInfo->manda_in_state = $this->cleanNumber2Dec($data['manda_in_state']);
                }
                if (isset($data['manda_out_state']) && !empty($data['manda_out_state'])) {
                    $user->userInfo->manda_out_state = $this->cleanNumber2Dec($data['manda_out_state']);
                }
                if (isset($data['room_in_state']) && !empty($data['room_in_state'])) {
                    $user->userInfo->room_in_state = $this->cleanNumber2Dec($data['room_in_state']);
                }
                if (isset($data['room_out_state']) && !empty($data['room_out_state'])) {
                    $user->userInfo->room_out_state = $this->cleanNumber2Dec($data['room_out_state']);
                }
                if (isset($data['dis_in_state']) && !empty($data['dis_in_state'])) {
                    $user->userInfo->dis_in_state = $this->cleanNumber2Dec($data['dis_in_state']);
                }
                if (isset($data['dis_out_state']) && !empty($data['dis_out_state'])) {
                    $user->userInfo->dis_out_state = $this->cleanNumber2Dec($data['dis_out_state']);
                }
                if (isset($data['tyearly_in_state']) && !empty($data['tyearly_in_state'])) {
                    $user->userInfo->tyearly_in_state = $this->cleanNumber2Dec($data['tyearly_in_state']);
                }
                if (isset($data['tyearly_out_state']) && !empty($data['tyearly_out_state'])) {
                    $user->userInfo->tyearly_out_state = $this->cleanNumber2Dec($data['tyearly_out_state']);
                }
                if (isset($data['pcredit_in_state']) && !empty($data['pcredit_in_state'])) {
                    $user->userInfo->pcredit_in_state = $this->cleanNumber2Dec($data['pcredit_in_state']);
                }
                if (isset($data['pdis_in_state']) && !empty($data['pdis_in_state'])) {
                    $user->userInfo->pdis_in_state = $this->cleanNumber2Dec($data['pdis_in_state']);
                }
                if (isset($data['pdis_out_state']) && !empty($data['pdis_out_state'])) {
                    $user->userInfo->pdis_out_state = $this->cleanNumber2Dec($data['pdis_out_state']);
                }
                if (isset($data['pann_in_state']) && !empty($data['pann_in_state'])) {
                    $user->userInfo->pann_in_state = $this->cleanNumber2Dec($data['pann_in_state']);
                }
                if (isset($data['pann_out_state']) && !empty($data['pann_out_state'])) {
                    $user->userInfo->pann_out_state = $this->cleanNumber2Dec($data['pann_out_state']);
                }
                if (isset($data['other_info']) && !empty($data['other_info'])) {
                    $user->userInfo->other_info = $data['other_info'];
                }
                if (isset($data['scholarship_info']) && !empty($data['scholarship_info'])) {
                    $user->userInfo->scholarship_info = $data['scholarship_info'];
                }
                $user->userInfo->update();
                $user->update();
            }
            return redirect()->back()->with(['success' => 'Profile Updated Successfully.']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
    public function getUniProgrames(Request $request)
    {

        $data = $request->except(['_method', '_token']);
        if ($data) {
            $courses = $this->courses->where('user_id', $request['uni_id'])->where('category_id', $request['type_id'])->get();
            return response()->json(['status' => true, 'courses' => $courses]);
        }
    }

    public function submitPopupRes(Request $request)
    {

        $data = $request->except(['_method', '_token']);
        if ($data) {
            $application = $this->applications->whereId($request['application_id'])->first();
            if ($data['status'] == 'completed') {
                if (Session::has('marked_no')) {
                    $already_marked = Session::get('marked_no');
                    if (!in_array($request['application_id'], $already_marked)) {
                        array_push($already_marked, $request['application_id']);
                        Session::put('marked_no', $already_marked);
                    }
                } else {
                    Session::put('marked_no', [$request['application_id']]);
                }
                $application->isPopup = 1;
                $application->status = 'mark_pending';
                $application->update();
            } else if ($data['status'] == 'no_interested') {
                if (Session::has('marked_no')) {
                    $already_marked = Session::get('marked_no');
                    if (!in_array($request['application_id'], $already_marked)) {
                        array_push($already_marked, $request['application_id']);
                        Session::put('marked_no', $already_marked);
                    }
                } else {
                    Session::put('marked_no', [$request['application_id']]);
                }
                $application->notInterested = 1;
                $application->delete();
            } else if ($data['status'] == 'no') {
                if (Session::has('marked_no')) {
                    $already_marked = Session::get('marked_no');
                    if (!in_array($request['application_id'], $already_marked)) {
                        array_push($already_marked, $request['application_id']);
                        Session::put('marked_no', $already_marked);
                    }
                } else {
                    Session::put('marked_no', [$request['application_id']]);
                }
            }
            if (Session::has('marked_no')) {
                $current = Session::get('marked_no');
                $outside_total = Session::get('outside_total');
                if (count($current) == $outside_total) {
                    Session::forget('marked_no');
                    Session::forget('outside_total');
                }
            }
            return redirect()->back()->with(['error' => 'Application status updated.']);
        }
    }

    public function googleSignup()
    {

        return Socialite::driver('google')->redirect();
    }
    public function emailTesting()
    {

        try {
            $attributes['code'] = rand();
            $attributes['email'] = 'ghalibsoomro@gmail.com';
            Mail::send('frontend.mails.register', ['data' => $attributes], function ($message) use ($attributes) {
                $message->from('no-reply@edubrokers.com', 'edubrokers.com');
                $message->to([$attributes['email']]);
                $message->replyTo('no-reply@edubrokers.com', 'Registration Successfull.');
                $message->subject('Registration Successfull.');
            });
        } catch (\Exception $e) {

            dd($e);
        }
    }

    public function defaultStartFactors()
    {

        $startFactors = array(
            'Grades / GPA',
            'Test Grades',
            'Essay',
            'Income',
            'Program Relevant Education',
            'Sports and Extracurricular activities',
        );
        return $startFactors;
    }
    public function get_social_credentials(Request $request)
    {
        try {
            $userSocial = Socialite::driver('facebook')->user();
            if (isset($userSocial->email)) {
                $login = User::where('email', $userSocial->email)->first();
                $signup = Session::get('facebook_signup');
                if (empty($login) && !empty($signup)) {
                    $user = new User();
                    if (isset($userSocial->email) && !empty($userSocial->email)) {
                        $user->email = $userSocial->email;
                    }
                    $user->type = Session::get('user_type');
                    $user->singup_steps = 1;
                    $user->isActive = 0;
                    $user->save();

                    $attributes['email'] = $userSocial->email;
                    Mail::send('frontend.mails.register', ['data' => $attributes], function ($message) use ($attributes) {
                        $message->from('no-reply@edubrokers.com', 'edubrokers.com');
                        $message->to([$attributes['email']]);
                        $message->replyTo('no-reply@edubrokers.com', 'Registration Successfull.');
                        $message->subject('Registration Successfull.');
                    });

                    Session::forget('user_type');
                    Session::forget('facebook_signup');

                    Flashy::success("Registered successfully. complete your profile..");
                    if (Session::get('user_type') == 'university') {
                        $factors = $this->defaultStartFactors();
                        if (!empty($factors)) {
                            foreach ($factors as $fact) {
                                $this->RatingFactors->create(['title' => $fact, 'uni_id' => $user->id]);
                            }
                        }
                    }
                    $encrypted = (new Helpers())->encrypt_string($user->id);
                    return redirect()->route('second_step', $encrypted)->with(['success' => "please complete the signup process"]);
                }
                if (!empty($login)) {
                    Flashy::success("Login Success.");
                    Auth::login($login);
                    return redirect()->route('dashboard');
                } else {
                    Flashy::error("User Does not exists.");
                    return Redirect::to('https://cloud.ferozitech.com/edu/');
                }
            }
        } catch (\Exception $e) {
            Flashy::error("Something went wrong.");
            return Redirect::to('https://cloud.ferozitech.com/edu/');
        }
    }
    public function facebook_login(Request $request)
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function google_signup(Request $request)
    {
        Session::put('google_signup', 1);
        return Socialite::driver('google')->redirect();
    }
    function get_social_credentials_google(Request $request)
    {

        try {
            $userSocial = Socialite::driver('google')->user();
            if (isset($userSocial->email)) {
                $login = User::where('email', $userSocial->email)->first();
                $signup = Session::get('google_signup');
                if (empty($login) && !empty($signup)) {
                    $user = new User();
                    if (isset($userSocial->email) && !empty($userSocial->email)) {
                        $user->email = $userSocial->email;
                    }
                    $user->type = Session::get('user_type');
                    $user->singup_steps = 1;
                    $user->isActive = 0;
                    $user->save();

                    $attributes['email'] = $userSocial->email;
                    Mail::send('frontend.mails.register', ['data' => $attributes], function ($message) use ($attributes) {
                        $message->from('no-reply@edubrokers.com', 'edubrokers.com');
                        $message->to([$attributes['email']]);
                        $message->replyTo('no-reply@edubrokers.com', 'Registration Successfull.');
                        $message->subject('Registration Successfull.');
                    });

                    Flashy::success("Registered successfully. complete your profile..");

                    if (Session::get('user_type') == 'university') {
                        $factors = $this->defaultStartFactors();
                        if (!empty($factors)) {
                            foreach ($factors as $fact) {
                                $this->RatingFactors->create(['title' => $fact, 'uni_id' => $user->id]);
                            }
                        }
                    }
                    $encrypted = (new Helpers())->encrypt_string($user->id);
                    Session::forget('user_type');
                    Session::forget('google_signup');
                    return redirect()->route('second_step', $encrypted)->with(['success' => "please complete the signup process"]);
                }
                if (!empty($login)) {
                    Flashy::success("Login Success.");
                    Auth::login($login);
                    return redirect()->route('dashboard');
                } else {
                    Flashy::error("User Does not exists.");
                    return Redirect::to('http://cloud.ferozitech.com/edu/');
                }
            }
        } catch (\Exception $e) {
            Flashy::error("Something went wrong.");
            return Redirect::to('http://cloud.ferozitech.com/edu/');
        }
    }
    public function facebook_signup(Request $request)
    {
        Session::put('facebook_signup', 1);
        return Socialite::driver('facebook')->redirect();
    }
    public function setUserType(Request $request)
    {

        Session::put('user_type', $request['type']);
    }
    public function resetPassword(Request $request)
    {

        $data = $request->except(['_method', '_token']);
        if (isset($data['email']) && !empty($data['email'])) {
            $user = User::where('email', $data['email'])->first();
            if (!empty($user)) {
                $code = rand(10000, 100000);
                $auth_code = (new Helpers())->encrypt_string($code);
                $user->remember_token = $code;
                $user->update();
                $attributes['subject'] = "Edu Brokers - Forgot Password";
                $attributes['file'] = "frontend.mails.forgot_password";
                $attributes['type'] = "university";
                $attributes['auth_code'] = $auth_code;
                $attributes['email'] = $user->email;
                (new Helpers())->EduMailer($attributes);
                return response()->json(['status' => true, 'message' => 'Password Reset Instruction has been sent to your email address.']);
            } else {
                return response()->json(['status' => false, 'message' => 'Email Does not exist, please check and try again.']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Something went wrong, please check and try again.']);
        }
    }

    public function resetPasswordNow(Request $request)
    {

        $data = $request->except(['_method', '_token']);
        if (!empty($data['auth_code']) && !empty($data['password'])) {
            $auth_code = (new Helpers())->decrypt_string($data['auth_code']);
            $user = User::where('remember_token', $auth_code)->first();
            if ($user) {
                $user->remember_token = null;
                $user->password = Hash::make($data['password']);
                $user->update();
                $attributes['subject'] = "Edu Brokers - Password Reset";
                $attributes['file'] = "frontend.mails.forgot_reset";
                $attributes['email'] = $user->email;
                (new Helpers())->EduMailer($attributes);
                return redirect()->back()->with(['success' => 'Password Reset Successfull.']);
            } else {
                return redirect()->back()->with(['error' => 'Password reset link expired or not available, please check and try again.']);
            }
        } else {
            return redirect()->back()->with(['error' => 'Something went wrong, please check and try again.']);
        }
    }

    public function singupSteps($user)
    {

        if (isset($user) && !empty($user)) {
            $userId = (new Helpers())->encrypt_string($user->id);
            if ($user->type == 'student') {
                if ($user->singup_steps == 1) {
                    Auth::guard('web')->logout();
                    Flashy::error("Please complete your profile first..");
                    return redirect()->route('second_step', $userId)->with(['error' => 'Please complete your profile first..']);
                } else if ($user->singup_steps == 2) {
                    Auth::guard('web')->logout();
                    Flashy::error("Please complete your profile first..");
                    return redirect()->route('third_step', $userId)->with(['error' => 'Please complete your profile first..']);
                } else if ($user->singup_steps == 3) {
                    Auth::guard('web')->logout();
                    Flashy::error("Please complete your profile first..");
                    return redirect()->route('fourth_step', $userId)->with(['error' => 'Please complete your profile first..']);
                }
            } else {
                if ($user->singup_steps == 1) {
                    Auth::guard('web')->logout();
                    Flashy::error("Please complete your profile first..");
                    return redirect()->route('second_step', $userId)->with(['error' => 'Please complete your profile first..']);
                } elseif ($user->singup_steps == 2) {
                    Auth::guard('web')->logout();
                    Flashy::error("Please complete your profile first..");
                    return redirect()->route('third_step', $userId)->with(['error' => 'Please complete your profile first..']);
                }
            }
        }
        return true;
    }
    public function changeStatusMultipleStatus(Request $request)
    {
        $data = $request->except(['_method', '_token']);

        if ($data['data']) {
            foreach ($data['data'] as $app) {
                $application = $this->applications->whereId($app)->first();
                $application->status = $data['status'];
                $application->save();
                try {
                    $status = ucwords(str_replace('_', ' ', $application->status));
                    $email = $application->user->email;
                    $attributes['code'] = rand();
                    $attributes['university']=$application->university->fullname;
                    $attributes['status']=$status;
                    $attributes['email'] = $email;
                    $appData['user_email']=$application->user->email;
                    Mail::send('frontend.mails.application_status', ['data' => $attributes], function ($message) use ($attributes) {
                        $message->from('no-reply@edubrokers.com', 'edubrokers.com');
                        $message->to($attributes['email']);
                        $message->replyTo('no-reply@edubrokers.com', 'Decision on recent application');
                        $message->subject('Decision on recent application');
                    });
                } catch (\Exception $e) {
                    dd($e);
                }
            }

            return response()->json(['status' => true]);
        }

    }
    public function index()
    {
        $cat = Category::where('parent_id', null)->get();
        $posts = Post::take(3)->orderBy('created_at', 'DESC')->get();
        $states = State::get();
        return view('frontend.pages.welcome', compact('cat', 'posts', 'states'));
    }
    public function store(Request $request)
    {
        try {
            parse_str($request['data'], $dataPost);
            if ($dataPost) {
                // dd($dataPost);
                // $rules = [
                //     'email' => 'required|email|unique:users',
                //     'password' => 'required',
                //     'user_type' => 'required',
                // ];
                // $customMessages = [
                //     'email.unique' => 'An Edu Brokers account already exists with this email address.',
                //     'email.required' => 'An Edu Brokers account already exists with this email address.',
                //     'password.required' => 'An Edu Brokers account already exists with this email address.'
                // ];

                // $validatedData = $request->validate($rules, $customMessages);

                $validator = Validator::make($dataPost, [
                    'email' => 'required|email|unique:users',
                    'password' => 'required',
                    'user_type' => 'required',
                ]);
                $customMessages = [
                    'email.unique' => 'An Edu Brokers account already exists with this email address.',
                    'email.email' => 'Fix Email format.',
                    'email.required' => 'Email is required Field.',
                    'password.required' => 'Password is required Field.',
                    'user_type.required' => 'User type is not defined.'
                ];

                $validator->setCustomMessages($customMessages);

                if ($validator->fails()) {
                    // $errors = $validator->errors();
                    $errors = implode("\n", $validator->errors()->all());
                    return response()->json(['status' => false, 'errors' => $errors]);
                } else {
                    $user = new User();
                    $user->email = $dataPost['email'];
                    $user->password = Hash::make($dataPost['password']);
                    $user->type = $dataPost['user_type'];
                    $user->singup_steps = 1;
                    $user->isActive = 0;
                    $user->save();

                    if ($dataPost['user_type'] == 'university') {
                        $factors = $this->defaultStartFactors();
                        if (!empty($factors)) {
                            foreach ($factors as $fact) {
                                $this->RatingFactors->create(['title' => $fact, 'uni_id' => $user->id]);
                            }
                        }
                    }

                    $encrypted = (new Helpers())->encrypt_string($user->id);
                    return response()->json(['status' => true, 'user' => $encrypted]);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'errors' => $e]);
        }
    }
    //    public function checkEmailAvailability(Request $request)
    //    {
    //        $email = $request->input('email');
    //        $user = User::where('email', $email)->first();
    //        if ($user) {
    //            return response()->json(false);
    //        }
    //        return response()->json(true);
    //    }
    public function markFavourite(Request $request)
    {

        $data = $request->except(['_method', '_token']);
        if ($data['isFvt']) {
            $this->favourite->updateOrCreate(['student_id' => Auth::user()->id, 'uni_id' => $data['universityId']], ['student_id' => Auth::user()->id, 'uni_id' => $data['universityId']]);
        } else {
            $this->favourite->where(['student_id' => Auth::user()->id, 'uni_id' => $data['universityId']])->delete();
        }
        $favourites = $this->favourite->with('university.userInfo')->where('student_id', Auth::user()->id)->get();
        $view = view('frontend.pages.favourites', compact('favourites'))->render();
        return response()->json(['status' => true, 'totalCount' => $favourites->count(), 'view' => $view]);
    }
    public static function makeEncryption($id)
    {
        return (new Helpers())->encrypt_string($id);
    }
    public function studentFactors(Request $request)
    {

        $data = $request->except(['_method', '_token']);
        if ($data) {
            $this->studentFactors->updateOrCreate(['uni_id' => Auth::user()->id, 'student_id' => $data['studentId'], 'factorId' => $data['factorId']], [
                'uni_id' => Auth::user()->id,
                'student_id' => $data['studentId'],
                'rating' => $data['rate'],
                'factorId' => $data['factorId'],
            ]);
            $totalSum = $this->studentFactors->where(['uni_id' => Auth::user()->id, 'student_id' => $data['studentId']])->sum('rating');
            $universityFactors = $this->RatingFactors->where('uni_id', Auth::user()->id)->count();
            $sumRating = ((int)$totalSum / $universityFactors);
            return response()->json(['status' => true, 'sumRating' => round($sumRating, 2)]);
        }
    }
    public function addStartRatings(Request $request)
    {

        $data = $request->except(['_method', '_token']);
        if ($data) {
            if ($data['ratingFields']) {
                foreach ($data['ratingFields'] as $rating) {
                    $this->RatingFactors->create([
                        'title' => $rating,
                        'uni_id' => Auth::user()->id,
                    ]);
                }
            }
        }
        return redirect()->back()->with(['success' => 'Added Successfully.']);
    }
    public function submitSecond(Request $request)
    {

        try {
            $userId = (new Helpers())->decrypt_string($request['user_id']);
            $user = User::whereId($userId)->first();
            $update = array();
            if (isset($request['first_name']) && !empty($request['first_name'])) {
                if (isset($user->type) && $user->type == 'university') {
                    $last = substr(strstr($request['first_name'], " "), 1);
                    $exploaded = explode(' ', $request['first_name']);
                    $update['first_name'] = (isset($exploaded[0]) ? $exploaded[0] : '');
                    $update['last_name'] = $last;
                    $update['fullname'] = $request['first_name'];
                } else {
                    $update['first_name'] = $request['first_name'];
                }
            }
            if (isset($request['last_name']) && !empty($request['last_name'])) {
                if ($user->type == 'university') {
                    $exploaded = explode(' ', $request['last_name']);
                    $update['last_name'] = (isset($exploaded[1]) ? $exploaded[1] : '');
                } else {
                    $update['last_name'] = $request['last_name'];
                }
            }
            if (isset($request['phone']) && !empty($request['phone'])) {
                $update['phone'] = $request['phone'];
            }
            if (isset($request['gender']) && !empty($request['gender'])) {
                $update['gender'] = $request['gender'];
            }
            if (isset($request['dob']) && !empty($request['dob'])) {
                $update['dob'] = Carbon::parse($request['dob'])->format('Y-m-d');
            }
            if (isset($request['image']) && !empty($request['image'])) {
                $height = Image::make($request['image'])->height();
                $width = Image::make($request['image'])->width();
                $height = ($height / $width * 750);
                $image    = $request['image'];
                $fileName = str_replace(' ', '', pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME));
                $extension = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
                $imageName = $fileName . "-" . time() . "." . $image->getClientOriginalExtension();
                $image_resize = Image::make($image->getRealPath());
                $image_resize->resize(750, $height);
                $image_resize->save(public_path('storage/users/' . $imageName));
                $uploadedImage = "public/users/" . $imageName;
                $update['image'] = $uploadedImage;
            }
            if (isset($request['uni_email']) && !empty($request['uni_email'])) {
                $update['uni_email'] = $request['uni_email'];
            }
            if (isset($request['fax']) && !empty($request['fax'])) {
                $update['fax'] = $request['fax'];
            }
            if (isset($request['city']) && !empty($request['city'])) {
                $update['city'] = $request['city'];
            }
            if (isset($request['state']) && !empty($request['state'])) {
                $update['state'] = $request['state'];
            }
            if (isset($request['zipcode']) && !empty($request['zipcode'])) {
                $update['zipcode'] = $request['zipcode'];
            }
            if (isset($request['address1']) && !empty($request['address1'])) {
                $update['address1'] = $request['address1'];
            }
            if (isset($request['address2']) && !empty($request['address2'])) {
                $update['address2'] = $request['address2'];
            }
            if (isset($request['latitude']) && !empty($request['latitude'])) {
                $update['latitude'] = $request['latitude'];
            }
            if (isset($request['country']) && !empty($request['country'])) {
                $update['country'] = $request['country'];
            }
            if (isset($request['longitude']) && !empty($request['longitude'])) {
                $update['longitude'] = $request['longitude'];
            }
            if (isset($request['website']) && !empty($request['website'])) {
                $update['website'] = $request['website'];
            }
            if (isset($request['ethnicity']) && !empty($request['ethnicity'])) {
                $update['ethnicity'] = $request['ethnicity'];
            }
            $update['singup_steps'] = 2;
            User::whereId($userId)->update($update);
            return redirect()->route('third_step', $request['user_id']);
        } catch (\Exception $e) {
            Flashy::success("Something went wrong..");
            return redirect()->back();
        }
    }
    public function cleanNumber($number)
    {
        $number = str_replace('$', '', str_replace(',', '', $number));
        $number = preg_replace('/[^0-9]/', '', $number);
        $number = ((int) filter_var($number, FILTER_SANITIZE_NUMBER_INT));
        return $number;
    }
    public function cleanNumber2Dec($number)
    {
        $number = str_replace('$', '', str_replace(',', '', $number));
        return $number;
    }
    public function submitThird(Request $request)
    {

        try {
            $userId = (new Helpers())->decrypt_string($request['user_id']);
            $user = User::whereId($userId)->first();
            if ($user->type == 'university') {
                $UserInfo = new UserInfo();
                if (isset($request['spring_dead_start']) && !empty($request['spring_dead_start'])) {
                    $UserInfo->spring_dead_start = $this->cleanNumber($request['spring_dead_start']);
                }
                if (isset($request['spring_dead_end']) && !empty($request['spring_dead_end'])) {
                    $UserInfo->spring_dead_end = $this->cleanNumber($request['spring_dead_end']);
                }
                if (isset($request['fall_dead_start']) && !empty($request['fall_dead_start'])) {
                    $UserInfo->fall_dead_start = $this->cleanNumber($request['fall_dead_start']);
                }
                if (isset($request['fall_dead_end']) && !empty($request['fall_dead_end'])) {
                    $UserInfo->fall_dead_end = $this->cleanNumber($request['fall_dead_end']);
                }
                if (isset($request['annual_in_state']) && !empty($request['annual_in_state'])) {
                    $UserInfo->annual_in_state = $this->cleanNumber($request['annual_in_state']);
                }
                if (isset($request['annual_out_state']) && !empty($request['annual_out_state'])) {
                    $UserInfo->annual_out_state = $this->cleanNumber($request['annual_out_state']);
                }
                if (isset($request['manda_in_state']) && !empty($request['manda_in_state'])) {
                    $UserInfo->manda_in_state = $this->cleanNumber($request['manda_in_state']);
                }
                if (isset($request['manda_out_state']) && !empty($request['manda_out_state'])) {
                    $UserInfo->manda_out_state = $this->cleanNumber($request['manda_out_state']);
                }
                if (isset($request['room_in_state']) && !empty($request['room_in_state'])) {
                    $UserInfo->room_in_state = $this->cleanNumber($request['room_in_state']);
                }
                if (isset($request['room_out_state']) && !empty($request['room_out_state'])) {
                    $UserInfo->room_out_state = $this->cleanNumber($request['room_out_state']);
                }
                if (isset($request['dis_in_state']) && !empty($request['dis_in_state'])) {
                    $UserInfo->dis_in_state = $this->cleanNumber($request['dis_in_state']);
                }
                if (isset($request['dis_out_state']) && !empty($request['dis_out_state'])) {
                    $UserInfo->dis_out_state = $this->cleanNumber($request['dis_out_state']);
                }
                if (isset($request['tyearly_in_state']) && !empty($request['tyearly_in_state'])) {
                    $UserInfo->tyearly_in_state = $this->cleanNumber($request['tyearly_in_state']);
                }
                if (isset($request['tyearly_out_state']) && !empty($request['tyearly_out_state'])) {
                    $UserInfo->tyearly_out_state = $this->cleanNumber($request['tyearly_out_state']);
                }
                if (isset($request['pann_in_state']) && !empty($request['pann_in_state'])) {
                    $UserInfo->pann_in_state = $this->cleanNumber($request['pann_in_state']);
                }
                if (isset($request['pann_out_state']) && !empty($request['pann_out_state'])) {
                    $UserInfo->pann_out_state = $this->cleanNumber($request['pann_out_state']);
                }
                if (isset($request['pdis_in_state']) && !empty($request['pdis_in_state'])) {
                    $UserInfo->pdis_in_state = $this->cleanNumber($request['pdis_in_state']);
                }
                if (isset($request['pdis_out_state']) && !empty($request['pdis_out_state'])) {
                    $UserInfo->pdis_out_state = $this->cleanNumber($request['pdis_out_state']);
                }
                if (isset($request['pcredit_in_state']) && !empty($request['pcredit_in_state'])) {
                    $UserInfo->pcredit_in_state = $this->cleanNumber($request['pcredit_in_state']);
                }
                if (isset($request['pcredit_out_state']) && !empty($request['pcredit_out_state'])) {
                    $UserInfo->pcredit_out_state = $this->cleanNumber($request['pcredit_in_state']);
                }
                if (isset($request['other_info']) && !empty($request['other_info'])) {
                    $UserInfo->other_info = $request['other_info'];
                }
                if (isset($request['scholarship_info']) && !empty($request['scholarship_info'])) {
                    $UserInfo->scholarship_info = $request['scholarship_info'];
                }
                if (isset($request['latitude']) && !empty($request['latitude'])) {
                    $user->latitude = $request['latitude'];
                }
                if (isset($request['longitude']) && !empty($request['longitude'])) {
                    $user->longitude = $request['longitude'];
                }
                $user->singup_steps = 3;
                $UserInfo->user_id = $user->id;
                $UserInfo->save();
                $user->update();
                $login = User::whereId($userId)->first();
                $attributes['subject'] = "Welcome to Edu Brokers";
                $attributes['file'] = "frontend.mails.welcome";
                $attributes['type'] = "university";
                $attributes['email'] = $login->email;
                (new Helpers())->EduMailer($attributes);
                return redirect()->route('thankyou');
            } else {
                if (isset($request['address1']) && !empty($request['address1'])) {
                    $user->address1 = $request['address1'];
                }
                if (isset($request['address2']) && !empty($request['address2'])) {
                    $user->address2 = $request['address2'];
                }
                if (isset($request['city']) && !empty($request['city'])) {
                    $user->city = $request['city'];
                }
                if (isset($request['country']) && !empty($request['country'])) {
                    $user->country = $request['country'];
                }
                if (isset($request['state']) && !empty($request['state'])) {
                    $user->state = $request['state'];
                }
                if (isset($request['zipcode']) && !empty($request['zipcode'])) {
                    $user->zipcode = $request['zipcode'];
                }
                if (isset($request['latitude']) && !empty($request['latitude'])) {
                    $user->latitude = $request['latitude'];
                }
                if (isset($request['longitude']) && !empty($request['longitude'])) {
                    $user->longitude = $request['longitude'];
                }
                $user->singup_steps = 3;
                $user->update();
                return redirect()->route('fourth_step', $request['user_id']);
            }
        } catch (\Exception $e) {
            Flashy::error("Invalid Input values please check and try again..");
            return redirect()->back()->with(['error' => $e->getMessage()]);;
        }
        return redirect()->route('fourth_step', $request['user_id']);
    }
    public function submitFourth(Request $request)
    {

        $userId = (new Helpers())->decrypt_string($request['user_id']);
        $user = new UserInfo();
        if (isset($request['student_type']) && !empty($request['student_type'])) {
            $user->student_type = $request['student_type'];
        }
        if (isset($request['education_level']) && !empty($request['education_level'])) {
            $user->education_level = $request['education_level'];
        }
        if (isset($request['institution']) && !empty($request['institution'])) {
            $user->institution = $request['institution'];
        }
        if (isset($request['interest']) && !empty($request['interest'])) {
            $user->interest = implode(',', $request['interest']);
        }
        $user->user_id = $userId;
        $user->save();
        $login = User::whereId($userId)->first();
        $login->singup_steps = 4;
        $login->update();
        $login = User::whereId($userId)->first();
        if ($login->type == 'student') {
            $login = User::whereId($userId)->first();
            $attributes['subject'] = "Welcome to Edu Brokers";
            $attributes['file'] = "frontend.mails.welcome";
            $attributes['type'] = "student";
            $attributes['email'] = $login->email;
            (new Helpers())->EduMailer($attributes);
            Auth::login($login);
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('thankyou');
        }
    }
    public function second_step($userId)
    {
        $decrypted = (new Helpers())->decrypt_string($userId);
        $user = User::whereId($decrypted)->first();
        return view('frontend.pages.signup_profile', compact('userId', 'user'));
    }
    public function third_step($userId)
    {
        $decrypted = (new Helpers())->decrypt_string($userId);
        $user = User::whereId($decrypted)->first();
        return view('frontend.pages.signup_addresses', compact('userId', 'user'));
    }
    public function fourth_step($userId)
    {
        $decrypted = (new Helpers())->decrypt_string($userId);
        return view('frontend.pages.signup_educational', compact('userId'));
    }
    public function dashboard($pattern = false, $type = false)
    {
        if (empty($pattern)) {
            return redirect()->route('dashboard', ['applications']);
        }
        $returned_val = $this->singupSteps(Auth::user());
        if ($returned_val instanceof RedirectResponse) {
            Flashy::success("Please complete your profile first..");
            return $returned_val->with(['error' => 'Please complete your profile first..']);
        }
        $page_controller = 'dashboard';
        $universities = '';
        $userType = Auth::user()->type;
        $isSearch = 0;
        $applicationsWithOffers = '';
        $countsSum = array();
        if ($userType == 'university') {
            $ratingsFactors = $this->RatingFactors->where('uni_id', Auth::user()->id)->get();
            if (!empty($pattern)) {
                if ($pattern == 'offers') {
                    if ($type == 'pending') {
                        $type = 'offer_extend';
                    } else if ($type == 'approved-shortlist') {
                        $type = 'approve_shortlist';
                    } else if ($type == 'history') {
                        $type = 'rejected';
                    }
                    $countsSum['pending_count'] = $this->applications->where('status', 'offer_extend')->where('uni_id', Auth::user()->id)->count();
                    $countsSum['approved_count'] = $this->applications->where('status', 'approve_shortlist')->where('isOffered', 1)->where('uni_id', Auth::user()->id)->count();
                    $countsSum['rejected'] = $this->applications->where('status', 'rejected')->where('isOffered', 1)->where('uni_id', Auth::user()->id)->count();
                    if (!empty($type)) {
                        $applicationsWithOffers = $this->applications->with('user', 'course', 'offer')->where('isOffered', 1)->where('status', $type)->whereHas('offer')->where('uni_id', Auth::user()->id)->get();
                        $applications = $this->applications->with('user', 'course', 'program', 'offer')->where('isOffered', 1)->where('status', $type)->where('uni_id', Auth::user()->id)->get();
                    } else {
                        $applications = $this->applications->with('user', 'course', 'program', 'offer')->where('isOffered', 1)->where('uni_id', Auth::user()->id)->get();
                    }
                } else {
                    if ($type == 'pending') {
                        $type = 'mark_pending';
                    } else if ($type == 'approved-shortlist') {
                        $type = 'approve_shortlist';
                    } else if ($type == 'history') {
                        $type = 'rejected';
                    }
                    $countsSum['pending_count'] = $this->applications->where('status', 'mark_pending')->where('uni_id', Auth::user()->id)->count();
                    $countsSum['approved_count'] = $this->applications->where('status', 'approve_shortlist')->where('uni_id', Auth::user()->id)->count();
                    $countsSum['rejected'] = $this->applications->where('status', 'rejected')->where('uni_id', Auth::user()->id)->count();
                    if (!empty($type)) {
                        $applications = $this->applications->with('user', 'course', 'program', 'offer')->where('status', $type)->where('uni_id', Auth::user()->id)->get();
                    } else {
                        $applications = $this->applications->with('user', 'course', 'program', 'offer')->where('uni_id', Auth::user()->id)->get();
                    }
                }
            } else {
                $applications = $this->applications->with('user', 'course', 'program', 'offer')->where('uni_id', Auth::user()->id)->get();
            }
            $states = State::get();

            return view('frontend.pages.dashboard_university', compact('isSearch', 'applications', 'ratingsFactors', 'pattern', 'applicationsWithOffers', 'type', 'countsSum', 'states'));
        } else {
            $states = State::get();

            $recentViews = $this->recentViewed->with('university')->where('student_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
            $featured = $this->user->with('userInfo', 'favourite')->where('isFeatured', 1)->inRandomOrder()->get();
            $user = Auth::user();

            if (!empty($pattern) && $pattern == 'history') {
                $applications = $this->applications->with(['university', 'offer', 'university.favourite' => function ($q) {
                    $q->where('student_id', Auth::user()->id);
                }])->where('user_id', Auth::user()->id)->where('status', 'rejected')->get();
            } else if (!empty($pattern) && $pattern == 'nearest') {
                if (Session::has('current_lat')) {
                    $lat = Session::get('current_lat');
                    $lon = Session::get('current_long');
                } else {
                    $lat = Auth::user()->latitude;
                    $lon = Auth::user()->longitude;
                }
                $universities = DB::table("users")
                    ->select(
                        "users.*",
                        DB::raw("6371 * acos(cos(radians(" . $lat . "))
                * cos(radians(users.latitude))
                * cos(radians(users.longitude) - radians(" . $lon . "))
                + sin(radians(" . $lat . "))
                * sin(radians(users.latitude))) AS distance")
                    )
                    ->groupBy("users.id")
                    ->OrderBy("distance", "ASC")
                    ->where('type', 'university')
                    ->having('distance', '<=', 100)
                    ->where('isActive', 1)
                    ->get();
                $isSearch = 1;
                $applications = $this->applications->with(['university', 'offer', 'university.favourite' => function ($q) {
                    $q->where('student_id', Auth::user()->id);
                }])->where('user_id', Auth::user()->id)->where('status', 'rejected')->get();
            } else {
                $applications = $this->applications->with(['university', 'offer', 'university.favourite' => function ($q) {
                    $q->where('student_id', Auth::user()->id);
                }])->where('status', '!=', 'rejected')->where('user_id', Auth::user()->id)->get();
            }
            if (isset(Auth::user()->id)) {
                $applicationOffered = Applications::with(['offer' => function ($q) {
                    $q->where('isAccepted', 1);
                }])->where('user_id', Auth::user()->id)->where('isOffered', 1)->first();
            } else {
                $applicationOffered = Applications::with(['offer' => function ($q) {
                    $q->where('isAccepted', 1);
                }])->where('isOffered', 1)->first();
            }
            return view('frontend.pages.dashboard', compact('isSearch', 'applications', 'pattern', 'recentViews', 'featured', 'type', 'countsSum', 'universities', 'user', 'states', 'applicationOffered', 'page_controller'));
        }
    }
    public function removeRatingsFactor(Request $request)
    {

        $data = $request->except(['_method', '_token']);
        if ($data['id']) {
            $this->RatingFactors->whereId($data['id'])->delete();
        }
    }
    public function loginUser(Request $request)
    {

        parse_str($request['data'], $dataPost);
        $credentials['email'] = $dataPost['email'];
        $credentials['password'] = $dataPost['password'];
        $remember = false;
        if (isset($request['remember_me'])) {
            $remember = true;
        }
        if (Auth::guard('web')->attempt($credentials, $remember)) {
            return response()->json(['status' => true, 'user' => Auth::user()]);
        } else {
            $message = "Invalid credentials. Please try again";
            return response()->json(['status' => false, 'message' => $message]);
        }
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
    public function searchUniversity(Request $request)
    {
        $data = $request->except(['_method', '_token']);
        if (isset($data['zipcode']) && !empty($data['zipcode'])) {
            $latLongs = $this->getLnt($data['zipcode']);
        } else {
            $latLongs = false;
        }
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
        session()->flashInput($request->input());
        $userType = Auth::user()->type;
        $isSearch = 1;
        $states = State::get();
        $page_controller = 'search_result';
        if ($userType == 'university') {
            return view('frontend.pages.dashboard_university', compact('universities', 'isSearch', 'states'));
        } else {
            $recentViews = $this->recentViewed->with('university')->where('student_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
            $featured = $this->user->with('userInfo', 'favourite')->where('isFeatured', 1)->inRandomOrder()->get();
            return view('frontend.pages.dashboard', compact('universities', 'isSearch', 'recentViews', 'featured', 'states', 'page_controller'));
        }
    }

    public function thankyou(Request $request)
    {

        return view('frontend.pages.thankyou');
    }

    public function unpublish(Request $request)
    {

        return view('frontend.pages.unpublish');
    }

    public function applyUniversity(Request $request)
    {
        $data = $request->except(['_method', '_token']);
        $appData = array();
        if ($data) {
            if ($data['apply_via'] == 'mark_favourite') {
                $this->favourite->updateOrCreate(['student_id' => Auth::user()->id, 'uni_id' => $data['uni_id']], ['student_id' => Auth::user()->id, 'uni_id' => $data['uni_id']]);
                $this->recentViewed->updateOrCreate(['student_id' => Auth::user()->id, 'uni_id' => $data['uni_id']], ['student_id' => Auth::user()->id, 'uni_id' => $data['uni_id']]);
                return redirect()->back()->with(['success' => 'Successfully Added to Favorite list.']);
            }
            if ($data['apply_via'] == 'remove_favourite') {
                $this->favourite->where(['student_id' => Auth::user()->id, 'uni_id' => $data['uni_id']])->delete();
                return redirect()->back()->with(['success' => 'University removed from Favorite list.']);
            }
            $app = $this->applications->create([
                'user_id' => Auth::user()->id,
                'uni_id' => $data['uni_id'],
                'season' => $data['season'],
                'program_type' => $data['program_type'],
                'course_id' => $data['course_id'],
                'apply_via' => $data['apply_via'],
                'status' => 'mark_pending',
            ]);
            if ($app->apply_via == 'apply_on_common_ap') {
                $applyvie = 'Common App';
            } else if ($app->apply_via == 'apply_directly_through_the_uni') {
                $applyvie = 'Directly through University';
            } else if ($app->apply_via == 'apply_via_black_college_app') {
                $applyvie = 'Common Black College App';
            } else {
                $applyvie = 'Application Submited Successfully..';
            }
            try {
                $university = $this->user->whereId($data['uni_id'])->first();
                $appData['season'] = $app->season;
                $appData['user_name'] = Auth::user()->first_name . ' ' . Auth::user()->last_name;
                $appData['apply_via'] = $applyvie;
                $appData['created_at'] = Carbon::parse($app->created_at)->format('m-d-Y');
                $appData['user_email'] = Auth::user()->email;
                $appData['university'] = $university->first_name . ' ' . $university->last_name;
                $appData['university_email'] = $university->email;
                Mail::send('frontend.mails.apply_application', ['data' => $appData], function ($message) use ($appData) {
                    $message->from('no-reply@edubrokers.com', 'Edubrokers.com');
                    $message->to([$appData['user_email']]);
                    $message->replyTo('no-reply@edubrokers.com', 'Edu Brokers');
                    $message->subject('Application Submited');
                });
                Mail::send('frontend.mails.university_alert', ['data' => $appData], function ($message) use ($appData) {
                    $message->from('no-reply@edubrokers.com', 'Edubrokers.com');
                    $message->to([$appData['university_email']]);
                    $message->replyTo('no-reply@edubrokers.com', 'Edu Brokers');
                    $message->subject('Application Received');
                });
            } catch (\Exception $e) {
            }
        }
        if ($data['apply_via'] == 'apply_on_common_ap') {
            $message = 'Connected to Common App';
        } else if ($data['apply_via'] == 'apply_via_black_college_app') {
            $message = 'Connected to Common Black College App';
        } else if ($data['apply_via'] == 'apply_directly_through_the_uni') {
            $message = 'Connected to University';
        } else {
            $message = 'application submited successfully..';
        }

        return redirect()->back()->with(['success' => $message]);
    }

    public function universityDetail($id)
    {

        $userId = (new Helpers())->decrypt_string($id);
        if (!$userId) {
            return Redirect::to($id);
        }
        $AcceptedApplication = '';
        $user = User::with('userInfo', 'courses.programes')->whereId($userId)->first();

        if ($user->isActive !== 1) {
            return redirect()->route('unpublish');
        }
        if (isset(Auth::user()->id)) {
            $this->recentViewed->updateOrCreate(['student_id' => Auth::user()->id, 'uni_id' => $userId], ['student_id' => Auth::user()->id, 'uni_id' => $userId]);
            $application = Applications::with('offer')->where('user_id', Auth::user()->id)->where('uni_id', $userId)->first();
        } else {
            $application = '';
        }
        if (isset(Auth::user()->id)) {
            $AcceptedApplication = Applications::whereHas('offer', function ($q) {
                $q->where('isAccepted', 1);
            })->where('user_id', Auth::user()->id)->first();
        }

        if (isset(Auth::user()->id)) {
            $applicationOffered = Applications::with(['offer' => function ($q) {
                $q->where('isAccepted', 1);
            }])->where('user_id', Auth::user()->id)->where('isOffered', 1)->first();
        } else {
            $applicationOffered = Applications::with(['offer' => function ($q) {
                $q->where('isAccepted', 1);
            }])->where('isOffered', 1)->first();
        }

        return view('frontend.pages.university_detail', compact('user', 'application', 'AcceptedApplication', 'applicationOffered'));
    }

    public function studentOffer($id)
    {

        $app_id = (new Helpers())->decrypt_string($id);
        $ratingsFactors = $this->RatingFactors->where('uni_id', Auth::user()->id)->get();
        $application = $this->applications->with('user.userInfo')->whereId($app_id)->first();
        $sumRating = 0;
        $universityFactors = "";
        $universityFactorsArray = "";
        $totalSum = $this->studentFactors->where(['uni_id' => Auth::user()->id, 'student_id' => $application->user->id])->get();
        if (!empty($totalSum)) {
            $universityFactorsArray = $totalSum->toArray();
            $universityFactors = $this->RatingFactors->where('uni_id', Auth::user()->id)->count();
            if (!empty($universityFactors)) {
                $sumRating = round(((int)$totalSum->sum('rating') / $universityFactors), 2);
            }
        }
        return view('frontend.pages.student_offer', compact('application', 'ratingsFactors', 'sumRating', 'universityFactorsArray'));
    }


    static function getRatingSum($studentId)
    {

        $sumRating = 0;
        $universityFactors = "";
        $universityFactorsArray = "";
        $totalSum = StudentFactors::where(['uni_id' => Auth::user()->id, 'student_id' => $studentId])->get();
        if (!empty($totalSum)) {
            $universityFactorsArray = $totalSum->toArray();
            $universityFactors = RatingFactors::where('uni_id', Auth::user()->id)->count();
            if (!empty($universityFactors)) {
                $sumRating = round(((int)$totalSum->sum('rating') / $universityFactors), 2);
            } else {
                return 'Not Rated Yet';
            }
            return $sumRating;
        } else {
            return 'Not Rated Yet';
        }
    }


    public function StudentProfile(Request $request)
    {

        $user = $this->user->with('userInfo')->whereId(Auth::user()->id)->first();
        //        dd($user->userInfo);
        return view('frontend.user.profile', compact('user'));
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        Session::forget('outside_total');
        Session::forget('marked_no');
        return redirect()->route('home');
    }
}
