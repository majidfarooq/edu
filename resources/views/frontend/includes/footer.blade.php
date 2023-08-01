<div class="container-fluid footer" id="footer">
    <div class="footer-overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-12 mx-auto text-center universitie-btn">
                <a target="_blank" href="{{ route('universityContact') }}" class="btn btn-white">Hey Universities, click here to recruit
                    with EDU Brokers </a>
            </div>
            <div class="col-12 text-center mb-5">
                <img src="{{asset('public/assets/frontend/images/footer-rect.png')}}" alt="logo">
            </div>
            <div class="col-lg-12 col-md-12 footer-logo mt-5 text-center">
                <img src="{{asset('public/assets/frontend/images/footer-logo.png')}}" alt="logo">
            </div>
            <div class="col-lg-6 mx-auto col-md-12 footer-links-use text-center">
                <ul>

                    <div class="col-lg-12 col-md-12 col-sm-12 footer-bottom">
                        @if(isset($footer))
                            @foreach($footer as $menu)
                                @isset($menu->MenuItem)
                                    @foreach($menu->MenuItem as $item)
                                        @if($item->page_type == 'cms')
                                            <li class="nav-item">
                                                <a class="nav-link nav-link"
                                                   href="{{route('page.show',$item->slug)}}"
                                                   target="_self">{{$item->title}}</a>
                                            </li>
                                        @elseif($item->page_type == 'static')
                                            <li class="nav-item static">
                                                <a class="nav-link"
                                                   href="{{ \Illuminate\Support\Facades\URL::to("/").$item->url}}"
                                                   target="_self">{{$item->title}}</a>
                                            </li>
                                        @elseif($item->page_type == 'external')
                                            <li class="nav-item external">
                                                <a class="nav-link" href="{{$item['url']}}"
                                                   target="_blank">{{$item->title}}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                @endisset
                            @endforeach
                        @endif

                    </div>
                </ul>
            </div>
            <div class="col-lg-12 col-md-12 footer-links my-4 text-center">
                <a href="https://www.facebook.com/Edu-Brokers-113170898057210/" target="_blank"><img src="{{asset('public/assets/frontend/images/facebook.png')}}" alt="facebook"></a>
                <a href="https://www.linkedin.com/company/edu-brokers/" target="_blank"><img src="{{asset('public/assets/frontend/images/linkdin.png')}}" alt="linkdin"></a>
                <a href="https://www.instagram.com/edu_brokers?igshid=MzRlODBiNWFlZA==" target="_blank"><img src="{{asset('public/assets/frontend/images/instagram.png')}}" alt="instagram"></a>
                <a href="https://twitter.com/edubrokers?s=21&t=lVgG_PwKhyJx8WPwcxm9eg" target="_blank"><img src="{{asset('public/assets/frontend/images/twitter.png')}}" alt="twitter"></a>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12 footer-links-usebottom my-4">
                    <p class="text-white">© All rights reserved Edu Brokers</p>
                </div>
                <div class="col-lg-6 col-md-12 footer-linksbottom text-end my-4">
                </div>
            </div>

        </div>
    </div>
</div>


<div class="container-fluid footer inner-footer" id="innerFooter">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 footer-logo mt-5 text-center">
                <img src="{{asset('public/assets/frontend/images/footer-logo.png')}}" alt="logo">
            </div>
            <div class="col-lg-6 mx-auto col-md-12 footer-links-use text-center">
                <ul>
                    <div class="col-lg-12 col-md-12 col-sm-12 footer-bottom">
                        @if(isset($footer))
                            @foreach($footer as $menu)
                                @isset($menu->MenuItem)
                                    @foreach($menu->MenuItem as $item)
                                        @if($item->page_type == 'cms')
                                            <li class="nav-item">
                                                <a class="nav-link nav-link"
                                                   href="{{route('page.show',$item->slug)}}"
                                                   target="_self">{{$item->title}}</a>
                                            </li>
                                        @elseif($item->page_type == 'static')
                                            <li class="nav-item static">
                                                <a class="nav-link"
                                                   href="{{ \Illuminate\Support\Facades\URL::to("/").$item->url}}"
                                                   target="_self">{{$item->title}}</a>
                                            </li>
                                        @elseif($item->page_type == 'external')
                                            <li class="nav-item external">
                                                <a class="nav-link" href="{{$item['url']}}"
                                                   target="_blank">{{$item->title}}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                @endisset
                            @endforeach
                        @endif
                    </div>
                </ul>
            </div>
            <div class="col-lg-12 col-md-12 footer-links my-4 text-center">
                <a href="https://www.facebook.com/Edu-Brokers-113170898057210/" target="_blank"><img src="{{asset('public/assets/frontend/images/facebook.png')}}" alt="facebook"></a>
                <a href="https://www.linkedin.com/company/edu-brokers/" target="_blank"><img src="{{asset('public/assets/frontend/images/linkdin.png')}}" alt="linkdin"></a>
                <a href="https://www.instagram.com/edu_brokers?igshid=MzRlODBiNWFlZA==" target="_blank"><img src="{{asset('public/assets/frontend/images/instagram.png')}}" alt="instagram"></a>
                <a href="https://twitter.com/edubrokers?s=21&t=lVgG_PwKhyJx8WPwcxm9eg" target="_blank"><img src="{{asset('public/assets/frontend/images/twitter.png')}}" alt="twitter"></a>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-12 footer-links-usebottom my-4">
                    <p class="text-white">© All rights reserved Edu Brokers</p>
                </div>
                <div class="col-lg-6 col-md-12 footer-linksbottom text-end my-4">
                </div>
            </div>

        </div>
    </div>
</div>


