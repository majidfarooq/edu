@extends('frontend.layouts.app')
@section('style')
    <link rel="stylesheet" href="{{ asset('public/assets/frontend/owlcarousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/frontend/owlcarousel/assets/owl.theme.default.min.css') }}">
@endsection
@section('content')
<div class="container-fluid page-title pt-3">
    <div class="container">
        <div class="row">

            <div class="search col-12 mt-4">
                {!! Form::open(array('route' => 'searchUniversity','id' => 'searchUniversity','class'=>'','files' => true)) !!}
                <div class="d-flex bg-white shadow justify-content-between">
                    <div class="search-1 d-flex align-items-center">
                        <input type="text" name="title" class="form-control" placeholder="Search College" value="{{ old('title') }}">
                    </div>
                    <div class="search-display d-flex justify-content-end">
                        <div class="search-zip same-seacrh">
                            <div class="form-group">
                                <label class="form-label">Zip Code</label>
                                <input type="text" name="zipcode" class="form-control onlyNumbers" maxlength="5" autocomplete="off" value="{{ old('zipcode') }}">
                            </div>
                        </div>
                        <div class="search-state same-seacrh">
                            <div class="form-group">
                                <label class="form-label">State</label>
                                <select class="form-control js-example-basic-single" name="state">
                                    <option value="">Select</option>
                                    @if($states)
                                        @foreach($states as $state)
                                            <option value="{{$state->name}}">{{$state->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="search-tuition same-seacrh">
                            <div class="form-group">
                                <label class="form-label">Annual Tuition Fees:</label>
                                <div class="d-flex justify-content-start">
                                    <input type="text" name="from_fee" placeholder="$000,000" class="form-control start_time" autocomplete="off" value="{{ old('from_fee') }}">
                                    <p>To</p>
                                    <input type="text" name="to_fee" placeholder="$000,000" class="form-control start_end" autocomplete="off" value="{{ old('to_fee') }}">
                                </div>
                            </div>
                        </div>
                        <div class="search-groupbtn same-seacrhbtn">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
<div class="container-fluid my-4 sort-buy-nearest">
    <div class="container">
        <div class="row">
            @if(isset(\Illuminate\Support\Facades\Auth::user()->id) && $page_controller=='dashboard')
                <h1 class="text-center mb-5">Welcome to EDU Dashboard.</h1>
                @if($applications->count() == 0 )
                    @if ($user->created_at->format('Y-m-d') === date('Y-m-d'))
                    @else
                    @endif
                @endif
            @endif
            <div class="offset-lg-3 col-lg-6 col-md-12 text-center college-search-title">
                @if($isSearch==1)
                <h1 class="my-2">College Search</h1>
                    <h4>Browse partner universities</h4>
                @else
                    <h1 class="my-2">Applications</h1>
                @endif
            </div>
            <div class="college-chekbox-in col-lg-3 col-md-12">
{{--                <div class="bg-white shadow p-1">--}}
{{--                    <span class="wpcf7-list-item first form-check sort-by p-3">--}}
{{--                       <input type="checkbox" id @if(isset($filter) && $filter =='nearest') checked @endif onclick="goToURL(this)" id="currPos"  value="">--}}
{{--                         <label class="chekboxMainText" for="RememberPassword">--}}
{{--                         <span class="cnv-name">Sort by: Nearest First</span>--}}
{{--                         </label>--}}
{{--                    </span>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="col-lg-7 col-md-12 btn-group-section gap-3 d-flex">
        <a href="{{ route('dashboard') }}" class="btn @if(isset($pattern) && $pattern=='applications') btn-success @else btn-white @endif"><span><img class="me-2" src="{{asset('public/assets/frontend/images/list.png')}}" alt="list"></span>Current Applications</a>
        <a href="{{ route('dashboard',['history']) }}" class="btn @if(isset($pattern) && $pattern=='history') btn-success @else btn-white @endif"><span><img class="me-2" src="{{asset('public/assets/frontend/images/history.png')}}" alt="list"></span>Applications History</a>
    </div>
</div>
<div class="container-fluid my-4 applicationStatus">
    <div class="container">
        @if(isset($outside) && !empty($outside))
            @php $outsideInfo=$outside->first(); @endphp
            @if(!empty($outsideInfo))
            <div class="col-12 alert-section alert-section-dashboard">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        @if(!empty($outsideInfo->university->image))
                            <img class="" src="{{ asset("public".\Illuminate\Support\Facades\Storage::url($outsideInfo->university->image)) }}" alt="amherst">
                        @else
                            <img class="card-img-top" src="{{asset('public/assets/frontend/images/no-image-icon-6.png')}}" alt="amherst">
                        @endif
                    </div>
                    @php
                        $already_marked=\Illuminate\Support\Facades\Session::get('marked_no');
                        $outside_total=\Illuminate\Support\Facades\Session::get('outside_total');
                        if(empty($already_marked)){
                            $already_count=1;
                        }else{
                            $already_count=(count($already_marked)+1);
                        }
                    @endphp
                    <div class="flex-grow-1 ms-3">
                        @php
                            if(isset($outsideInfo->apply_via) && $outsideInfo->apply_via=='apply_on_common_ap') {
                                $text='Common App';
                            }else if( isset($outsideInfo->apply_via) && $outsideInfo->apply_via=='apply_via_black_college_app') {
                                $text='Common Black College App';
                            }else{
                                $text='';
                            }
//                        @endphp
                        <h6 class="mb-0">Need Confirmation: {{$already_count}} of {{$outside_total}} </h6>
                        <p>Have you submitted your application via {{ $text }} for {{$outsideInfo->university->first_name.' '.$outsideInfo->university->last_name}}</p>
                        {!! Form::open(array('route' => 'submitPopupRes','id' => 'submitPopupRes','class'=>'','files' => true)) !!}
                        <input type="hidden" name="application_id" value="{{$outsideInfo->id}}">
                        <div class="col-lg-12 col-md-12 btn-group-section gap-3 mt-3">
                            <button type="submit" name="status" value="completed" class="btn btn-white mb-3">Yes, I have completed the application</button>
                            <button type="submit" name="status" value="no" class="btn btn-white mb-3">No</button>
                            <button type="submit" name="status" value="no_interested" class="btn btn-white mb-3">No, I am no Longer Interested</button>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
            @endif
        @endif
        <div class="row">
            @if($isSearch==1)
                <h2>Search Results:</h2>
            @if($universities)
                @foreach($universities as $university)
                    <div class="col-lg-3 col-m-6 col-sm-12">
                    <div class="card bg-white shadow mb-4 p-1">
                        <div class="d-flex flex-row-reverse bd-highlight p-2">
                            <div class="bg-white heartfont shadow p-2">
                                @if(isset(\Illuminate\Support\Facades\Auth::user()->id))
                                    <i class="fa-heart js-heart heart @if(isset($university->favouriteGet->id) && !empty($university->favouriteGet->id)) fas @else far @endif" onclick="likeUnlike(this,{{$university->id}})"></i>
                                @endif
                            </div>
                        </div>
                        <div class="card-img text-center">
                        @if(!empty($university->image))
                            <img class="card-img-top" src="{{ asset("public".\Illuminate\Support\Facades\Storage::url($university->image)) }}" alt="amherst">
                        @else
                            <img class="card-img-top" src="{{asset('public/assets/frontend/images/amherst.png')}}" alt="amherst">
                        @endif
                        </div>
                        <div class="d-flex justify-content-between bottom-card p-2">
                            @php  $encrypted=\App\Http\Controllers\frontend\HomeController::makeEncryption($university->id)  @endphp
                            <h6 class="mb-0">{{ $university->fullname  }}</h6>
                            <a href="{{ route('universityDetail',$encrypted) }}" class="btn btn-link">Show Details</a>
                        </div>
                    </div>
                </div>
                @endforeach
            @else

               <h5>No Records found:</h5>
            @endif
            @else
                <h2>Application Status:</h2>
                @if(isset($applications))
                    @foreach($applications->where('isOffered',null)->where('status','!==','approve_shortlist') as $university)
                        <div class="col-lg-3 col-m-6 col-sm-12">
                            @if($university->apply_via=='apply_on_common_ap' || $university->apply_via=='apply_via_black_college_app')
                                <div class="card bg-white shadow mb-4 p-1">
                                    <div class="dropdown applicationProgress d-flex align-items-center justify-content-between p-2">
                                        <button class="btn btn-secondary bg-white shadow dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            @if(isset($university->offer) && $university->offer->isAccepted==1)
                                                <span class="green-mark me-2"><i class="fas fa-circle"></i></span>
                                                <p>Offer Accepted</p>
                                            @else
                                                @if($university->status=='mark_pending')
                                                    <span class="green-mark me-2"><i class="fas fa-circle"></i></span>
                                                    <p>Pending</p>
                                                @elseif($university->status=='approve_shortlist')
                                                    <span class="green-mark me-2"><i class="fas fa-circle"></i></span>
                                                    <p>Pending</p>
                                                @elseif($university->status=='rejected')
                                                    <span class="red-mark me-2"><i class="fas fa-circle"></i></span>
                                                    @if($university->notInterested==1)
                                                        <p>Not Interested</p>
                                                    @else
                                                        <p>Declined</p>
                                                    @endif
                                                @elseif($university->status=='offer_extend')
                                                    <span class="green-mark me-2"><i class="fas fa-circle"></i></span>
                                                    <p>Offer Received</p>
                                                @endif
                                            @endif
                                        </button>
                                        <div class="bg-white heartfont shadow p-2">
                                            <i class="fa-heart js-heart heart @if(isset($university->university->favourite->id)) fas @else far @endif" @if(isset($university->university->id)) onclick="likeUnlike(this,{{$university->university->id}})" @endif></i>
                                        </div>
                                    </div>
                                    <div class="card-img text-center">
                                        @if(!empty($university->university->image))
                                            <img class="card-img-top" src="{{ asset("public".\Illuminate\Support\Facades\Storage::url($university->university->image)) }}" alt="amherst">
                                        @else
                                            <img class="card-img-top" src="{{asset('public/assets/frontend/images/amherst.png')}}" alt="amherst">
                                        @endif
                                    </div>
                                    <div class="d-flex justify-content-between bottom-card p-2">
                                        @php if(isset($university->university->id)){ $encrypted=\App\Http\Controllers\frontend\HomeController::makeEncryption($university->university->id); }   @endphp
                                        <h6 class="mb-0">@if(isset($university->university->fullname)){{ $university->university->fullname  }} @endif</h6>

                                        <a href="{{ route('universityDetail',$encrypted) }}" class="btn btn-link">Show Details</a>                                 </div>
                                </div>
                            @else
                                <div class="card bg-white shadow mb-4 p-1">
                                    <div class="d-flex justify-content-between p-2 applictions">
                                        <div class="bg-white shadow applicationProgress d-flex align-items-center p-2">
                                            @if(isset($university->offer) && $university->offer->isAccepted==1)
                                                <span class="green-mark me-2"><i class="fas fa-circle"></i></span>
                                                <p>Offer Accepted</p>
                                            @else
                                                @if($university->status=='mark_pending')
                                                    <span class="green-mark me-2"><i class="fas fa-circle"></i></span>
                                                    <p>Pending</p>
                                                @elseif($university->status=='approve_shortlist')
                                                    <span class="green-mark me-2"><i class="fas fa-circle"></i></span>
                                                    <p>Shortlisted</p>
                                                @elseif($university->status=='rejected')
                                                    <span class="red-mark me-2"><i class="fas fa-circle"></i></span>
                                                    @if($university->notInterested==1)
                                                        <p>Not Interested</p>
                                                    @else
                                                        <p>Declined</p>
                                                    @endif
                                                @elseif($university->status=='offer_extend')
                                                    <span class="green-mark me-2"><i class="fas fa-circle"></i></span>
                                                    <p>Offer Received</p>
                                                @endif
                                            @endif

                                        </div>
                                        <div class="bg-white heartfont shadow p-2">
                                            <i class="fa-heart js-heart heart @if(isset($university->university->favourite)) fas @else far @endif" onclick="likeUnlike(this,{{$university->university->id}})"></i>
                                        </div>
                                    </div>
                                    <div class="card-img text-center">
                                        @if(!empty($university->university->image))
                                            <img class="card-img-top" src="{{ asset("public".\Illuminate\Support\Facades\Storage::url($university->university->image)) }}" alt="amherst">
                                        @else
                                            <img class="card-img-top" src="{{asset('public/assets/frontend/images/amherst.png')}}" alt="amherst">
                                        @endif
                                    </div>
                                    <div class="d-flex justify-content-between bottom-card p-2">
                                        @php  $encrypted=\App\Http\Controllers\frontend\HomeController::makeEncryption($university->university->id)  @endphp
                                        <h6 class="mb-0">{{ $university->university->fullname  }}</h6>

                                        <a href="{{ route('universityDetail',$encrypted) }}" class="btn btn-link">Show Details</a>                                </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <h5>No Records found:</h5>
                @endif
            @endif
        </div>
    </div>
</div>
<div class="container-fluid my-4 applicationStatus">
    <div class="container">
        <div class="row">
            <hr class="my-5">
            <h2>Received Offers:</h2>
            <h4>Only one university offer may be accepted. All others will be forfeited.</h4>
            @if(isset($applications))
                @foreach($applications as $university)
                    @if($university->status=='offer_extend' || $university->status=='approve_shortlist')
                    <div class="col-lg-3 col-m-6 col-sm-12">
                        @if($university->apply_via=='apply_on_common_ap' || $university->apply_via=='apply_via_black_college_app')
                            <div class="card bg-white shadow mb-4 p-1">
                                <div class="dropdown applicationProgress d-flex align-items-center justify-content-between p-2">
                                    <button class="btn btn-secondary bg-white shadow dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        @if(isset($university->offer) && $university->offer->isAccepted==1)
                                            <span class="green-mark me-2"><i class="fas fa-circle"></i></span>
                                            <p>Offer Accepted</p>
                                        @else
                                            @if($university->status=='mark_pending')
                                                <span class="green-mark me-2"><i class="fas fa-circle"></i></span>
                                                <p>Pending</p>
                                            @elseif($university->status=='approve_shortlist')
                                                <span class="green-mark me-2"><i class="fas fa-circle"></i></span>
                                                <p>Pending</p>
                                            @elseif($university->status=='rejected')
                                                <span class="red-mark me-2"><i class="fas fa-circle"></i></span>
                                                <p>Offer Rejected</p>
                                            @elseif($university->status=='offer_extend')
                                                <span class="green-mark me-2"><i class="fas fa-circle"></i></span>
                                                <p>Offer Received</p>
                                            @endif
                                        @endif
                                    </button>
                                    <div class="bg-white heartfont shadow p-2">
                                        <i class="fa-heart js-heart heart @if(isset($university->university->favourite->id)) fas @else far @endif" onclick="likeUnlike(this,{{$university->university->id}})"></i>
                                    </div>
                                </div>
                                <div class="card-img text-center">
                                    @if(!empty($university->university->image))
                                        <img class="card-img-top" src="{{ asset("public".\Illuminate\Support\Facades\Storage::url($university->university->image)) }}" alt="amherst">
                                    @else
                                        <img class="card-img-top" src="{{asset('public/assets/frontend/images/amherst.png')}}" alt="amherst">
                                    @endif
                                </div>
                                <div class="d-flex justify-content-between bottom-card p-2">
                                    @php  $encrypted=\App\Http\Controllers\frontend\HomeController::makeEncryption($university->university->id)  @endphp
                                    <h6 class="mb-0">{{ $university->university->fullname  }}</h6>
                                    <a href="{{ route('universityDetail',$encrypted) }}" class="btn btn-link">Show Details</a>
                                </div>
                            </div>
                        @else
                            <div class="card bg-white shadow mb-4 p-1">
                                <div class="d-flex justify-content-between p-2 applictions">
                                    <div class="bg-white shadow applicationProgress d-flex align-items-center p-2">
                                        @if(isset($university->offer) && $university->offer->isAccepted==1)
                                            <span class="green-mark me-2"><i class="fas fa-circle"></i></span>
                                            <p>Offer Accepted</p>
                                        @else
                                            @if($university->status=='mark_pending')
                                                <span class="green-mark me-2"><i class="fas fa-circle"></i></span>
                                                <p>Pending</p>
                                            @elseif($university->status=='approve_shortlist')
                                                <span class="green-mark me-2"><i class="fas fa-circle"></i></span>
                                                <p>Shortlisted</p>
                                            @elseif($university->status=='rejected')
                                                <span class="red-mark me-2"><i class="fas fa-circle"></i></span>
                                                <p>Rejected</p>
                                            @elseif($university->status=='offer_extend')
                                                <span class="green-mark me-2"><i class="fas fa-circle"></i></span>
                                                <p>Offer Received</p>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="bg-white heartfont shadow p-2">
                                        <i class="fa-heart js-heart heart @if(isset($university->university->favourite)) fas @else far @endif" @if(isset($university->university->id)) onclick="likeUnlike(this,{{$university->university->id}})" @endif></i>
                                    </div>
                                </div>
                                <div class="card-img text-center">
                                    @if(!empty($university->university->image))
                                        <img class="card-img-top" src="{{ asset("public".\Illuminate\Support\Facades\Storage::url($university->university->image)) }}" alt="amherst">
                                    @else
                                        <img class="card-img-top" src="{{asset('public/assets/frontend/images/amherst.png')}}" alt="amherst">
                                    @endif
                                </div>
                                <div class="d-flex justify-content-between bottom-card p-2">
                                    @php if(isset($university->university->id)){ $encrypted=\App\Http\Controllers\frontend\HomeController::makeEncryption($university->university->id); }   @endphp
                                    <h6 class="mb-0">@if(isset($university->university->fullname)){{ $university->university->fullname  }} @endif</h6>
                                    <a @if(isset($encrypted)) href="{{ route('universityDetail',$encrypted) }}" @endif class="btn btn-link">Show Details</a>
                                </div>
                            </div>
                        @endif
                    </div>
                    @endif
                @endforeach
            @else
                <h5>No Records found:</h5>
            @endif
        </div>
    </div>
</div>

<div class="container-fluid my-4 p-5 applicationStatus featured-section">
    <div class="container">
        <div class="row">
            <h2>Featured Colleges</h2>
            @if($featured)
                <div class="owl-carousel owl-theme servicesSlider" id="FeaturedDashboard">
                    @foreach($featured as $university)
                        <div class="item">
                            <div class="card carosel-slider bg-white shadow mb-4 p-1">
                                <div class="d-flex justify-content-between p-2 applictions featured-bg">
                                    <div class="bg-white shadow applicationProgress d-flex align-items-center p-2">
                                        <p>Featured</p>
                                    </div>
                                </div>
                                <div class="card-img text-center">
                                    @if(!empty($university->image))
                                        <img class="card-img-top" src="{{ asset("public".\Illuminate\Support\Facades\Storage::url($university->image)) }}" alt="amherst">
                                    @else
                                        <img class="card-img-top" src="{{asset('public/assets/frontend/images/amherst.png')}}" alt="amherst">
                                    @endif
                                </div>
                                <div class="d-flex justify-content-between bottom-card p-2">
                                    @php  $encrypted=\App\Http\Controllers\frontend\HomeController::makeEncryption($university->id)  @endphp
                                    <h6 class="mb-0">{{ $university->fullname  }}</h6>
                                    <a href="https://cloud.ferozitech.com/edu/university/detail/{{$encrypted}}" class="btn btn-link">Show Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <h5>No Records found:</h5>
            @endif
        </div>
    </div>
</div>
<div class="container-fluid my-5 slider-search">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bg-white shadow p-4">
                    <h2 class="mb-4">Recently viewed</h2>
                    <div class="owl-carousel owl-theme recentlyViewd owl-loaded owl-drag" id="recentlyViewd">
                        <div class="owl-stage-outer">
                            <div class="owl-stage" style="transform: translate3d(-2536px, 0px, 0px); transition: all 0.25s ease 0s; width: 4650px;">
                                @if(isset($recentViews) && !empty($recentViews))
                                    @foreach($recentViews as $uni)
                                        <div class="owl-item" style="width: 402.667px; margin-right: 20px;">
                                            <div class="item">
                                                <div class="card-body recently-slider bg-white shadow mb-3 mt-3">
                                                    <div class="d-flex bd-highlight">
                                                        <div class="p-1 bd-highlight favourites recent">
                                                            @if(!empty($uni->university->image))
                                                                <img class="card-img-top" src="{{ asset("public".\Illuminate\Support\Facades\Storage::url($uni->university->image)) }}" alt="amherst">
                                                            @else
                                                                <img class="card-img-top" src="{{asset('public/assets/frontend/images/amherst.png')}}" alt="amherst">
                                                            @endif
                                                        </div>
                                                        <div class="p-1 bd-highlight dropdown-text">
                                                            <p class="Auburn">@if(isset($uni->university->fullname)){{ $uni->university->fullname }} @endif</p>
                                                            <p>@if(isset($uni->university->address1)){{ $uni->university->address1 }}@endif</p>
                                                        </div>
                                                        <div class="p-1 bd-highlight">
                                                            @php if(isset($uni->university->id)){ $encrypted=\App\Http\Controllers\frontend\HomeController::makeEncryption($uni->university->id); } @endphp
                                                            @if($uni->university->has_applied >0)
                                                            @php $txt= 'Show Details' @endphp
                                                            @else
                                                            @php $txt= 'Apply' @endphp
                                                            @endif
                                                            @if(isset($encrypted))
                                                                <a href="{{ route('universityDetail',$encrypted) }}" class="btn btn-link showdetail_{{$txt}}">{{$txt}}</a>
                                                            @else
                                                                <a href="#" class="btn btn-link apply_{{$txt}}">{{$txt}}</a>
                                                            @endif
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

                <div class="owl-dots disabled"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid my-4 mb-5 need-application">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-m-8 col-sm-12 mx-auto">
                <div class="card bg-white shadow p-1 text-center p-4">
                    <h2>Need Help?</h2>

                    <h3>Check out our <span><a href="https://cloud.ferozitech.com/edu/faqs">FAQs</a></span> or <span><a href="https://cloud.ferozitech.com/edu/contact">Get in touch</a></span> with us.</h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script type="text/javascript" src="{{ asset('public/assets/frontend/owlcarousel/owl.carousel.js') }}"></script>
@section('script')
    <script>
        jQuery(document).ready(function($) {
            var title = $('#MaxCharLimit');
            var titleMaxLength = 2;
            var charactersDisplay = $('#title-character-counter');

            charactersDisplay.text(titleMaxLength - title.val().length);

            title.on('keydown', function(e){
                var length = calculateLength(titleMaxLength, $(this));
                checkLength(length, e);
            });
            title.on('keyup', function(e){
                var length = calculateLength(titleMaxLength, $(this));
                charactersDisplay.text(length);
            });
            title.on('paste', function(e){
                var $self = $(this);
                setTimeout(function(){
                    var length = calculateLength(titleMaxLength, $self);
                    if (length < 0 ) {
                        var newString = truncateString($self, titleMaxLength);
                        $self.val(newString);
                    }
                },100);
            });

            function calculateLength(maxLength, elem) {
                return maxLength-elem.val().length;
            }
            function checkLength(length, e) {
                if(length <= 0) {
                    switch(e.which) {
                        case 8:
                        case 9:
                        case 37:
                        case 39:
                        case 46:
                            break;
                        default:
                            e.preventDefault();
                            break;
                    }
                }
            }
            function truncateString(elem, maxLength) {
                return elem.val().substring(0, maxLength);
            }
        });
        function changeApplicationStatus(appId,status){
          var dataPost={}
            dataPost['application_id']=appId
            dataPost['status']=status
            $.post('{{ route('changeApplicationStatus') }}',{_token:'{{ csrf_token() }}',data:dataPost},function(data){ location.reload() });
          }
        $('#recentlyViewd').owlCarousel({
            loop: true,
            screenLeft:true,
            margin: 20,
            dots: false,
            nav: true,
            navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
            autoplay: true,
            autoplayTimeout: 2000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 3
                }
            }
        });
        $('#FeaturedDashboard').owlCarousel({
            loop: true,
            screenLeft:true,
            margin: 10,
            dots: false,
            nav: true,
            navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
            autoplay: true,
            autoplayTimeout: 2000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 4
                }
            }

        });
        function goToURL(elem){
            if($(elem).is(":checked")){
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        geoLocationSuccess,
                        geoLocationError,
                        { timeout: 10000 }
                    );
                }
            }else{
                window.location='{{ route('dashboard',['applications']) }}'
            }
        }
        function geoLocationSuccess(pos) {
            var data = {}
            data['latitude']=pos.coords.latitude
            data['longitude']=pos.coords.longitude
            $.post('{{ route('storeLatLong') }}',{_token:'{{ csrf_token() }}',data:data},function(data){
                window.location='{{ route('dashboard',['nearest']) }}'
            });
        }

        function geoLocationError(error) {
            var errors = {
                1: "Permission denied",
                2: "Position unavailable",
                3: "Request timeout"
            };
            // alert("Error: " + errors[error.code]);
        }


    </script>
@endsection
