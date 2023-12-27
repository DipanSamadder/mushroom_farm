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
            @endphp

            @if(dsld_page_meta_value_by_meta_key($title_page.'_message_message_0_image', $page->id) > 0)
            <div class="denninfo">
                <div class="denimd">
                    <img src="{{ dsld_uploaded_file_path(dsld_page_meta_value_by_meta_key($title_page.'_message_message_0_image', $page->id)) }}" style="max-width:320px">
                </div>
                <div class="denind">
                    <div class="namede">
                        <p>{{ dsld_page_meta_value_by_meta_key($title_page.'_message_message_0_name', $page->id) }}</p>
                    </div>
                    <div class="desig">
                        <div class="desnam">
                            <p>{{ dsld_page_meta_value_by_meta_key($title_page.'_message_message_0_designations', $page->id) }}</p>
                        </div>
                        <p>{{ dsld_page_meta_value_by_meta_key($title_page.'_message_message_0_institute', $page->id)}}</p>
                    </div>
                </div>
            </div>
            @endif
            @if(!is_null($page->content))
                <p>
                    @php $str = $page->content; @endphp
                    <?php echo htmlspecialchars_decode($str); ?>
                </p>
            @endif
            
            @include('frontend.partials.in_the_news')
            @include('frontend.partials.updates')
        </div>
    </div>
</div>
</section>
@endsection
