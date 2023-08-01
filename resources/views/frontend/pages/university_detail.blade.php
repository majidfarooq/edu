@extends('frontend.layouts.app')
@section('style')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

@endsection
@section('content')
    <div class="loading" style="display:none;">
        <div class='uil-ring-css' style='transform:scale(0.79);'>
            <div></div>
        </div>
    </div>
    <div class="container-fluid page-title pt-3">
        <div class="container">
            <div class="row px-5">
                <div class="col-lg-5 col-md-12 btn-group-section gap-3">
                    <a href="{{ route('dashboard') }}" class="btn btn-success"><span><img class="me-2" src="{{asset('public/assets/frontend/images/list.png')}}" alt="list"></span>Current Applications</a>
                    <a href="{{ route('dashboard',['history']) }}" class="btn btn-white"><span><img class="me-2" src="{{asset('public/assets/frontend/images/accept.png')}}" alt="list"></span>Applications History</a>
                </div>
                <div class="col-lg-7 col-md-12 btn-group-section gap-3 apply-btn-show" id="topApplyBtn">
                    @if($application)
                     @else
                        @if(isset(Auth::user()->id) && Auth::user()->id !==$user->id)
                            @if(!isset($applicationOffered->offer->isAccepted))
                                <a href="#apply_down" class="btn btn-success me-0">Apply</a>
                            @endif
                        @endif
                     @endif
                </div>
                <div class="search search-detail col-12 mt-4">
                    <div class="profile-new-tab col-lg-12 col-md-12 mt-4">
                        <div class="d-flex bg-white shadow bd-highlight">
                            <div class="p-3 bd-highlight amherst-college-bg">
                                <h5 class="mb-0 text-white">@if($user){{ $user->first_name.' '.$user->last_name }} @endif</h5>
                            </div>
                            <div class="p-3 d-flex align-items-center bd-highlight border-right amherst-website-name">
                                <img class="me-2" src="{{asset('public/assets/frontend/images/internet.png')}}" alt="">
                                <p>@if(isset($user->website)){{ $user->website }} @else N/A @endif</p>
                            </div>
                            <div class="p-2 mx-4 d-flex flex-fill bd-highlight applicationdeadlines">

                                <div class="form-group">
                                    <label class="form-label mb-1">Fall Application deadline:</label>
                                    <div class="applicationdeadlines">
                                        <input type="text" name="spring" class="form-control spring" value="@if(isset($user->userInfo)){{ \Carbon\Carbon::parse($user->userInfo->fall_dead_start)->format('m-d-Y') }} @endif" disabled readonly>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label mb-1">Spring Application deadline:</label>
                                    <div class="applicationdeadlines">
                                        <input type="text" name="spring" class="form-control spring" value="@if(isset($user->userInfo)){{ \Carbon\Carbon::parse($user->userInfo->spring_dead_start)->format('m-d-Y') }} @endif" disabled readonly>
                                    </div>
                                </div>
                                &nbsp;&nbsp

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid pt-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-m-12 col-sm-12 college-profile-section mb-5">
                    <div class="card bg-white shadow mb-4 p-4">
                        <div class="row">
                            <div class="col-lg-4 col-md-12 mb-4">
                                <div class="college-profile-pic bg-white shadow text-center samecollege-height">
                                    @if(!empty($user->image))
                                        <img class="company-profile" src="{{ asset("public".\Illuminate\Support\Facades\Storage::url($user->image)) }}" alt="amherst">
                                    @else
                                        <img class="company-profile" src="{{asset('public/assets/frontend/images/allegheny-profile.png')}}" alt="amherst">
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-12 mb-4">
                                @if ($message = \Illuminate\Support\Facades\Session::get('error'))
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>Failed!</strong> {{ $message }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @elseif ($message = \Illuminate\Support\Facades\Session::get('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Success!</strong> {{ $message }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                <div class="college-profile-text gray-box shadow p-4 pb-5 samecollege-height">
                                    <div class="main-campus">
                                        <h5><span>Main campus</span> : @if($user){{ $user->fullname }} @endif</h5>
                                        <div class="share-buttons-container">
                                            <div class="share-list">
                                                <!-- FACEBOOK -->
                                                <a class="fb-h" onclick="return fbs_click()" target="_blank">
                                                    <img src="https://img.icons8.com/material-rounded/96/000000/facebook-f.png">
                                                </a>

                                                <!-- TWITTER -->
                                                <a class="tw-h" onclick="return tbs_click()"  target="_blank">
                                                    <img src="https://img.icons8.com/material-rounded/96/000000/twitter-squared.png">
                                                </a>

                                                <!-- LINKEDIN -->
                                                <a class="li-h" onclick="return lbs_click()"  target="_blank">
                                                    <img src="https://img.icons8.com/material-rounded/96/000000/linkedin.png">
                                                </a>

                                                <!-- REDDIT -->
                                                <a class="re-h" onclick="return rbs_click()" target="_blank">
                                                    <img src="https://img.icons8.com/ios-glyphs/90/000000/reddit.png">
                                                </a>

                                                <!-- PINTEREST -->
                                                <a data-pin-do="buttonPin" data-pin-config="none" class="pi-h" onclick="return pbs_click()" target="_blank">
                                                    <img src="https://img.icons8.com/ios-glyphs/90/000000/instagram.png">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="bg-white d-flex mb-2 p-2 gap-3">
                                        <img src="{{asset('public/assets/frontend/images/location.png')}}" class="location" alt="location">
                                        <p class="storng-p">Address:</p>
                                        <p>@if($user){{ $user->address1 }} @endif</p>
                                    </div>
                                    <div class="bg-white d-flex mb-2 p-2 gap-3">
                                        <img src="{{asset('public/assets/frontend/images/phone-alt.png')}}" class="phone" alt="phone">
                                        <p class="storng-p">Phone:</p>
                                        <p>@if($user){{ $user->phone }} @endif</p>
                                    </div>
                                    <div class="bg-white d-flex mb-2 p-2 gap-3">
                                        <img src="{{asset('public/assets/frontend/images/simple-email.png')}}" class="email" alt="email">
                                        <p class="storng-p">Contact person email:</p>
                                        <p>@if(isset($user->uni_email)){{ $user->uni_email }} @endif</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 mb-4">
                                <div class="scholarship-info-section gray-box shadow p-4">

                                    <div class="row">
                                        <div class="col-lg-6 col-md-12 scholarship-info">
                                            <h6>Scholarship information: </h6>
                                            <hr>
                                            <div class="bg-white p-3">
                                                <p>@if(isset($user->userInfo)){{ $user->userInfo->scholarship_info }} @endif</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 scholarship-info">
                                            <h6>Other information: </h6>
                                            <hr>
                                            <div class="bg-white p-3">
                                                <p>@if(isset($user->userInfo)){{ $user->userInfo->other_info }} @endif</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-white shadow mb-4 p-4">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 mb-4">
                                <div class="scholarship-info-section gray-box shadow scholarship-info p-4">
                                    <div class="row">
                                        <h6>Financial Information:</h6>
                                        <hr>
                                        <div class="col-lg-6 col-md-12 scholarship-info">
                                            <div class="table-responsive scholarship-info-left-table">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Full-Time</th>
                                                    <th scope="col">In-State</th>
                                                    <th scope="col">Out-of-State</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>Per Academic Year</td>
                                                    <td>$@if(isset($user->userInfo->annual_in_state)){{ number_format($user->userInfo->annual_in_state,2) }} @endif</td>
                                                    <td>$@if(isset($user->userInfo->annual_out_state)){{ number_format($user->userInfo->annual_out_state,2) }} @endif</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Mandatory Fees</b></td>
                                                    <td>$@if(isset($user->userInfo->manda_in_state)){{ number_format($user->userInfo->manda_in_state,2) }} @endif</td>
                                                    <td>$@if(isset($user->userInfo->manda_out_state)){{ number_format($user->userInfo->manda_out_state,2) }} @endif</td>
                                                </tr>
                                                <tr>
                                                    <td>Room & Board</td>
                                                    <td>$@if(isset($user->userInfo->room_in_state)){{ number_format($user->userInfo->room_in_state,2) }} @endif</td>
                                                    <td>$@if(isset($user->userInfo->room_out_state)){{ number_format($user->userInfo->room_out_state,2) }} @endif</td>
                                                </tr>
                                                <tr>
                                                    <td><b style="font-weight: bold;color: #00a825;">EDU Brokers Discount</b></td>
                                                    <td class="EDUDiscount-green" ><b style="font-weight: bold;color: #00a825;">$@if(isset($user->userInfo->dis_in_state)){{ number_format($user->userInfo->dis_in_state,2) }} @else 0 @endif</b></td>
                                                    <td class="EDUDiscount-green"><b style="font-weight: bold;color: #00a825;">$@if(isset($user->userInfo->dis_out_state)){{ number_format($user->userInfo->dis_out_state,2) }} @else 0 @endif</b></td>
                                                </tr>
                                                <tr class="last-tr">
                                                    <td>Per Academic Year</td>
                                                    <td>$@if(isset($user->userInfo->tyearly_in_state)){{ number_format($user->userInfo->tyearly_in_state,2) }} @endif</td>
                                                    <td>$@if(isset($user->userInfo->tyearly_out_state)){{ number_format($user->userInfo->tyearly_out_state,2) }} @endif</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 scholarship-info">
                                            <div class="table-responsive">
                                            <table class="table table-striped part-time">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Part-Time</th>
                                                    <th scope="col">In-State</th>
                                                    <th scope="col">Out-of-State</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>Tuition - Per Credit</td>
                                                    <td>$@if(isset($user->userInfo->pann_in_state)){{ number_format($user->userInfo->pann_in_state,2) }} @endif</td>
                                                    <td>$@if(isset($user->userInfo->pann_out_state)){{ number_format($user->userInfo->pann_out_state,2) }} @endif</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Mandatory Fees</b></td>
                                                    <td>$@if(isset($user->userInfo->manda_in_state)){{ number_format($user->userInfo->manda_in_state,2) }} @endif</td>
                                                    <td>$@if(isset($user->userInfo->manda_out_state)){{ number_format($user->userInfo->manda_out_state,2) }} @endif</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight: bold;color: #00a825;">EDU Brokers Discount</td>
                                                    <td class="EDUDiscount-green"><b style="font-weight: bold;color: #00a825;">$@if(isset($user->userInfo->pdis_in_state)){{ number_format($user->userInfo->pdis_in_state,2) }} @endif</b></td>
                                                    <td class="EDUDiscount-green"><b style="font-weight: bold;color: #00a825;">$@if(isset($user->userInfo->pdis_out_state)){{ number_format($user->userInfo->pdis_out_state,2) }} @endif</b></td>
                                                </tr>
                                                <tr class="last-tr">
                                                    <td>Total Per Credit</td>
                                                    <td>$@if(isset($user->userInfo->pcredit_in_state)){{ number_format($user->userInfo->pcredit_in_state,2) }} @endif</td>
                                                    <td>$@if(isset($user->userInfo->pcredit_out_state)){{ number_format($user->userInfo->pcredit_out_state,2) }} @endif</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>
                                        @if(!isset(Auth::user()->id))
                                        <div class="col-lg-12 col-md-12 edu-negotiated">
                                            <div class="user-text text-center">
                                                <h6>To view EDU Negotiated Offer</h6>
                                                <div class="edu-negotiated-inner d-flex justify-content-center">
                                                    <a class="SigUp" data-bs-toggle="modal" data-bs-target="#createAccount">Sign Up</a>
                                                    <p>Or</p>
                                                    <a class="SigUp" data-bs-toggle="modal" data-bs-target="#onlyLogin">Log In</a>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-white shadow mb-4 p-4">
                        <div class="row p-0">
                            <div class="col-lg-6 col-md-12 filter-by-program">
                             <h6>Programs/Courses list</h6>
                            </div>
                            <div class="col-lg-6 col-md-12 filter-by-degree">
                                <div class="form-group border-input">
                                    <select name="create_rating" class="form-select form-control" onchange="sorting(this)" aria-label="Filter by Degree / Program Type">
                                        <option value="">Filter By: Degree Program</option>
                                        <option value="1">Undergraduate</option>
                                        <option value="2">Graduate</option>
                                        <option value="3">Micro Masters</option>
                                        <option value="4">Certificates</option>
                                    </select>
                                </div>
                                <div class="form-group border-input">
                                    <input type="text" name="search" onkeyup="searchCourse(this)" class="form-control" placeholder="Search">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="gray-box programs-courses shadow p-2">
                            <div class="row change-box" id="sortedResults">

                            @if($user->courses)
                                @foreach($user->courses as $course)
                                        <div class="col-lg-4 col-md-6 col-sm-12 user-couse-padd">
                                            <div class="card-body bg-white shadow mb-3">
                                            <div class=" col-lg-12 col-md-12 col-sm-12 bd-highlight">
                                                <div class="user-text">
                                                    <h6>{{$course->degree_program}}</h6>
                                                    <p class="strong">Program Type:</p>

                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 user-title-section">
                                                <div class="bd-highlight program-typflex">
                                                    <div class="city-state">
                                                        <p>{{$course->programes->title}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                @endforeach
                            @endif
                            </div>
                        </div>
                    </div>
                    @if($application)
                        <div class="card bg-white shadow mb-4 p-4 text-center">
                            @if($application->apply_via=='apply_on_common_ap')
                                <h6>Connected to {{$user->first_name.' '.$user->last_name}}, via Common App, on {{ \Carbon\Carbon::parse($application->created_at)->format('m-d-Y') }}</h6>
                            @elseif($application->apply_via=='apply_via_black_college_app')
                                <h6>Connected to {{$user->first_name.' '.$user->last_name}}, via Common Black College App, on {{ \Carbon\Carbon::parse($application->created_at)->format('m-d-Y') }}</h6>
                            @else
                                <h6>Connected to {{$user->first_name.' '.$user->last_name}} on {{ \Carbon\Carbon::parse($application->created_at)->format('m-d-Y') }}</h6>
                            @endif
                        </div>

                        @if(isset($application->offer) && !empty($application->offer))
                            @if($application->status !=='rejected')
                            <div class="card bg-white shadow mb-4 p-4 text-center">
                                <a data-bs-toggle="modal" data-bs-target="#universityOffer"> <h6>View Offer</h6> </a>
                            </div>
                            @else
                                <div class="card bg-white shadow mb-4 p-4 text-center">
                                    <a> <h6>Offer Forfeited/ Offer Declined on {{ \Carbon\Carbon::parse($application->offer->updated_at)->format('m-d-y') }}</h6> </a>
                                </div>
                            @endif
                        @endif
                    @else

                        @if(isset(Auth::user()->id) && Auth::user()->id !==$user->id)
                            @if(!isset($applicationOffered->offer->isAccepted))
                                <a id="apply_down"></a>
                                <div class="card bg-white shadow mb-4 p-4">
                            <h6>Ready to Apply?</h6>
                            <hr>
                            {!! Form::open(array('route' => 'applyUniversity','id' => 'applyUniversity','class'=>'','files' => true)) !!}
                            <div class="mb-4 row">
                                <div class="col-md-4 col-sm-12">
                                    <select class="form-control" name="season" onchange="selectSession(this)" required>
                                        <option value="">Select Session</option>
                                        <option value="spring">Spring</option>
                                        <option value="fall">Fall</option>
                                    </select>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <select class="form-control" name="program_type" id="program_type" onchange="selectProgrames(this)" required disabled>
                                        <option value="">Select Program Type</option>
                                        <option value="1">Undergraduate</option>
                                        <option value="2">Graduate</option>
                                        <option value="3">Micro Masters</option>
                                        <option value="4">Certificates</option>
                                    </select>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <select class="form-control" style="width: 100%;" name="course_id" id="course_id" required disabled>
                                        <option value="">Select Field Of Interest</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                @php
                                $isFvt=false;
                                if(isset($favourites)){
                                    $favo=$favourites->toArray();
                                    $key = array_search($user->id, array_column($favo, 'uni_id'));
                                    if($key !==false){
                                        if(isset($favo[$key])){
                                            $isFvt=true;
                                        }
                                    }
                                }
//                                @endphp
                                <div class="col-md-3 col-sm-12">
                                @if($isFvt)
                                    <button type="submit" onclick="applyVia('remove_favourite')" class="btn btn-link w-100 mb-2">Remove from Favorites!</button>
                                @else
                                    <button type="submit" onclick="applyVia('mark_favourite')" class="btn btn-link w-100 mb-2">Add to Favorites</button>
                                @endif
                                </div>
                                <input type="hidden" name="apply_via" id="apply_via">
                                @if($user->id) <input type="hidden" name="uni_id" id="uni_id" value="{{$user->id}}"> @endif
                                <div class="col-md-3 col-sm-12">
                                    <button type="submit" onclick="applyVia('apply_on_common_ap')" class="btn btn-link w-100 mb-2">Apply Via Common App</button>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <button type="submit" onclick="applyVia('apply_directly_through_the_uni')" class="btn btn-link w-100 mb-2">Apply Directly through University</button>
                                </div>
                                @if(isset($user->hbcu) && $user->hbcu==1)
                                <div class="col-md-3 col-sm-12">
                                    <button type="submit" onclick="applyVia('apply_via_black_college_app')" class="btn btn-link w-100 mb-2">Apply Via Common Black College App</button>
                                </div>
                                @endif
                            </div>
                            {{ Form::close() }}
                        </div>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="apply-main-section col-12 p-0 d-none d-sm-block d-md-none" id="bottomApplyBtn" style="display: none;">
        @if($application)
        @else
            @if(isset(Auth::user()->id) && Auth::user()->id !==$user->id)
                @if(!isset($applicationOffered->offer->isAccepted))
                    <a href="#apply_down" class="btn btn-success me-0 w-100 border-0">Apply</a>
                @endif
            @endif
        @endif
    </div>


    <div class="modal fade" id="universityOffer" tabindex="-1" aria-labelledby="extendOfferLabel" aria-hidden="true">
        <div class="modal-dialog universityOffer modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h5>University Offer</h5>
                    <div class="bg-white p-3 mb-3">
                        <h6 class="float-left align-left">Headline</h6>
                        <input type="text" name="title" @if(isset($application->offer->title) && !empty($application->offer->title)) value="{{ $application->offer->title }}" @endif  class="form-control" readonly>
                    </div>
                    @if(isset($application->offer->attachment) && !empty($application->offer->attachment))
                    <div class="bg-white d-flex justify-content-between align-items-center p-3 mb-3">
                        <a href="{{ asset("public".\Illuminate\Support\Facades\Storage::url($application->offer->attachment)) }}" class="view-link" download>View File</a>
                        <a href="{{ asset("public".\Illuminate\Support\Facades\Storage::url($application->offer->attachment)) }}" class="btn btn-success" download>Download File <span><img src="{{asset('public/assets/frontend/images/file-download.png')}}" class="ms-2" download></span></a>
                    </div>
                    @endif
                    <div class="bg-white p-3 mb-3">
                        <h6>Detail</h6>
                        <textarea type="text" name="title" class="form-control" readonly>@if(isset($application->offer->desc) && !empty($application->offer->desc)) {{ $application->offer->desc }} @endif</textarea>
                    </div>
                    <div class="row">
                        @if(isset($application->offer) && $application->offer->isAccepted==1)
                            <div class="col-md-12 col-sm-12">
                                <a class="btn btn-primary w-100">Offer Accepted on {{ \Carbon\Carbon::parse($application->offer->updated_at)->format('m-d-y') }} </a>
                            </div>
                        @else
                            @if(isset($application->status) && $application->status !=='rejected')
                                <div class="col-md-6 col-sm-12">
                                    <a onclick="changeStatus('accept')" class="btn btn-primary w-100 mb-2">Accept Offer?</a>
                                </div>
                            <div class="col-md-6 col-sm-12">
                                <a onclick="changeStatus('reject')" class="btn btn-link w-100">Not Interested</a>
                            </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>



//        var scrollToTop = window.setInterval(function() {
//            var pos = window.pageYOffset;
//            console.log(pos)
//            if ( pos > 50 ) {
//                $("#topApplyBtn").hide();
//                $("#bottomApplyBtn").show();
//            } else {
//                $("#topApplyBtn").show();
//                $("#bottomApplyBtn").hide();
//
//            }
//        }, 1000);
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.3/moment.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('public/assets/frontend/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('public/assets/frontend/js/additional-methods.min.js') }}"></script>

    <script type="application/javascript">

        var pageLink = window.location.href;
        var pageTitle ='@if($user){{ $user->fullname }} @endif';

        function fbs_click() { window.open(`http://www.facebook.com/sharer.php?u=${pageLink}&quote=${pageTitle}`,'sharer','toolbar=0,status=0,width=626,height=436');return false; }

        function tbs_click() { window.open(`https://twitter.com/intent/tweet?text=${pageTitle}&url=${pageLink}`,'sharer','toolbar=0,status=0,width=626,height=436');return false; }

        function lbs_click() { window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${pageLink}`,'sharer','toolbar=0,status=0,width=626,height=436');return false; }

        function rbs_click() { window.open(`https://www.reddit.com/submit?url=${pageLink}`,'sharer','toolbar=0,status=0,width=626,height=436');return false; }

        function pbs_click() { window.open(`https://www.instagram.com/pin/create/button/?&text=${pageTitle}&url=${pageLink}&description=${pageTitle}`,'sharer','toolbar=0,status=0,width=626,height=436');return false; }


        function sorting(elem){
            $('.loading').css('display','block')
            $.post('{{ route('courseSorting') }}',
                {_token:'{{ csrf_token() }}'
                    ,uniId:'{{$user->id}}'
                    ,type_id:$(elem).val()}
                , function (data) {
                console.log(data)
                $('#sortedResults').empty().append(data['view'])
                $('.loading').css('display','none')
            });
        }

        function searchCourse(elem){

            $.post('{{ route('searchCourse') }}', {_token:'{{ csrf_token() }}',uniId:'{{$user->id}}',search:$(elem).val()}, function (data) {
                $('#sortedResults').empty().append(data['view'])
            });

        }


        function selectProgrames(elem){
            $('#course_id').prop("disabled", false);
            $.post('{{ route('getUniProgrames') }}', {_token:'{{ csrf_token() }}',uni_id:'{{$user->id}}',type_id:$(elem).val()}, function (data) {
                if(data['status']==true){
                    $('#course_id').empty().append('<option value="">Select Field Of Interest</option>')
                    jQuery.each(data['courses'], function(index, item) {
                        $('#course_id').append('<option value="'+item['id']+'">'+item['degree_program']+'</option>')
                    });
                }
            });
        }
        function selectSession(elem){


            $('#program_type').prop("disabled", false);

            if($(elem).val()=='spring'){

                var strping_start='@if(isset($user->userInfo->spring_dead_start)) {{ \Carbon\Carbon::parse($user->userInfo->spring_dead_start)->format('Y-m-d') }} @endif'
                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                var yyyy = today.getFullYear();

                today = yyyy + '-' + mm + '-' + dd;
                console.log(today,strping_start);
                if (moment(today).isSameOrBefore(strping_start)) {
                    console.log('✅ date is between the 2 dates');
                } else {
                    Swal.fire({
                        // title: '   Note: The deadline for this session has passed. If you continue with the application process, your application may be considered for the next session. ',
                        title: '   Note: The deadline for this semester has passed.  If you wish to proceed with your application, click “Yes”. If you wish to return to browse other colleges, click “No”. ',
                        showDenyButton: true,
                        showCancelButton: false,
                        confirmButtonText: 'Yes',
                    }).then((result) => {
                        if (result.isDenied) {
                            $('#program_type').prop("disabled", true);
                        }else{
                            $('#program_type').prop("disabled", false);
                        }
                    })
                }
            }else{
                var fall_deadline='@if(isset($user->userInfo->fall_dead_start)) {{ \Carbon\Carbon::parse($user->userInfo->fall_dead_start)->format('Y-m-d') }} @endif'
                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                var yyyy = today.getFullYear();

                today = yyyy + '-' + mm + '-' + dd;

                if (moment(today).isSameOrBefore(fall_deadline)) {
                    console.log('✅ date is between the 2 dates');
                } else {
                    Swal.fire({
                        // title: '   Note: The deadline for this session has passed. If you continue with the application process, your application may be considered for the next session. ',
                        title: '   Note: The deadline for this semester has passed.  If you wish to proceed with your application, click “Yes”. If you wish to return to browse other colleges, click “No”. ',
                        showDenyButton: true,
                        showCancelButton: false,
                        confirmButtonText: 'Yes',
                    }).then((result) => {
                        if (result.isDenied) {
                            $('#program_type').prop("disabled", true);
                        }else{
                            $('#program_type').prop("disabled", false);
                        }
                    })
                }

            }
        }

        function changeStatus(status){
            if(status=='accept'){
                var statusOffer='Are you sure you want to accept?'
                var OfferStatus='Congratulations! You will not be able to accept an offer to any other Universities for the next 30 days'
            }else{
                var statusOffer="Are you sure you're not interested?"
                var OfferStatus='Offer marked as not interested.'
            }

            Swal.fire({
                title: statusOffer,
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: `No`,
            }).then((result) => {
                if (result.isConfirmed) {
                    var data={}
                    data['status']=status
                    data['offer_id']="@if(isset($application->offer->id)){{$application->offer->id}}@endif"
                    data['application_id']="@if(isset($application->id)){{$application->id}}@endif"
                    $.post('{{ route('ChangeofferStatus') }}', {_token:'{{ csrf_token() }}',data:data}, function (data) {
                        if(data['status']==true){
                            Swal.fire(OfferStatus, '', 'success')
                            $('#universityOffer').modal('hide')
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }

                    });
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            })
        }
        $("#applyUniversity").submit(function(e){
            e.preventDefault()
            var message='';
            var html='';
            var applyVia = $('#apply_via').val()
            if(applyVia=='apply_via_black_college_app'){
                message='We will now connect you to Common Black College App to complete your Application'
                html='Note: Once you complete your application on the Common Black College App, please update the status of your application on your EDU Brokers Dashboard.';
            }else if(applyVia=='apply_on_common_ap'){
                message='We will now connect you to Common App to complete your application.'
                html='Note: Once you complete your application on the Common App, please update the status of your application on your EDU Brokers Dashboard.';
            }else if(applyVia=='apply_directly_through_the_uni'){
                html='Note: Once you complete your application on the University website, please update the status of your application on your EDU Brokers Dashboard.';
                message='You are now redirected to the University Website to complete your application.'
            }

            if(applyVia !=='mark_favourite'){
                if($("#applyUniversity").valid()){
                    Swal.fire({
                        title: message,
                        html:html,
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: 'Ok',
                        denyButtonText: false,
                        showCloseButton: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if(applyVia=='apply_via_black_college_app'){
                                window.open("https://commonblackcollegeapp.com");
                            }else if(applyVia=='apply_on_common_ap'){
                                window.open("https://www.commonapp.org/");
                            }else if(applyVia=='apply_directly_through_the_uni'){
                                window.open('{{$user->website}}');
                            }
                            $('#applyUniversity').unbind('submit').submit();
                        }
                    })
                }
            }else{
                $('#applyUniversity').unbind('submit').submit();
            }
        });
        function applyVia(result){

            $('#apply_via').val(result)
            if(result =='mark_favourite' || result =='remove_favourite'){

                $("#applyUniversity").find('select').removeClass('error').removeAttr("required");
                $("#applyUniversity").find('select').removeClass('error').prop('required',false);

            }else{
                $("#applyUniversity").validate({
                    rules: {
                        "season": {
                            required: true,
                        },
                        "program_type": {
                            required: true,
                        },
                        "course_id": {
                            required: true,
                        }
                    },
                    messages: {
                        "season": {
                            required: "this field is required.",
                        },
                        "program_type": {
                            required: "this field is required.",
                        },
                        "course_id": {
                            required: "this field is required.",
                        },
                    },
                    submitHandler: function (form) {

                    }
                });
            }
        }
        function redirect_blank(url) {
            window.location.href=url
        }
        $(document).ready(function() {

            $('.select2').select2({
                multiple: "multiple",
                placeholder: "Select",
                allowClear: true
            });
        });

    </script>
@endsection
