@extends('frontend.layouts.app')

@include('frontend.partials.page_meta')

@section('content')

@if(dsld_page_meta_value_by_meta_key('setting_page_slider_image', $page->id) !='') 
@if(dsld_page_meta_value_by_meta_key('setting_page_banner_slider', $page->id) == 'slider') 

@if(is_array(json_decode(dsld_page_meta_value_by_meta_key('setting_page_slider_image', $page->id), true)) && count(json_decode(dsld_page_meta_value_by_meta_key('setting_page_slider_image', $page->id), true)) > 0 ) 

<section>

	<div class="banner1 z9 hm banner__mobile_viw_main___box">

		<div class="banner____main_se">


			<div class="swiper mybannerSwiper">
				<div class="swiper-wrapper">

					@foreach(json_decode(dsld_page_meta_value_by_meta_key('setting_page_slider_image', $page->id), true) as $key => $value)
						<div class="swiper-slide">
							<div class="banner__main__foot_hovr">
								<?php echo dsld_lazy_image_by_id(json_decode(dsld_page_meta_value_by_meta_key('setting_page_slider_image', $page->id), true)[$key], ''); ?>
								<div class="banner__main_img_over_blc"></div>
							</div>
							<div class=" bnrHead___banner_over">
								<h1><b>{{ json_decode(dsld_page_meta_value_by_meta_key('setting_page_slider_heading', $page->id), true)[$key] }}</b></h1>
								<a href="{{ json_decode(dsld_page_meta_value_by_meta_key('setting_page_slider_btn_link', $page->id), true)[$key] }}" class="viewAll">Know More</a>
							</div>
						</div>
					@endforeach
					



				</div>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			</div>



			<div class="banner_left___sec">
				<ul>
					<li>NOTICE</li>
					<li>NOTICE</li>
					<li>ENQUIRY</li>
				</ul>
			</div>             
		</div>


		<div class="container-fluid g-0">
			<div class="belowsection w-100">
				<div class="row banner-below banner-below____mobi">

					<div class="col-md-4 g-0">
						<div class="banner__foot_hovr_box">
							<div class="banner__foot_hovr">
								<?php echo dsld_lazy_image_by_id(dsld_page_meta_value_by_meta_key('home_bannelbellow_file_2', $page->id), ''); ?>
							</div>
							<div class="banner__foot">
								<h4>{{ dsld_page_meta_value_by_meta_key('home_bannelbellow_text_0', $page->id) }}</h4>
								<p>{{ dsld_page_meta_value_by_meta_key('home_bannelbellow_text_1', $page->id) }}</p>
							</div>
						</div>    
					</div>

					<div class="col-md-4 g-0">
						<div class="banner__foot_hovr_box">
							<div class="banner__foot_hovr">
								<?php echo dsld_lazy_image_by_id(dsld_page_meta_value_by_meta_key('home_bannelbellow_file_5', $page->id), ''); ?>
							</div>
							<div class="banner__foot">
								<h4>{{ dsld_page_meta_value_by_meta_key('home_bannelbellow_text_3', $page->id) }}</h4>
								<p>{{ dsld_page_meta_value_by_meta_key('home_bannelbellow_text_4', $page->id) }}</p>
							</div>
						</div>  
					</div>

					<div class="col-md-4 g-0">
						<div class="banner__foot_hovr_box">
							<div class="banner__foot_hovr">
								<?php echo dsld_lazy_image_by_id(dsld_page_meta_value_by_meta_key('home_bannelbellow_file_8', $page->id), ''); ?>
							</div>
							<div class="banner__foot">
								<h4>{{ dsld_page_meta_value_by_meta_key('home_bannelbellow_text_6', $page->id) }}</h4>
								<p>{{ dsld_page_meta_value_by_meta_key('home_bannelbellow_text_7', $page->id) }}</p>
							</div>
						</div>  
					</div>

				</div>
			</div>


		</div>
	</div>
</section>
@endif
@endif
@endif


