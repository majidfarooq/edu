@extends('frontend.layouts.app')
@section('style')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
@endsection
@section('content')
    <section class="h-100 gradient-form" style="background-color: hsl(0deg 0% 0% / 53%);">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card rounded-3 text-black">
                        <div class="wrap d-md-flex">
                            <div class="img">
                                <img class="w-100" src="{{asset('public/assets/frontend/images/step3.png')}}" alt="create">
                            </div>
                            <div class="login-wrap login-wrap-second">
                                <div class="d-flex justify-content-between stepCreate">
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
                                    <h5>Create Account</h5>
                                    <p class="step1">Step-3</p>
                                </div>
                                {!! Form::open(array('route' => 'submitFourth','id' => 'submitFourth','class'=>'','files' => true)) !!}
                                <div class="form">
                                    @if($userId) <input type="hidden" name="user_id" value="{{$userId}}"> @endif
                                    <div class="d-flex educational-inform gap-4 my-4">
                                        <span class="wpcf7-list-item first form-check educational mb-3">
                                        <input type="radio" id="firstYearStudent" name="student_type" value="First year student" required>
                                        <label class="chekboxMainText" for="firstYearStudent">
                                            <span class="cnv-name">First year student</span>
                                        </label>
                                        </span>
                                        <span class="wpcf7-list-item first form-check educational mb-3">
                                        <input type="radio" id="firstYearStudent" name="student_type" value="Transfer student" required>
                                        <label class="chekboxMainText" for="transferStudent">
                                            <span class="cnv-name">Transfer student</span>
                                        </label>
                                        </span>
                                        <span class="wpcf7-list-item first form-check educational mb-3">
                                        <input type="radio" id="firstYearStudent" name="student_type" value="Graduate student" required>
                                        <label class="chekboxMainText" for="graduateStudent">
                                            <span class="cnv-name">Graduate student</span>
                                        </label>
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Highest Education Level Attained</label>
                                        <select class="form-select form-control" name="education_level" aria-label="Default select example" required>
                                            <option value="">Select</option>
                                            <option value="High School">High School</option>
                                            <option value="Some College">Some College</option>
                                            <option value="Undergraduage">Undergraduate</option>
                                            <option value="Masters">Masters</option>
                                            <option value="Professional Certification">Professional Certification</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Institution Attended</label>
                                        <input type="text" name="institution" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label fields-interset">Fields of Interest <span> (enter values separating with comma)</span></label>
                                        <select class="select2 form-control" style="width: 100%;" name="interest[]" id="miscellaneous_yr_built" required>
                                            <option value="Accounting">Accounting</option>
                                            <option value="Architecture">Architecture</option>
                                            <option value="Business Administration">Business Administration</option>
                                            <option value="Environmental Design">Environmental Design</option>
                                            <option value="Aviation">Aviation</option>
                                            <option value="Business Management">Business Management</option>
                                            <option value="Communication">Communication</option>
                                            <option value="Journalism">Journalism</option>
                                            <option value="Computer Science">Computer Science</option>
                                            <option value="Information Science">Information Science</option>
                                            <option value="Education">Education</option>
                                            <option value="Engineering">Engineering</option>
                                            <option value="Linguistics">Linguistics</option>
                                            <option value="History">History</option>
                                            <option value="Homeland Security">Homeland Security</option>
                                            <option value="Law Enforcement">Law Enforcement</option>
                                            <option value="Firefighting">Firefighting</option>
                                            <option value="Human Services">Human Services</option>
                                            <option value="Law">Law</option>
                                            <option value="Liberal Arts">Liberal Arts</option>
                                            <option value="Culinary Arts">Culinary Arts</option>
                                            <option value="Philosophy">Philosophy</option>
                                            <option value="Religious Studies">Religious Studies</option>
                                            <option value="Psychology">Psychology</option>
                                            <option value="Theology">Theology</option>
                                            <option value="Visual Arts">Visual Arts</option>
                                            <option value="Architectural Engineering">Architectural Engineering</option>
                                            <option value="Civil Engineering">Civil Engineering</option>
                                            <option value="Computer Engineering">Computer Engineering</option>
                                            <option value="Construction Engineering">Construction Engineering</option>
                                            <option value="Electrical Engineering">Electrical Engineering</option>
                                            <option value="Industrial Engineering">Industrial Engineering</option>
                                            <option value="Mechanical Engineering">Mechanical Engineering</option>
                                            <option value="Nuclear Engineering">Nuclear Engineering</option>
                                            <option value="Biomedical Sciences">Biomedical Sciences</option>
                                            <option value="Biochemistry">Biochemistry</option>
                                            <option value="Molecular Biology">Molecular Biology</option>
                                            <option value="Biology">Biology</option>
                                            <option value="Biomathematics">Biomathematics</option>
                                            <option value="Biotechnology">Biotechnology</option>
                                            <option value="Plant Biology">Plant Biology</option>
                                            <option value="Cellular Biology">Cellular Biology </option>
                                            <option value="Ecology">Ecology</option>
                                            <option value="Genetics">Genetics</option>
                                            <option value="Microbiology">Microbiology</option>
                                            <option value="Immunology">Immunology</option>
                                            <option value="Molecular Medicine">Molecular Medicine</option>
                                            <option value="Neurobiology">Neurobiology</option>
                                            <option value="Pharmacology">Pharmacology</option>
                                            <option value="Toxicology">Toxicology</option>
                                            <option value="Physiology">Physiology</option>
                                            <option value="Zoology">Zoology</option>
                                            <option value="undecided">Undecided</option>
                                        </select>
                                    </div>
                                    <div class="col-12 text-end next-start">
                                        <button type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script src="{{ asset('public/assets/frontend/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('public/assets/frontend/js/additional-methods.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="application/javascript">

        $(document).ready(function() {
            $('.select2').select2({
                minimumResultsForSearch: -1,
                multiple: "multiple",
                placeholder: "Select",
                allowClear: true
            });
            if ($('.select2.fix').hasClass("select2-hidden-accessible")) {
                $('.select2.fix').val(null).trigger('change');
            }
            $(".select2").val('').trigger('change')
        });

    </script>
@endsection
