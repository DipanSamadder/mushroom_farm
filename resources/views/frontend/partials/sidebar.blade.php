

@php 



if($page->parent != 0){



$sidebar = App\Models\Post::where('status', 1)->where('parent', $page->parents->id)->orderBy('order', 'asc')->get();

$name = $page->parents->title;
$content = $page->parents->content;
$type = $page->parents->type;
$is_content = 0;

if(!is_null(htmlspecialchars_decode($content)) && $content != '<p><br></p>'){
    $is_content = 1;
}

$slug = $page->parents->slug;



}else{



$sidebar = App\Models\Post::where('status', 1)->where('parent', $page->id)->orderBy('order', 'asc')->get();

$name = $page->title;

$slug = $page->slug;

$is_content = 0;
$content = $page->content;
$type = $page->type;
if(!is_null(htmlspecialchars_decode($content)) && $content != '<p><br></p>'){
    $is_content = 1;
}

}

if($type == 'department_details'){ $is_content = 1; }

@endphp



<div class="details_sec_left">

    <div class="details_sec_main nice-nav">

        <ul class="dropdown_menu_multi">

            <li>

                <a @if($is_content == 1) href="{{ route('custom-pages.show_custom_page', [$slug]) }}" @else href="#" @endif class="{{ dsld_is_slug_active([$slug, 'active']) }}"><span class="dsml_contain">{{ $name }}</span></a>

            </li>



            @if(!empty($sidebar))



                @foreach($sidebar as $key => $value)



                    @php 

                        $childs = App\Models\Post::where('status', 1)->where('parent', $value->id)->orderBy('order', 'asc')->get();

                    @endphp

                        

                    <!-- Multi Dropdown -->

                   



                        <li @if($childs->count() > 0) class="dropdown-submenu" @endif>

                            <a @if($childs->count() > 0) href="#" class="test {{ dsld_is_slug_active([$value->slug]) }}"  @else href="{{ route('custom-pages.show_custom_page', [$value->slug]) }}" class="{{ dsld_is_slug_active([$value->slug]) }}" @endif>

                                <span class="dsml_contain">{{ $value->title }}</span>

                                @if($childs->count() > 0) <i class="fa fa-plus plus__add" aria-hidden="true"></i> @endif

                            </a>

                            @if($childs->count() > 0)

                            <ul @if($childs->count() > 0) class="dropdown-menu dropdown-menu-border" @endif>

                                @foreach($childs as $key2 => $value2)

                                    @php 

                                        

                                        $childs2 = App\Models\Post::where('status', 1)->where('parent', $value2->id)->orderBy('order', 'asc')->get();



                                    @endphp



                                    <!-- Multi Dropdown -->

                                    @if($childs2->count() > 0)

                                        <li @if($childs2->count() > 0) class="dropdown-submenu" @endif>

                                            <a @if($childs2->count() > 0) href="#" class="test {{ dsld_is_slug_active([$value->slug]) }}" @else href="{{ route('custom-pages.show_custom_page', [$value2->slug]) }}" class="{{ dsld_is_slug_active([$value->slug]) }}" @endif>

                                                <span class="dsml_contain">{{ $value2->title }}</span>

                                                @if($childs2->count() > 0)<i class="fa fa-plus plus__add" aria-hidden="true"></i>@endif

                                            </a>

                                            @if($childs2->count() > 0)

                                            <ul  class="dropdown-menu">

                                            @foreach($childs2 as $key3 => $value3)

                                                <li><a href="{{ route('custom-pages.show_custom_page', [$value3->slug]) }}">{{ $value3->title }}</a></li>

                                            @endforeach 

                                            </ul>

                                            @endif

                                        </li>

                                    @else

                                        <li><a href="{{ route('custom-pages.show_custom_page', [$value2->slug]) }}">{{ $value2->title }}</a></li>

                                    @endif



                                @endforeach 

                            </ul>

                            @endif

                        </li>





                @endforeach

            @endif



        </ul>

    </div>

</div>



