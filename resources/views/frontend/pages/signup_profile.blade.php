@extends('frontend.layouts.app')
@section('style')
@endsection
@section('content')
    @if(isset($user) && $user->type=='university')
    <section class="h-100 gradient-form">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-xl-10">
                        <div class="card rounded-3 text-black">
                            <div class="wrap d-md-flex">
                                <div class="img">
                                    <img class="w-100" src="{{ asset('public/assets/frontend/images/university.png') }}" alt="create">
                                </div>
                                <div class="login-wrap university-login-wrap">
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
                                    <div class="d-flex justify-content-between stepCreate">
                                        <h5>Create University Profile</h5>
                                        <p class="step1">Step-1</p>
                                    </div>
                                    {!! Form::open(array('route' => 'submitSecond','id' => 'applicationInformation','class'=>'','files' => true)) !!}
                                    @if($userId) <input type="hidden" name="user_id" value="{{$userId}}"> @endif
                                    <div class="form">
                                        <div class="form-group">
                                            <div class="file-upload">
                                                <div class="image-upload-wrap">
                                                    <input class="file-upload-input" onclick="removeUpload()" id="profile-photo" name="image" type='file' required onchange="readURL(this);" accept="image/*" />
                                                    <div class="drag-text">
                                                        <img src="{{ asset('public/assets/frontend/images/uploud-your-photo.png') }}" alt="">
                                                        <span class="text-white">Uploaded Image</span>

                                                    </div>
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
                                        <div class="form-group col-lg-12 col-md-12">
                                            <label class="form-label">University / College Name</label>
                                            <input type="text" name="first_name" class="form-control" required>
                                        </div>
                                        <div class="form-group col-lg-12 col-md-12">
                                            <label class="form-label">University Contact Person Email</label>
                                            <input type="email" name="uni_email" class="form-control" required>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-6 col-md-12">
                                                <label class="form-label">University phone number</label>
                                                <div class="col-auto form-input-col flag-input">
                                                    <input type="hidden" name="csrfmiddlewaretoken" value="JKdw9iIYBmZFvVdLFHssPLJuzmsm0UIxhtaWCLCtQgxn59h3vLpXMmUz5rQoJX5o">
                                                    <input type="tel" name="phone" maxlength="12"  title="Please use only numbers with no special characters" required placeholder="###-###-####" id="mobile-phone-number" class="form-control acct-mobile-number">
                                                </div>

                                            </div>

                                            <div class="form-group col-lg-6 col-md-12">
                                                <label class="form-label">University Fax number</label>
                                                <div class="col-auto form-input-col flag-input">
                                                    <input type="hidden" name="csrfmiddlewaretoken" value="JKdw9iIYBmZFvVdLFHssPLJuzmsm0UIxhtaWCLCtQgxn59h3vLpXMmUz5rQoJX5o">
                                                    <input type="tel" name="fax" maxlength="12" title="Please use only numbers with no special characters" placeholder="###-###-####" id="mobile-fax-number" class="form-control acct-mobile-number">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-12 col-md-12">
                                                <label class="form-label">Address</label>
                                                <input type="text" name="address1" id="address-input" class="form-control map-input" required>
                                                <input type="hidden" name="latitude" id="address-latitude" value="0" />
                                                <input type="hidden" name="longitude" id="address-longitude" value="0" />
                                                <div id="address-map-container" >
                                                    <div id="address-map"></div>
                                                </div>
                                            </div>

                                            <input type="hidden" name="city" id="google_city" class="form-control" required>
                                            <input type="hidden" name="state" id="google_state" class="form-control" required>
                                            <input type="hidden" name="zipcode" id="google_zipcode" class="form-control" required>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-12 col-md-12">
                                                <label class="form-label">University Website</label>
                                                <input type="text" name="website" id="" placeholder="website"  class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-12 col-md-12">
                                                <label class="form-label">Country</label>
                                                <select class="form-select form-control" name="country" aria-label="Default select example" required>
                                                    <option selected>Select</option>
                                                    <option value="United States">United States</option>
                                                    <option value="Canada">Canada</option>
                                                    <option value="United Kingdom">United Kingdom</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-12 col-md-12">
                                            <label class="form-label">Other information </label>
                                            <textarea name="other_info" class="form-control" rows="4"></textarea>
                                        </div>
                                        <div class="col-12 text-end next-start">
                                            <button type="submit" class="btn btn-primary">Next</button>
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
    @else
    <section class="h-100 gradient-form" style="background-color: hsl(0deg 0% 0% / 53%);">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-xl-10">
                        <div class="card rounded-3 text-black">
                            <div class="wrap d-md-flex">
                                <div class="img">
                                    <img class="w-100" src="{{asset('public/assets/frontend/images/creat-profile.png')}}" alt="create">
                                </div>
                                <div class="login-wrap">
                                    <div class="d-flex justify-content-between stepCreate">
                                        <h5>Create Account</h5>
                                        <p class="step1">Step-1</p>
                                    </div>
                                    {!! Form::open(array('route' => 'submitSecond','id' => 'applicationInformation','class'=>'','files' => true)) !!}
                                    <div class="form">
                                        @if($userId)
                                            <input type="hidden" name="user_id" value="{{$userId}}">
                                        @endif
                                        <div class="form-group">
                                            <div class="file-upload">
                                                <div class="image-upload-wrap">
                                                    <input class="file-upload-input" id="profile-photo" onclick="removeUpload()" name="image" type='file' onchange="readURL(this);" accept="image/*" />
                                                    <div class="drag-text">
                                                        <img src="{{asset('public/assets/frontend/images/uploud-your-photo.png')}}" alt="">
                                                        <span class="text-white">Uploaded Image</span>
                                                    </div>
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
                                            <div class="form-group col-lg-6 col-md-12">
                                                <label class="form-label">First / Given Name</label>
                                                <input type="text" name="first_name" class="form-control" required>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-12">
                                                <label class="form-label">Last / Surname </label>
                                                <input type="text" name="last_name" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-12 col-md-12">
                                                <label class="form-label">Phone</label>
                                                <div class="col-auto form-input-col flag-input">
                                                    <input type="tel" name="phone" maxlength="12" title="Please use only numbers with no special characters" placeholder="###-###-####" id="mobile-number" class="form-control acct-mobile-number" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-6 col-md-12">
                                                <label class="form-label">Gender</label>
                                                <select class="form-control" name="gender" required>
                                                    <option value="">Select</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                    <option value="x">X</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-12">
                                                <label class="form-label">Date of Birth</label>
                                                <input max="2050-12-31" pattern="[0-9]{4}[0-1][0-9][0-3][0-9}" id="dt" type="date" name="dob" class="form-control min-today" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-12 col-md-12">
                                                <label class="form-label">Ethnicity</label>
                                                <select class="form-control" name="ethnicity" required>
                                                    <option value="">Select</option>
                                                    <option value="American Indian or Alaska Native">American Indian or Alaska Native</option>
                                                    <option value="Black or African American">Black or African American</option>
                                                    <option value="Asian">Asian</option>
                                                    <option value="Hispanic or Latino">Hispanic or Latino</option>
                                                    <option value="Native Hawaiian or Other Pacific Islander">Native Hawaiian or Other Pacific Islander</option>
                                                    <option value="White">White</option>
                                                    <option value="Prefer Not to Answer">Prefer Not to Answer</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 text-end next-start">
                                            <button type="submit" class="btn btn-primary">Next</button>
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
    @endif
