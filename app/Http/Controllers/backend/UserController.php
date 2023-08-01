<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Applications;
use App\Models\Property;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{

  public function student(Request $request)
  {
      $users = User::where('type','student')->get();
      return view('backend.users.student', compact('users'));
  }


  public function marKFeatured(Request $request){

      User::whereId($request['userId'])->update(['isFeatured'=>$request['status']]);

  }
  public function marKHbcu(Request $request){

      User::whereId($request['userId'])->update(['hbcu'=>$request['status']]);

  }

  public function activeInActive(Request $request){

      User::whereId($request['userId'])->update(['isActive'=>$request['status']]);
      Session::put('success','Status Updated Successfully..!');
  }

    public function university(Request $request)
    {
        $users = User::where('type','university')->with('applications')->orderby('id','DESC')->get();
        return view('backend.users.university', compact('users'));

    }
    public function userdetail($id)
    {
        $user = User::with('userInfo')->whereId($id)->first();
        return view('backend.users.detail', compact('user'));

    }


  public function show($id)
  {
    $user = User::withTrashed()->whereId($id)->first();
    return view('backend.users.show', compact('user'));
  }

  public function destroy($id)
  {

      try {
          $user = User::whereId($id)->first();
          $user->email=null;
          $user->uni_email=null;
          $user->update();
          Applications::where('user_id',$user->id)->delete();
          Applications::where('uni_id',$user->id)->delete();
          if ($user->delete()) {
              return redirect()->back()->with(['success' => 'Deleted Successfully..!']);
          } else {
              return redirect()->back()->with(['error' => 'Something went wrong....!']);
          }
      }
      catch (\Exception $e) {
          return redirect()->back()->with(['error' => 'Something went wrong....!']);
      }
  }

  public function deleteApplications($id)
  {
    $user = Applications::whereId($id)->first();
    if ($user->delete()) {
      return redirect()->back()->with(['success' => 'Deleted Successfully..!']);
    } else {
      return redirect()->back()->with(['error' => 'Something went wrong....!']);
    }
  }

  public function restore($id)
  {
    $user = User::withTrashed()->whereId($id)->first();
    if ($user->restore()) {
      return redirect()->back()->with(['success' => 'User Restored Successfully..!']);
    } else {
      return redirect()->back()->with(['error' => 'Something went wrong....!']);
    }
  }
}
