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
        <h2  class="tableheading">{{ dsld_page_meta_value_by_meta_key('academiccalendar_academiccalendar_text_0', $page->id) }}</h2>
        	<div class="table-responsive">
                    @php $str = dsld_page_meta_value_by_meta_key('academiccalendar_academiccalendar_editor_1', $page->id); @endphp
                    <?php echo htmlspecialchars_decode($str); ?>
        	</div>
        	<h2 class="tableheading">{{ dsld_page_meta_value_by_meta_key('academiccalendar_academiccalendar_text_2', $page->id) }}</h2>
        	<div class="table-responsive">
                    @php $str1 = dsld_page_meta_value_by_meta_key('academiccalendar_academiccalendar_editor_3', $page->id); @endphp
                    <?php echo htmlspecialchars_decode($str1); ?>
        	</div>
        	<div class="downloadbtncsv">
        		<a href="{{ dsld_page_meta_value_by_meta_key('academiccalendar_academiccalendar_text_4', $page->id) }}" download>
                    <button class="downloadcsv">
        			<i class="fa-solid fa-download"></i> Click Here For Download
                    </button>
                </a>
        	</div>
        	<h2 class="tableheading">{{ dsld_page_meta_value_by_meta_key('academiccalendar_academiccalendar_text_5', $page->id) }}</h2>
        	<p class="sibheadtbl">{{ dsld_page_meta_value_by_meta_key('academiccalendar_academiccalendar_text_6', $page->id) }}</p>
        	<div class="table-responsive">
                    @php $str2 = dsld_page_meta_value_by_meta_key('academiccalendar_academiccalendar_editor_7', $page->id); @endphp
                    <?php echo htmlspecialchars_decode($str2); ?>
        	</div>
        	<div class="downloadbtncsv">
        		<a href="{{ dsld_page_meta_value_by_meta_key('academiccalendar_academiccalendar_text_8', $page->id) }}" download>
                    <button class="downloadcsv">
        			<i class="fa-solid fa-download"></i> Click Here For Download
                    </button>
                </a>
        	</div>
    </div>
    </div>
</div>
</section>
@endsection