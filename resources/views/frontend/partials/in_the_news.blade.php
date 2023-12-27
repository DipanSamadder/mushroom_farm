<h1 class="nnews">In The News</h1>
<div class="row owl-carousel owl-theme indexnewplace newabtus">
    @php
    $news_events = App\Models\Post::where('type', 'news_events')
    ->whereIn('cat_type', ['news'])
    ->where('status', 1)
    ->orderBy('id', 'desc')->limit(10)
    ->get();
    @endphp
    @if (!empty($news_events))
        @foreach($news_events as $key => $value)
        <div>
            <a href="{{ route('custom-pages.show_custom_page', [$value->slug]) }}" class="text-decoration-none">
            <div class="inersrollbox">
                <div class="imegsecas">
                    <img src="{{ dsld_uploaded_file_path($value->banner) }}" alt="{{ dsld_upload_file_title($value->banner) }}" />
                </div>
                <div class="consdea">
                    <div class="heasdin">
                        <p>{{ $value->title }}</p>
                    </div>
                    <div class="kntn">
                        @if($value->content !='')
                            <p>{{ $value->content }}</p>
                        @endif
                    </div>
                </div>
            </div>
            </a>
        </div>
        @endforeach
    @endif
</div>