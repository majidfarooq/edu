@extends('frontend.layouts.app')

@section('style')
  <style>
      .banner_text {
          position: absolute;
          top: 50%;
          transform: translateY(-50%);
          width: 100%;
          text-align: center;
      }
  </style>
@endsection

@section('title'){{(isset($page['meta_title']) ? $page['meta_title'] : '')}}@endsection
@section('description'){{(isset($page['meta_description']) ? $page['meta_description'] : '')}}@endsection
@section('keywords'){{(isset($page['meta_keyword']) ? $page['meta_keyword'] : '')}}@endsection
@section('canonical'){{ Request::url() }}@endsection

@section('content')

  <!-- Page Header-->
  <header class="masthead" style="background-image: url('{{ isset($page['banner']) ? asset($page['banner']) : '' }}')">
    <div class="container position-relative px-4 px-lg-5">
      <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-7">
          <div
            class="site-heading text-uppercase">{!! isset($page['banner_content']) ? $page['banner_content'] : '' !!}</div>
        </div>
      </div>
    </div>
  </header>

  @if (isset($page))
    @foreach ($page->pageSections as $pg)
      <div class="{{ ($pg->container_type) ? $pg->container_type : '' }} mb-4 {{ ($pg->e_class) ? $pg->e_class : '' }}" id="{{ ($pg->e_id) ? $pg->e_id : '' }}">
        <div class='row mx-0 '>
          @foreach ($pg->section->PageSubSections as $ss)
            <div class='col-md-{{$ss->row_width}} parent-col'>
              @isset($pg->subsection)
                @foreach ($pg->subsection as $subsection)
                  @if ($subsection->sub_section_id == $ss->id)
                    <div class="row mb-4">
                      @foreach ($subsection->section->PageSubSections as $pss)
                        <div class='col-md-{{$pss->row_width}}'>
                          @isset($subsection->PageElements)
                            <?php
//                            $pContent = '';
                            $pageContent = '';
                            foreach ($subsection->PageElements as $pSubE) {
                              if ($pss->id == $pSubE->sub_section_id && $pSubE['element']['type'] != 'daughter') {
                            ?>
                            @include('frontend.pages.element',['pageElement'=>$pSubE])
                            <?php
//                                $pTemplate = $pSubE['element']['template'];
//                                $pTemplate = str_replace('{{cstm_class}}', $pSubE->e_class, $pTemplate);
//                                $pTemplate = str_replace('{{cstm_id}}', $pSubE->e_id, $pTemplate);
//                                foreach ($pSubE['content'] as $content) {
//                                  $pTemplate = str_replace('{{' . $content['field']['slug'] . '}}', $content['content'], $pTemplate);
//                                }
//                                if ($pSubE->element->type == 'parent') {
//                                  $innerChildren = $pSubE->child_page_element(explode(',', $pSubE->children_ids));
//                                  $chldCont = '';
//                                  if ($innerChildren->isNotEmpty()) {
//                                    foreach ($innerChildren as $innerChild) {
//                                      $innerChildTemplate = $innerChild['element']['template'];
//                                      $innerChildTemplate = str_replace('{{cstm_class}}', $innerChild->e_class, $innerChildTemplate);
//                                      $innerChildTemplate = str_replace('{{cstm_id}}', $innerChild->e_id, $innerChildTemplate);
////                                      $innerChildTemplate = str_replace('collapse-', "collapse-$innerChild->id", $innerChildTemplate);
//                                      foreach ($innerChild['content'] as $innerChildContent) {
//                                        $innerChildTemplate = str_replace('{{' . $innerChildContent['field']['slug'] . '}}', $innerChildContent['content'], $innerChildTemplate);
//                                      }
//                                      $chldCont .= $innerChildTemplate;
//                                    }
//                                  }
//                                  $pTemplate = str_replace('{{section_loop}}', $chldCont, $pTemplate);
//                                }
//                                $pContent .= $pTemplate;
                              }
                            }
                            ?>
                            @isset($pContent)
                              {!! isset($pContent) ? $pContent : '' !!}
                            @endisset
                          @endisset
                        </div>
                      @endforeach
                    </div>
                  @endif
                @endforeach
              @endisset



  @isset($pg->PageElements)
    <?php
    $pageContent = '';
    foreach ($pg->PageElements as $pgE) {
      if ($pgE->sub_section_id == $ss->id && $pgE['element']['type'] != 'daughter') {
//        view("backend.pages.get_child_element", compact(['pageElement' => $pgE,$pageContent =>$pageContent]))->render();
//        $pageElement = $pgE;
//                  return view('frontend.pages.element', ['pageElement' => $pgE]);
    ?>
    @include('frontend.pages.element',['pageElement'=>$pgE])
    <?php

//        $template = $pgE['element']['template'];
//        $template = str_replace('{{cstm_class}}', $pgE->e_class, $template);
//        $template = str_replace('{{cstm_id}}', $pgE->e_id, $template);
//        foreach ($pgE['content'] as $content) {
//          $template = str_replace('{{' . $content['field']['slug'] . '}}', $content['content'], $template);
//        }
//        $children = $pgE->child_page_element(explode(',', $pgE->children_ids));
//        if ($pgE->element->type == 'parent') {
//          $chldCont = '';
//          if ($children->isNotEmpty()) {
//            foreach ($children as $child) {
//              $childTemplate = $child['element']['template'];
//              $childTemplate = str_replace('{{cstm_class}}', $child->e_class, $childTemplate);
//              $childTemplate = str_replace('{{cstm_id}}', $child->e_id, $childTemplate);
////                          $childTemplate = str_replace('collapse-', "collapse-$child->id", $childTemplate);
//              foreach ($child['content'] as $childContent) {
//                $childTemplate = str_replace('{{' . $childContent['field']['slug'] . '}}', $childContent['content'], $childTemplate);
//              }
//              $chldCont .= $childTemplate;
//            }
//          }
//          $template = str_replace('{{section_loop}}', $chldCont, $template);
//        }
//        $pageContent .= $template;
        // Add JSS and css
      }
      /*$pageContent = str_replace('src="/', 'src="' . asset(''), $pageContent);*/
    }
    ?>
    @isset($pageContent)
{{--      @dd($pageContent)--}}
      {!! isset($pageContent) ? $pageContent : '' !!}
    @endisset
  @endisset
