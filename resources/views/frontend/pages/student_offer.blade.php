@extends('frontend.layouts.app')
@section('style')
    <style>
        body {
            background-color: #F7F7F7;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid page-title pt-3">
        <div class="container">
            <div class="row px-5">
                <div class="col-lg-5 col-md-12 btn-group-section gap-3">
                    <a href="{{ route('dashboard') }}" class="btn btn-white"><span><img class="me-2" src="http://cloud.ferozitech.com/edu/public/assets/frontend/images/history.png" alt="list"></span>Back</a>
                </div>
                <div class="col-lg-7 col-md-12 page-title-text">
                    <h1>Student Application</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid student-offer pt-3">
        <div class="container">
            <div class="row px-5">
                <div class="col-lg-12 col-m-12 col-sm-12 student-application-section">
                    <div class="card bg-white shadow mb-4 p-5">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 mb-4 mt-4">
                                <div class="college-profile-text gray-box shadow p-4 pb-5 samecollege-height">
                                    <div class="col-12 text-center position-relative">
                                        @if(!empty($application->user->image))
                                          <img class="student-app" src="{{ asset("public".\Illuminate\Support\Facades\Storage::url($application->user->image)) }}" alt="amherst">
                                        @else
                                          <img class="student-app" src="{{asset('public/assets/frontend/images/amherst.png')}}" alt="amherst">
                                        @endif
                                    </div>
                                    <div class="main-campus student-info">
                                        <h5>Student Information:</h5>
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
                                        @if(isset($application->status) && $application->status=='rejected')
                                            <button type="button" class="btn btn-outline-danger rejected-users">Rejected</button>
                                        @endif
                                    </div>
                                    <hr>
                                    <div class="bg-white d-flex mb-2 p-2 gap-3">
                                        <p class="storng-p">Full / Given Name:</p>
                                        <p>@if($application->user->first_name) {{$application->user->first_name.' '.$application->user->last_name}} @endif</p>
                                    </div>
                                    <div class="bg-white d-flex mb-2 p-2 gap-3">
                                        <p class="storng-p">Gender:</p>
                                        <p>@if($application->user->gender) {{$application->user->gender}} @endif</p>
                                    </div>
                                    <div class="bg-white d-flex mb-2 p-2 gap-3">
                                        <p class="storng-p">Country: </p>
                                        <p>@if($application->user->country) {{$application->user->country}} @endif</p>
                                    </div>
                                    <div class="bg-white d-flex mb-2 p-2 gap-3">
                                        <p class="storng-p">City & State: </p>
                                        <p>@if($application->user->city) {{$application->user->city.' '.$application->user->state}} @endif</p>
                                    </div>
                                    <div class="bg-white d-flex mb-2 p-2 gap-3">
                                        <p class="storng-p">Zip code:</p>
                                        <p>@if($application->user->zipcode) {{$application->user->zipcode}} @endif</p>
                                    </div>
                                    <div class="bg-white d-flex mb-2 p-2 gap-3">
                                        <p class="storng-p">Address: </p>
                                        <p>@if($application->user->address1) {{$application->user->address1}} @endif</p>
                                    </div>
                                    <div class="bg-white d-flex mb-2 p-2 gap-3">
                                        <p class="storng-p">Address 2: </p>
                                        <p>@if($application->user->address2) {{$application->user->address2}} @endif</p>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 mb-4 mt-4">
                                <div class="college-profile-text gray-box shadow p-3 mb-4 samecollege-height">
                                    <div class="main-campus">
                                        <h5>Educational Information:</h5>
                                    </div>
                                    <hr>
                                    <div class="bg-white d-flex mb-2 p-2 gap-3">
                                        <p class="storng-p">Student Type:</p>
                                        <p>@if($application->user->userInfo->student_type) {{$application->user->userInfo->student_type}} @endif</p>
                                    </div>
                                    <div class="bg-white d-flex mb-2 p-2 gap-3">
                                        <p class="storng-p">Highest Education Level Attained:</p>
                                        <p>@if($application->user->userInfo->education_level) {{$application->user->userInfo->education_level}} @endif</p>
                                    </div>
                                    <div class="bg-white d-flex mb-2 p-2 gap-3">
                                        <p class="storng-p">Fields of Interest: </p>
                                        <p>@if($application->user->userInfo->interest) {{$application->user->userInfo->interest}} @endif</p>
                                    </div>
                                </div>
                                <div class="scholarship-info-section gray-box shadow scholarship-info p-3">
                                    <div class="col-lg-12 col-md-12 student-application-table">
                                        <table class="table bg-white student-factor">
                                            <thead>
                                            <tr>
                                                <th scope="col">Student Factors</th>
                                                <th scope="col"><div class="student-factor-th"><span id="StartRating">@if(!empty($sumRating)){{$sumRating}}@else Not Rated Yet @endif</span> <i class="fa fa-star ms-2" aria-hidden="true"></i></div> </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($ratingsFactors)
                                                @foreach($ratingsFactors as $rating)
                                                    <tr>
                                                        <td>{{ $rating['title'] }}</td>
                                                        <td class="star-rating-section student-factor-td">
                                                            <div class='rating-stars text-center'>
                                                                <ul id="stars" class="stars_{{$rating['id']}}">
                                                                    @php
                                                                    if(isset($universityFactorsArray)){
                                                                        $key = array_search($rating['id'], array_column($universityFactorsArray, 'factorId'));
                                                                        if($key !==false){
                                                                            if(!empty($universityFactorsArray[$key])){
                                                                                $ratingCurrent=$universityFactorsArray[$key]['rating'];
                                                                            }
                                                                        }
                                                                    }
                                                                    @endphp
                                                                    <li class='star @if(isset($ratingCurrent) && $ratingCurrent >=1) selected @endif' onclick="starRating(this,{{$rating['id']}})" title='Poor' data-value='1'>
                                                                        <i class='fa fa-star fa-fw'></i>
                                                                    </li>
                                                                    <li class='star @if(isset($ratingCurrent) && $ratingCurrent >=2) selected @endif' onclick="starRating(this,{{$rating['id']}})" title='Fair' data-value='2'>
                                                                        <i class='fa fa-star fa-fw'></i>
                                                                    </li>
                                                                    <li class='star @if(isset($ratingCurrent) && $ratingCurrent >=3) selected @endif' onclick="starRating(this,{{$rating['id']}})" title='Good' data-value='3'>
                                                                        <i class='fa fa-star fa-fw'></i>
                                                                    </li>
                                                                    <li class='star @if(isset($ratingCurrent) && $ratingCurrent >=4) selected @endif' onclick="starRating(this,{{$rating['id']}})" title='Excellent' data-value='4'>
                                                                        <i class='fa fa-star fa-fw'></i>
                                                                    </li>
                                                                    <li class='star @if(isset($ratingCurrent) && $ratingCurrent >=5) selected @endif' onclick="starRating(this,{{$rating['id']}})" title='WOW!!!' data-value='5'>
                                                                        <i class='fa fa-star fa-fw'></i>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-white shadow mb-4 p-4">
                        <div class="row">
                            @if($application->isOffered !==1)
                            <div class="col-md-3 col-sm-12 col">
                                <button type="button" @if($application->status && $application->status=='rejected') disabled @endif onclick="changeStatus('mark_pending')" class="btn @if($application->status && $application->status=='mark_pending') btn-primary @else btn-link  @endif w-100">Mark As Pending</button>
                            </div>
                            <div class="col-md-3 col-sm-12 col">
                                <button type="button" @if($application->status && $application->status=='rejected') disabled @endif onclick="changeStatus('approve_shortlist')" class="btn @if($application->status && $application->status=='approve_shortlist') btn-primary @else btn-link  @endif w-100">Approve / Shortlist</button>
                            </div>
                            @endif
                            <div class="col-md-3 col-sm-12 col">
                                <button type="button" @if($application->status && $application->status=='rejected') disabled @endif class="btn @if($application->status && $application->status=='rejected') btn-primary @else btn-link  @endif w-100" onclick="changeStatus('rejected')">Reject Application</button>
                            </div>
                            @if($application->isOffered !==1)
                            <div class="col-md-3 col-sm-12 col">
                                <button type="button" @if($application->status && $application->status=='rejected') disabled @endif class="btn @if($application->status && $application->status=='offer_extend') btn-primary @else btn-link  @endif w-100" data-bs-toggle="modal" data-bs-target="#extendOffer">Extend Offer</button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="extendOffer" tabindex="-1" aria-labelledby="extendOfferLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg create-newprofile modal-dialog-centered">
            <div class="modal-content">
                <h5>Create Offer Statement</h5>
                <hr class="rating-hr">
                <div class="modal-body text-start">
                    {!! Form::open(array('route' => 'submitOffer','id' => 'submitOffer','class'=>'','files' => true)) !!}
                    <h6>Headline</h6>
                    <input type="hidden" name="application_id" value="@if($application->id) {{$application->id}} @endif">
                    <div class="bg-white p-3 mb-3">
                        <input type="text" name="title" class="form-control">
                    </div>
                    <h6>Attachment</h6>
                    <div class="bg-white p-3 mb-3">
                        <input type="file" name="attachment" class="form-control">
                    </div>
                    <h6>Detail: </h6>
                    <div class="bg-white p-3 mb-3">
                        <textarea rows="6" name="desc" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Submit Offer</button>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="application/javascript">

        function starRating(elem,id){
            $(function(){
                var rate=0;
                $($(elem).parent().children('li')).each(function () {
                    if ($(this).hasClass("selected")) {
                        rate =$(this).data('value');
                    }
                });
                var studentId="{{$application->user->id}}"
                $.post('{{ route('studentFactors') }}', {_token:'{{ csrf_token() }}',rate:rate,factorId:id,studentId:studentId}, function (data) {
                    $('#StartRating').text(data['sumRating'])
                });
            });
        }
        function changeStatus(status){
//             if(status=='accept'){
//                 var statusOffer='Are you sure you want to accept'
//                 var OfferStatus='Congratulations! You will not be able to accept an offer to any other Universities for the next 30 days'
//             }else{
//                 var statusOffer='Are you sure you want to reject?'
//                 var OfferStatus='Offer Rejected Successfully.'
//             }
                if (status == 'mark_pending') {
                    var statusOffer = 'Are you sure you want to mark as pending?'
                    var OfferStatus = 'Application marked as pending'
                } else if (status == 'approve_shortlist') {
                    var statusOffer = 'Are you sure you want to approve/shortlist?'
                    var OfferStatus = 'Application shortlisted successfully.'
                } else if (status=='accept') {
                    var statusOffer='Are you sure you want to accept'
                    var OfferStatus = 'Congratulations! You will not be able to accept an offer to any other Universities for the next 30 days'
                }
                else {
                    var statusOffer = 'Are you sure you want to reject?'
                    var OfferStatus = 'Application Rejected Successfully.'
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
                    data['application_id']="{{$application->id}}"
                    $.post('{{ route('changeApplicationStatus') }}', {_token:'{{ csrf_token() }}',data:data}, function (data) {
                        if(data['status']==true){
                            Swal.fire(OfferStatus, '', 'success')
                            setTimeout(function (){location.reload();},1500)
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            })
        }
    </script>
    <script>
        $(document).ready(function(){

            $('#stars li').on('mouseover', function(){
                var onStar = parseInt($(this).data('value'), 10);
                $(this).parent().children('li.star').each(function(e){
                    if (e < onStar) {
                        $(this).addClass('hover');
                    }
                    else {
                        $(this).removeClass('hover');
                    }
                });
            }).on('mouseout', function(){
                $(this).parent().children('li.star').each(function(e){
                    $(this).removeClass('hover');
                });
            });

            $('#stars li').on('click', function(){
                var onStar = parseInt($(this).data('value'), 10);
                var stars = $(this).parent().children('li.star');

                for (i = 0; i < stars.length; i++) {
                    $(stars[i]).removeClass('selected');
                }

                for (i = 0; i < onStar; i++) {
                    $(stars[i]).addClass('selected');
                }

                var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
                var msg = "";
                if (ratingValue > 1) {
                    msg = "Thanks! You rated this " + ratingValue + " stars.";
                }
                else {
                    msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
                }
                responseMessage(msg);
            });
        });
        function responseMessage(msg) {
            $('.success-box').fadeIn(200);
            $('.success-box div.text-message').html("<span>" + msg + "</span>");
        }
    </script>
@endsection
