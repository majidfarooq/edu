@extends('frontend.layouts.app')
@section('style')
    <link rel="stylesheet" href="{{ asset('public/assets/frontend/owlcarousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/frontend/owlcarousel/assets/owl.theme.default.min.css') }}">
@endsection
@section('content')

    <header class="masthead " style="background-image: url('https://cloud.ferozitech.com/edu/public/storage/banner/banner_211.jpg')">
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
            <div class="search informational-search-section col-12 mt-4">
                {!! Form::open(array('route' => 'searchInform','id' => 'searchInform','class'=>'','files' => true)) !!}
                <div class="d-flex bg-white shadow justify-content-between">
                    <div class="search-1 d-flex align-items-center">
                        <input type="text" name="title" class="form-control" placeholder="Search College" value="{{ old('title') }}">
                    </div>
                    <div class="search-display d-flex justify-content-end">
                        <div class="search-zip same-seacrh">
                            <div class="form-group">
                                <label class="form-label">Zip Code</label>
                                <input type="text" maxlength="5" name="zipcode" value="{{ old('zipcode') }}"  class="form-control onlyNumbers" autocomplete="off">
                            </div>
                        </div>
                        <div class="search-state same-seacrh">
                            <div class="form-group">
                                <label class="form-label">State</label>
                                <select class="form-control js-example-basic-single" name="state">
                                    <option value="">Select</option>
                                    @if($states)
                                        @foreach($states as $state)
                                            <option value="{{$state->name}}">{{$state->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="search-tuition same-seacrh">
                            <div class="form-group">
                                <label class="form-label">Annual Tuition Fees:</label>
                                <div class="d-flex justify-content-start">
                                    <input type="text" name="from_fee" placeholder="$000,000" class="form-control start_time" value="{{ old('from_fee') }}" autocomplete="off">
                                    <p>To</p>
                                    <input type="text" name="to_fee" placeholder="$000,000" class="form-control start_end" value="{{ old('to_fee') }}" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="search-groupbtn same-seacrhbtn">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
            <div class="col-lg-12 parent-col">
                <div id="" class="">
                    <h1>Search Results:</h1>
                    <div class="row">
                        @if(!empty($universities))
                        @forelse ($universities as $university)
                            <div class="col-lg-3 col-m-6 col-sm-12">
                                <div class="card bg-white shadow mb-4 p-1">
                                    <div class="d-flex flex-row-reverse bd-highlight p-2">
                                        <div class="bg-white heartfont shadow p-2">
                                            @if(isset(\Illuminate\Support\Facades\Auth::user()->id))
                                                <i class="fa-heart js-heart heart @if(isset($university->favouriteGet->id) && !empty($university->favouriteGet->id)) fas @else far @endif" onclick="likeUnlike(this,{{$university->id}})"></i>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-img text-center">
                                        @if(!empty($university->image))
                                            <img class="card-img-top" src="{{ asset("public".\Illuminate\Support\Facades\Storage::url($university->image)) }}" alt="amherst">
                                        @else
                                            <img class="card-img-top" src="{{asset('public/assets/frontend/images/amherst.png')}}" alt="amherst">
                                        @endif
                                    </div>
                                    <div class="d-flex justify-content-between bottom-card p-2">
                                        @php  $encrypted=\App\Http\Controllers\frontend\HomeController::makeEncryption($university->id)  @endphp
                                        <h6 class="mb-0">{{ $university->fullname  }}</h6>
                                        <a href="{{ route('universityDetail',$encrypted) }}" class="btn btn-link">Show Details</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <h5>No Records found:</h5>
                        @endforelse
                        @endif
                    </div>
                </div>
        </div>
    </div>
    </div>


@endsection
<script type="text/javascript" src="{{ asset('public/assets/frontend/owlcarousel/owl.carousel.js') }}"></script>
@section('script')
    <script>
        jQuery(document).ready(function($) {
            var title = $('#MaxCharLimit');
            var titleMaxLength = 2;
            var charactersDisplay = $('#title-character-counter');

            charactersDisplay.text(titleMaxLength - title.val().length);

            title.on('keydown', function(e){
                var length = calculateLength(titleMaxLength, $(this));
                checkLength(length, e);
            });
            title.on('keyup', function(e){
                var length = calculateLength(titleMaxLength, $(this));
                charactersDisplay.text(length);
            });
            title.on('paste', function(e){
                var $self = $(this);
                setTimeout(function(){
                    var length = calculateLength(titleMaxLength, $self);
                    if (length < 0 ) {
                        var newString = truncateString($self, titleMaxLength);
                        $self.val(newString);
                    }
                },100);
            });

            function calculateLength(maxLength, elem) {
                return maxLength-elem.val().length;
            }
            function checkLength(length, e) {
                if(length <= 0) {
                    switch(e.which) {
                        case 8:
                        case 9:
                        case 37:
                        case 39:
                        case 46:
                            break;
                        default:
                            e.preventDefault();
                            break;
                    }
                }
            }
            function truncateString(elem, maxLength) {
                return elem.val().substring(0, maxLength);
            }
        });
        function changeApplicationStatus(appId,status){
            var dataPost={}
            dataPost['application_id']=appId
            dataPost['status']=status
            $.post('{{ route('changeApplicationStatus') }}',{_token:'{{ csrf_token() }}',data:dataPost},function(data){ location.reload() });
        }
        $('#recentlyViewd').owlCarousel({
            loop: true,
            screenLeft:true,
            margin: 20,
            dots: false,
            nav: true,
            navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
            autoplay: true,
            autoplayTimeout: 2000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 3
                }
            }

        });
        function goToURL(elem){
            if($(elem).is(":checked")){
                window.location='{{ route('dashboard',['nearest']) }}'
            }else{
                window.location='{{ route('dashboard') }}'
            }
        }
    </script>
    <style>
        header.masthead {
            height: 40vh;
        }
    </style>
@endsection
