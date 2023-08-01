@extends('backend.layouts.app')
@section('style')
@endsection
@section('content')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="float-right">
                    </div>
                    <h4 class="page-title">User Detail</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card bg-white shadow mb-4 p-4">
                    @if ($message = \Illuminate\Support\Facades\Session::get('error'))
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @elseif ($message = \Illuminate\Support\Facades\Session::get('success'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    {{\Illuminate\Support\Facades\Session::forget('success')}}
                <div class="">
                    <div class="row">
                        <div class="col-lg-4 col-md-12 mb-4">
                            <div class="college-profile-pic bg-white shadow text-center samecollege-height">
                                @if(isset($user) && !empty($user->image))
                                    <img class="card-img-top img-fluid" src="{{ asset("public".\Illuminate\Support\Facades\Storage::url($user->image)) }}" alt="amherst">
                                @else
                                    <img class="card-img-top img-fluid" src="{{asset('public/assets/frontend/images/uploud-your-photo.png')}}" alt="">
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-12 mb-4">
                            <div class="college-profile-text gray-box shadow p-4 pb-5 samecollege-height">
                                <div class="main-campus">
                                    <h5>Name :<span>@if(isset($user->fullname)) {{$user->fullname}} @endif</span></h5>
                                </div>
                                <div class="main-campus">
                                    <h5>email :<span>@if(isset($user->email)) {{$user->email}} @endif</span></h5>
                                </div>
                                <div class="main-campus">
                                    <h5>type :<span>@if(isset($user->type)) {{$user->type}} @endif</span></h5>
                                </div>
                                <div class="main-campus">
                                    <h5>Fax :<span>@if(isset($user->fax)) {{$user->fax}} @endif</span></h5>
                                </div>
                                <div class="main-campus">
                                    <h5>Gender :<span>@if(isset($user->gender)) {{$user->gender}} @endif</span></h5>
                                </div>
                                <div class="main-campus">
                                    <h5>phone :<span>@if(isset($user->phone)) {{$user->phone}} @endif</span></h5>
                                </div>

                                <div class="main-campus">
                                    <h5>country :<span> @if(isset($user->country)) {{$user->country}} @endif</span></h5>
                                </div>
                                <div class="main-campus">
                                    <h5>state :<span>@if(isset($user->state)) {{$user->state}} @endif</span></h5>
                                </div>
                                <div class="main-campus">
                                    <h5>city :<span> @if(isset($user->city)) {{$user->city}} @endif</span> </h5>
                                </div>
                                <div class="main-campus">
                                    <h5>address1: <span>@if(isset($user->address1)) {{$user->address1}} @endif</span></h5>
                                </div>
                                <div class="main-campus">
                                    <h5>Date of joining:  <span class="business_name">@if(isset($user->created_at)) {{ \Carbon\Carbon::parse($user->created_at)->format('m-d-Y') }} @endif</span></h5>
                                </div>
                                <div class="main-campus">
                                    <select class="form-control" onchange="activeInActive(this,{{$user->id}})">
                                        <option value="">Select</option>
                                        <option value="1" @if(isset($user->isActive) && $user->isActive==1) selected @endif>Active</option>
                                        <option value="0" @if(isset($user->isActive) && (int)$user->isActive==0) selected @endif>InActive</option>
                                    </select>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @include('flashy::message')
    <script> </script>
@endsection
