@if(dsld_page_meta_value_by_meta_key('setting_page_banner_slider', $page->id) == 'banner') 
<div class="details_sec_right" @if(!is_null($page->banner) || $page->banner != 0) style="background: url({{ dsld_uploaded_file_path($page->banner,'full') }});" @endif>
    <div class="dsmr_image__box">
      
        <div class="banner__con_defer">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                                @if(dsld_page_meta_value_by_meta_key('setting_page_name_hide', $page->id) != 'yes') 
                        <h2>
                            {{ $page->title }}
                            @auth()
                                <a href="{{ route('departments.edit', [$page->id]) }}"><i class="fas fa-edit"></i> </a>
                            @endauth
                        </h2>
                        @endif
                    </div>
                </div>
            </div>
        </div>

		
    </div>
</div>
@endif

