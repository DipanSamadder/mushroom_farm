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

        @include('frontend.partials.department_banner')

        <div class="below-content-new">

        <h1>

            {{ $page->title }}

            @auth()

                <a href="{{ route('departments.edit', [$page->id]) }}"><i class="fas fa-edit"></i> </a>

            @endauth

        </h1>



        @if(!is_null($page->short_content))

            <p>{{ $page->short_content }}</p>

        @endif



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

</div>

</section>

@endsection

