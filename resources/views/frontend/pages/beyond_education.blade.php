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
                <div class="short-content"><p>{{ $page->short_content }}</p></div>
            @endif
            @php 
                $title_page = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '_', $page->key_title));
                $page_title = strtolower($title_page);
                $page_meta_key = $page_title."_".$page_title."_album_id_0";

                $album_id_value =  dsld_page_meta_value_by_meta_key($page_meta_key, $page->id)
            @endphp
        
            @if(!is_null($page->content) || $page->content !="<p><br></p>")
                <div class="editor-content">
                    @php $str = $page->content; @endphp
                    <?php echo htmlspecialchars_decode($str); ?>
                </div>
            @endif

            @if(!is_null($album_id_value))
            @php 
                $ablum_child_pages  = App\Models\Post::where('parent', $album_id_value)->where('status', 1)->get();
            @endphp

            @if(!is_null($ablum_child_pages))
            <ul class="nav nav-tabs galgoties____tab___main" id="myTab" role="tablist">
                @foreach($ablum_child_pages as $key => $value)
                <li class="nav-item" role="presentation">
                <button class="nav-link @if($key ==0) active @endif" id="{{ $value->slug }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $value->slug }}" type="button" role="tab" aria-controls="{{ $value->slug }}" aria-selected="true">{{ $value->title }}</button>
                </li>
                @endforeach
            </ul>
            @endif

            @if(!is_null($ablum_child_pages))
            <div class="tab-content galgoties____content" id="myTabContent">
                @foreach($ablum_child_pages as $key1 => $value1)
                <div class="tab-pane fade @if($key1 ==0) show active @endif" id="{{ $value1->slug }}" role="tabpanel" aria-labelledby="{{ $value1->slug }}-tab">
                    <div class="row my-5 imagegaleio">
                        @if(!is_null($value1->short_content))
                            <h2>{{ $value1->short_content }}</h2>
                        @endif

                        @if(!is_null($value1->content) || $page->content !="<p><br></p>")
                            <div class="editor-content">
                                @php $str = $value1->content; @endphp
                                <?php echo htmlspecialchars_decode($str); ?>
                            </div>
                        @endif


                        @php 
                            $images = App\Models\Upload::where('page_id', $value1->id)->orderBy('created_at', 'desc')->get();
                        @endphp


                        @foreach($images as $key3 => $value3)
                        <div class="col-md-6 py-3">
                            <img src="{{ dsld_uploaded_file_path($value3->id) }}" class="image-id-{{ $value3->id }}" alt="{{ dsld_upload_file_title($value3->id) }}">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach

                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="row my-5 imagegaleio">
                        <h2>The best located, finest Boutique Business Hotel in Gurgaon.</h2>
                        <div class="col-md-6 py-3"><img src="assets/images/new-college/hotel-th1.png"></div>
                        <div class="col-md-6 py-3"><img src="assets/images/new-college/hotel-th1.png"></div>
                        <div class="col-md-6 py-3"><img src="assets/images/new-college/hotel-th1.png"></div>
                        <div class="col-md-6 py-3"><img src="assets/images/new-college/hotel-th1.png"></div>
                        <div class="col-md-6 py-3"><img src="assets/images/new-college/hotel-th1.png"></div>
                        <div class="col-md-6 py-3"><img src="assets/images/new-college/hotel-th1.png"></div>
                        <div class="col-md-6 py-3"><img src="assets/images/new-college/hotel-th1.png"></div>
                        <div class="col-md-6 py-3"><img src="assets/images/new-college/hotel-th1.png"></div>
                        
                    </div>
                </div>


            </div>
            @endif
            
            @endif

            @include('frontend.partials.updates')
        </div>
    </div>
</div>
</section>
@endsection