<!-- <section>

	<div class="banner1 z9 hm banner__mobile_viw_main___box">

		<div class="banner____main_se">
			<div class="swiper mybannerSwiper">
				<div class="swiper-wrapper">
					<div class="swiper-slide">
						<div class="banner__main__foot_hovr">
							<img src="{{ dsld_static_asset('frontend/images/banner.png') }}" alt="">
							<div class="banner__main_img_over_blc"></div>
						</div>
						<div class=" bnrHead___banner_over">
							<h1><b>HOW WILL YOU MAKE YOUR IMPACT?</b></h1>
							<button class="viewAll">Know More</button>
						</div>
					</div>
					<div class="swiper-slide">
						<div class="banner__main__foot_hovr">
							<img src="{{ dsld_static_asset('frontend/images/banner.png') }}" alt="">
							<div class="banner__main_img_over_blc"></div>
						</div>
						<div class=" bnrHead___banner_over">
							<h1><b>HOW WILL YOU MAKE YOUR IMPACT?</b></h1>
							<button class="viewAll">Know More</button>
						</div>
					</div>
					<div class="swiper-slide">
						<div class="banner__main__foot_hovr">
							<img src="{{ dsld_static_asset('frontend/images/banner.png') }}" alt="">
							<div class="banner__main_img_over_blc"></div>
						</div>
						<div class=" bnrHead___banner_over">
							<h1><b>HOW WILL YOU MAKE YOUR IMPACT?</b></h1>
							<button class="viewAll">Know More</button>
						</div>
					</div>
					<div class="swiper-slide">
						<div class="banner__main__foot_hovr">
							<img src="{{ dsld_static_asset('frontend/images/banner.png') }}" alt="">
							<div class="banner__main_img_over_blc"></div>
						</div>
						<div class=" bnrHead___banner_over">
							<h1><b>HOW WILL YOU MAKE YOUR IMPACT?</b></h1>
							<button class="viewAll">Know More</button>
						</div>
					</div>
				</div>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			</div>
			<div class="banner_left___sec">
				<ul>
					<li>NOTICE</li>
					<li>NOTICE</li>
					<li>ENQUIRY</li>
				</ul>
			</div>             
		</div>
		<div class="container-fluid g-0">
			<div class="belowsection w-100">
				<div class="row banner-below banner-below____mobi">

					<div class="col-md-4 g-0">
						<div class="banner__foot_hovr_box">
							<div class="banner__foot_hovr">
								<img src="./assets/images/new-college/Swimmer-1200x675.png" alt="">
							</div>
							<div class="banner__foot">
								<h4>GCET</h4>
								<p>GALGOTIAS COLLEGE OF ENGINEERING AND TECHNOLOGY</p>
							</div>
						</div>    
					</div>

					<div class="col-md-4 g-0">
						<div class="banner__foot_hovr_box">
							<div class="banner__foot_hovr">
								<img src="./assets/images/new-college/Swimmer-1200x675.png" alt="">
							</div>
							<div class="banner__foot">
								<h4>GCET</h4>
								<p>GALGOTIAS COLLEGE OF ENGINEERING AND TECHNOLOGY</p>
							</div>
						</div>  
					</div>

					<div class="col-md-4 g-0">
						<div class="banner__foot_hovr_box">
							<div class="banner__foot_hovr">
								<img src="./assets/images/new-college/Swimmer-1200x675.png" alt="">
							</div>
							<div class="banner__foot">
								<h4>GCET</h4>
								<p>GALGOTIAS COLLEGE OF ENGINEERING AND TECHNOLOGY</p>
							</div>
						</div>  
					</div>

				</div>
			</div>


		</div>
	</div>
</section>
 -->

