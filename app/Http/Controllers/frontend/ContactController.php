<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('web');
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function universityContact()
    {
        return view('frontend.pages.university_contact');
    }

    public function contactPost(Request $request)
    {

        $data = $request->except(['_method', '_token']);
        if ($data) {
            try {
                $data['code'] = rand();
                $data['email_admin'] = 'support@edubrokers.com';
                Mail::send('frontend.mails.contact-us', ['data' => $data], function ($message) use ($data) {
                    $message->from('no-reply@edubrokers.com', 'Edubrokers.com');
                    $message->to($data['email_admin']);
                    $message->replyTo('no-reply@edubrokers.com', 'Contact us');
                    $message->subject('Contact us');
                });

                return redirect()->back()->with(['success' => 'Thank You for your Message!  An Edu Brokers associate will respond within 24-48hrs.']);
            } catch (\Exception $e) {

                return redirect()->back()->with(['error' => 'Something went wrong, try again later.']);
            }
        }
    }

    public function universityContactPost(Request $request)
    {
        $data = $request->except(['_method', '_token']);
        if ($data) {
            try {
                $data['code'] = rand();
                $data['email_admin'] = 'universitysupport@edubrokers.com';
                Mail::send('frontend.mails.university_contact-us', ['data' => $data], function ($message) use ($data) {
                    $message->from('no-reply@edubrokers.com', 'Edubrokers.com');
                    $message->to($data['email_admin']);
                    $message->replyTo('no-reply@edubrokers.com', 'Contact us');
                    $message->subject('University Contact us');
                });
                return redirect()->back()->with(['success' => 'Thank You for your Message!  An Edu Brokers associate will respond within 24-48hrs.']);
            } catch (\Exception $e) {
                return redirect()->back()->with(['error' => 'Something went wrong, try again later.']);
            }
        }


    }
}
