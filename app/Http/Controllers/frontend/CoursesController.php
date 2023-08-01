<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\ApplicationOffers;
use App\Models\Applications;
use App\Models\CourseCategory;
use App\Models\Courses;
use App\Models\RatingFactors;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MercurySeries\Flashy\Flashy;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $course;
    protected $RatingFactors;
    public function __construct(Courses $courses)
    {
        $this->course=$courses;
        $this->RatingFactors= new RatingFactors();
    }


    public function testBody(){



        $applications = Applications::with('user')->get();

        foreach($applications as $app){

        if(isset($app->user->id)){

        }else{
            $app->delete();
        }

        }


    }


    public function index($type=false)
    {
        if(empty($type)){ $type='undergraduate-programs'; }
        if(Auth::user()->isActive !==1){
            return redirect()->back()->with(['error' => "You're current status is in Active you can't access to this page, contact admin, thank you !"]);
        }
        $category=CourseCategory::where('slug',$type)->first();
        $courses=Courses::where('user_id',Auth::user()->id)->with('programes')->where('category_id',$category->id)->get();
        $CoursesCategories= CourseCategory::get();
        $ratingsFactors=$this->RatingFactors->where('uni_id',Auth::user()->id)->get();
        return view('frontend.courses.index',compact('type','CoursesCategories','courses','ratingsFactors'));
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

        if($request['program_type']){
            $category=CourseCategory::where('slug',$request['program_type'])->first();
            $course = new Courses();
            $course->user_id = Auth::user()->id;
            $course->category_id = $category->id;
            $course->isActive = 1;
            if(isset($request['title']) && !empty($request['title'])){
                $course->title= $request['title'];
            }
            if(isset($request['degree_program']) && !empty($request['degree_program'])){
                $course->degree_program= $request['degree_program'];
            }
            if(isset($request['publish_date']) && !empty($request['publish_date'])){
                $course->publish_date= $request['publish_date'];
            }
            if(isset($request['degree_type']) && !empty($request['degree_type'])){
                $course->degree_type= $request['degree_type'];
            }
            if(isset($request['due_date']) && !empty($request['due_date'])){
                $course->due_date= $request['due_date'];
            }
            $course->save();
            Flashy::success("Course created successfully.");
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $data = $request->except(['_method', '_token']);
        if($data){
            $result=$this->course->whereId($data['course_id'])->first();
            $view= view('frontend.courses.edit',compact('result'))->render();
            return response()->json(['status'=>true,'view'=>$view]);
        }else{
            return response()->json(['status'=>false,'result'=>'']);
        }
    }

    public function courseSorting(Request $request){

        $data = $request->except(['_method', '_token']);
        if($data){
            if(empty($data['type_id'])){
                $result=$this->course->where('user_id',$data['uniId'])->get();
            }else{
                $result=$this->course->where('user_id',$data['uniId'])->where('category_id',$data['type_id'])->get();
            }
            $view= view('frontend.courses.sorting',compact('result'))->render();
            return response()->json(['status'=>true,'view'=>$view]);
        }else{
            return response()->json(['status'=>false,'result'=>'']);
        }

    }
    public function searchCourse(Request $request){

        $data = $request->except(['_method', '_token']);
        if($data){
            if(empty($data['search'])){
                $result=$this->course->where('user_id',$data['uniId'])->get();
            }else{
                $result=$this->course->where('user_id',$data['uniId'])->where('degree_program', 'LIKE', '%' . $data['search'] . '%')->get();
            }
            $view= view('frontend.courses.sorting',compact('result'))->render();
            return response()->json(['status'=>true,'view'=>$view]);
        }else{
            return response()->json(['status'=>false,'result'=>'']);
        }

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->except(['_method', '_token']);
        if($data){
            $course=$this->course->whereId($data['course_id'])->first();
            if(isset($request['title']) && !empty($request['title'])){
                $course->title= $request['title'];
            }
            if(isset($request['degree_program']) && !empty($request['degree_program'])){
                $course->degree_program= $request['degree_program'];
            }
            if(isset($request['publish_date']) && !empty($request['publish_date'])){
                $course->publish_date= $request['publish_date'];
            }
            if(isset($request['due_date']) && !empty($request['due_date'])){
                $course->due_date= $request['due_date'];
            }
            $course->update();
            Flashy::success("Course updated successfully.");
            return redirect()->back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($id){
            Courses::whereId($id)->delete();
            Flashy::success("Course deleted successfully.");
            return redirect()->back();
        }
    }
}
