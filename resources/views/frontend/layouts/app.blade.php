<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awsome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>

    <link rel="preload" href="{{asset('../fonts/Nunito-Bold/Nunito-Bold.woff2')}}" as="font"  crossorigin="anonymous">
    <link rel="preload" href="{{asset('../fonts/Nunito-Bold/Nunito-Bold.woff')}}" as="font" crossorigin="anonymous">
    <link rel="preload" href="{{asset('../fonts/Nunito-Light/Nunito-Light.woff2')}}" as="font" crossorigin="anonymous">
    <link rel="preload" href="{{asset('../fonts/Nunito-Light/Nunito-Light.woff')}}" as="font" crossorigin="anonymous">
    <link rel="preload" href="{{asset('../fonts/Nunito-Medium/Nunito-Medium.woff2')}}" as="font" crossorigin="anonymous">
    <link rel="preload" href="{{asset('../fonts/Nunito-Medium/Nunito-Medium.woff')}}" as="font" crossorigin="anonymous">
    <link rel="preload" href="{{asset('../fonts/Nunito-SemiBold/Nunito-SemiBold.woff2')}}" as="font" crossorigin="anonymous">
    <link rel="preload" href="{{asset('../fonts/Nunito-SemiBold/Nunito-SemiBold.woff')}}" as="font" crossorigin="anonymous">
    <link rel="preload" href="{{asset('../fonts/Nunito-Regular/Nunito-Regular.woff2')}}" as="font" crossorigin="anonymous">
    <link rel="preload" href="{{asset('../fonts/Nunito-Regular/Nunito-Regular.woff')}}" as="font" crossorigin="anonymous">
    <link rel="preload" href="{{asset('../fonts/gt-america/gt_america_bold.woff2')}}" as="font" crossorigin="anonymous">
    <link rel="preload" href="{{asset('../fonts/gt-america/gt_america_bold.woff')}}" as="font" crossorigin="anonymous">
    <link rel="preload" href="{{asset('../fonts/gt-america/gt_america_regular.woff2')}}" as="font" crossorigin="anonymous">
    <link rel="preload" href="{{asset('../fonts/gt-america/gt_america_regular.woff')}}" as="font" crossorigin="anonymous">

    <!-- Bootstrap CSS -->
    <link rel="shortcut icon" href="{{ asset('public/assets/backend/images/Edu Broker-Final-Logo-Favicon-2-01.png') }}" />
    <link rel="stylesheet" href="{{asset('public/assets/frontend/owlcarousel/assets/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/frontend/owlcarousel/assets/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/frontend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/frontend/css/hover-min.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/frontend/css/style.css')}}" as="style">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @if(isset($user->fullname))
    <title></title>
    <meta property="og:title" content="{{$user->fullname}}"/>
    @else
    <title>Edu Brokers</title>
    @endif
    @if(isset($user->image))
        <meta property="og:image" content="{{ asset("public".\Illuminate\Support\Facades\Storage::url($user->image)) }}"/>
        <meta property="og:image:secure_url" content="{{ asset("public".\Illuminate\Support\Facades\Storage::url($user->image)) }}" />
    @endif
    <link rel="icon" type="image/x-icon" href="{{asset('public/assets/frontend/images/favicon.ico')}}">
    <script type="text/javascript" src="{{asset('public/assets/frontend/js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/assets/frontend/owlcarousel/owl.carousel.js')}}"></script>
    @yield('style')
</head>
<body>

@include('frontend.includes.header')
@yield('content')
@include('frontend.includes.footer')
@stack('js')
@yield('script')

