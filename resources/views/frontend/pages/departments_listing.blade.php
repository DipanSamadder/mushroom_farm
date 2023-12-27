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

            {{ $page->getTranslation('title', env('DEFAULT_LANGUAGE'));  }}

            @auth()

                <a href="{{ route('departments.edit', [$page->id]) }}"><i class="fas fa-edit"></i> </a>

            @endauth

        </h1>



        @if(!is_null($page->getTranslation('short_content', env('DEFAULT_LANGUAGE'))))

            <p>{{ $page->getTranslation('short_content', env('DEFAULT_LANGUAGE')); }}</p>

        @endif



        @php 

            $programs = App\Models\Post::where('type', 'programs_details')->where('status', 1)->whereNotIn('id', [73])->get();

        @endphp



        @foreach($programs as $key => $value)

            @php 

                $departments = App\Models\Post::where('type', 'department_details')->where('cat_type', $value->id)->where('status', 1)->whereNotIn('id', [72])->get();

            @endphp

            

            @if(!is_null($departments->toArray()) && is_array($departments->toArray()) && count($departments->toArray()) > 0)

                <h2 class="redhash mt-5 mt-2">{{ @$value->getTranslation('title', env('DEFAULT_LANGUAGE'));  }}</h2>

                <div class="row">

                    @foreach($departments as $key2 => $value2)



                        <div class="col-md-4 my-4">

                            <div class="inerordinance dep">

                                <h3>{{ @$value2->getTranslation('title', env('DEFAULT_LANGUAGE'));  }}</h3>

                                <div class="pt-4 ">

                                <a href="{{ route('custom-pages.show_custom_page', [$value2->slug]) }}" class="my-3">EXPLORE <i class="fa-solid fa-arrow-right"></i></a>

                                </div>

                                    

                            </div>

                        </div>

                    @endforeach

                </div>

            @endif

        @endforeach



        @if(!is_null($page->getTranslation('content', env('DEFAULT_LANGUAGE'))) && $page->getTranslation('content', env('DEFAULT_LANGUAGE')) !="<p><br></p>")

            <p>

                @php $str = $page->getTranslation('content', env('DEFAULT_LANGUAGE')); @endphp

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

