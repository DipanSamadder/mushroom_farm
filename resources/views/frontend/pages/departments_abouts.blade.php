@extends('frontend.layouts.app')
@include('frontend.partials.canonical')
@include('frontend.partials.page_meta')

@section('content')

@php 

    $title_page = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '_', $page->key_title));

    $parent_name = '';

    if($page->parent != 0){

        $parent_name = $page->parents->title;

    }



@endphp

<section class="details_sec common____fix">

<div class="container-fluid g-0">

    <div class="row g-0">

    <div class="col-md-3">

        @include('frontend.partials.sidebar')

    </div>

    <div class="col-md-9">

        @include('frontend.partials.department_banner')

        <div class="below-content-new">

            <h1 class="new12">

                {{ $parent_name }}

                <span class="durationo">{{ dsld_page_meta_value_by_meta_key($title_page.'_abouttemplate_text_0', $page->id) }} | 

                    <a href="{{ dsld_page_meta_value_by_meta_key($title_page.'_abouttemplate_text_1', $page->id) }}" target="_blank"><span class="coloredsa">View Fee Structure</span></a>

                </span>

            </h1>

            <h2 class="aca12 about____depat">

                {{ $page->getTranslation('title', env('DEFAULT_LANGUAGE'));  }}

                @auth()

                    <a href="{{ route('departments.edit', [$page->id]) }}"><i class="fas fa-edit"></i> </a>

                @endauth

            </h2>



            @if(!is_null($page->getTranslation('short_content', env('DEFAULT_LANGUAGE'))))

                <p>{{ $page->getTranslation('short_content', env('DEFAULT_LANGUAGE')); }}</p>

            @endif



            @if(!is_null($page->getTranslation('content', env('DEFAULT_LANGUAGE'))) && $page->getTranslation('content', env('DEFAULT_LANGUAGE')) !="<p><br></p>")   

                @php $str = $page->getTranslation('content', env('DEFAULT_LANGUAGE')); @endphp

                <?php echo htmlspecialchars_decode($str); ?>   

            @endif



            @php 

                $vission_image = $title_page.'_abouttemplate_vission_mession_2_vimage';

                $vission_heading = $title_page.'_abouttemplate_vission_mession_2_vheading';

                $vission_content = $title_page.'_abouttemplate_vission_mession_2_vcontent';



                $mission_image = $title_page.'_abouttemplate_vission_mession_2_mimage';

                $mission_heading = $title_page.'_abouttemplate_vission_mession_2_mheading';

                $page_mission_list = $title_page.'_abouttemplate_vission_mession_2_mlist';

            @endphp



            <div class="row below___con__gry mt-3">

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



            <div class="civl_eng_secti_1">

                @if(!is_null(dsld_page_meta_value_by_meta_key($title_page.'_abouttemplate_editor_3', $page->id)) && dsld_page_meta_value_by_meta_key($title_page.'_abouttemplate_editor_3', $page->id) !="<p><br></p>")   

                    @php $str = dsld_page_meta_value_by_meta_key($title_page.'_abouttemplate_editor_3', $page->id); @endphp

                    <?php echo htmlspecialchars_decode($str); ?>   

                @endif

            </div>



            <div class="below-iner-img">

                <div class="civl_eng_secti_2">

                    @if(!is_null(dsld_page_meta_value_by_meta_key($title_page.'_abouttemplate_editor_4', $page->id)) && dsld_page_meta_value_by_meta_key($title_page.'_abouttemplate_editor_4', $page->id) !="<p><br></p>")   

                        @php $str = dsld_page_meta_value_by_meta_key($title_page.'_abouttemplate_editor_4', $page->id); @endphp

                        <?php echo htmlspecialchars_decode($str); ?>   

                    @endif

                </div>

            </div>

        @include('frontend.partials.updates')

        </div>

    </div>

    </div>

</div>

</section>

@endsection