<section class="highlights py-5">
    <div class="container">
        <div class="row">
            <h4 class="heigh"><b>Highlights</b></h4>
        </div>
    </div>
    <div class="container">
        <div class="row highlights____baneer">
            
            <div class="col-md-8">
                
                <div class="heighlight-img">
                    <?php echo dsld_lazy_image_by_id(json_decode(@dsld_page_meta_value_by_meta_key('home_highlights_image_repeter_1_img', $page->id), true)[0], 'w-100'); ?>
                </div>
            </div>
            <div class="col-md-4">
            	@php
				    $highlights = App\Models\Post::where('type', 'page_others')
				    ->where('status', 1)
				    ->whereIn('cat_type', ['highlights'])
				    ->orderBy('id', 'desc')->limit(3)->get();
				@endphp
				@if(!is_null($highlights))
					@foreach($highlights as $key => $value)
		                <div class="hei-boxes">
		                    <h4>{{ date('M d, Y', strtotime($value->created_at)) }}</h4>
		                    <p><b>{{ $value->title }}</b></p>
		                </div>
	                @endforeach
                @endif
            </div>
        </div>


        <div class="">
            <div class="row  align-items-center tpCntrBox____paddd">
                @php
                    $counter_heading = "home_highlights_thc_repeter_0_heading";
                    $counter_subheading = "home_highlights_thc_repeter_0_subheading";
                    $counter_content = "home_highlights_thc_repeter_0_content";
                @endphp
                @if(dsld_page_meta_value_by_meta_key($counter_heading, $page->id) != '')
                    
                @foreach(json_decode(@dsld_page_meta_value_by_meta_key($counter_heading, $page->id), true) as $key3 => $value) 
                    <div class="col-md-3 tpCntrBox">
                        <h4 class="mb-0 redishfont"> <span class="counter">{{ json_decode(@dsld_page_meta_value_by_meta_key($counter_heading, $page->id), true)[$key3] }}</span></h4>
                        <p class="mb-0 white">{{ json_decode(@dsld_page_meta_value_by_meta_key($counter_subheading, $page->id), true)[$key3] }}</p>
                        <p class="mb-0  discr">{{ json_decode(@dsld_page_meta_value_by_meta_key($counter_content, $page->id), true)[$key3] }}
                        </p>

                    </div>
                @endforeach
                
            @endif
                
            </div>
        </div>
    </div>
</section>
<section class="z9 pos-rel vibrant">
    <div class="container">
        <div class=" row nationCnt">

            <div class="col-lg-6 contentindex">
                <h2>{{ dsld_page_meta_value_by_meta_key('home_journeys_text_0', $page->id) }}</h2>
                {{ dsld_page_meta_value_by_meta_key('home_journeys_editor_1', $page->id) }}
                <a href="{{ dsld_page_meta_value_by_meta_key('home_journeys_editor_1', $page->id) }}" class="explore mb-3 mt-4 d-block">Call to action</a>
            </div>
            <div class="col-lg-6 imgsection1">
                <div class="sidesection1">
                    <div class="imgsectin1">
                        <?php echo dsld_lazy_image_by_id(dsld_page_meta_value_by_meta_key('home_journeys_file_3', $page->id), ''); ?>
                        <a href="{{ dsld_page_meta_value_by_meta_key('home_journeys_text_4', $page->id) }}" class="three32"><i class="fa-solid fa-rotate"></i> 360 VIEW</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<section class="fundedstudent">
    <div class="container">
        <div class="row klklko klklko1">
            <div class="col-md-4">
                <div class="contentindex2">
                    <h2>{{ dsld_page_meta_value_by_meta_key('home_studentinnovations_text_0', $page->id) }}</h2>
                    {{ dsld_page_meta_value_by_meta_key('home_studentinnovations_text_1', $page->id) }}
                    <a href="{{ dsld_page_meta_value_by_meta_key('home_studentinnovations_text_2', $page->id) }}" class="explore mb-3 mt-4 d-block">Call to action</a>
                </div>
            </div>
            <div class="col-md-8">
                <div class="owl-carousel owl-theme indexnewcollege">
                @php
                    $sinnovateion_heading = "home_studentinnovations_image_box_repeter_3_heading";
                    $sinnovateion_image = "home_studentinnovations_image_box_repeter_3_img";
                @endphp
                @if(dsld_page_meta_value_by_meta_key($sinnovateion_heading, $page->id) != '')
                    
                @foreach(json_decode(@dsld_page_meta_value_by_meta_key($sinnovateion_heading, $page->id), true) as $key1 => $value) 

                    <div class="item">
                        <div class="slideriage">
                            <div class="slideriage___img_over">
                                <?php echo dsld_lazy_image_by_id(json_decode(@dsld_page_meta_value_by_meta_key($sinnovateion_image, $page->id), true)[$key1], ''); ?>
                                <div class="slideriage___img_over_blc"></div>
                            </div>
                            <div class="contentimgsdf">
                                <h2>{{ json_decode(@dsld_page_meta_value_by_meta_key($sinnovateion_heading, $page->id), true)[$key1]  }}</h2>
                            </div>
                        </div>
                    </div>
                    @endforeach
                
                @endif
                    
                </div>
            </div>
        </div>
    </div>