<div class="modal fade" id="createAccount" tabindex="-1" aria-labelledby="createAccountLabel" aria-hidden="true">
    <div class="modal-dialog createAccount modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h5>Choose Account Type</h5>
                <hr>
                <a data-bs-toggle="modal" onclick="setUserType('student')" data-bs-target="#logIn" class="btn btn-primary w-100">Student?</a>
                <div class="col-12 or-text text-center my-3">
                    <p>OR</p>
                </div>
                <a data-bs-toggle="modal" onclick="setUserType('university')" class="btn btn-link w-100" data-bs-target="#logIn">College/University?</a>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="onlyLogin" tabindex="-1" aria-labelledby="onlyLogin" aria-hidden="true">
    <div class="modal-dialog loginAccount modal-dialog-centered">
        <div class="modal-content">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    {!! Form::open(array('route' => 'loginUser','id' => 'loginUser','class'=>'','files' => true)) !!}
                    <div class="form pt-5">
                        <div style="display: none" class="alert alert-warning alert-dismissible fade show" role="alert" id="dismiss_alerts">
                            <strong>Failed!</strong> failed to process request, try again.
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="text" name="email" class="form-control" >
                        </div>
                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group creat-account text-end forgot-area">
                            <p class="align-left"><a onclick="forgotPassMOdal()">Forgot Password</a></p>
                            <p class="align-right"><a onclick="createAccount()">Create your Account</a></p>
                        </div>

                        <button type="submit" class="btn btn-link w-100">Login</button>

                        <div class="col-12 text-center my-3">
                            <div class="offset-lg-6 col-lg-6 col-md-12 d-flex or-log">
                                <p class="me-2">OR</p>
                                <p>LOG IN WITH</p>
                            </div>
                        </div>
                        <div class="text-center social-modal my-4">
                            <a href="{{route('facebook-response')}}">
                                <button type="button" class="btn btn-link facebook-link btn-floating mx-3">
                                    <i class="fab fa-facebook-f"></i>
                                </button>
                            </a>
                            <a href="{{route('google-login')}}">
                            <button type="button" class="btn btn-link google-link btn-floating mx-3">
                                <i class="fab fa-google"></i>
                            </button>
                            </a>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="logIn" tabindex="-1" aria-labelledby="logInLabel" aria-hidden="true">
    <div class="modal-dialog loginAccount modal-dialog-centered">
        <div class="modal-content">

        <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="loginUser-tab" data-bs-toggle="tab" data-bs-target="#loginUser_tab" type="button" role="tab" aria-controls="loginUser" aria-selected="false">Log In</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab" aria-controls="register" aria-selected="true">Create Account</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade" id="loginUser_tab" role="tabpanel" aria-labelledby="loginUser-tab">
                {!! Form::open(array('route' => 'loginUser','id' => 'loginUserNext','class'=>'','files' => true)) !!}
                <div class="form pt-5">
                    <div style="display: none" class="alert alert-warning alert-dismissible fade show dismiss_alerts" role="alert" >
                        <strong>Failed!</strong> failed to process request, try again.
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="form-group creat-account text-end">
                        <p><a href="#">Create your Account</a></p>
                    </div>

                    <button type="submit" class="btn btn-link w-100">Login</button>

                    <div class="col-12 text-center my-3">
                        <div class="offset-lg-6 col-lg-6 col-md-12 d-flex or-log">
                            <p class="me-2">OR</p>
                            <p>LOG IN WITH</p>
                        </div>
                    </div>
                    <div class="text-center social-modal my-4">
                        <a href="{{route('facebook-response')}}">
                        <button type="button" class="btn btn-link facebook-link btn-floating mx-3">
                            <i class="fab fa-facebook-f"></i>
                        </button>
                        </a>
                        <a href="{{route('google-login')}}">
                        <button type="button" class="btn btn-link google-link btn-floating mx-3">
                            <i class="fab fa-google"></i>
                        </button>
                        </a>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
            <div class="tab-pane fade show active" id="register" role="tabpanel" aria-labelledby="register-tab">
                <div class="form pt-5">
                    {!! Form::open(array('route' => 'submitsignup','id' => 'submitsignup','class'=>'','files' => true)) !!}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div style="display: none" class="alert alert-warning alert-dismissible fade show" role="alert" id="dismiss_alerts">
                        <strong>Failed!</strong> failed to process request, try again.
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control"  autocomplete="false">
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif

                    </div>
                    <input type="hidden" name="user_type" id="user_type" value="">
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" autocomplete="false">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="cpassword" id="cpassword" class="form-control"  autocomplete="false">
                    </div>
                    <button type="submit" href="#" class="btn btn-link w-100">Create your Account</button>
                    {{ Form::close() }}
                    <div class="col-12 text-center my-3">
                        <div class="offset-lg-6 col-lg-6 col-md-12 d-flex or-log">
                            <p class="me-2">OR</p>
                            <p>LOG IN WITH</p>
                        </div>
                    </div>
                    <div class="text-center social-modal my-4">
                        <a href="{{route('facebook-signup')}}">
                        <button type="button" class="btn btn-link facebook-link btn-floating mx-3">
                            <i class="fab fa-facebook-f"></i>
                        </button>
                        </a>
                        <a href="{{route('google-signup')}}">
                        <button type="button" class="btn btn-link google-link btn-floating mx-3">
                            <i class="fab fa-google"></i>
                        </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
