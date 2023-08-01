<div class="container-fluid begin-section mb-5" id="">
    <div class="row mx-0 ">
        <div class="col-lg-12 parent-col">
            <div class="col-lg-12">
                <div id="" class="heading-area">
                    <h1><a target="_blank" href="https://cloud.ferozitech.com/edu/find-college">Begin</a> </h1>
                    @if($universities)
                        <div class="owl-carousel owl-theme servicesSlider" id="homeSlider">
                            @foreach($universities as $university)
                            <div class="item">
                                <div class="card carosel-slider bg-white shadow mb-4 p-1">
                                    <div class="d-flex justify-content-between p-2 applictions featured-bg">
                                        <div class="bg-white shadow applicationProgress d-flex align-items-center p-2">
                                            <p>Featured College</p>
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
                                        <h6 class="mb-0">{{ $university->first_name.' '.$university->last_name  }}</h6>
                                        <a href="https://cloud.ferozitech.com/edu/university/detail/{{$encrypted}}" class="btn btn-link">Show Details</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <h5>No Records found:</h5>
                    @endif
                </div>
        </div>
    </div>
</div>
</div>