</section>

<section class="fundeninovation">
    <div class="container">
        <div class="row fundeninovatione1">
            <div class="col-md-5 pos-rel">

                <?php echo dsld_lazy_image_by_id(dsld_page_meta_value_by_meta_key('home_studentinnovations_image_box_4_img', $page->id), 'newforphone'); ?>

                <div class="content-box">
                    <h2>{{ dsld_page_meta_value_by_meta_key('home_studentinnovations_image_box_4_heading', $page->id) }}</h2>
                    <p>{{ dsld_page_meta_value_by_meta_key('home_studentinnovations_image_box_4_content', $page->id) }}</p>

                    <a href="{{ dsld_page_meta_value_by_meta_key('home_studentinnovations_image_box_4_link', $page->id) }}" class="explore mb-3 mt-4 d-block">Call to action</a>
                </div>
            </div>

            <div class="col-md-6 lkjsa">
                <div class="row ">
                    <div class="col-md-6 ">
                        <div class="perbox text-center">
                            <h1>{{ json_decode(@dsld_page_meta_value_by_meta_key('home_studentinnovations_thc_repeter_5_heading', $page->id), true)[0]  }}</h1>
                            <p>{{ json_decode(@dsld_page_meta_value_by_meta_key('home_studentinnovations_thc_repeter_5_content', $page->id), true)[0]  }}</p>
                        </div>

                    </div>
                    <div class="col-md-6 ">
                        <div class="perbox text-center" style="background: #202020;">
                            <h1>{{ json_decode(@dsld_page_meta_value_by_meta_key('home_studentinnovations_thc_repeter_5_heading', $page->id), true)[1]  }}</h1>
                            <p>{{ json_decode(@dsld_page_meta_value_by_meta_key('home_studentinnovations_thc_repeter_5_content', $page->id), true)[1]  }}</p>
                        </div>
                    </div>
                </div>
                <div class="row testmonoala">
                    <div class="mt-5">
                        <img src="{{ dsld_static_asset('frontend/images/new-college/testmo.png')}}">
                    </div>
                    <div class="testreview mt-5">

                        <P>{{ json_decode(@dsld_page_meta_value_by_meta_key('home_studentinnovations_thc_repeter_5_content', $page->id), true)[2]  }}</p>
                    </div>
                    <div class="namegoeshere mt-5">
                        <p>{{ json_decode(@dsld_page_meta_value_by_meta_key('home_studentinnovations_thc_repeter_5_heading', $page->id), true)[2]  }}</p>
                    </div>

                </div>

            </div>
        </div>
    </div>
</section>

@php
    $achievements = App\Models\Post::where('type', 'page_others')
    ->where('status', 1)
    ->whereIn('cat_type', ['achievements'])
    ->orderBy('id', 'desc')->limit(5)->get();
