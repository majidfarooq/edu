<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Libraries\Helpers;
use App\Models\ApplicationOffers;
use App\Models\Applications;
use App\Models\Courses;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $user;
    protected $applicationsOffers;
    protected $applications;
    public function __construct(ApplicationOffers $applicationOffers)
    {
        $this->applicationsOffers=$applicationOffers;
        $this->user= new User();
        $this->applications= new Applications();
    }

    public function index()
    {
        //
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

    public function storeLatLong(Request $request){

        if(isset($request['data']['latitude'])){
            Session::put('current_lat',$request['data']['latitude']);
            Session::put('current_long',$request['data']['longitude']);
        }

    }

    public function changeApplicationStatus(Request $request)
    {
        $data = $request->except(['_method', '_token']);
        if($data){
            $this->applications->whereId($data['data']['application_id'])->update(['status'=>$data['data']['status'],'isOffered'=>null]);
            $this->applicationsOffers->where('application_id',$data['data']['application_id'])->update(['isAccepted'=>0]);
            $application= $this->applications->whereId($data['data']['application_id'])->with('user','university')->first();
            if($data['data']['status']=='rejected'){
                try {
                    $attributes['code']=rand();
                    $attributes['email']=$application->user->email;
                    $attributes['university']=$application->university->fullname;
                    Mail::send('frontend.mails.university_decline_student',['data' => $attributes],function($message) use ($attributes){
                        $message->from('no-reply@edubrokers.com','edubrokers.com');
                        $message->to([$attributes['email']]);
                        $message->replyTo('no-reply@edubrokers.com', 'Decision on recent application');
                        $message->subject('Decision on recent application');
                    });
                } catch (\Exception $e) {

                }
            }else{

                return response()->json(['status'=>true]);
            }
            return response()->json(['status'=>true]);
        }
    }

    public function changeApplicationModal(Request $request)
    {
        $data = $request->except(['_method', '_token']);
        if($data){
            $this->applications->whereId($data['modal_status_id'])->update(['status'=>$data['status']]);
            return redirect()->back()->with(['success' => 'Application Status Updated Successfully.']);
        }
    }

    public function ChangeofferStatus(Request $request)
    {
        $data = $request->except(['_method', '_token']);
        if($data){
            if($data['data']['status']=='accept'){
                $this->applications->where('user_id',Auth::user()->id)->update(['status'=>'rejected','isOffered'=>null,'notInterested'=>1]);
                $this->applications->whereId($data['data']['application_id'])->update(['status'=>'approve_shortlist','isOffered'=>1]);
                $this->applicationsOffers->whereId($data['data']['offer_id'])->update(['isAccepted'=>1]);
            }else{
                $this->applications->whereId($data['data']['application_id'])->update(['status'=>'rejected','isOffered'=>null,'notInterested'=>1]);
                $this->applicationsOffers->whereId($data['data']['offer_id'])->update(['isAccepted'=>0]);
            }
            return response()->json(['status'=>true]);
        }
    }

    public function submitOffer(Request $request)
    {
        $data = $request->except(['_method', '_token']);
        if($data){
            if(isset($data['multiple_offers'])){
                $multiple=explode(',',$data['multiple_offers']);
                if(!empty($multiple)){
                    foreach ($multiple as $app){
                        $offer=array();
                        $this->applicationsOffers->where('application_id',$app)->delete();
                        if(isset($app) && !empty($app)){
                            $offer['application_id']=$app;
                        }
                        if(isset($data['title']) && !empty($data['title'])){
                            $offer['title']=$data['title'];
                        }
                        if(isset($data['attachment']) && !empty($data['attachment'])){
                            $offer['attachment']=(new Helpers())->uploadFile($request['attachment'], 'application_offers');
                        }
                        if(isset($data['desc']) && !empty($data['desc'])){
                            $offer['desc']=$data['desc'];
                        }
                        $submit= $this->applicationsOffers->create($offer);
                        if($submit){
                            $this->applications->whereId($app)->update(['isOffered'=>1,'status'=>'offer_extend']);
                        }
                    }
                    return redirect()->back()->with(['success' => 'Offer Submited Successfully.']);
                }
            }else{
                $offer=array();
                $this->applicationsOffers->where('application_id',$data['application_id'])->delete();

                $application=$this->applications->whereId($data['application_id'])->with('university','user')->first();

                if(isset($data['application_id']) && !empty($data['application_id'])){
                    $offer['application_id']=$data['application_id'];
                }
                if(isset($data['title']) && !empty($data['title'])){
                    $offer['title']=$data['title'];
                }
                if(isset($data['attachment']) && !empty($data['attachment'])){
                    $offer['attachment']=(new Helpers())->uploadFile($request['attachment'], 'application_offers');
                }
                if(isset($data['desc']) && !empty($data['desc'])){
                    $offer['desc']=$data['desc'];
                }
                $submit= $this->applicationsOffers->create($offer);
                if(isset($application->user->first_name)){
                    $appData['student']=$application->user->first_name;
                    $appData['university']=$application->university->fullname;
                    $appData['user_email']=$application->user->email;
                    $appData['subject']="Congratulations, You’ve Received An Offer from ".$application->university->fullname;
                    Mail::send('frontend.mails.offer',['data' => $appData],function($message) use ($appData){
                        $message->from('no-reply@edubrokers.com','Edubrokers.com');
//                        $message->to('ghalibsoomro@gmail.com');
                        $message->to([$appData['user_email']]);
                        $message->replyTo('no-reply@edubrokers.com', 'Edu Brokers');
                        $message->subject($appData['subject']);
                    });
                }
                if($submit){
                    $this->applications->whereId($data['application_id'])->update(['isOffered'=>1,'status'=>'offer_extend']);
                }
                return redirect()->back()->with(['success' => 'Offer Submited Successfully.']);
            }


        }

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
