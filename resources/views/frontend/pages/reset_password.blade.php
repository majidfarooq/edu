@extends('frontend.layouts.app')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/frontend/css/fullpage.css') }}"/>
    <style rel="stylesheet">
        /*#mainNav, */
        /*header.masthead {*/
        /*    !*display: none;*!*/
        /*    height: 100vh;*/
        /*}*/
        header {
            height: 100vh;
        }
        header.masthead {
            height: 60vh;
        }

        header.section {
            position: unset !important;
            margin-bottom: 0 !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
        }

        .banner_text {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
            text-align: center;
        }

        .home-about .home-about-inner {
            display: grid;
            height: 100%;
            align-content: center;
        }

        .home-about .home-about-inner p {
            margin: 10px 0;
        }

        .feature-box h3 {
            gap: 5px;
            display: flex;
            font-size: 18px;
            color: #012970;
            font-weight: 700;
            margin: 0;
        }

        .feature-box {
            padding: 24px 20px;
            box-shadow: 0px 0 30px rgb(1 41 112 / 8%);
            transition: 0.3s;
            height: 100%;
            gap: 10px;
        }

        .feature-box i {
            line-height: 0;
            background: #ecf3ff;
            padding: 4px;
            margin-right: 10px;
            font-size: 24px;
            border-radius: 3px;
            transition: 0.3s;
        }

        .feature-box:hover i {
            background: #4154f1;
            color: #fff;
        }
        {{(isset($page['page_css']) ? $page['page_css'] : '')}}
    </style>
@endsection

@section('title'){{(isset($page['meta_title']) ? $page['meta_title'] : '')}}@endsection
@section('description'){{(isset($page['meta_description']) ? $page['meta_description'] : '')}}@endsection
@section('keywords'){{(isset($page['meta_keyword']) ? $page['meta_keyword'] : '')}}@endsection
@section('canonical'){{ Request::url() }}@endsection

@section('content')

<header class="masthead " style="background-image: url('https://cloud.ferozitech.com/edu/public/storage/banner/banner_641.png')">
    <div class="container position-relative px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <div class="site-heading text-uppercase"></div>
            </div>
        </div>
    </div>
</header>

<div class=" container p-5 first-container mb-5" id="">
    <div class="row mx-0 ghalib">
        <h1>Enter Your New Password.</h1>
        <div class="search informational-search-section col-8 mt-4 reset pass now">
            @if ($message = \Illuminate\Support\Facades\Session::get('error'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Failed!</strong> {{ $message }}
                </div>
            @elseif ($message = \Illuminate\Support\Facades\Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ $message }}
                </div>
            @endif
                {!! Form::open(array('route' => 'resetPasswordNow','id' => 'resetPasswordNow','class'=>'reset pass now')) !!}
                <div class="form-group">
                    @if(!empty($auth_code)) <input type="hidden" name="auth_code" value="{{$auth_code}}"> @endif
                    <label class="form-label">Enter New Password</label>
                    <input type="password" name="password" class="form-control" id="password" autocomplete="off">
                </div>
                <div class="form-group">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="cpassword" class="form-control" id="cpassword" autocomplete="off">
                </div>
                <div class="form-group">
                    <button class="btn btn-default" type="submit">Reset Now</button>
                </div>
                {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
@section('script')
    <script src="{{ asset('public/assets/frontend/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('public/assets/frontend/js/additional-methods.min.js') }}"></script>
    <script type="application/javascript">

        $("#resetPasswordNow").validate({
            rules: {
               "password": {
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
                "password": {
                    required: "Please enter password",
                    password: "Password Must contain 6 characters.",
                    pattern:"6 characters atleast, uppercase, lowercase and a numeric digit"
                },
                "cpassword": {
                    required: "Please enter password",
                    confirm_password: "Password Must contain 6 characters.",
                    equalTo: "Please enter the same password as above"
                }
            },
            submitHandler: function (form) {
                return true;
            }
        });
    </script>

@endsection
