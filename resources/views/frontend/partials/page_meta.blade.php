@if(isset($page) && $page !='')

@if(!is_null($page->indexing))
	@if($page->status == 1)
		@section('indexing'){{ $page->indexing }}@stop
	@else
		@section('indexing') noindex, nofollow @stop
	@endif 
@endif 

@section('meta_title'){{ $page->meta_title }}@stop

@section('meta_description'){{ $page->meta_description }}@stop

@section('meta_keywords'){{ $page->keywords }}@stop



@endif