@extends('frontend.layouts.app')

@include('frontend.partials.page_meta')

@section('content')

@php 

    $title_page = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '_', $page->key_title));

@endphp

<section class="details_sec common____fix">

<div class="container-fluid g-0">

    <div class="row g-0">

    <div class="col-md-3">

        @include('frontend.partials.sidebar')

    </div>

    <div class="col-md-9">

        @include('frontend.partials.department_banner')

        <div class="below-content-new page16">

        <h1 class="aca12">

            {{ $page->getTranslation('title', env('DEFAULT_LANGUAGE'));  }}

            @auth()

                <a href="{{ route('departments.edit', [$page->id]) }}"><i class="fas fa-edit"></i> </a>

            @endauth

        </h1>



        @if(!is_null($page->getTranslation('short_content', env('DEFAULT_LANGUAGE'))))

            <p>{{ $page->getTranslation('short_content', env('DEFAULT_LANGUAGE')); }}</p>

        @endif

        



        @if(!is_null($page->getTranslation('content', env('DEFAULT_LANGUAGE'))) && $page->getTranslation('content', env('DEFAULT_LANGUAGE')) !="<p><br></p>")

            <p>

                @php $str = $page->getTranslation('content', env('DEFAULT_LANGUAGE')); @endphp

                <?php echo htmlspecialchars_decode($str); ?>

            </p>

        @endif

        <div class="row">

        @php

            $page_link_box_text = $title_page."_coursesoutcomestemplate_link_box_0_text";

            $page_link_box_color = $title_page."_coursesoutcomestemplate_link_box_0_color";

            $page_link_box_link = $title_page."_coursesoutcomestemplate_link_box_0_link";

            $page_link_box_block = $title_page."_coursesoutcomestemplate_link_box_0_block";

        @endphp

        @if(dsld_page_meta_value_by_meta_key($page_link_box_text, $page->id) != '')

            

        @foreach(json_decode(@dsld_page_meta_value_by_meta_key($page_link_box_text, $page->id), true) as $key3 => $value) 

                

            @php 



            $color = json_decode(@dsld_page_meta_value_by_meta_key($page_link_box_color, $page->id), true)[$key3] ? json_decode(@dsld_page_meta_value_by_meta_key($page_link_box_color, $page->id), true)[$key3] : '#991d1f';

            

            @endphp

            <div class="col-md-4 my-3">

                <div class="inerordinance dep" style="background: {{ $color  }}; display: {{ json_decode(@dsld_page_meta_value_by_meta_key($page_link_box_block, $page->id), true)[$key3] }}">

                    <h3>{{ json_decode(@dsld_page_meta_value_by_meta_key($page_link_box_text, $page->id), true)[$key3] }}</h3>

                    <div class="pt-4">

                        <a href="{{ json_decode(@dsld_page_meta_value_by_meta_key($page_link_box_link, $page->id), true)[$key3] }}" class="my-3">OPEN <i class="fa-solid fa-arrow-right"></i></a>

                    </div>



                </div>

            </div>

        @endforeach

        

    @endif

            





        </div>

        @include('frontend.partials.updates')

        </div>

    </div>

    </div>

</div>

</section>

@endsection

