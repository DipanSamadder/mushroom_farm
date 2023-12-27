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

            @php 
                $title_page = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '_', $page->key_title));
                $vission_image = $title_page.'_visionmission_vission_mession_0_vimage';
                $vission_heading = $title_page.'_visionmission_vission_mession_0_vheading';
                $vission_content = $title_page.'_visionmission_vission_mession_0_vcontent';

                $mission_image = $title_page.'_visionmission_vission_mession_0_mimage';
                $mission_heading = $title_page.'_visionmission_vission_mession_0_mheading';
                $page_mission_list = $title_page.'_visionmission_vission_mession_0_mlist';
            @endphp

            <div class="row below___con__gry">
                <div class="col-md-5 p-0">
                    <div class="mesagevions">
                    <h2 class="hea">{{ dsld_page_meta_value_by_meta_key($vission_heading, $page->id) }}</h2>
                    @php $str = dsld_page_meta_value_by_meta_key($vission_content, $page->id); @endphp
                    <h2><?php echo htmlspecialchars_decode($str); ?></h2>
                    </div>
                </div>
                <div class="col-md-7 p-0">
                    <div class="imgsecfde"><img src="{{ dsld_uploaded_file_path(dsld_page_meta_value_by_meta_key($vission_image, $page->id)) }}"  alt="{{ dsld_upload_file_title(dsld_page_meta_value_by_meta_key($vission_image, $page->id)) }}"></div>
                </div>
            </div>

            <div class="row below___con__red">
                <div class="col-md-7 p-0">
                    <div class="inerevison">
                        <h2>{{ dsld_page_meta_value_by_meta_key($mission_heading, $page->id) }}</h2>
                        @if(dsld_page_meta_value_by_meta_key($page_mission_list, $page->id) != '')
                                @foreach(json_decode(dsld_page_meta_value_by_meta_key($page_mission_list, $page->id), true) as $key3 => $value) 
                                    <p>{{ $value }}<p><hr>
                                @endforeach
                            @endif
                    </div>
                </div>
                <div class="col-md-5 p-0">
                    <div class="newgs">
                    <img src="{{ dsld_uploaded_file_path(dsld_page_meta_value_by_meta_key($mission_image, $page->id)) }}"  alt="{{ dsld_upload_file_title(dsld_page_meta_value_by_meta_key($mission_image, $page->id)) }}">
                    </div>
                </div>
            </div>
                @if(!is_null($page->content))
                    <p>
                        @php $str = $page->content; @endphp
                        <?php echo htmlspecialchars_decode($str); ?>
                    </p>
                @endif

            @include('frontend.partials.updates')
        </div>
    </div>
</div>
</section>
@endsection
