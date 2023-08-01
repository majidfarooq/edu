@if(\Illuminate\Support\Facades\Route::currentRouteName()=='home' || !isset(\Illuminate\Support\Facades\Auth::user()->id))
<nav class="navbar navbar-expand-lg fixed-top navbar-light main-nav @if(\Illuminate\Support\Facades\Route::currentRouteName() !=='home' && !isset(\Illuminate\Support\Facades\Auth::user()->id)) while-singup @endif ">
                <a class="navbar-brand" href="{{ \Illuminate\Support\Facades\URL::to("/") }}"><img src="{{asset('public/assets/frontend/images/logo-black-green.png')}}" alt="logo"> </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                    <div class="d-flex align-items-center ms-auto">
                        <!-- Left links -->
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 header-nav">
                            @if(isset($header))
                                @foreach($header as $menu)
                                    @isset($menu->MenuItem)
                                        @foreach($menu->MenuItem as $item)
                                            @if($item->page_type == 'cms')
                                                <li class="nav-item">
                                                    <a class="nav-link px-lg-3 py-3 py-lg-2 navigation_{{$item->id}}"
                                                       href="{{route('page.show',$item->slug)}}"
                                                       target="_self">{{$item->title}}</a>
                                                </li>
                                            @elseif($item->page_type == 'static')
                                                <li class="nav-item static">
                                                    <a class="nav-link px-lg-3 py-3 py-lg-4"
                                                       href="{{ \Illuminate\Support\Facades\URL::to("/").$item->url}}"
                                                       target="_self">{{$item->title}}</a>
                                                </li>
                                            @elseif($item->page_type == 'external')
                                                <li class="nav-item external">
                                                    <a class="nav-link px-lg-3 py-3 py-lg-4" href="{{$item['url']}}"
                                                       target="_blank">{{$item->title}}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    @endisset
                                @endforeach
                            @endif
                        </ul>
                        @if(!isset(\Illuminate\Support\Facades\Auth::user()->id))
                        <!-- Left links -->
                        <button type="button" class="btn btn-link px-3 me-3" data-bs-toggle="modal" data-bs-target="#onlyLogin">
                            Log In
                        </button>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createAccount">
                            Create an Account
                        </button>
                        <button type="button" class="btn btn-green" data-bs-toggle="modal" data-bs-target="#onlyLogin">
                            <img src="{{asset('public/assets/frontend/images/burger-menu.png')}}" alt="logo">
                        </button>
                        @else
                            <div class="nav-item dropdown user-drop">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if(\Illuminate\Support\Facades\Auth::user() && !empty(\Illuminate\Support\Facades\Auth::user()->image))
                                        <img class="dropdown-toggle-img" src="{{ asset("public".\Illuminate\Support\Facades\Storage::url(\Illuminate\Support\Facades\Auth::user()->image)) }}" alt="amherst">
                                    @else
                                        <img class="dropdown-toggle-img" src="{{asset('public/assets/frontend/images/amherst.png')}}" alt="amherst">
                                    @endif
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end header_profile_menu" aria-labelledby="navbarDropdownMenu">
                                    @if(\Illuminate\Support\Facades\Auth::user() && !empty(\Illuminate\Support\Facades\Auth::user()->type=='university'))
                                        <li><a class="dropdown-item" href="{{ route('courses-listing') }}">Programs Listing</a></li>
                                    @endif
                                        <li class="nav-item">
                                            <a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="dropdown-item" href="{{ route('StudentProfile') }}">Profile</a>
                                        </li>
                                        <li><a class="dropdown-item" href="{{ route('logout') }}">Log out</a></li>
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
</nav>
@else

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top inner-navbar main-nav while-singup" aria-label="Ninth navbar example">
        <a class="navbar-brand" href="{{ \Illuminate\Support\Facades\URL::to("/") }}"><img src="{{asset('public/assets/frontend/images/logo-black-green.png')}}" alt="logo"> </a>
    @if(\Illuminate\Support\Facades\Auth::user() && !empty(\Illuminate\Support\Facades\Auth::user()->type=='student'))
        <div class="nav-item dropdown heart-drop mobile-show">
            <a class="nav-link dropdown-toggle position-relative" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="dropdown-toggle-img" src="{{asset('public/assets/frontend/images/heart.png')}}" alt="dropdown image" data-toggle="dropdown">
                <span class="position-absolute start-0 translate-middle badge rounded-pill bg-danger" id="totalCount">
                                   @if(isset($favourites)) {{$favourites->count()}} @else 0 @endif
                                </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end favourites_list_header" aria-labelledby="navbarDropdownMenuLink">
                <div class="d-flex justify-content-between stepCreate">
                    <h5>My Favorites</h5>
                </div>

                <div id="myFavourite">
                    @if(isset($favourites))
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
                                        <p class="Auburn">@if(isset($uni->university->first_name)) {{ $uni->university->first_name.' '.$uni->university->last_name }} @endif</p>
                                        <p>@if(isset($uni->university->address1)){{ $uni->university->address1 }}@endif</p>
                                    </div>
                                    <div class="p-1 bd-highlight d-flex">
                                        @php if(isset($uni->university->id)){ $encrypted=\App\Http\Controllers\frontend\HomeController::makeEncryption($uni->university->id); } @endphp
                                        @if(isset($encrypted))
                                            @if(!isset($uni->application->id))
                                                <a href="{{ route('universityDetail',$encrypted) }}" class="btn btn-link">Apply</a>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </ul>
        </div>
    @endif
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample07XL" aria-controls="navbarsExample07XL" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample07XL">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @if(\Illuminate\Support\Facades\Auth::user() && !empty(\Illuminate\Support\Facades\Auth::user()->type=='student'))
                @if(isset($header))
                    @foreach($header as $menu)
                        @isset($menu->MenuItem)
                            @foreach($menu->MenuItem as $item)
                                @if($item->page_type == 'cms')
                                    <li class="nav-item">
                                        <a class="nav-link px-lg-3 py-3 py-lg-2 navigation_{{$item->id}}"
                                           href="{{route('page.show',$item->slug)}}"
                                           target="_self">{{$item->title}}</a>
                                    </li>
                                @elseif($item->page_type == 'static')
                                    <li class="nav-item static">
                                        <a class="nav-link px-lg-3 py-3 py-lg-4"
                                           href="{{ \Illuminate\Support\Facades\URL::to("/").$item->url}}"
                                           target="_self">{{$item->title}}</a>
                                    </li>
                                @elseif($item->page_type == 'external')
                                    <li class="nav-item external">
                                        <a class="nav-link px-lg-3 py-3 py-lg-4" href="{{$item['url']}}"
                                           target="_blank">{{$item->title}}</a>
                                    </li>
                                @endif
                            @endforeach
                        @endisset
                    @endforeach
                @endif
                @endif
            </ul>

            <form class="header-form">
                <div class="d-flex align-items-center">
                    @if(\Illuminate\Support\Facades\Auth::user() && !empty(\Illuminate\Support\Facades\Auth::user()->type=='student'))
                    <div class="nav-item dropdown heart-drop">
                        <a class="nav-link dropdown-toggle position-relative" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img class="dropdown-toggle-img" src="{{asset('public/assets/frontend/images/heart.png')}}" alt="dropdown image" data-toggle="dropdown">
                            <span class="position-absolute start-0 translate-middle badge rounded-pill bg-danger" id="totalCount">
                               @if(isset($favourites)) {{$favourites->count()}} @else 0 @endif
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                            <div class="d-flex justify-content-between stepCreate">
                                <h5>My Favorites</h5>
                            </div>

                            <div id="myFavourite">
                                @if(isset($favourites))
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
                                                    <p class="Auburn">@if(isset($uni->university->first_name)) {{ $uni->university->first_name.' '.$uni->university->last_name }} @endif</p>
                                                    <p>@if(isset($uni->university->address1)){{ $uni->university->address1 }}@endif</p>
                                                </div>
                                                <div class="p-1 bd-highlight d-flex">
                                                    @php if(isset($uni->university->id)){ $encrypted=\App\Http\Controllers\frontend\HomeController::makeEncryption($uni->university->id); } @endphp
                                                    @if(isset($encrypted))
                                                        @if(!isset($uni->application->id))
                                                        <a href="{{ route('universityDetail',$encrypted) }}" class="btn btn-link">Apply</a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </ul>
                    </div>
                    @endif
                    <div class="nav-item dropdown user-drop">
                        @if(isset(\Illuminate\Support\Facades\Auth::user()->id))
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if(\Illuminate\Support\Facades\Auth::user() && !empty(\Illuminate\Support\Facades\Auth::user()->image))
                                <img class="dropdown-toggle-img" src="{{ asset("public".\Illuminate\Support\Facades\Storage::url(\Illuminate\Support\Facades\Auth::user()->image)) }}" alt="amherst">
                            @else
                                <img class="dropdown-toggle-img" src="{{asset('public/assets/frontend/images/amherst.png')}}" alt="amherst">
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end header_profile_menu" aria-labelledby="navbarDropdownMenu">
                            @if(\Illuminate\Support\Facades\Auth::user() && !empty(\Illuminate\Support\Facades\Auth::user()->type=='university'))
                            <li><a class="dropdown-item" href="{{ route('courses-listing') }}">Programs Listing</a></li>
                            @endif
                                <li class="nav-item">
                                    <a class="dropdown-item" aria-current="page" href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-item" href="{{ route('StudentProfile') }}">Edit Profile</a>
                                </li>
                                @if(\Illuminate\Support\Facades\Auth::user() && !empty(\Illuminate\Support\Facades\Auth::user()->type=='university'))
                                <li class="nav-item">
                                    @php if(isset(Auth::user()->id)){ $encrypted=\App\Http\Controllers\frontend\HomeController::makeEncryption(Auth::user()->id); } @endphp
                                    <a class="dropdown-item" href="{{ route('universityDetail',$encrypted) }}">View Profile</a>
                                </li>
                                @endif
                                <li>
                                <a class="dropdown-item" href="{{ route('logout') }}">Log out</a>
                                </li>
                        </ul>
                            @endif
                    </div>
                </div>
            </form>
        </div>
</nav>
@endif