@endphp
@if(!is_null($achievements))
<section class="achivements">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="heigh"><b>Achievements</b></h4>
            </div>
        </div>
    </div>
    <div class="row pb-3">
            @foreach($achievements as $key => $value) 
	        <div class="boxessa g-0">
	            <div class="ytBox">
	                <div class="ytVideo pos-rel ">
	                    <div class="ytVideo____img">
	                    	<?php echo dsld_lazy_image_by_id($value->banner, 'img-fluid lg'); ?>
	                        <div class="ytVideo____img___bcl"></div>
	                    </div>
	                    <a href="#">
	                        <div class="ytPlay">
	                            <img src="{{ dsld_static_asset('frontend/images/yt.png') }}" class="img-fluid"> 
	                            <div class="ytVideo___watch">
	                                <p>Watch Story</p>
	                            </div>
	                        </div>
	                    </a>
	                </div>
	                <div class="ytVideo____foooter">
	                    <p>{{ $value->title }}</p>
	                </div>

	            </div>
	        </div>
        	@endforeach
        

    <div>

</section>
@endif


@php
    $placements = App\Models\Post::where('type', 'placements')
    ->where('status', 1)
    ->orderBy('id', 'desc')->limit(12)->get();
@endphp
@if(!is_null($placements))
<section class="plmentus  brightbgfornew">
    <div class="container">
        <div class="row">
            <h4 class="heigh"><b>Placements</b></h4>
        </div>
        <div class="row owl-carousel owl-theme indexnewplace">
        	
	            @foreach($placements as $key => $value) 
		            <div class="">
		                <div class="inersrollbox">
		                    <div class="imegsecas">
		                        <?php echo dsld_lazy_image_by_id($value->banner, ''); ?>
		                    </div>
		                    <div class="consdea">
		                        <div class="heasdin">
		                            <p>{{ $value->title }}</p>
		                        </div>
		                         @if($value->content !='')
		                        <div class="kntn">
		                            @php $content = $value->content; @endphp
		                            <?php echo htmlspecialchars_decode($content); ?>
		                        </div>
		                        @endif
		                    </div>
		                </div>
		            </div>
	            @endforeach
            

        </div>
    </div>
</section>
@endif

