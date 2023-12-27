@extends('frontend.layouts.app')
@include('frontend.partials.page_meta')

@section('content')


<section class="smtTab">
	<div class="container">
		<div class="row">
            @if($page !='')
                <div class="col-lg-12 col-md-12 ps-md-4">
                    @php $str = $page->content; @endphp
                    <?php echo htmlspecialchars_decode($str); ?>
                    @auth()
                        <p><i><a href="{{ route('pages.edit', [$page->id]) }}">Edit</a></i></p>
                    @endauth
                </div>
            @else
                <div class="col-lg-12 col-md-12 ps-md-4">
                   <center>Content Not Found.</center>
                </div>
            @endif
		</div>
	</div>
</section>





@endsection