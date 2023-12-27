@extends('frontend.layouts.app')

@include('frontend.partials.page_meta')

@section('content')

@php 

    $title_page = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '_', $page->key_title));

    $parent_name = '';

    if($page->parent != 0){

        $child_page_listing = App\Models\Post::where('status', 1)->where('parent', $page->id)->orderBy('order', 'asc')->get();

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

        <div class="below-content-new page16">

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



            <div class="row">

                @php 



                @endphp

                @if(!is_null($child_page_listing))

                @foreach($child_page_listing as $child_key => $child_value) 

                <div class="col-md-4 my-4">

                    <div class="inerordinance dep">

                        <h3>{{ $child_value->getTranslation('title', env('DEFAULT_LANGUAGE'));  }}</h3>

                        <div class="pt-4 ">

                            <a href="{{ route('custom-pages.show_custom_page', [$child_value->slug]) }}" class="my-3">Details <i class="fa-solid fa-arrow-right"></i></a>

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