<section class="belowpace">
    <?php echo dsld_lazy_image_by_id(dsld_page_meta_value_by_meta_key('home_campus_file_0', $page->id), 'nato'); ?>
    <div class="container">
        <div class="row owl-carousel owl-theme indexnewplace2">

        @if(dsld_page_meta_value_by_meta_key('home_campus_image_box_repeter_1_heading', $page->id) != '')
                    
        @foreach(json_decode(@dsld_page_meta_value_by_meta_key('home_campus_image_box_repeter_1_heading', $page->id), true) as $key1 => $value) 
          
            <div class="">
                <div class="inersrollbox">
                    <div class="imegsecas">
                        <?php echo dsld_lazy_image_by_id(json_decode(@dsld_page_meta_value_by_meta_key('home_campus_image_box_repeter_1_img', $page->id), true)[$key1], ''); ?>
                    </div>
                    <div class="consdea">
                        <div class="heasdin">
                            <p>{{ json_decode(@dsld_page_meta_value_by_meta_key('home_campus_image_box_repeter_1_heading', $page->id), true)[$key1] }}</p>
                        </div>
                        <div class="kntn">
                            <p>{{ json_decode(@dsld_page_meta_value_by_meta_key('home_campus_image_box_repeter_1_content', $page->id), true)[$key1] }}</p>
                        </div>
                    </div>

                </div>
            </div>
            @endforeach
        
        @endif
            
            
        </div>

        <div class="student-achivement">
            <div class="row">
                <div class="col-md-4 jknkbh g-0">
                    <div class="contentsecstac">
                        <div class="heddasd2">
                            <p>{{ dsld_page_meta_value_by_meta_key('home_campus_text_2', $page->id) }}</p>
                        </div>
                        <div class="heddasd py-1">
                            <p>{{ dsld_page_meta_value_by_meta_key('home_campus_text_3', $page->id) }}</p>
                        </div>
                        <a href="{{ dsld_page_meta_value_by_meta_key('home_campus_text_4', $page->id) }}" class="explore my-5 d-block ">Call to action</a>

                    </div>
                    </div>
                    <div class="col-md-4 jknkbh___ds">
                    <div class="imaesdf">
                        <?php echo dsld_lazy_image_by_id(dsld_page_meta_value_by_meta_key('home_campus_file_5', $page->id), ''); ?>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="stndimagecntn">
                        <div class="headingkjsd ">
                            <h2>{{ dsld_page_meta_value_by_meta_key('home_campus_text_6', $page->id) }}</h2>
                        </div>
                        <div class="imagesectionstnt">
                            <?php echo dsld_lazy_image_by_id(dsld_page_meta_value_by_meta_key('home_campus_file_9', $page->id), 'w-100'); ?>

                        </div>
                        <div class="naminfo pt-2">
                            <p class="dsds">{{ dsld_page_meta_value_by_meta_key('home_campus_text_7', $page->id) }}</p>
                            <p class="iooin">{{ dsld_page_meta_value_by_meta_key('home_campus_text_8', $page->id) }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

</section>


<section class="newseventnew  brightbgfornew">
    <div class="container">
        <div class="row mrlpq">
            <div class="col-md-6">
                <h4 class="heigh"><b>News and events</b></h4>
            </div>
            <div class="col-md-6 text-end m-auto">
                <div class="ltm">
                    <a href="{{ route('custom-pages.show_custom_page', ['trending-new-events-listing'])}}" class="p-3">Latest </a>
                    <a href="{{ route('custom-pages.show_custom_page', ['trending-new-events-listing'])}}" class="p-3">Trending </a>
                    <a href="{{ route('custom-pages.show_custom_page', ['trending-new-events-listing'])}}" class="p-3"> More News <i class="fa-solid fa-chevron-right" style="color: red"></i></a>
                </div>
            </div>
        </div>
        <div class="row sectionnews_____rows">
            <div class="col-md-6">
            	@php
		        $big_news_events = App\Models\Post::where('type', 'news_events')
		        ->whereIn('cat_type', ['news', 'events'])
		        ->where('status', 1)
		        ->orderBy('id', 'desc')->first();
		        @endphp
		        @if(!is_null($big_news_events))
                <div class="sectionnews">
                    <div class="imagenews">
                    	 <?php echo dsld_lazy_image_by_id($big_news_events->banner, 'w-100'); ?>
                    </div>
                    <div class="contentnews">
                        <div class="dateews">
                            <p>{{ date('M d, Y', strtotime($big_news_events->created_at)) }}</p>
                        </div>
                        <div class="headingnews">
                            <p>{{ $big_news_events->title }}</p>
                        </div>
                        @if($big_news_events->content !='')
                        <div class="discripnews">
                        	@php $newsandevents_content = $big_news_events->content; @endphp
                            <?php echo htmlspecialchars_decode($newsandevents_content); ?>
                        </div>
                        @endif
                        <div class="readmorenews">
                            <a href="{{ route('custom-pages.show_custom_page', [$big_news_events->slug]) }}">Read More <i class="fa-solid fa-chevron-right" style="color: red"></i></a>
                        </div>
                    </div>
                </div>
                @endif

            </div>
            <div class="col-md-6">

				@php
		        	$news_events = App\Models\Post::where('type', 'news_events')
			        ->whereIn('cat_type', ['news', 'events'])
			        ->where('status', 1)
			        ->orderBy('id', 'desc')->skip(1)->limit(3)->get();
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


<section class="placement z9 pos-rel ">
    <div class="container">

        <div class="tpCompanie">
            <h4 class="mb-4">Associate Recruiters</h4>
            <div class="tpCompanieRow d-flex">

                @if(dsld_page_meta_value_by_meta_key('home_associate_image_repeter_0_img', $page->id) != '')
                    
                @foreach(json_decode(@dsld_page_meta_value_by_meta_key('home_associate_image_repeter_0_img', $page->id), true) as $key1 => $value) 
                    <div class="tpCompanieBox">
                        <?php echo dsld_lazy_image_by_id(json_decode(@dsld_page_meta_value_by_meta_key('home_associate_image_repeter_0_img', $page->id), true)[$key1], 'img-fluid'); ?>
                    </div>
                    @endforeach
                
                @endif
               

            </div>
        </div>
    </div>
</section>


@endsection