<div class="modal fade" id="forgotPassword" tabindex="-1" aria-labelledby="forgotPassword" aria-hidden="true">
    <div class="modal-dialog loginAccount modal-dialog-centered">
        <div class="modal-content">
            <h5>Forgot Password</h5>
            <hr>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="form">
                        <div style="display: none" class="alert alert-warning alert-dismissible fade show" role="alert" id="dismiss_alerts">
                            <strong>Failed!</strong> failed to process request, try again.
                        </div>
                        <div id="forgotAlerts" class="form-group">

                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="text" name="email" id="forgot_email" placeholder="Enter your email address." class="form-control" >
                        </div>
                        <button type="submit" onclick="forgotPassword(this)" class="btn btn-link w-100">Forgot</button>
                        <div class="col-12 text-center my-3">
                            <div class="offset-lg-6 col-lg-6 col-md-12 d-flex or-log"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<script type="text/javascript" src="{{asset('public/assets/frontend/js/bootstrap.bundle.min.js')}}"></script>

<script src="{{ asset('public/assets/frontend/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('public/assets/frontend/js/additional-methods.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).on('click', function () {
        $('#navbarText').collapse('hide');
    });
    $(document).on('click', function () {
        $('#navbarsExample07XL').collapse('hide');
    });
    function limitRangeFour(input) {
        var min = 0;
        var max = 4;

        if (input.value < min) {
            input.value = min;
        } else if (input.value > max) {
            input.value = max;
        }
    }
    function limitRangeEight(input) {
        var min = 0;
        var max = 8;

        if (input.value < min) {
            input.value = min;
        } else if (input.value > max) {
            input.value = max;
        }
    }
    // function limitRangeSix(input) {
    //     var min = 0;
    //     var max = 6;
    //     if (input.value < min) {
    //         input.value = min;
    //     } else if (input.value > max) {
    //         input.value = max;
    //     }
    // }


