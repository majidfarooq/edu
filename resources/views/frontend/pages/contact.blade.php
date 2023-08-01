@extends('frontend.layouts.app')
@section('style')
@endsection
@section('content')

<div class="container-fluid my-5">
    <div class="container">
    <div class="row">
            <div class="col-md-10 mx-auto col-sm-12 contact-form card my-5 bg-white shadow p-4">

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
                <br>
                    {!! Form::open(array('route' => 'contactForm','id' => 'contact-form','class'=>'','files' => true)) !!}
                    <!--Grid row-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="md-form mb-4">
                                <label for="name" class="">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="md-form mb-4">
                                <label for="email" class="">Email</label>
                                <input type="text" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="md-form mb-4">
                                <label for="Phone" class="">Phone (optional)</label>
                                <input type="text" class="form-control" id="Phone" name="phone">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="md-form mb-4">
                                <label for="Subject" class="">Subject </label>
                                <input type="text" class="form-control" id="Subject" name="subject" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="md-form mb-4">
                                <label for="message">Message</label>
                                <textarea type="text" class="form-control" rows="4" id="message" name="message" required></textarea>
                            </div>
                        </div>
                    </div>
{{--                    <div class="row">--}}
{{--                        <div class="col-xs-12 col-sm-12 col-md-6">--}}
{{--                            <div class="form-group">--}}
{{--                                <strong>Recaptcha:</strong>--}}
{{--                                {!! NoCaptcha::renderJs() !!}--}}
{{--                                {!! NoCaptcha::display() !!}--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')

@endsection
