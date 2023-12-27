@extends('frontend.layouts.app')
@include('frontend.partials.page_meta')
@section('content')
<section class="details_sec common____fix">
<div class="container-fluid g-0">
    <div class="row g-0">
    <div class="col-md-3">
        @include('frontend.partials.sidebar')
    </div>
    <div class="col-md-9">
        @include('frontend.partials.inner_banner')
        <div class="below-content-new">
        <h1>
            {{ $page->title }}
            @auth()
                <a href="{{ route('pages.edit', [$page->id]) }}"><i class="fas fa-edit"></i> </a>
            @endauth
        </h1>
        @if(!is_null($page->short_content))
            <p>{{ $page->short_content }}</p>
        @endif

        <h2>{{ dsld_page_meta_value_by_meta_key('aboutgei_about-educationalinstitutions_text_0', $page->id) }}</h2>
        <div class="row p-3">
            @php
                $educationalinstitutions_image_box_repeter_1 = dsld_page_meta_value_by_meta_key('aboutgei_about-educationalinstitutions_image_box_repeter_1', $page->id);
                $theading = 'aboutgei_about-educationalinstitutions_image_box_repeter_1_heading';
                $tlink = 'aboutgei_about-educationalinstitutions_image_box_repeter_1_link';
            @endphp

            @if (json_decode($educationalinstitutions_image_box_repeter_1, true) != '')
                @foreach (json_decode(dsld_page_meta_value_by_meta_key($theading, $page->id), true) as $key => $value)
                <div class="col-md-3 p-0">
                    <div class="boxinerabtge @if($key%2 == 0 ) darkred @else  lired @endif">
                        <div class="deas">
                        <a href="{{ json_decode(dsld_page_meta_value_by_meta_key($tlink, $page->id), true)[$key] }}" class="text-decoration-none"><h3>{{ json_decode(dsld_page_meta_value_by_meta_key($theading, $page->id), true)[$key] }}</h3></a>
                        </div>
                    </div>
                </div>
            @endforeach
            @endif
          </div>

        
        
          @if(!is_null($page->content))
            <p>
                @php $str = $page->content; @endphp
                <?php echo htmlspecialchars_decode($str); ?>
            </p>
        @endif

        <div class="darkboxes mt-5">
            <h2>Updates</h2>

            <div class="row">
                <div class="col-md-4">
                    <div class="boxesnew">
                    <div class="headlo">
                    <h4>June 15, 2023</h4>
                    </div>
                    <div class="dsoa">
                    <p>Department of Applied Science is organizing an International Conference on Innovation and Application in Science & Technology (ICIAST-2021) during December 21-23, 2021. Conference Website:https://iciast.in/</p>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    </div>
</div>
</section>
@endsection