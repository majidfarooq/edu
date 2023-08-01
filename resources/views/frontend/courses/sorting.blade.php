@if($result)
    @foreach($result as $course)
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card-body bg-white shadow mb-3">
                <div class="p-1 col-lg-12 col-md-12 col-sm-12 bd-highlight">
                    <div class="user-text">
                        <p>{{$course->degree_program}}</p>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 user-title-section">
                    <div class="bd-highlight program-typflex">
                        <div class="city-state p-2">
                            <p class="strong">Program Type:</p>
                            <p>{{$course->programes->title}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
