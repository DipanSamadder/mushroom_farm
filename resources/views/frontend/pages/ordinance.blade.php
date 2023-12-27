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


        <div class="row">
        @php
                $ordinance_image_box_repeter = dsld_page_meta_value_by_meta_key('ordinance_ordinance_image_box_repeter_0', $page->id);
                $theading = 'ordinance_ordinance_image_box_repeter_0_heading';
                $tlink = 'ordinance_ordinance_image_box_repeter_0_link';
            @endphp

            @if (json_decode($ordinance_image_box_repeter, true) != '')
                @foreach (json_decode(dsld_page_meta_value_by_meta_key($theading, $page->id), true) as $key => $value)
                
                <div class="col-md-4 mt-4">
                <div class="inerordinance">
                    <h3>{{ json_decode(dsld_page_meta_value_by_meta_key($theading, $page->id), true)[$key] }}</h3>
                    <div class="pt-4 ">
                    <a href="{{ json_decode(dsld_page_meta_value_by_meta_key($tlink, $page->id), true)[$key] }}" class="my-3"><span class="vicon"><i class="fa-solid fa-up-right-from-square"></i></span>  https://aktu.ac.in</a>
                    </div>
                    
                </div>
            </div>
            @endforeach
            @endif
            
            
        </div>


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