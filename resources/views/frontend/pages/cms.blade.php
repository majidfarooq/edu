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

  <div id="@if ($page->page_type == 'fullpage'){{'fullpage'}}@endif">
    <!-- Page Header-->
    <header class="masthead @if ($page->page_type == 'fullpage'){{'section'}}@endif" style="background-image: url('{{ isset($page['banner']) ? asset($page['banner']) : '' }}')">
      <div class="container position-relative px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
          <div class="col-md-10 col-lg-8 col-xl-7">
            <div
              class="site-heading text-uppercase">{!! isset($page['banner_content']) ? $page['banner_content'] : '' !!}</div>
          </div>
        </div>
      </div>
    </header>

      @if($page->slug !=="about-us")
          <div class=" container p-5 first-container mb-5 home-none">
              <div class="row">

                  <div class="search informational-search-section col-12 mt-4">
                      {!! Form::open(array('route' => 'searchInform','id' => 'searchInform','class'=>'','files' => true)) !!}
                      <input type="hidden" name="page_id" id="page_id" value="{{isset($page['id'])}}">
                      <div class="d-flex bg-white shadow justify-content-between">
                          <div class="search-1 d-flex align-items-center">
                              <input type="text" name="title" class="form-control" autocomplete="off" placeholder="Search College">
                          </div>
                          <div class="search-display d-flex justify-content-end">
                              <div class="search-zip same-seacrh">
                                  <div class="form-group">
                                      <label class="form-label">Zip Code</label>
                                      <input type="text" maxlength="5" name="zipcode" class="form-control onlyNumbers" autocomplete="off">
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
                                          <input type="text" name="from_fee" placeholder="$000,000" class="form-control start_time" autocomplete="off">
                                          <p>To</p>
                                          <input type="text" name="to_fee" placeholder="$000,000" class="form-control start_end" autocomplete="off">
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
              </div>
          </div>
          @endif
    @if (isset($page))
      @foreach ($page->pageSections as $pg)
        <div class="@if ($page->page_type == 'fullpage'){{'section'}}@endif {{ ($pg->container_type) ? $pg->container_type : '' }} {{ ($pg->e_class) ? $pg->e_class : '' }} mb-5" id="{{ ($pg->e_id) ? $pg->e_id : '' }}">
          <div class='row mx-0 ghalib'>

          @if($page->slug =='find-college')
                  @if(!empty($universitiesList))
                      @forelse ($universitiesList as $university)
                          <div class="col-lg-3 col-m-6 col-sm-12">
                              <div class="card bg-white shadow mb-4 p-1">
                                  <div class="d-flex flex-row-reverse bd-highlight p-2">
                                      <div class="bg-white heartfont shadow p-2">
                                          @if(isset(\Illuminate\Support\Facades\Auth::user()->id))
                                              <i class="fa-heart js-heart heart @if(isset($university->favouriteGet->id)) fas @else far @endif" onclick="likeUnlike(this,{{$university->id}})"></i>
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
                                      <h6 class="mb-0">{{ $university->first_name.' '.$university->last_name  }}</h6>
                                      <a href="{{ route('universityDetail',$encrypted) }}" class="btn btn-link">Show Details</a>
                                  </div>
                              </div>
                          </div>
                      @empty
                          <h5>No Records found:</h5>
                      @endforelse
                  @endif
          @else
          @foreach ($pg->section->PageSubSections as $ss)
              <div class='col-lg-{{$ss->row_width}} parent-col'>
                @isset($pg->subsection)
                  @foreach ($pg->subsection as $subsection)
                    @if ($subsection->sub_section_id == $ss->id)
                        @foreach ($subsection->section->PageSubSections as $pss)
                          <div class='col-lg-{{$pss->row_width}}'>
                            @isset($subsection->PageElements)
                              <?php
                              $pageContent = '';
                              foreach ($subsection->PageElements as $pSubE) {
                              if ($pss->id == $pSubE->sub_section_id && $pSubE['element']['type'] != 'daughter') {
                              ?>
                              @include('frontend.pages.element',['pageElement'=>$pSubE])
                              <?php }} ?>
                              @isset($pContent)
                                {!! isset($pContent) ? $pContent : '' !!}
                              @endisset
                            @endisset
                          </div>
                        @endforeach
                    @endif
                  @endforeach
                @endisset
                @isset($pg->PageElements)
                  <?php
                  $pageContent = '';
                  foreach ($pg->PageElements as $pgE) {
                  if ($pgE->sub_section_id == $ss->id && $pgE['element']['type'] != 'daughter') { ?>
                  @include('frontend.pages.element',['pageElement'=>$pgE])
                  <?php }} ?>
                  @isset($pageContent)
                    {!! isset($pageContent) ? $pageContent : '' !!}
                  @endisset
                @endisset
              </div>
            @endforeach
          @endif
          </div>
        </div>
      @endforeach
    @endisset
  </div>
 @if(isset($university_list) && $page['is_home'] == 1) {!! $university_list !!} @endif
@endsection
@section('script')
  <script type="text/javascript" src="{{ asset('public/assets/frontend/js/fullpage.js') }}"></script>
  <script type="text/javascript">
      var myFullpage = new fullpage('#fullpage', {
          // sectionsColor: ['#d72e2d', '#d72e2d', '#d72e2d', '#d72e2d', '#d72e2d'],
          // anchors: ['homesection', 'the-GKE', 'services', 'product-press-release', 'ways-to-work', 'contact'],
          navigation: true,
          navigationPosition: 'right',
          showActiveTooltip: true,
          menu: '#menu',
          // licenseKey: 'OPEN-SOURCE-GPLV3-LICENSE',
          licenseKey: 'YWx2YXJvdHJpZ28uY29tXzlNZGNHRnlZV3hzWVhnPTFyRQ==',
          responsiveWidth: 991,
          afterResponsive: function (isResponsive) {

          }
      });
  </script>
  @include('flashy::message')
  <script type="text/javascript">
    {{(isset($page['page_script']) ? $page['page_script'] : '')}}
    $('.carousel').each(function () {
        $(this).find('.carousel-item:eq(0)').addClass('active');
    });
  </script>
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
      // $( function() {
      //     $( "#accordion" ).accordion({
      //         collapsible: true,
      //         heightStyle: "content",
      //     });
      // } );
      $(function () {
          var icons = {
              header: "fas fa-arrow-right",
              activeHeader: "fas fa-arrow-down"
          };
          $("#accordion").accordion({
              collapsible: true,
              icons: icons
          });
          $("#toggle").button().on("click", function () {
              if ($("#accordion").accordion("option", "icons")) {
                  $("#accordion").accordion("option", "icons", null);
              } else {
                  $("#accordion").accordion("option", "icons", icons);
              }
          });
      });
  </script>
@endsection
