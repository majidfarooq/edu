@extends('frontend.layouts.app')
@section('style')
@endsection
@section('content')
    <div class="container-fluid page-title pt-3">
        <div class="container">
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

            <div class="row">
                <div class="search col-12 mt-4">
                    <div class="programlisting-tab col-lg-12 col-md-12 mt-4">
                        <div class="d-flex bg-white programlisting-section shadow bd-highlight">
                            @if($CoursesCategories)
                                @foreach($CoursesCategories as $cat)
                                    <div class="p-2 px-3 bd-highlight amherst-college-bg @if(isset($type) && $type==$cat->slug) active @endif">
                                        <a href="{{ route('courses-listing',$cat->slug) }}">
                                        <p class="mb-0">{{$cat->title}}</p>
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                            <div class="p-2 px-3 d-flex align-items-center bd-highlight">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#programListing"><i class="fa fa-plus-circle" aria-hidden="true"></i>
                                    Add
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid pt-3 undergraduate-programs">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-m-12 col-sm-12 programlist">

                    <div class="card bg-white shadow mb-4 p-4">
                        <div class="row">
                            <div class="d-flex justify-content-between">
                                <div class="undergraduateProgram">
                                    <h5>Add Program:</h5>
                                    <p>Help Students find all the programs your institution has to offer. Please ensure you provide accurate information.</p>
                                </div>
                                <div class="undergraduateProgram">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @if($courses)
                            @forelse($courses as $course)
                            <div class="col-lg-3 col-m-6 col-sm-12 program-managment-card">
                            <div class="card bg-white shadow mb-4 text-center">
                                <div class="p-2 py-4 projectManagement-inner">
                                    <h6 class="">@if(isset($course->degree_program) && !empty($course->degree_type)) {{$course->degree_type}}: @endif  {{ $course->degree_program }}</h6>
                                    <p><img src="{{asset('public/assets/frontend/images/graduate-cap.png')}}" class="me-2 graduate">{{ $course->programes->title }}</p>
                                </div>
                                <div class="d-flex justify-content-between program-managment-bottom">
                                    <a  onclick="return confirm(' you want to delete?');" href="{{ route('courses-delete',$course->id) }}" class="btn btn-link">Delete Program</a>
                                    <a onclick="updateProgram({{$course->id}})" class="btn btn-primary">Edit Program</a>
                                </div>
                            </div>
                        </div>
                            @empty
                                <h2>No Record Found.</h2>
                            @endforelse
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="programListing" tabindex="-1" aria-labelledby="createAccountLabel" aria-hidden="true">
        <div class="modal-dialog projectManagement-modal modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body">
                    <div class="mb-4 projectManagement-inner">
                        <h6 class="">Add a {{ ucfirst(str_replace('-',' ',str_replace('programs','',$type))) }} Program</h6>
                    </div>
                    {!! Form::open(array('route' => 'courses-create','id' => 'courses-create','class'=>'','files' => true)) !!}
                    <div class="form">
                        @if($type) <input type="hidden" name="program_type" value="{{$type}}"> @endif
                        @if($type=='undergraduate-programs')
                        <div class="form-group">
                            <label class="form-label" for="publishedDate">Degree Type</label>
                            <select name="degree_type" class="form-control" required>
                                <option value="">Select</option>
                                <option value="B.">B.</option>
                                <option value="BA">BA</option>
                                <option value="BBA">BBA</option>
                                <option value="BS">BS</option>
                                <option value="BCS">BCS</option>
                                <option value="BE">BE</option>
                                <option value="BFA">BFA</option>
                                <option value="BEd">BEd</option>
                                <option value="BSN">BSN</option>
                                <option value="MBBS">MBBS</option>
                                <option value="ACCA">ACCA</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        @endif
                        @if($type=='micro-masters-programs')
                            <div class="form-group">
                                <label class="form-label" for="publishedDate">Degree Type</label>
                                <select name="degree_type" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="M.">M.</option>
                                    <option value="CA">CA</option>
                                    <option value="MA">MA</option>
                                    <option value="MBA">MBA</option>
                                    <option value="MFA">MFA</option>
                                    <option value="MPA">MPA</option>
                                    <option value="MPH">MPH</option>
                                    <option value="ME">ME</option>
                                    <option value="MEd">MEd</option>
                                    <option value="MS">MS</option>
                                    <option value="MSW">MSW</option>
                                    <option value="MSc">MSc</option>
                                    <option value="MCS">MCS</option>
                                    <option value="MSN">MSN</option>
                                    <option value="MPhil">MPhil</option>
                                    <option value="PhD">PhD</option>
                                    <option value="CIMA">CIMA</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        @endif
                        @if($type=='graduate-programs')
                            <div class="form-group">
                                <label class="form-label" for="publishedDate">Degree Type</label>
                                <select name="degree_type" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="M.">M.</option>
                                    <option value="CA">CA</option>
                                    <option value="MA">MA</option>
                                    <option value="MBA">MBA</option>
                                    <option value="MFA">MFA</option>
                                    <option value="MPA">MPA</option>
                                    <option value="MPH">MPH</option>
                                    <option value="ME">ME</option>
                                    <option value="MEd">MEd</option>
                                    <option value="MS">MS</option>
                                    <option value="MSW">MSW</option>
                                    <option value="MSc">MSc</option>
                                    <option value="MCS">MCS</option>
                                    <option value="MSN">MSN</option>
                                    <option value="MPhil">MPhil</option>
                                    <option value="PhD">PhD</option>
                                    <option value="CIMA">CIMA</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        @endif
                        <div class="form-group">
                            <label class="form-label" for="bachelorDegree">Program</label>
                            <input type="text" name="degree_program" id="degree_program" class="form-control" placeholder="" required>
                        </div>
                        <button type="submit" class="btn btn-link w-100">Submit</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updateProgram" tabindex="-1" aria-labelledby="createAccountLabel" aria-hidden="true">
        <div class="modal-dialog projectManagement-modal modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body">
                    <div class="mb-4 projectManagement-inner">
                        <h6 class="">Update Program</h6>
                    </div>
                    {!! Form::open(array('route' => 'courses-update','id' => 'courses-update','class'=>'','files' => true)) !!}
                    <div class="form" id="ajaxValues">
                        @if(isset($type))
                            <input type="hidden" name="program_type" value="{{$type}}">
                        @else
                            <input type="hidden" name="program_type" value="1">
                        @endif
                        <div class="form-group">
                            <label class="form-label" for="projectTitle">Course Title</label>
                            <input type="text" id="projectTitle" name="title" class="form-control" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="bachelorDegree">Program</label>
                            <input type="text" name="degree_program" id="degree_program" class="form-control" placeholder="" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="publishedDate">Published Date</label>
                            <input type="date" name="publish_date" class="form-control" id="publish_date" placeholder="2/2/2023" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="dueDate">Due Date</label>
                            <input type="date" name="due_date" class="form-control" id="due_date" placeholder="2/5/2023" required>
                        </div>
                        <button type="submit" class="btn btn-link w-100">Update</button>
                    </div>
                    {{ Form::close() }}
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
                <p class="out-state">Out of State Tuition</p>
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
@endsection
@section('script')
    @include('flashy::message')
    <script type="application/javascript">
        function removeRating(elem,id){
            if(id){
                $.post('{{ route('removeRatingsFactor') }}', {_token:'{{ csrf_token() }}',id:id}, function (data) {

                });
            }
            $(elem).parent().parent().remove()
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
        function updateProgram(id){
            $.post('{{ route('courses-edit') }}', {_token:'{{ csrf_token() }}',course_id:id}, function (data) {
                $('#ajaxValues').empty().append(data['view'])
                $('#updateProgram').modal('show')
            });
        }
    </script>
@endsection
