@extends('frontend.layouts.app')
@section('style')
    <style>
        .modal-dialog.modal-lg.create-newprofile.modal-dialog-centered {
            margin-top: 5rem;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid page-title pt-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-12 btn-group-section gap-3">
                    <a href="{{ route('dashboard',['applications']) }}" class="btn @if(isset($pattern) && $pattern=='applications') btn-success @else btn-white @endif"><span><img class="me-2" src="{{asset('public/assets/frontend/images/list.png')}}" alt="list"></span>Applications</a>
                    <a href="{{ route('dashboard',['offers']) }}" class="btn @if(isset($pattern) && $pattern=='offers') btn-success @else btn-white @endif "><span><img class="me-2" src="{{asset('public/assets/frontend/images/accept.png')}}" alt="list"></span>Offers</a>
                </div>
                <div class="row search search-uni col-12 mt-4">
                    <div class="profile-new-tab col-lg-7 col-md-12 mt-2">
                        <div class="d-flex bg-white shadow bd-highlight p-2">
                            <div class="p-2 mx-2 d-flex flex-fill bd-highlight border-right">
                                @php
                                    if(isset($pattern) && !empty($pattern)){
                                        $patternText=$pattern;
                                    }else{
                                        $patternText='applications';
                                    }
                                @endphp
                                <a href="{{ route('dashboard',[$patternText,'pending']) }}">
                                <span class="badge bg-primary me-2">@if(isset($countsSum['pending_count'])){{$countsSum['pending_count']}}@endif</span>
                                <p>Pending {{ ucfirst($patternText) }}</p>
                                </a>
                            </div>
                            <div class="p-2 mx-2 d-flex flex-fill bd-highlight border-right">
                                <a href="{{ route('dashboard',[$patternText,'approved-shortlist']) }}">
                                <span class="badge bg-primary me-2">@if(isset($countsSum['approved_count'])){{$countsSum['approved_count']}}@endif</span>
                                <p>Approved {{ ucfirst($patternText) }}</p>
                                </a>
                            </div>
                            <div class="p-2 mx-2 d-flex flex-fill bd-highlight">
                                <a href="{{ route('dashboard',[$patternText,'history']) }}">
                                <span class="badge bg-primary me-2">@if(isset($countsSum['rejected'])){{$countsSum['rejected']}}@endif</span>
                                <p>{{ ucfirst($patternText) }} History</p>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12 mt-2">
                        <div class="d-flex justify-content-end">
                            <div style="cursor:pointer" class="bg-white shadow my-1 p-3">
                                <div class="d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createRating">
                                    <p>Create Rating Factors </p>
                                    <i class="fa fa-star ms-2" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid my-4 applicationStatus">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-m-12 col-sm-12">
                    <div class="card bg-white shadow mb-4 p-4">
                        <div class="d-flex justify-content-between new-application">
                            <h5>New Applications</h5>
                            <div class="gray-box multiple shadow d-flex align-items-center p-3" id="selectMultiple" >
                                <p >Multi-select and Submit Offer</p>
                                <select class="form-control" onchange="changeStatus(this)">
                                    <option value="">Select</option>
                                    <option value="mark_pending">Pending</option>
                                    <option value="approve_shortlist">Approve/Shortlist</option>
                                    <option value="rejected">Rejected</option>
                                    <option value="offer_extend">Offer Extend</option>
                                </select>
                            </div>
                        </div>
                        <hr>
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
                        @php if(isset($filter) && !empty($filter)){ $applications=$applicationsWithOffers; } @endphp
                        @if(isset($applications) && !empty($applications))
                        <div class="gray-box p-2 scroll-gray pr-5" id="Selections">
                                @php $counter=1; @endphp
                                @forelse ($applications as $student)
                                    @if(isset($student->user))
                                        <input type="hidden" value="{{ $student->user->id }}">
                                    <div class="card-body recently-slider bg-white shadow mb-3" >
                                        <div class="row">
                                            <div class="p-1 col-lg-2 col-md-3 col-sm-12 d-flex user-title bd-highlight" onclick="checkCheckbox(this,'{{$student->status}}')">
                                                <div class="chekbox-section p-1" style="display: none"> <span class="wpcf7-list-item first form-check sort-by p-3">
                                                   <input type="checkbox" onclick="checkCheckbox(this)" id="RememberPassword" name="app_id" value="{{$student->id}}">
                                                     <label class="chekboxMainText" for="RememberPassword">
                                                     <span class="cnv-name"></span> </label>
                                                    </span>
                                                </div>
                                                @if(!empty($student->user->image))
                                                    <div class="user-img">
                                                        <img class="card-img-top" src="{{ asset("public".\Illuminate\Support\Facades\Storage::url($student->user->image)) }}" alt="amherst">
                                                    </div>
                                                @else
                                                    <div class="user-img">
                                                        <img class="card-img-top" src="{{asset('public/assets/frontend/images/amherst.png')}}" alt="amherst">
                                                    </div>
                                                @endif
                                                <div class="user-text">
                                                    <p>{{$student->user->first_name.' '.$student->user->last_name}}</p>
                                                    @if($student->status=='mark_pending')
                                                        <p class="badge badge-section light-bg">Submited/Pending</p>
                                                    @elseif($student->status=='approve_shortlist')
                                                        @if($student->isOffered==1)
                                                            <p class="badge badge-section light-bg">Accepted</p>
                                                        @else
                                                            <p class="badge badge-section light-bg">Approved/Shortlisted</p>
                                                        @endif
                                                    @elseif($student->status=='rejected')
                                                        @if($student->notInterested==1)
                                                            <p class="badge badge-section light-bg">Not Interested</p>
                                                        @else
                                                            <p class="badge badge-section light-bg">Rejected</p>
                                                        @endif
                                                    @elseif($student->status=='offer_extend')
                                                        @if(isset($student->offer->isAccepted) && $student->offer->isAccepted==1)
                                                            <p class="badge badge-section light-bg">Offer Accepted</p>
                                                        @else
                                                            <p class="badge badge-section light-bg">Offer Sent</p>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-10 col-md-9 col-sm-12 d-flex user-title-section user-select-section justify-content-end">
                                                <div class="course-type-inner p-1 d-flex bd-highlight">
                                                    <div class="course-type p-2 border-right-1">
                                                        <p class="strong">Program Type</p>
                                                        <p>{{$student->program->title}}</p>
                                                    </div>
                                                    <div class="course-type p-2 border-right-1">
                                                        <p class="strong">Student Rating</p>
                                                        <p>@if(!empty(\App\Http\Controllers\frontend\HomeController::getRatingSum($student->user->id))) {{\App\Http\Controllers\frontend\HomeController::getRatingSum($student->user->id)}} @else Not Rated Yet @endif</p>
                                                    </div>
                                                    <div class="course-type p-2 border-right-1">
                                                        <p class="strong">Origination Date</p>
                                                        <p>{{ \Carbon\Carbon::parse($student->created_at)->format('m-d-Y') }}</p>
                                                    </div>

                                                    <div class="city-state p-2 border-right-1">
                                                        <p class="strong">City, State</p>
                                                        <p>{{$student->user->city.','.$student->user->state}}</p>
                                                    </div>
                                                    <div class="highest-edu p-2">
                                                        <p class="strong">Highest Education</p>
                                                        <p>@if(isset($student->user->userInfo->education_level)) {{$student->user->userInfo->education_level}} @endif</p>
                                                    </div>
                                                </div>
                                                <div class="p-1 bd-highlight d-flex view-student">
                                                    @php  $encrypted=\App\Http\Controllers\frontend\HomeController::makeEncryption($student->id)  @endphp
                                                    <a href="{{ route('studentOffer',$encrypted) }}" class="btn btn-link">View Student Application</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @php $counter++; @endphp
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="5"><i>No Record Found!</i></td>
                                    </tr>
                                @endforelse
                        </div>
                        @else
                        <tr>
                            <td class="text-center" colspan="5"><i>No Record Found!</i></td>
                        </tr>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="createRating" tabindex="-1" aria-labelledby="createRatingLabel" aria-hidden="true">
        <div class="modal-dialog create-newprofile modal-dialog-centered">
            <div class="modal-content">
                <h5>Create Rating Factors for ease of Shortlisting</h5>
                <p>Your ratings apply across all applicants,
                    you determine the factors and rate applicants.</p>
                <hr class="rating-hr">
                {!! Form::open(array('route' => 'addStartRatings','id' => 'addStartRatings','class'=>'','files' => true)) !!}
                @if($ratingsFactors)
                    @foreach($ratingsFactors as $rating)
                        <div class="d-flex bd-highlight grades-gpa">
                            <div class="p-1 w-100 bd-highlight">
                                <p>{{ $rating['title'] }}</p>
                            </div>
                            <div class="p-1 flex-shrink-1 bd-highlight croos-section">
                                <img src="{{asset('public/assets/frontend/images/croos.png')}}" onclick="removeRating(this,{{ $rating['id'] }})" alt="cross">
                            </div>
                        </div>
                    @endforeach
                @endif
                <div id="appendFields"></div>
                <div class="form-group creat-account append-dflex-main text-end my-3" id="addMore" style="display: none">
                    <div class="d-flex append-dflex">
                        <div class="p-1 bd-highlight col-md-10">
                            <input type="text" name="" id="new_field" class="form-control">
                        </div>
                        <div class="p-1 flex-shrink-1 bd-highlight col-md-2 croos-section">
                            <button type="button" onclick="addMore(this)" class="btn btn-primary btn-sm">Submit</button>
                        </div>
                    </div>
                </div>
                <div  onclick="enableAddMore()" class="form-group creat-account text-end my-3">
                    <p><a>Add More</a></p>
                </div>
                <button type="submit" class="btn btn-success w-100">Create</button>
                {{ Form::close() }}
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
                    <div class="bg-white p-3 mb-3">
                        <input type="text" name="title" class="form-control">
                    </div>
                    <input type="hidden" name="multiple_offers" id="multiple_offers">
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

        function checkCheckbox(elme,status){
            if(status=='mark_pending'){
                if($(elme).hasClass('selected')){
                    $(elme).removeClass('selected')
                    // $('.user-select-section').removeClass('selected');
                    $(elme).find('input[type=checkbox]').prop("checked",false)
                }else{
                    $(elme).addClass('selected')
                    // $(elme).('.user-select-section').not(':last').addClass('selected');
                    $(elme).find('input[type=checkbox]').prop("checked",true)
                }
                $('#Selections input[type=checkbox]').each(function() {

                });
            }else{
                // Swal.fire('Only pending application can be selected.', '', 'success')
                Swal.fire({
                    title: 'Only pending application can be selected.',
                })
            }

        }

        function changeStatus(elemt){
                var data=[]
            var data_uncheck=[]
                $('#Selections input[type=checkbox]').each(function() {
                    if($(this).prop('checked')==true){
                        data.push($(this).val())
                    }else{
                        data_uncheck.push($(this).val())
                    }
                });
            console.log(data)
            console.log(data_uncheck)
            if(data.length > 0) {
                if ($(elemt).val() == 'offer_extend') {
                    $('#multiple_offers').val(data)
                    $('#extendOffer').modal('show')
                } else {
                    Swal.fire({
                        title: 'Are you sure you wants to change status?',
                        showDenyButton: true,
                        confirmButtonText: 'Yes',
                        denyButtonText: `No`,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // var data=[]
                            // $('#Selections input[type=checkbox]').each(function() {
                            //     if($(this).prop('checked')==true){
                            //         data.push($(this).val())
                            //     }
                            // });
                            $.post('{{ route('changeStatusMultipleStatus') }}', {
                                _token: '{{ csrf_token() }}',
                                data: data,
                                status: $(elemt).val()
                            }, function (data) {
                                if (data['status'] == true) {
                                    Swal.fire('Status Changes Successfully.', '', 'success')
                                    setTimeout(function () {
                                        location.reload()
                                    }, 2000)
                                }
                            });
                        } else if (result.isDenied) {
                            Swal.fire('Changes are not saved', '', 'info')
                        }
                    })
                }
            }else{
                alert('Select Applications first')
            }
        }

        function removeRating(elem,id){
            if(id){
                $.post('{{ route('removeRatingsFactor') }}', {_token:'{{ csrf_token() }}',id:id}, function (data) {

                });
            }
            $(elem).parent().parent().remove()
        }

        function multipleSelect(){

            $('.chekbox-section').toggle('slow');

        }


        function enableAddMore(){

            $('#addMore').css('display','block')

        }

        function addMore(eleme){
           var value= $(eleme).parent().parent().find('#new_field').val()
            if(value){
                $('#appendFields').append('<div class="d-flex bd-highlight grades-gpa">' +
                    '<div class="p-1 w-100 bd-highlight">' +
                    '<p>'+value+'</p>' +
                    '</div>' +
                    '<input type="hidden" name="ratingFields[]" value="'+value+'">' +
                    '<div class="p-1 flex-shrink-1 bd-highlight croos-section">' +
                    '<img src="{{asset('public/assets/frontend/images/croos.png')}}" onclick="removeRating(this)" alt="cross">' +
                    '</div>' +
                    '</div>');
                $('#new_field').val('')
            }

        }
    </script>
@endsection
