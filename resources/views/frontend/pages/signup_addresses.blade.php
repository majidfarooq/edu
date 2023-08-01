@extends('frontend.layouts.app')
@section('style')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
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
                            <div class="login-wrap university-login-wrap university-login-section">
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
                                    <h5>Application Information</h5>
                                    <p class="step1">Step-3</p>
                                </div>
                                {!! Form::open(array('route' => 'submitThird','id' => 'applicationInformation','class'=>'','files' => true)) !!}
                                @if($userId) <input type="hidden" name="user_id" value="{{$userId}}"> @endif
                                <div class="form">
                                    <div class="row">
                                        <div class="form-group col-lg-12 col-md-12">
                                            <label class="form-label">Spring Application Deadline</label>
                                            <input max="2050-12-31" pattern="[0-9]{4}[0-1][0-9][0-3][0-9}" type="date" name="spring_dead_start" id="spring_dead_start" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-12 col-md-12">
                                            <label class="form-label">Fall Application Deadline</label>
                                            <input max="2050-12-31" pattern="[0-9]{4}[0-1][0-9][0-3][0-9}" type="date" name="fall_dead_start" id="fall_application_deadline" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between stepCreate">
                                        <h5 class="fw-bold">Full-Time</h5>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12">
                                        <label class="form-label">Annual Tuition</label>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-12">
                                                <input type="text" name="annual_in_state" placeholder="In-State" class="form-control onlyNumbersInput" required>
                                            </div>
                                            <div class="col-lg-6 col-md-12">
                                                <input type="text" name="annual_out_state" placeholder="Out-of-State" class="form-control onlyNumbersInput" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12">
                                        <label class="form-label">Room & Board</label>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-12">
                                                <input type="text" name="room_in_state" placeholder="In-State" class="form-control onlyNumbersInput" required>
                                            </div>
                                            <div class="col-lg-6 col-md-12">
                                                <input type="text" name="room_out_state" placeholder="Out-of-State" class="form-control onlyNumbersInput" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12">
                                        <label class="form-label">EDU Discount</label>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-12">
                                                <input type="text" name="dis_in_state" placeholder="In-State" class="form-control onlyNumbersInput" required>
                                            </div>
                                            <div class="col-lg-6 col-md-12">
                                                <input type="text" name="dis_out_state" placeholder="Out-of-State" class="form-control onlyNumbersInput" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12">
                                        <label class="form-label">Total Yearly</label>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-12">
                                                <input type="text" name="tyearly_in_state" placeholder="In-State" class="form-control onlyNumbersInput" required>
                                            </div>
                                            <div class="col-lg-6 col-md-12">
                                                <input type="text" name="tyearly_out_state" placeholder="Out-of-State" class="form-control onlyNumbersInput" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between stepCreate">
                                    <h5 class="fw-bold">Mandatory Fees</h5>
                                </div>
                                <div class="form">
                                    <div class="form-group col-lg-12 col-md-12">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <input type="text" name="manda_in_state" placeholder="In-State" class="form-control onlyNumbersInput" required>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <input type="text" name="manda_out_state" placeholder="Out-of-State" class="form-control onlyNumbersInput" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between stepCreate">
                                    <h5 class="fw-bold">Part-Time</h5>
                                </div>
                                <div class="form">
                                    <div class="form-group col-lg-12 col-md-12">
                                        <label class="form-label">Tuition - Per Credit</label>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <input type="text" name="pann_in_state" placeholder="In-State" class="form-control onlyNumbersInput" required>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <input type="text" name="pann_out_state" placeholder="Out-State" class="form-control onlyNumbersInput" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12">
                                        <label class="form-label">EDU Discount</label>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-12">
                                                <input type="text" name="pdis_in_state" placeholder="In-State" class="form-control onlyNumbersInput" required>
                                            </div>
                                            <div class="col-lg-6 col-md-12">
                                                <input type="text" name="pdis_out_state" placeholder="Out-of-State" class="form-control onlyNumbersInput" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12">
                                        <label class="form-label">Total Per Credit</label>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-12">
                                                <input type="text" name="pcredit_in_state" placeholder="In-State" class="form-control onlyNumbersInput" required>
                                            </div>
                                            <div class="col-lg-6 col-md-12">
                                                <input type="text" name="pcredit_out_state" placeholder="Out-of-State" class="form-control onlyNumbersInput" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12">
                                        <label class="form-label">Other information </label>
                                        <textarea name="scholarship_info" class="form-control" rows="4"></textarea>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12">
                                        <label class="form-label">Scholarship information (Optional)</label>
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
                            <div class="login-wrap login-wrap-second">
                                <div class="d-flex justify-content-between stepCreate">
                                    <h5>Create Account</h5>
                                    <p class="step1">Step-2</p>
                                </div>
                                {!! Form::open(array('route' => 'submitThird','id' => 'submitThird','class'=>'','files' => true)) !!}

                                <div class="form">
                                    @if($userId) <input type="hidden" name="user_id" value="{{$userId}}"> @endif
                                    <div class="row">
                                        <div class="form-group col-lg-12 col-md-12">
                                            <label class="form-label">Address</label>
                                            <input type="text" name="address1" id="address-input" class="form-control map-input">
                                            <input type="hidden" name="latitude" id="address-latitude" value="0" />
                                            <input type="hidden" name="longitude" id="address-longitude" value="0" />
                                            <div id="address-map-container" >
                                                <div id="address-map"></div>
                                            </div>
                                        </div>
                                    </div>
                                        <input type="hidden" name="city" id="google_city" class="form-control">
                                        <input type="hidden" name="state" id="google_state" class="form-control">
                                        <input type="hidden" name="zipcode" id="google_zipcode" class="form-control">
                                        <div class="row">
                                        <div class="form-group col-lg-12 col-md-12">
                                            <label class="form-label">Select Country</label>
                                            <select class="form-select form-control" name="country" aria-label="Default select example">
                                                <option selected>Select</option>
                                                <option value="United States">United States</option>
                                                <option value="Canada">Canada</option>
                                                <option value="United Kingdom">United Kingdom</option>
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

        // document.getElementById('spring_dead_start').max = new Date(new Date().getTime() - new Date().getTimezoneOffset() * 60000).toISOString().split("T")[0];
        // document.getElementById('fall_application_deadline').max = new Date(new Date().getTime() - new Date().getTimezoneOffset() * 60000).toISOString().split("T")[0];
        //
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
        $(document).ready(function () {
            $(".onlyNumbersInput").on('input', function (event) {
                var input = $(this);
                var value = input.val().replace(/[^0-9]/g, ''); // Remove non-numeric characters

                if (value.length > 6) {
                    value = value.slice(0, 6); // Keep only the first 6 digits
                }
                input.val('$' + value);
            });
        });

        $(document).ready(function(){
            $('#applicationInformation').submit(function(){
                if (!$(this).valid()) return false;
            });
        });
        $("#applicationInformation").validate({
            rules: {
                "spring_dead_start": {
                    required: true,
                },
                "annual_in_state": {
                    required: true,
                    dollarsscents: true
                },"annual_out_state": {
                    required: true,
                    dollarsscents: true
                },"manda_in_state": {
                    required: true,
                    dollarsscents: true
                },"manda_out_state": {
                    required: true,
                    dollarsscents: true
                },"room_in_state": {
                    required: true,
                    dollarsscents: true
                },"room_out_state": {
                    required: true,
                    dollarsscents: true
                },"dis_in_state": {
                    required: true,
                    dollarsscents: true
                },"dis_out_state": {
                    required: true,
                    dollarsscents: true
                },"tyearly_in_state": {
                    required: true,
                    dollarsscents: true
                },"tyearly_out_state": {
                    required: true,
                    dollarsscents: true
                },"pann_in_state": {
                    required: true,
                    dollarsscents: true
                },"pann_out_state": {
                    required: true,
                    dollarsscents: true
                },"pdis_in_state": {
                    required: true,
                    dollarsscents: true
                },"pdis_out_state": {
                    required: true,
                    dollarsscents: true
                },"pcredit_in_state": {
                    required: true,
                    dollarsscents: true
                },"pcredit_out_state": {
                    required: true,
                    dollarsscents: true
                }
            },
            messages: {
                "spring_dead_start": {
                    required: "please select the date.",
                },
                "annual_in_state": {
                    required: "this field is required.",
                    dollarsscents:"Only Integer value allowed. like 334.87"
                },
                "annual_out_state": {
                    required: "this field is required.",
                    dollarsscents:"Only Integer value allowed. like 334.87"
                },
                "manda_in_state": {
                    required: "this field is required.",
                    dollarsscents:"Only Integer value allowed. like 334.87"
                },
                "manda_out_state": {
                    required: "this field is required.",
                    dollarsscents:"Only Integer value allowed. like 334.87"
                },
                "room_in_state": {
                    required: "this field is required.",
                    dollarsscents:"Only Integer value allowed. like 334.87"
                },
                "room_out_state": {
                    required: "this field is required.",
                    dollarsscents:"Only Integer value allowed. like 334.87"
                },
                "dis_in_state": {
                    required: "this field is required.",
                    dollarsscents:"Only Integer value allowed. like 334.87"
                },
                "dis_out_state": {
                    required: "this field is required.",
                    dollarsscents:"Only Integer value allowed. like 334.87"
                },
                "tyearly_in_state": {
                    required: "this field is required.",
                    dollarsscents:"Only Integer value allowed. like 334.87"
                },
                "tyearly_out_state": {
                    required: "this field is required.",
                    dollarsscents:"Only Integer value allowed. like 334.87"
                },
                "pann_in_state": {
                    required: "this field is required.",
                    dollarsscents:"Only Integer value allowed. like 334.87"
                },
                "pann_out_state": {
                    required: "this field is required.",
                    dollarsscents:"Only Integer value allowed. like 334.87"
                },
                "pdis_in_state": {
                    required: "this field is required.",
                    dollarsscents:"Only Integer value allowed. like 334.87"
                },
                "pdis_out_state": {
                    required: "this field is required.",
                    dollarsscents:"Only Integer value allowed. like 334.87"
                },
                "pcredit_in_state": {
                    required: "this field is required.",
                    dollarsscents:"Only Integer value allowed. like 334.87"
                },
                "pcredit_out_state": {
                    required: "this field is required.",
                    dollarsscents:"Only Integer value allowed. like 334.87"
                }
            },
            submitHandler: function (form) {
                return true;
            }
        });

        var date = new Date();
        $(function() {
            $( ".datepicker" ).datepicker({
                dateFormat: "dd-M",
                changeMonth: true,
                minDate:  new Date(date.getFullYear(), 0,1),
                maxDate: new Date(date.getFullYear(), 12,31)
            });
        });
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
@endsection