</div>
@endforeach
</div>
</div>
@endforeach
@endisset

{{--    <h2>{{question}}</h2><p>{{answer}}</p>--}}
{{--    <div class="toggle"><h1>{{toggle_title}}</h1>{{loop}}</div>--}}
{{--    <div class="accordion accordion-flush" id="accordionFlushCollapse">--}}
{{--        <div class="accordion-item">--}}
{{--            <h2 class="accordion-header" id="heading-collapse-">--}}
{{--                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-" aria-expanded="false" aria-controls="flush-collapse-">--}}
{{--                    {{question}}--}}
{{--                </button>--}}
{{--            </h2>--}}
{{--            <div id="flush-collapse-" class="accordion-collapse collapse" aria-labelledby="heading-collapse-" data-bs-parent="#accordionFlushCollapse">--}}
{{--                <div class="accordion-body">{{answer}}</div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--<h2>{{question}}</h2>--}}
{{--<p>{{answer}}</p>--}}

{{--    @if (isset($data['posts']) && count($data['posts']) > 0)--}}
{{--        <div class="container mb-4">--}}
{{--            <div class="row">--}}
{{--                <div class="col-12">--}}
{{--                    <h2 class="my-4">Recent Posts</h2>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <article class="entry row">--}}
{{--                @foreach($data['posts'] as $post)--}}
{{--                    <div class="col-lg-4 post-box">--}}
{{--                        <div class="post-img">--}}
{{--                            <img class="img-fluid" src="{{ (isset($post->thumbnail) ? asset($post->thumbnail) : asset('/public/storage/placeholder.jpg')) }}"--}}
{{--                                 alt="{{(isset($post->title) ? Illuminate\Support\Str::limit($post->title, 150) : '')}}">--}}
{{--                        </div>--}}
{{--                        <a href="#">{{ (isset($post->admin->name) ? $post->admin->name : '') }}</a>--}}
{{--                        <span class="my-4 post-date">{{(isset($post->created_at) ? $post->created_at->format('M d Y') : '')}}</span>--}}
{{--                        <h3 class="post-title">{{(isset($post->title) ? Illuminate\Support\Str::limit($post->title, 150) : '')}}</h3>--}}
{{--                        <a href="{{route('blog.show', $post->slug)}}"><span>Read More</span><i class="bi bi-arrow-right"></i></a>--}}
{{--                    </div>--}}
{{--                @endforeach--}}
{{--            </article>--}}
{{--            <div class="row">--}}
{{--                <div class="col-12 text-center mt-5 mb-3">--}}
{{--                    <a href="{{route('blogs.index')}}">--}}
{{--                        <span>View All</span>--}}
{{--                        <i class="bi bi-arrow-right"></i>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endif--}}

@endsection

@section('script')

@include('flashy::message')

<script>
$('.carousel').each(function(){
$(this).find('.carousel-item:eq(0)').addClass('active');
});
</script>

@endsection

{{--<div class="card single_image">
<img src="{{single_image}}" class="card-img-top" alt="...">
</div>

<div class="carousel slide" data-bs-ride="carousel">
<div class="carousel-inner">
<div class="carousel-item active">
<img src="{{banner_img}}" class="d-block w-100" alt="{{banner_text}}">{{banner_text}}
</div>
</div>
</div>--}}


{{--
<div class="accordion accordion-flush" id="accordionFlushExample">
<div class="accordion-item">
<h2 class="accordion-header" id="flush-headingOne">
<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">{{accordion_text}}</button>
</h2>
<div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
<div class="accordion-body">{{accordion_content}}</div>
</div>
</div>
</div>
--}}


{{--
<div class="card">
<div class="card_image">
<img src="{{card_image}}" class="card-img-top" alt="...">
</div>
<div class="card-body">
<div class="card-title">{{card_text}}</div>
<div class="card-text">{{card_content}}</div>
</div>
</div>
--}}
