@extends('frontend.layouts.app')
@section('style')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
@endsection
@section('content')
    <div class="container-fluid page-title pt-3">
        <div class="container">
            <div class="row px-5">
                <div class="col-lg-5 col-md-12 btn-group-section gap-3">
                    <a href="{{ route('dashboard') }}" class="btn btn-white"><span><img class="me-2" src="{{asset('public/assets/frontend/images/history.png')}}" alt="list"></span>Back</a>
                </div>
                <div class="col-lg-7 col-md-12 page-title-text">
                    <h1>Your Profile</h1> </div>
            </div>
        </div>
    </div>
    <div class="container-fluid profile-section-tab my-4">
        <div class="container">
            <div class="row">
                @if(\Illuminate\Support\Facades\Auth::user() && !empty(\Illuminate\Support\Facades\Auth::user()->type=='student'))
                <div class="card-body bg-white shadow">
                    <div class="row">
                        <div class="nav flex-column nav-pills col-lg-4 col-md-12 col-sm-12 account-info" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Account Information</button>
                            <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Educational Information</button>
                        </div>
                        <div class="tab-content col-lg-8 col-md-12 col-sm-12 account-info-inner" id="v-pills-tabContent">

                            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                <div class="login-wrap w-100">

                                    <div class="form">
                                        {!! Form::open(array('route' => 'updateProfile','id' => 'updateProfile','class'=>'','files' => true)) !!}
                                        <div class="form-group">
                                            <div class="file-upload">
                                                <div class="image-upload-wrap">
                                                    <input class="file-upload-input" id="profile-photo" name="image" type='file' onchange="readURL(this);" accept="image/*" />
                                                    <div class="drag-text">
                                                        @if(isset($user) && !empty($user->image))
                                                            <img class="" src="{{ asset("public".\Illuminate\Support\Facades\Storage::url($user->image)) }}" alt="amherst">
                                                        @else
                                                            <img src="{{asset('public/assets/frontend/images/uploud-your-photo.png')}}" alt="">
                                                        @endif
                                                    </div>
                                                    <span>Change Image</span>
                                                </div>
                                                <div class="file-upload-content">
                                                    <img class="file-upload-image" src="#" alt="your image" />
                                                    <div class="image-title-wrap">
                                                        <button type="button" onclick="removeUpload()" class="remove-image btn btn-danger my-4">Remove
                                                            <span class="text-white">Uploaded Image</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
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
                                            @if(isset($user->id))<input type="hidden" name="user_id" value="{{$user->id}}">@endif
                                            <div class="form-group col-lg-6 col-md-12">
                                                <label class="form-label">First / Given Name</label>
                                                <input type="text" name="first_name" @if($user->first_name) value="{{$user->first_name}}" @endif class="form-control">
                                            </div>
                                            <div class="form-group col-lg-6 col-md-12">
                                                <label class="form-label">Last / Surname </label>
                                                <input type="text" name="last_name" @if($user->last_name) value="{{$user->last_name}}" @endif class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-4 col-md-12">
                                                <label class="form-label">Phone</label>
                                                <input type="text" name="phone" min="1"  @if($user->phone) value="{{$user->phone}}" @endif class="form-control js-input-mobile">
                                            </div>
                                            <div class="form-group col-lg-4 col-md-12">
                                                <label class="form-label">Email</label>
                                                <input type="text" name="email" @if($user->email) value="{{$user->email}}" @endif class="form-control">
                                            </div>
                                            <div class="form-group col-lg-4 col-md-12">
                                                <label class="form-label">Gender</label>
{{--                                                <input type="text" name="gender" @if($user->gender) value="{{$user->gender}}" @endif class="form-control">--}}
                                                <select  class="form-select form-control" name="gender" aria-label="Default select example">
                                                    <option selected>Select</option>
                                                    <option value="United States" @if(isset($user->gender) && $user->gender=='male') selected @endif>Male</option>
                                                    <option value="Canada" @if(isset($user->gender) && $user->gender=='female') selected @endif>Female</option>
                                                    <option value="United Kingdom" @if(isset($user->gender) && $user->gender=='x') selected @endif>X</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-6 col-md-12">
                                                <label class="form-label">Date of Birth</label>
                                                <input type="date" name="dob" id="dt" class="form-control" @if($user->dob) value="{{$user->dob}}" @endif>
                                            </div>

                                            <div class="form-group col-lg-6 col-md-12">
                                                <label class="form-label">Address 1</label>
                                                <input type="text" name="address1" class="form-control" @if($user->address1) value="{{$user->address1}}" @endif>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-6 col-md-12">
                                                <label class="form-label">Address 2</label>
                                                <input type="text" name="address2" class="form-control" @if($user->address2) value="{{$user->address2}}" @endif>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-12">
                                                <label class="form-label">City</label>
                                                <input type="text" name="city" class="form-control" @if($user->city) value="{{$user->city}}" @endif>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-6 col-md-12">
                                                <label class="form-label">State</label>
                                                <input type="text" name="state" class="form-control" @if($user->state) value="{{$user->state}}" @endif>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-12">
                                                <label class="form-label">Zip code</label>
                                                <input type="text" name="zipcode" maxlength="5" class="form-control" @if($user->zipcode) value="{{$user->zipcode}}" @endif>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-12 col-md-12">
                                                <label class="form-label">Country</label>
                                                <select  class="form-select form-control" name="country" aria-label="Default select example">
                                                    <option selected>Select</option>
                                                    <option value="United States" @if(isset($user->country) && $user->country=='United States') selected @endif>United States</option>
                                                    <option value="Canada" @if(isset($user->country) && $user->country=='Canada') selected @endif>Canada</option>
                                                    <option value="United Kingdom" @if(isset($user->country) && $user->country=='United Kingdom') selected @endif>United Kingdom</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="input-group input-group-pass col-lg-6 col-md-12">
                                                <label class="form-label">New Password</label>
                                                <input type="password" name="password" class="form-control password new_password" placeholder="password">
                                                 <button class="btn" type="button">
                                                     <span toggle="#password-field" class="fa fa-eye field_icon toggle-password" aria-hidden="true"></span>
                                                    </button>
                                                </span>
                                            </div>
                                            <div class="input-group input-group-pass col-lg-6 col-md-12">
                                                <label class="form-label">Confirm New Password</label>
                                                <input type="password" name="cpassword" class="form-control password c_password" placeholder="confirm new password">
                                                <span class="input-group-append">
                                                    <button class="btn" type="button">
                                                <span toggle="#password-field" class="fa fa-eye field_icon confirm_toggle-password" aria-hidden="true"></span>
                                                    </button>
                                                </span>
                                            </div>


                                        </div>
                                        <div class="col-12 text-end next-start">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                        {{ Form::close() }}
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
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
                                {!! Form::open(array('route' => 'updateProfile','id' => 'updateProfile','class'=>'','files' => true)) !!}
                                @if(isset($user->id))<input type="hidden" name="user_id" value="{{$user->id}}">@endif
                                <div class="login-wrap login-wrap-second w-100">
                                    <div class="d-flex educational-inform gap-4 my-4">
                                        <span class="wpcf7-list-item first form-check educational mb-3">
                                        <input type="radio" id="firstYearStudent" @if(isset($user->userInfo->student_type) && $user->userInfo->student_type=='First year student') checked @endif name="student_type"  value="First year student">
                                        <label class="chekboxMainText" for="firstYearStudent">
                                            <span class="cnv-name">First year student -{{$user->userInfo->student_type}}</span>
                                        </label>
                                        </span>
                                        <span class="wpcf7-list-item first form-check educational mb-3">
                                        <input type="radio" id="firstYearStudent" @if(isset($user->userInfo->student_type) && $user->userInfo->student_type=='Transfer student') checked @endif name="student_type" value="Transfer student">
                                        <label class="chekboxMainText" for="transferStudent">
                                            <span class="cnv-name">Transfer student</span>
                                        </label>
                                        </span>
                                        <span class="wpcf7-list-item first form-check educational mb-3">
                                        <input type="radio" id="firstYearStudent" @if(isset($user->userInfo->student_type) && $user->userInfo->student_type=='Graduate student') checked @endif name="student_type" value="Graduate student">
                                        <label class="chekboxMainText" for="graduateStudent">
                                            <span class="cnv-name">Graduate student</span>
                                        </label>
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Highest Education Level Attained</label>
                                        <select class="form-select form-control" name="education_level" aria-label="Default select example">
                                            <option value="">Select</option>
                                            <option value="High School" @if(isset($user->userInfo->education_level) && $user->userInfo->education_level=='High School') selected @endif>High School</option>
                                            <option value="Some College" @if(isset($user->userInfo->education_level) && $user->userInfo->education_level=='Some College') selected @endif>Some College</option>
                                            <option value="Undergraduage" @if(isset($user->userInfo->education_level) && $user->userInfo->education_level=='Undergraduage') selected @endif>Undergraduage</option>
                                            <option value="Masters" @if(isset($user->userInfo->education_level) && $user->userInfo->education_level=='Masters') selected @endif>Masters</option>
                                            <option value="Professional Certification" @if(isset($user->userInfo->education_level) && $user->userInfo->education_level=='Professional Certification') selected @endif>Professional Certification</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Attained Institution Name</label>
                                        <input type="text" name="institution" class="form-control" @if($user->userInfo->institution) value="{{$user->userInfo->institution}}" @endif>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label fields-interset">Fields of Interest</label>
                                        @php if(isset($user->userInfo->interest)){ $interest= explode(',',$user->userInfo->interest); } @endphp
                                        <select class="select2 form-control" style="width: 100%;" name="interest[]" id="miscellaneous_yr_built" multiple>
                                            <option  value="Accounting">Accounting</option>
                                            <option  value="Architecture">Architecture</option>
                                            <option  value="Business Administration">Business Administration</option>
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
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                {{ Form::close() }}
                            </div>
                            </div>
                        </div>
                    </div>
                @else
                <div class="card-body bg-white shadow">
                    <div class="row">
                        <div class="nav flex-column nav-pills col-lg-4 col-md-12 col-sm-12 account-info" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">University Information</button>
                            <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Application Information</button>
                        </div>
                        <div class="tab-content col-lg-8 col-md-12 col-sm-12 account-info-inner" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                <div class="login-wrap w-100">
                                    {!! Form::open(array('route' => 'updateProfile','id' => 'updateProfile','class'=>'','files' => true)) !!}
                                    @if(isset($user->id))<input type="hidden" name="user_id" value="{{$user->id}}">@endif
                                    <div class="form">
                                        <div class="form-group">
                                            <div class="file-upload">
                                                <div class="image-upload-wrap">
                                                    <input class="file-upload-input" id="profile-photo" name="image" type="file" onchange="readURL(this);" accept="image/*">
                                                    <div class="drag-text">
                                                        @if(isset($user) && !empty($user->image))
                                                            <img class="" src="{{ asset("public".\Illuminate\Support\Facades\Storage::url($user->image)) }}" alt="amherst">
                                                        @else
                                                            <img src="{{asset('public/assets/frontend/images/uploud-your-photo.png')}}" alt="">
                                                        @endif
                                                    </div>
                                                    <span>Change Image</span>
                                                </div>
                                                <div class="file-upload-content">
                                                    <img class="file-upload-image" src="#" alt="your image">
                                                    <div class="image-title-wrap">
                                                        <button type="button" onclick="removeUpload()" class="remove-image btn btn-danger my-4">Remove
                                                            <span class="text-white">Uploaded Image</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                        <div class="form-group col-lg-12 col-md-12">
                                            <label class="form-label">University / College Name</label>
                                            <input type="text" name="fullname" @if(isset($user->fullname)) value="{{ $user->fullname }}" @endif class="form-control"  required>
                                        </div>
                                        <div class="form-group col-lg-12 col-md-12">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email"  @if(isset($user->email)) value="{{ $user->email }}" @endif class="form-control" required>
                                        </div>
                                        <div class="form-group col-lg-12 col-md-12">
                                            <label class="form-label">University Website</label>
                                            <input type="text" name="website"  @if(isset($user->website)) value="{{ $user->website }}" @endif class="form-control" required>
                                        </div>
                                        <div class="form-group col-lg-12 col-md-12">
                                            <label class="form-label">Contact Person email</label>
                                            <input type="email" name="uni_email"  @if(isset($user->uni_email)) value="{{ $user->uni_email }}" @endif class="form-control" required>
                                        </div>
                                        <div class="row">

                                            <div class="form-group col-lg-6 col-md-12">
                                                <label class="form-label">University phone number</label>
                                                <div class="col-auto form-input-col flag-input">
                                                    <input type="hidden" name="csrfmiddlewaretoken" value="JKdw9iIYBmZFvVdLFHssPLJuzmsm0UIxhtaWCLCtQgxn59h3vLpXMmUz5rQoJX5o">
                                                    <input type="tel" name="phone" maxlength="12" @if(isset($user->phone)) value="{{ $user->phone }}" @endif  title="Please use only numbers with no special characters" required placeholder="###-###-####" id="mobile-phone-number" class="form-control acct-mobile-number">
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-6 col-md-12">
                                                <label class="form-label">University Fax number</label>
                                                <div class="col-auto form-input-col flag-input">
                                                    <input type="hidden" name="csrfmiddlewaretoken" value="JKdw9iIYBmZFvVdLFHssPLJuzmsm0UIxhtaWCLCtQgxn59h3vLpXMmUz5rQoJX5o">
                                                    <input type="tel" maxlength="12" name="fax" @if(isset($user->fax)) value="{{ $user->fax }}" @endif  title="Please use only numbers with no special characters" placeholder="###-###-####" id="mobile-phone-number" class="form-control acct-mobile-number">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-6 col-md-12">
                                                <label class="form-label">Addresss</label>
                                                <input type="text" name="address1" @if(isset($user->address1)) value="{{ $user->address1 }}" @endif id="address-input" class="form-control map-input">
                                                <input type="hidden" name="latitude" id="address-latitude" value="0" />
                                                <input type="hidden" name="longitude" id="address-longitude" value="0" />
                                                <div id="address-map-container" >
                                                    <div id="address-map"></div>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-12">
                                                <label class="form-label">City</label>
                                                <input type="text" name="city" @if(isset($user->city)) value="{{ $user->city }}" @endif class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-4 col-md-12">
                                                <label class="form-label">State</label>
                                                <input type="text" id="google_state" name="state" @if(isset($user->state)) value="{{ $user->state }}" @endif class="form-control" required>
                                            </div>
                                            <div class="form-group col-lg-4 col-md-12">
                                                <label class="form-label">Zip</label>
                                                <input type="text" name="zipcode" @if(isset($user->zipcode)) value="{{ $user->zipcode }}" @endif class="form-control" required>
                                            </div>
                                            <div class="form-group col-lg-4 col-md-12">
                                                <label class="form-label">Country</label>
                                                <select class="form-select form-control" name="country" aria-label="Default select example" required>
                                                    <option selected>Select</option>
                                                    <option value="United States" @if(isset($user->country) && $user->country=='United States') selected @endif>United States</option>
                                                    <option value="Canada" @if(isset($user->country) && $user->country=='Canada') selected @endif>Canada</option>
                                                    <option value="United Kingdom" @if(isset($user->country) && $user->country=='United Kingdom') selected @endif>United Kingdom</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-12 col-md-12">
                                            <label class="form-label">Other information </label>
                                            <textarea name="other_info" class="form-control" rows="4">@if(isset($user->other_info)) {{ $user->other_info }} @endif</textarea>
                                        </div>
                                        <div class="row">
                                            <div class="input-group input-group-pass col-lg-6 col-md-12">
                                                <label class="form-label">New Password</label>
                                                <input type="password" name="password" class="form-control password new_password" placeholder="password">                                                <span class="input-group-append">
                                                    <button class="btn" type="button">
                                                     <span toggle="#password-field" class="fa fa-eye field_icon toggle-password" aria-hidden="true"></span>
                                                    </button>
                                                </span>
                                            </div>
                                            <div class="input-group input-group-pass col-lg-6 col-md-12">
                                                <label class="form-label">Confirm New Password</label>
                                                <input type="password" name="cpassword" class="form-control password c_password" placeholder="confirm new password">                                             <span class="input-group-append">
                                                    <button class="btn" type="button">
                                                <span toggle="#password-field" class="fa fa-eye field_icon confirm_toggle-password" aria-hidden="true"></span>
                                                    </button>
                                                </span>
                                            </div>

                                        </div>
                                        <div class="col-12 text-end next-start">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                    {{ Form::close() }}
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                <div class="login-wrap login-wrap-second w-100">
                                    {!! Form::open(array('route' => 'updateProfile','id' => 'updateProfile','class'=>'','files' => true)) !!}
                                    @if(isset($user->id))<input type="hidden" name="user_id" value="{{$user->id}}">@endif
                                    <div class="form">
                                        <div class="row state_tuitionFlex">
                                            <div class="form-group col-lg-12 col-md-12">
                                                <label class="form-label">Spring Application Deadline</label>
                                                <input max="2050-12-31" pattern="[0-9]{4}[0-1][0-9][0-3][0-9}" type="date" id="datePicker_spring" name="spring_dead_start" @if(isset($user->userInfo->spring_dead_start)) value="{{ \Carbon\Carbon::parse($user->userInfo->spring_dead_start)->format('Y-m-d') }}" @endif class="datepicker form-control" required>
                                            </div>
                                        </div>
                                        <div class="row state_tuitionFlex">
                                            <div class="form-group col-lg-12 col-md-12">
                                                <label class="form-label">Fall Application Deadline</label>
                                                <input max="2050-12-31" pattern="[0-9]{4}[0-1][0-9][0-3][0-9}" type="date" name="fall_dead_start" @if(isset($user->userInfo->fall_dead_start)) value="{{ \Carbon\Carbon::parse($user->userInfo->fall_dead_start)->format('Y-m-d') }}" @endif class="datepicker form-control" required>
                                            </div>

                                        </div>
                                            <div class="d-flex justify-content-between stepCreate">
                                                <h5>Full-Time</h5>
                                                <p class="step1">Step-1</p>
                                            </div>
                                            <div class="form">
                                                <div class="form-group col-lg-12 col-md-12">
                                                    <label class="form-label">Annual Tuition</label>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-12">
                                                            <input min="0" max="6" type="text" name="annual_in_state" @if(isset($user->userInfo->annual_in_state)) value="${{ number_format($user->userInfo->annual_in_state,2) }}" @endif class="form-control onlyNumbersInputs">
                                                        </div>
                                                        <div class="col-lg-6 col-md-12">
                                                            <input min="0" max="6" type="text" name="annual_out_state" @if(isset($user->userInfo->annual_out_state)) value="${{ number_format($user->userInfo->annual_out_state,2) }}" @endif class="form-control onlyNumbersInputs">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group col-lg-12 col-md-12">
                                                    <label class="form-label">Mandatory Fees</label>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-12">
                                                            <input min="0" max="6" type="text" name="manda_in_state" @if(isset($user->userInfo->manda_in_state)) value="${{ number_format($user->userInfo->manda_in_state,2) }}" @endif class="form-control onlyNumbersInputs">
                                                        </div>
                                                        <div class="col-lg-6 col-md-12">
                                                            <input min="0" max="6" type="text" name="manda_out_state" @if(isset($user->userInfo->manda_out_state)) value="${{ number_format($user->userInfo->manda_out_state,2) }}" @endif class="form-control onlyNumbersInputs">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-lg-12 col-md-12">
                                                    <label class="form-label">Room &amp; Board</label>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-12">
                                                            <input min="0" max="6" type="text" name="room_in_state" @if(isset($user->userInfo->room_in_state)) value="${{ number_format($user->userInfo->room_in_state,2) }}" @endif class="form-control onlyNumbersInputs">
                                                        </div>
                                                        <div class="col-lg-6 col-md-12">
                                                            <input min="0" max="6" type="text" name="room_out_state" @if(isset($user->userInfo->room_out_state)) value="${{ number_format($user->userInfo->room_out_state,2) }}" @endif class="form-control onlyNumbersInputs" >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-lg-12 col-md-12">
                                                    <label class="form-label">EDU Discount</label>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-12">
                                                            <input min="0" max="6" type="text" name="dis_in_state" @if(isset($user->userInfo->dis_in_state)) value="${{ number_format($user->userInfo->dis_in_state,2) }}" @endif class="form-control onlyNumbersInputs">
                                                        </div>
                                                        <div class="col-lg-6 col-md-12">
                                                            <input min="0" max="6" type="text" name="dis_out_state" @if(isset($user->userInfo->dis_out_state)) value="${{ number_format($user->userInfo->dis_out_state,2) }}" @endif class="form-control onlyNumbersInputs">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-lg-12 col-md-12">
                                                    <label class="form-label">Total Yearly</label>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-12">
                                                            <input min="0" max="6" type="text" name="tyearly_in_state" @if(isset($user->userInfo->tyearly_in_state)) value="${{ number_format($user->userInfo->tyearly_in_state,2) }}" @endif class="form-control onlyNumbersInputs">
                                                        </div>
                                                        <div class="col-lg-6 col-md-12">
                                                            <input min="0" max="6" type="text" name="tyearly_out_state" @if(isset($user->userInfo->tyearly_out_state)) value="${{ number_format($user->userInfo->tyearly_out_state,2) }}" @endif class="form-control onlyNumbersInputs">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-between stepCreate">
                                                <h5>Part-Time</h5>
                                                <p class="step1">Step-2</p>
                                            </div>
                                            <div class="form">
                                                <div class="form-group col-lg-12 col-md-12">
                                                    <label class="form-label">Tuition - Per Credit</label>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6">
                                                            <input min="0" max="6" type="text" name="pann_in_state" class="form-control onlyNumbersInputs" placeholder="in state" @if(isset($user->userInfo->pann_in_state)) value="${{ number_format($user->userInfo->pann_in_state,2) }}" @endif>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6">
                                                            <input min="0" max="6" type="text" name="pann_out_state" class="form-control onlyNumbersInputs " placeholder="out state" @if(isset($user->userInfo->pann_out_state)) value="${{ number_format($user->userInfo->pann_out_state,2) }}" @endif>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-lg-12 col-md-12">
                                                    <label class="form-label">EDU Discount</label>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-12">
                                                            <input min="0" max="6" type="text" name="pdis_in_state" class="form-control onlyNumbersInputs" @if(isset($user->userInfo->pdis_in_state)) value="${{ number_format($user->userInfo->pdis_in_state,2) }}" @endif>
                                                        </div>
                                                        <div class="col-lg-6 col-md-12">
                                                            <input min="0" max="6" type="text" name="pdis_out_state" class="form-control onlyNumbersInputs" @if(isset($user->userInfo->pdis_out_state)) value="${{ number_format($user->userInfo->pdis_out_state,2) }}" @endif>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-lg-12 col-md-12">
                                                    <label class="form-label">Total Per Credit</label>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-12">
                                                            <input min="0" max="6" type="text" name="pcredit_in_state" class="form-control onlyNumbersInputs" @if(isset($user->userInfo->pcredit_in_state)) value="${{ number_format($user->userInfo->pcredit_in_state,2) }}" @endif>
                                                        </div>
                                                        <div class="col-lg-6 col-md-12">

                                                            <input min="0" max="6" type="text" name="pcredit_out_state" class="form-control onlyNumbersInputs" @if(isset($user->userInfo->pcredit_out_state)) value="${{ number_format($user->userInfo->pcredit_out_state,2) }}" @endif>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="form-group col-lg-12 col-md-12">
                                            <label class="form-label">Scholarship information (Optional)</label>
                                            <textarea name="scholarship_info"  class="form-control" rows="4">@if(isset($user->userInfo->scholarship_info)) {{$user->userInfo->scholarship_info}} @endif</textarea>
                                        </div>
                                        <div class="form-group col-lg-12 col-md-12">
                                            <label class="form-label">Other information </label>
                                            <textarea name="other_info" class="form-control" rows="4">@if(isset($user->userInfo->other_info)) {{$user->userInfo->other_info}} @endif</textarea>
                                        </div>
                                        <div class="col-12 text-end next-start">
                                            <button type="submit" class="btn btn-link me-3">Update</button>
                                        </div>
                                    </div>
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('public/assets/frontend/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('public/assets/frontend/js/additional-methods.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAG6eAdW_1mCTdPUJSGVLrFB_UPMj0Y4Yg&libraries=places&callback=initialize" async defer></script>
    <script>
        // document.getElementById('dt').max = new Date(new Date().getTime() - new Date().getTimezoneOffset() * 60000).toISOString().split("T")[0];
        $(document).on('click', '.toggle-password', function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $(".new_password");
            input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
        });
        $(document).on('click', '.confirm_toggle-password', function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $(".c_password");
            input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
        });
    </script>
    <script type="application/javascript">
        function initialize() {
            $('#address-input').on('keyup keypress', function(e) {
                var keyCode = e.keyCode || e.which;
                if (keyCode === 13) {
                    e.preventDefault();
                    return false;
                }
            });

            const locationInputs = document.getElementsByClassName("map-input");
            const autocompletes = [];
            const geocoder = new google.maps.Geocoder;

            for (let i = 0; i < locationInputs.length; i++) {

                const input = locationInputs[i];
                const fieldKey = input.id.replace("-input", "");
                const isEdit = document.getElementById(fieldKey + "-latitude").value != '' && document.getElementById(fieldKey + "-longitude").value != '';

                const latitude = parseFloat(document.getElementById(fieldKey + "-latitude").value) || -33.8688;
                const longitude = parseFloat(document.getElementById(fieldKey + "-longitude").value) || 151.2195;

                const map = new google.maps.Map(document.getElementById(fieldKey + '-map'), {
                    center: {lat: latitude, lng: longitude},
                    zoom: 13
                });
                const marker = new google.maps.Marker({
                    map: map,
                    position: {lat: latitude, lng: longitude},
                });

                marker.setVisible(isEdit);
                const autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.key = fieldKey;
                autocompletes.push({input: input, map: map, marker: marker, autocomplete: autocomplete});
            }

            for (let i = 0; i < autocompletes.length; i++) {
                const input = autocompletes[i].input;
                const autocomplete = autocompletes[i].autocomplete;
                const map = autocompletes[i].map;
                const marker = autocompletes[i].marker;

                google.maps.event.addListener(autocomplete, 'place_changed', function () {
                    marker.setVisible(false);
                    const place = autocomplete.getPlace();

                    geocoder.geocode({'placeId': place.place_id}, function (results, status) {
                        if (status === google.maps.GeocoderStatus.OK) {
                            if (results[0])
                            {
                                var city = "";
                                var state = "";
                                var country = "";
                                var zipcode = "";
                                var address_components = results[0].address_components;
                                for (var i = 0; i < address_components.length; i++)
                                {
                                    if (address_components[i].types[0] === "administrative_area_level_1" && address_components[i].types[1] === "political") {
                                        state = address_components[i].short_name;
                                        $('#google_state').val(state)
                                    }
                                    if (address_components[i].types[0] === "locality" && address_components[i].types[1] === "political" ) {
                                        city = address_components[i].long_name;
                                        $('#google_city').val(city)
                                    }
                                    if (address_components[i].types[0] === "postal_code" && zipcode == "") {
                                        zipcode = address_components[i].long_name;
                                        $('#google_zipcode').val(zipcode)
                                    }
                                    if (address_components[i].types[0] === "country") {
                                        country = address_components[i].long_name;
                                    }
                                }
                            }


                            const lat = results[0].geometry.location.lat();
                            const lng = results[0].geometry.location.lng();
                            setLocationCoordinates(autocomplete.key, lat, lng);
                        }
                    });

                    if (!place.geometry) {
                        window.alert("No details available for input: '" + place.name + "'");
                        input.value = "";
                        return;
                    }

                    if (place.geometry.viewport) {
                        map.fitBounds(place.geometry.viewport);
                    } else {
                        map.setCenter(place.geometry.location);
                        map.setZoom(17);
                    }
                    marker.setPosition(place.geometry.location);
                    marker.setVisible(true);

                });
            }
        }
        function setLocationCoordinates(key, lat, lng) {
            const latitudeField = document.getElementById(key + "-" + "latitude");
            const longitudeField = document.getElementById(key + "-" + "longitude");
            latitudeField.value = lat;
            longitudeField.value = lng;
        }
        function openAddressModal() {
            $( ".map_Area" ).toggle('slow');
        }
    </script>
    <script type="application/javascript">
        var format = function(num){
            var str = num.toString().replace("", ""), parts = false, output = [], i = 1, formatted = null;
            if(str.indexOf(".") > 0) {
                parts = str.split(".");
                str = parts[0];
            }
            str = str.split("").reverse();
            for(var j = 0, len = str.length; j < len; j++) {
                if(str[j] != ",") {
                    output.push(str[j]);
                    if(i%3 == 0 && j < (len - 1)) {
                        output.push(",");
                    }
                    i++;
                }
            }
            formatted = output.reverse().join("");
            return("" + formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
        };
        $(".onlyNumbersInputs").on('input', function (event) {
            var input = $(this);
            var value = input.val().replace(/[^0-9]/g, ''); // Remove non-numeric characters

            if (value.length > 6) {
                value = value.slice(0, 6); // Keep only the first 6 digits
            }
            input.val('$' + value);
        });
    </script>
    <script type="application/javascript">
        var inputQuantity = [];
        $(function() {
            $(".js-input-mobile").on("keyup", function (e) {
                var $field = $(this),
                    val=this.value,
                    $thisIndex=parseInt($field.data("idx"),7);
                if (+this.validity && this.validity.badInput || isNaN(val) || $field.is(":invalid") ) {
                    this.value = inputQuantity[$thisIndex];
                    return;
                }
                if (val.length > Number($field.attr("maxlength"))) {
                    val=val.slice(0, 5);
                    $field.val(val);
                }
                inputQuantity[$thisIndex]=val;
            });
        });

        $(document).ready(function() {
            $('.password').val('')
            setTimeout(function (){$('.password').val('')},1500)

            $('.select2').select2({
                multiple: "multiple",
                placeholder: "Select",
                allowClear: true
            });
            $(".select2").select2({
                multiple: true,
            });
            $('.select2').val(selectedAll).trigger('change');
        });
        var selectedAll=<?php if(isset($interest)){ echo json_encode($interest); } ?>


        var date = new Date();
        $(function() {
            $( ".datepicker" ).datepicker({
                dateFormat: "yy-mm-dd", // Change date format if needed
                changeMonth: true,
                yearRange: "-100:+100", // Allow a range of 100 years
                beforeShow: function(input) {
                    setTimeout(function() {
                        var yearField = $('.ui-datepicker-year');
                        yearField.attr('maxlength', 4);
                    }, 1);
                },
                onClose: function(dateText, inst) {
                    var yearField = $('.ui-datepicker-year');
                    var year = parseInt(yearField.val());
                    if (yearField.val().length > 4 || isNaN(year)) {
                        yearField.val('');
                        inst.selectedYear = null;
                    }
                }
            });

        });
        {{--document.getElementById('datePicker_spring').valueAsDate = '{{ \Carbon\Carbon::parse($user->userInfo->spring_dead_start)->format('d-m-Y') }}';--}}
    </script>
    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.image-upload-wrap').hide();
                    $('.file-upload-image').attr('src', e.target.result);
                    $('.file-upload-content').show();
                    $('.image-title').html(input.files[0].name);
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                removeUpload();
            }
        }
        function removeUpload() {
            $('.file-upload-content').hide();
            $('.file-upload-image').attr('src','');
            $('.image-upload-wrap').show();
            $('.file-upload-input').val('')
        }
        $('.image-upload-wrap').bind('dragover', function() {
            $('.image-upload-wrap').addClass('image-dropping');
        });
        $('.image-upload-wrap').bind('dragleave', function() {
            $('.image-upload-wrap').removeClass('image-dropping');
        });
        var regex = /^\s*(?:\+?(\d{1,3}))?([-. (]*(\d{3})[-. )]*)?((\d{3})[-. ]*(\d{2,4})(?:[-.x ]*(\d+))?)\s*$/gm;
        $('#mobile-phone-number').keydown(function (e) {
            var key = e.charCode || e.keyCode || 0;
            $text = $(this);
            if (key !== 8 && key !== 9) {
                if ($text.val().length === 3) {
                    $text.val($text.val() + '-');
                }
                if ($text.val().length === 7) {
                    $text.val($text.val() + '-');
                }
            }
            return;
        })
        $('#mobile-number').keydown(function (e) {
            var key = e.charCode || e.keyCode || 0;
            $text = $(this);
            if (key !== 8 && key !== 9) {
                if ($text.val().length === 3) {
                    $text.val($text.val() + '-');
                }
                if ($text.val().length === 7) {
                    $text.val($text.val() + '-');
                }
            }
            return;
        })
        $('#mobile-fax-number').keydown(function (e) {
            var key = e.charCode || e.keyCode || 0;
            $text = $(this);
            if (key !== 8 && key !== 9) {
                if ($text.val().length === 3) {
                    $text.val($text.val() + '-');
                }
                if ($text.val().length === 7) {
                    $text.val($text.val() + '-');
                }
            }
            return;
        })
    </script>
    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.image-upload-wrap').hide();
                    $('.file-upload-image').attr('src', e.target.result);
                    $('.file-upload-content').show();
                    $('.image-title').html(input.files[0].name);
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                removeUpload();
            }
        }
        function removeUpload() {
            $('.file-upload-content').hide();
            $('.file-upload-image').attr('src','');
            $('.image-upload-wrap').show();
            $('.file-upload-input').val('')
        }
        $('.image-upload-wrap').bind('dragover', function() {
            $('.image-upload-wrap').addClass('image-dropping');
        });
        $('.image-upload-wrap').bind('dragleave', function() {
            $('.image-upload-wrap').removeClass('image-dropping');
        });
        // Setting regex for validating phone number
        var regex = /^\s*(?:\+?(\d{1,3}))?([-. (]*(\d{3})[-. )]*)?((\d{3})[-. ]*(\d{2,4})(?:[-.x ]*(\d+))?)\s*$/gm;
        // Adding in dashes to the encourage 10-digit US mobile number formatting
        $('#mobile-phone-number').keydown(function (e) {
            var key = e.charCode || e.keyCode || 0;
            $text = $(this);
            if (key !== 8 && key !== 9) {
                if ($text.val().length === 3) {
                    $text.val($text.val() + '-');
                }
                if ($text.val().length === 7) {
                    $text.val($text.val() + '-');
                }
            }
            return;
        })
        $('#mobile-number').keydown(function (e) {
            var key = e.charCode || e.keyCode || 0;
            $text = $(this);
            if (key !== 8 && key !== 9) {
                if ($text.val().length === 3) {
                    $text.val($text.val() + '-');
                }
                if ($text.val().length === 7) {
                    $text.val($text.val() + '-');
                }
            }
            return;
        })

        // Adding in dashes to the encourage 10-digit US mobile number formatting
        $('#mobile-fax-number').keydown(function (e) {
            var key = e.charCode || e.keyCode || 0;
            $text = $(this);
            if (key !== 8 && key !== 9) {
                if ($text.val().length === 3) {
                    $text.val($text.val() + '-');
                }
                if ($text.val().length === 7) {
                    $text.val($text.val() + '-');
                }
            }
            return;
        })

    </script>
@endsection