@endsection
@section('script')
    <script src="{{ asset('public/assets/frontend/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('public/assets/frontend/js/additional-methods.min.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAG6eAdW_1mCTdPUJSGVLrFB_UPMj0Y4Yg&libraries=places&callback=initialize" async defer></script>
    <script>
        var date = new Date();
        $(function() {
            $( ".datepicker" ).datepicker({
                dateFormat: "yy-mm-dd",
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
    </script>
    <script>
        // document.getElementById('dt').max = new Date(new Date().getTime() - new Date().getTimezoneOffset() * 60000).toISOString().split("T")[0];

        function initialize() {
            $('#address-input').on('keyup keypress', function(e) {
                var keyCode = e.keyCode || e.which;
                if (keyCode === 13) {
                    e.preventDefault();
                    return false;
                }
            });
            $("#applicationInformation").validate({
                rules: {
                    "phone": {
                        required: true,
                        minlength: 10,
                        maxlength: 12,
                    },
                },
                messages: {
                    "phone": {
                        required: "Please enter your phone number",
                    },
                },
                submitHandler: function (form) {
                    return true;
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
                            const lat = results[0].geometry.location.lat();
                            const lng = results[0].geometry.location.lng();
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
            console.log('remove image called.')
            // $('.file-upload-input').replaceWith($('.file-upload-input').clone());
            $('.file-upload-content').hide();
            $('.file-upload-image').attr('src','');
            $('.image-upload-wrap').show();
            $('.file-upload-input').val('')

            // location.reload()
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

