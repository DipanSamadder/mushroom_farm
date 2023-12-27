<div class="darkboxes">
<h2>Updates</h2>

<div class="row">
@php
    $news_updates = App\Models\Post::where('type', 'news_updates')
    ->where('status', 1)
    ->orderBy('id', 'desc')->limit(3)
    ->get();
    @endphp
    @if (!empty($news_updates))
        @foreach($news_updates as $key => $value)
            @if($value->content !='')
                <div class="col-md-4">
                    <div class="boxesnew">
                        <div class="headlo">
                            <h4>{{ $value->title }}</h4>
                        </div>
                        <div class="dsoa">
                            <p>{{ $value->content }}</p>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endif
</div>