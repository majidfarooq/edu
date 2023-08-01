@if($favourites)
    @foreach($favourites as $uni)
        <div class="card-body recently-slider bg-white shadow mb-3 mt-3">
            <div class="d-flex bd-highlight">
                <div class="p-1 bd-highlight favourites">
                    @if(!empty($uni->university->image))
                        <img class="card-img-top" src="{{ asset("public".\Illuminate\Support\Facades\Storage::url($uni->university->image)) }}" alt="amherst">
                    @else
                        <img class="card-img-top" src="{{asset('public/assets/frontend/images/amherst.png')}}" alt="amherst">
                    @endif
                </div>
                <div class="p-1 bd-highlight dropdown-text">
                    <p class="Auburn">@if(isset($uni->university->first_name)){{ $uni->university->first_name.' '.$uni->university->last_name }}@endif</p>
                    <p>@if(isset($uni->university->address1)){{ $uni->university->address1 }}@endif</p>
                </div>
                <div class="p-1 bd-highlight d-flex">
                    @php if(isset($uni->university->id)){ $encrypted=\App\Http\Controllers\frontend\HomeController::makeEncryption($uni->university->id); } @endphp
                    @if(isset($encrypted))
                        <a href="{{ route('universityDetail',$encrypted) }}" class="btn btn-link">Apply</a>
                    @else
                        <a href="#" class="btn btn-link">Apply</a>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
@endif