</script>
<script>


    $('.onlyNumbers').keyup(function(e)
    {
        if (/\D/g.test(this.value))
        {
            this.value = this.value.replace(/\D/g, '');
        }
    });

    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            placeholder: 'Select State',
            allowClear: true
        });
    });

    $("#resetPasswordNowU").submit(function(e){
        e.preventDefault()
        $(this).find('button').text('Please wait..')
        $.post('{{ route('resetPasswordNow') }}',{_token:'{{ csrf_token() }}',data:$("#resetPasswordNowU").serialize()},function(data){
            if(data['status']==true){
                $('#forgotAlertsReset').empty().append('<div class="alert alert-success" role="alert">'+data['message']+'</div>')
                $(this).find('button').text('Reset Now')
                $(this).find('input').val('')
                $('#resetPasswordNowU button').text('Reset Now');
                $('#resetPasswordNowU')[0].reset();
                setTimeout(function (){$('#resetPasswordNow').modal('hide');},5000)
            }else{
                $('#forgotAlertsReset').empty().append('<div class="alert alert-danger" role="alert">'+data['message']+'</div>')
                $(this).find('button').text('Reset Now')
                $('#resetPasswordNowU')[0].reset();
                $('#resetPasswordNowU button').text('Reset Now');
            }
        });
    });
    $(document).ready(function() {
        var vid = document.getElementById("htmlVideo");
        vid.autoplay = false;
        vid.load();
        $('#createVideo').on('hidden.bs.modal', function () {
            var video_screen = document.getElementById('htmlVideo');
            video_screen.pause();
            console.log($('video'));
        });
    });
    function forgotPassMOdal(){
        $('#createAccount').modal('hide')
        $('#onlyLogin').modal('hide')
        $('#forgotPassword').modal('show')
    }
    function createAccount(){
        $('#onlyLogin').modal('hide')
        $('#forgotPassword').modal('hide')
        $('#createAccount').modal('show')
    }
    function likeUnlike(elem,universityId){
        if($(elem).hasClass('far')==true){
            $(elem).removeClass('far').addClass('fas')
            $.post('{{ route('markFavourite') }}',{_token:'{{ csrf_token() }}',universityId:universityId,isFvt:1},function(data){
                $('#myFavourite').empty().html(data['view'])
                $('#totalCount').text(data['totalCount'])
            });
        }else{
            $(elem).removeClass('fas').addClass('far')
            $.post('{{ route('markFavourite') }}',{_token:'{{ csrf_token() }}',universityId:universityId,isFvt:0},function(data){
                $('#myFavourite').empty().html(data['view'])
                $('#totalCount').text(data['totalCount'])
            });
        }
    }

    $("#loginUser").validate({
        rules: {
            "email": {
                required: true,
            },"password": {
                required: true,
                minlength: 6
            }
        },
        messages: {
            "email": {
                required: "Please enter your email address.",
            },
            "password": {
                required: "Please enter password",
                password: "Password Must contain 6 characters.",
            }
        },
        submitHandler: function (form) {
            return true;
        }
    });
    $("#submitsignup").validate({
        rules: {
            "email": {
                required: true,
                email: true,
            },"password": {
                pattern: /^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])[a-zA-Z0-9!@#$%&*]+$/,
                required: true,
                minlength: 6
            },"cpassword": {
                required: true,
                equalTo : "#password",
                minlength: 6,
            }
        },
        messages: {
            "email": {
                required: "Please enter an email address.",
                email: "Please enter a valid email address.",
            },"agree_terms": {
                required: "please respond on terms and conditions",
            },"password": {
                required: "Please enter password",
                password: "Password Must contain 6 characters.",
                pattern:"6 characters atleast, uppercase, lowercase and a numeric digit"
            },
            "cemail": {
                required: "Please confirm email",
                equalTo: "Confirm Email should same as above"
            },
            "cpassword": {
                required: "Please enter password",
                confirm_password: "Password Must contain 6 characters.",
                equalTo: "Please enter the same password as above"
            }
        },
        errorPlacement: function(error, element) {
            // Custom error placement logic
            if (element.attr("name") === "email") {
                error.appendTo("#email-error"); // Display error message in the element with id "email-error"
            } else {
                error.insertAfter(element); // Default error placement for other fields
            }
        },
        submitHandler: function (form) {
            return true;
        }
    });

    $("#submitsignup").submit(function(e){
        e.preventDefault()
        if($("#submitsignup").valid()){
            $.post('{{ route('submitsignup') }}',{_token:'{{ csrf_token() }}',data:$("#submitsignup").serialize()},function(data){
                // alert(data['errors']);

                if(data['status']==false){
                    console.log(data);
                    alert(data['errors']);

                    // $('#dismiss_alerts').css('display','block')
                    // setTimeout(function (){
                    //     $('#dismiss_alerts').css('display','none')
                    // },5000)
                }else{
                    window.location.href = "{{ route('second_step') }}/"+data['user'];
                    console.log(data)
                }
            });
        }
    });

    $("#loginUser").submit(function(e){
        e.preventDefault()
        if($("#submitsignup").valid()){
            $.post('{{ route('loginUser') }}',{_token:'{{ csrf_token() }}',data:$("#loginUser").serialize()},function(data){

                if(data['status']==false){
                    $('#dismiss_alerts').css('display','block')
                    setTimeout(function (){
                        $('#dismiss_alerts').css('display','none')
                    },5000)
                }else{
                    window.location.href = "{{ route('dashboard') }}";
                }
            });
        }
    });

    $("#loginUserNext").submit(function(e){
        e.preventDefault()
        if($("#submitsignup").valid()){
            $.post('{{ route('loginUser') }}',{_token:'{{ csrf_token() }}',data:$("#loginUserNext").serialize()},function(data){
                if(data['status']==false){
                    $('.dismiss_alerts').css('display','block')
                    setTimeout(function (){
                        $('.dismiss_alerts').css('display','none')
                    },5000)
                }else{
                    window.location.href = "{{ route('dashboard') }}";
                }
            });
        }
    });

    $(window).scroll(function() {
        var scroll = $(window).scrollTop();
        if (scroll >= 100) {
            $(".fixed-top").addClass("sticky-header");
        } else {
            $(".fixed-top").removeClass("sticky-header");
        }
    });

    function setUserType(type){

        $('#user_type').val(type)
        $('#createAccount').modal('hide')
        $.post('{{ route('setUserType') }}',{_token:'{{ csrf_token() }}',type:type},function(data){ });
    }

    function forgotPassword(elem){

        if($('#forgot_email').val() ==''){
            $("#forgot_email").focus();
        }else{
            $(elem).text('Please wait..')
            $.post('{{ route('resetPassword') }}',{_token:'{{ csrf_token() }}',email:$('#forgot_email').val()},function(data){
                if(data['status']==true){
                    $('#forgotAlerts').empty().append('<div class="alert alert-success" role="alert">'+data['message']+'</div>')
                    $(elem).text('Forgot')
                }else{
                    $('#forgotAlerts').empty().append('<div class="alert alert-danger" role="alert">'+data['message']+'</div>')
                    $(elem).text('Forgot')
                }
            });
        }
    }
</script>
<script type="text/javascript">
        $('#homeSlider').owlCarousel({
            loop: false,
            screenLeft:true,
            margin: 10,
            dots: false,
            nav: true,
            dots: true,
            navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
            autoplay: false,
            autoplayTimeout: 40000,
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



    </script>

@include('flashy::message')
</body>
</html>
