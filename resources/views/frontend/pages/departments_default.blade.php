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

        <div class="below-content-new">

        <h1 class="hossec">

            {{ $page->getTranslation('title', env('DEFAULT_LANGUAGE'));  }}

            @auth()

                <a href="{{ route('departments.edit', [$page->id]) }}"><i class="fas fa-edit"></i> </a>

            @endauth

        </h1>



        @if(!is_null($page->getTranslation('short_content', env('DEFAULT_LANGUAGE'))))

            <p>{{ $page->getTranslation('short_content', env('DEFAULT_LANGUAGE')); }}</p>

        @endif



        @if(!is_null($page->getTranslation('content', env('DEFAULT_LANGUAGE'))) && $page->getTranslation('content', env('DEFAULT_LANGUAGE')) !="<p><br></p>")

            <div class="table-responsive">

                @php $str = $page->getTranslation('content', env('DEFAULT_LANGUAGE')); @endphp

                <?php echo htmlspecialchars_decode($str); ?>

            </div>

        @endif



        @include('frontend.partials.updates')

        </div>

    </div>

    </div>

</div>

</section>

@endsection

