@extends('frontend.layouts.app')

@include('frontend.partials.page_meta')

@section('content')

<section class="newseventnew  brightbgfornew">
    <div class="container">
        <div class="row mrlpq">
            <div class="col-md-12">
                <h4 class="heigh"><b>News and events</b></h4>
            </div>
        </div>
        <div class="row sectionnews_____rows">
            <div class="col-md-12">

                <div class="sectionnews">
                    <div class="imagenews">
                         <?php echo dsld_lazy_image_by_id($page->banner, 'w-100'); ?>
                    </div>
                    <div class="contentnews">
                        <div class="dateews">
                            <p>{{ date('M d, Y', strtotime($page->created_at)) }}</p>
                        </div>
                        <div class="headingnews">
                            <p>{{ $page->title }}</p>
                        </div>
                        @if($page->content !='')
                        <div class="discripnews">
                            @php $newsandevents_content = $page->content; @endphp
                            <?php echo htmlspecialchars_decode($newsandevents_content); ?>
                        </div>
                        @endif
                    </div>
                </div>
        

            </div>
        </div>
</section>



@endsection