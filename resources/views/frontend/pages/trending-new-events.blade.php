@extends('frontend.layouts.app')

@include('frontend.partials.page_meta')

@section('content')

<section class="newseventnew  brightbgfornew">
    <div class="container">
        <div class="row mrlpq">
            <div class="col-md-6">
                <h4 class="heigh"><b>News and events</b></h4>
            </div>
            <div class="col-md-6 text-end m-auto">
                <div class="ltm">
                    <a href="#" class="p-3">Latest </a>
                    <a href="#" class="p-3">Trending </a>
                    <a href="#" class="p-3"> More News <i class="fa-solid fa-chevron-right" style="color: red"></i></a>
                </div>
            </div>
        </div>
        <div class="row sectionnews_____rows">
            <div class="col-md-7">
                <h4 class="heigh"><b>Trending</b></h4>
                @php
                $big_news_events = App\Models\Post::where('type', 'news_events')
                ->whereIn('cat_type', ['news', 'events'])
                ->where('status', 1)
                ->orderBy('visitor', 'desc')->get();
                @endphp
                @if(!is_null($big_news_events))
                @foreach($big_news_events as $key => $value)
                <div class="sectionnews">
                    <div class="imagenews">
                         <?php echo dsld_lazy_image_by_id($value->banner, 'w-100'); ?>
                    </div>
                    <div class="contentnews">
                        <div class="dateews">
                            <p>{{ date('M d, Y', strtotime($value->created_at)) }}</p>
                        </div>
                        <div class="headingnews">
                            <p>{{ $value->title }}</p>
                        </div>
                        @if($value->content !='')
                        <div class="discripnews">
                            @php $newsandevents_content = $value->content; @endphp
                            <?php echo htmlspecialchars_decode($newsandevents_content); ?>
                        </div>
                        @endif
                        <div class="readmorenews">
                            <a href="{{ route('custom-pages.show_custom_page', [$value->slug]) }}">Read More <i class="fa-solid fa-chevron-right" style="color: red"></i></a>
                        </div>
                    </div>
                </div><br>
                @endforeach
                @endif

            </div>
            <div class="col-md-5">
                <h4 class="heigh"><b>Latest</b></h4>

                @php
                    $news_events = App\Models\Post::where('type', 'news_events')
                    ->whereIn('cat_type', ['news', 'events'])
                    ->where('status', 1)
                    ->orderBy('id', 'desc')->limit(3)->get();
                @endphp
                @if(!is_null($news_events))
                 @foreach($news_events as $key => $value)
                <div class="row sidecnl">
                    <div class="col-md-6">
                        <div class="imagesectionnewax text-center">
                            <?php echo dsld_lazy_image_by_id($value->banner, 'w-75'); ?>
                            
                        </div>
                    </div>
                    <div class="col-md-6 sidebyside">
                        <div class="contentnews">
                            <div class="dateews">
                                <p>{{ date('M d, Y', strtotime($value->created_at)) }}</p>
                            </div>

                            
                            @if($value->content !='')
                            <div class="discripnews">
                                @php $newsandevents_content = $value->content; @endphp
                                <?php echo htmlspecialchars_decode($newsandevents_content); ?>
                            </div>
                            @endif
                            <div class="readmorenews">
                                <a href="{{ route('custom-pages.show_custom_page', [$value->slug]) }}">Read More <i class="fa-solid fa-chevron-right" style="color: red"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
                <hr class="myhrfornewer">
                 @endforeach
                @endif

            </div>
        </div>
</section>


@endsection