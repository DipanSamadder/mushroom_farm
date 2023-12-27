@extends('backend.layouts.app')



@section('header')

<link rel="stylesheet" href="{{ dsld_static_asset('backend/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">

<style>

    .bootstrap-tagsinput{    border: 1px solid #cbcbcb !important;width: 100%;}

</style>

@endsection



@section('content')


 <!-- Exportable Table -->

 <form id="update_form" action="{{ route('pages.update') }}" method="POST" enctype="multipart/form-data" >

    <div class="row clearfix">

        <div class="col-lg-8">

            @csrf 

            <input type="hidden" name="_method" value="PATCH">

		    <input type="hidden" name="lang" id="lang" value="{{ $lang }}">

            <input type="hidden" name="id" id="id" value="{{ $data->id }}" />

            <input type="hidden" name="type" id="type" value="custom_page" />

            <div class="card mb-0">

                <div class="header">

                    <a href="{{ route('custom-pages.show_custom_page', [$data->slug]) }}" target="_blank">         

                        <h2><strong> <i class="zmdi zmdi-hc-fw"></i> {{ $data->title }}</strong></h2>

                    </a>

                </div>

                <div class="body">

                    <div class="row clearfix">

                        <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">

                            <label class="form-label">Title <small class="text-danger">*</small> </label>  

                        </div>

                        <div class="col-lg-10 col-md-10 col-sm-8">

                            <div class="form-group">

                            <input type="text" name="title" id="title" class="form-control" placeholder="Title" onchange="is_edited()" value="{{ $data->getTranslation('title', $lang) }}" />

                            <small>Key : ( {{ $data->key_title }} )</small>

                            </div>

                        </div>

                    </div>

                    <div class="row clearfix">

                        <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">

                            <label class="form-label">Slug <small class="text-danger">*</small><span class="ml-2 pointer-cursor" onclick="$('input[name=slug]').removeAttr('disabled');"><i class="zmdi zmdi-edit"></i></a></label>  

                        </div>

                        <div class="col-lg-10 col-md-10 col-sm-8">

                            <div class="form-group">

                            <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug" value="{{ $data->slug }}" onchange="is_edited()" disabled/>

                            </div>

                        </div>

                    </div>

                    <div class="row clearfix">

                        <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">

                            <label class="form-label">Short Content</label>  

                        </div>

                        <div class="col-lg-10 col-md-10 col-sm-8">

                            <div class="form-group">

                            <input type="text" name="short_content" id="short_content" class="form-control" placeholder="Short Content" onchange="is_edited()" value="{{ $data->getTranslation('short_content', $lang) }}" />

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="card mb-0">

                <div class="header">

                    <h2><strong>Description</strong></h2>

                </div>

                <div class="form-group">                                

                    <div class="summernote" id="content" onchange="is_edited()"><?php $str = $data->getTranslation('content', $lang); echo htmlspecialchars_decode($str); ?></div>                                   

                </div>

            </div>

            <div class="card mb-0">

                <div class="header">

                    <h2><strong>Setting</strong></h2>                        

                </div>

                <div class="body">

                    <div class="row clearfix">

                        <div class="col-lg-3 col-md-3 col-sm-4 form-control-label">

                            <label class="form-label"><strong>Page Name </strong></label>  

                        </div>

                        <div class="col-lg-9 col-md-9 col-sm-8">

                            <div class="form-group">

                                <div class="checkbox">

                                    <input name="setting[]" type="hidden" value="setting_page_name_hide">

                                    <input id="setting_page_name_hide" name="setting_page_name_hide" type="checkbox" value="yes" @if(dsld_page_meta_value_by_meta_key('setting_page_name_hide', $data->id) =='yes') checked @endif>

                                    <label for="setting_page_name_hide">Hide</label>

                                </div>

                            </div>

                        </div>

                    </div><hr>

                    <div class="row clearfix">

                        <div class="col-lg-3 col-md-3 col-sm-4 form-control-label">

                            <label class="form-label"><strong>Banner/Slider </strong></label>  

                        </div>

                        <div class="col-lg-9 col-md-9 col-sm-8">

                            <div class="form-group">

                                <input name="setting[]" type="hidden" value="setting_page_banner_slider">

                                <input name="setting_slider" type="hidden" id="setting_slider"  @if(dsld_page_meta_value_by_meta_key('setting_page_banner_slider', $data->id) =='banner') value="banner" @elseif(dsld_page_meta_value_by_meta_key('setting_page_banner_slider', $data->id) =='slider') value="slider" @else value="no" @endif>

                                <div class="radio inlineblock m-r-20">

                                    <input type="radio" name="setting_page_banner_slider" id="setting_page_banner_slider_no" class="with-gap slider_activity" value="no"  @if(dsld_page_meta_value_by_meta_key('setting_page_banner_slider', $data->id) =='no') checked @endif>

                                    <label for="setting_page_banner_slider_no">No Need</label>

                                </div> 

                                <div class="radio inlineblock m-r-20">

                                    <input type="radio" name="setting_page_banner_slider" id="setting_page_banner_slider_banner" class="with-gap slider_activity" value="banner"  @if(dsld_page_meta_value_by_meta_key('setting_page_banner_slider', $data->id) =='banner') checked @endif>

                                    <label for="setting_page_banner_slider_banner">Banner</label>

                                </div>                                

                                <div class="radio inlineblock">

                                    <input type="radio" name="setting_page_banner_slider" id="setting_page_banner_slider_slider" class="with-gap slider_activity" value="slider"   @if(dsld_page_meta_value_by_meta_key('setting_page_banner_slider', $data->id) =='slider') checked @endif>

                                    <label for="setting_page_banner_slider_slider">Slider</label>

                                </div>                                  

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="card mb-0 slider_card" @if(dsld_page_meta_value_by_meta_key('setting_page_banner_slider', $data->id) !='slider') style="display:none" @endif>

                <div class="header">

                    <h2><strong>Slider</strong></h2>                        

                </div>

                <div class="body">

                    <div class="row clearfix">

                        <div class="col-lg-12 col-md-12 col-sm-12 form-control-label">

                            <label class="form-label"><strong>Image, Content, Sub Content, Button and Button</strong></label>  

                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12">

                            <div class="setting_page_slider_area">

                                

                                <input name="setting_slider[]" type="hidden" value="setting_page_slider_heading">

                                <input name="setting_slider[]" type="hidden" value="setting_page_slider_content">   

                                <input name="setting_slider[]" type="hidden" value="setting_page_slider_btn_link">  

                                <input name="setting_slider[]" type="hidden" value="setting_page_slider_btn_link2">  

                                <input name="setting_slider[]" type="hidden" value="setting_page_slider_image"> 

                                @if(dsld_page_meta_value_by_meta_key('setting_page_slider_image', $data->id) != 'null' && dsld_page_meta_value_by_meta_key('setting_page_slider_image', $data->id) != 'null' && dsld_page_meta_value_by_meta_key('setting_page_slider_image', $data->id) != '')

                                @foreach(json_decode(dsld_page_meta_value_by_meta_key('setting_page_slider_image', $data->id), true) as $key => $value)

                                <div class="row clearfix">

                                    <div class="col-sm-10">

                                        <div class="form-group">

                                            <input type="text" name="setting_page_slider_heading[]" class="form-control" placeholder="Heading" value="{{ json_decode(dsld_page_meta_value_by_meta_key('setting_page_slider_heading', $data->id), true)[$key] }}" />

                                        </div>

                                        <div class="form-group">                             

                                            <textarea name="setting_page_slider_content[]"  class="form-control" placeholder="Content">{{ json_decode(dsld_page_meta_value_by_meta_key('setting_page_slider_content  ', $data->id), true)[$key] }}</textarea>                                   

                                        </div>

                                        <div class="form-group">

                                            <input type="text" name="setting_page_slider_btn_link[]" class="form-control" placeholder="Button Link" value="{{ json_decode(dsld_page_meta_value_by_meta_key('setting_page_slider_btn_link', $data->id), true)[$key] }}" />

                                        </div>

                                        <div class="form-group">

                                            <input type="text" name="setting_page_slider_btn_link2[]" class="form-control" placeholder="Button Link 2"  value="{{ json_decode(dsld_page_meta_value_by_meta_key('setting_page_slider_btn_link2', $data->id), true)[$key] }}" />

                                        </div>

                                        <div class="form-group">


                                                <label class="form-label">Banner </label><a class="btn btn-primary text-white" onclick="media_file_get('{{ json_decode(dsld_page_meta_value_by_meta_key('setting_page_slider_image', $data->id), true)[$key] }}','setting_page_slider_image{{ $key }}', 0)"><i class="zmdi zmdi-collection-image"></i></a>
                                                 @if(json_decode(dsld_page_meta_value_by_meta_key('setting_page_slider_image', $data->id), true)[$key] != "")

                                                <div class="image mt-2 d-inline">

                                                    <img src="{{ dsld_uploaded_file_path(json_decode(dsld_page_meta_value_by_meta_key('setting_page_slider_image', $data->id), true)[$key]) }}"  alt="{{ dsld_upload_file_title(json_decode(dsld_page_meta_value_by_meta_key('setting_page_slider_image', $data->id), true)[$key]) }}" class="img-fluid" width="50">

                                                </div> 

                                                @endif 

                                                <div class="setting_page_slider_image{{ $key }}">
                                                    @if(isset(json_decode(dsld_page_meta_value_by_meta_key('setting_page_slider_image', $data->id), true)[$key]))
                                                    <strong>Selected Image:</strong>
                                                    <i>{{ @json_decode(dsld_page_meta_value_by_meta_key('setting_page_slider_image', $data->id), true)[$key] }}</i>@endif
                                                </div>


                                                <input type="hidden" class="setting_page_slider_image{{ $key }}" name="setting_page_slider_image[]" value="{{ json_decode(dsld_page_meta_value_by_meta_key('setting_page_slider_image', $data->id), true)[$key] }}" >
                                            

                                                                                  

                                        </div>

                                    </div>

                                    <div class="col-auto">

                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row">

                                            <i class="zmdi zmdi-hc-fw"></i>

                                        </button>

                                    </div>

                                </div>

                                @endforeach

                                @endif

                            </div>

                            <div class="row clearfix">

                                <div class="col-sm-10">

                                    <button

                                    type="button"

                                    class="btn btn-primary addMoreBtn"

                                    data-toggle="add-more"

                                    data-content='<div class="row clearfix">

                                    <div class="col-sm-10">

                                        <div class="form-group">

                                            <input type="text" name="setting_page_slider_heading[]" class="form-control" placeholder="Heading" />

                                        </div>

                                        <div class="form-group">                             

                                            <textarea name="setting_page_slider_content[]"  class="form-control" placeholder="Content"></textarea>                                   

                                        </div>

                                        <div class="form-group">

                                            <input type="text" name="setting_page_slider_btn_link[]" class="form-control" placeholder="Button Link" />

                                        </div>

                                        <div class="form-group">

                                            <input type="text" name="setting_page_slider_btn_link2[]" class="form-control" placeholder="Button Link 2"  />

                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Banner </label><a class="btn btn-primary text-white" onclick="media_file_get(``,`setting_page_slider_image_s`, 0)"><i class="zmdi zmdi-collection-image"></i></a><div class="setting_page_slider_image_s"></div>

                                            <input type="hidden" class="setting_page_slider_image" name="setting_page_slider_image[]">                                  

                                        </div>

                                    </div>

                                    <div class="col-auto">

                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row">

                                            <i class="zmdi zmdi-hc-fw"></i>

                                        </button>

                                    </div>

                                </div>'

                                    data-target=".setting_page_slider_area">

                                    <i class="zmdi zmdi-hc-fw"></i> Add New

                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card mb-0">

                <div class="header">

                    <h2><strong>Publish</strong></h2>                        

                </div>

                <div class="body">

            

                    <div class="form-group">

                        <label class="form-label">Status *</label>                                 

                        <select class="form-control" name="status" id="status" onchange="is_edited()">

                            <option value="">-- Please select --</option>

                            <option value="1" @if($data->status == 1) selected @endif>Active</option>

                            <option value="0" @if($data->status == 0) selected @endif>Deactive</option>

                        </select>                             

                    </div>

                    <div class="form-group">

                        <label class="form-label">Template *</label>                                 

                        <select class="form-control" name="template" id="template" onchange="is_edited()">

                            <option value="">-- Please select --</option>

                            @php

                                $templates = App\Models\Post::where('type', 'blade_template')->where('level', 1)->where('status', 1)->get();

                            @endphp

                            @foreach($templates as $key => $value)

                                <option value="{{ $value->template }}"  @if($value->template == $data->template) selected @endif>{{ $value->title }}</option>

                            @endforeach

                        </select>                             

                    </div>

                    

                    <div class="form-group">

                        <label class="form-label">Parent</label>                                 

                        <select class="form-control show-tick ms select2" name="parent" id="parent" onchange="is_edited()">

                            <option value="0">-- Please select --</option>



                                @foreach(App\Models\Post::where('type', 'custom_page')->where('status', 1)->whereNotIn('id', [$data->id])->get() as $key => $value)

                                

                                <option value="{{ $value->id }}"  @if($data->parent ==  $value->id) selected @endif>{{ $value->title }}</option>

                                @php

                                    $child = App\Models\Post::where('parent', $value->id)->where('type', 'custom_page')->where('level', 2)->where('status', 1)->get();

                                @endphp

                                @if($child != '')

                                    @foreach($child as $key => $value1)

                                        <option value="{{ $value1->id }}"  @if($data->parent ==  $value1->id) selected @endif>- {{ $value1->title }}</option>

                                        @php

                                            $child2 = App\Models\Post::where('parent', $value1->id)->where('type', 'custom_page')->where('level', 3)->where('status', 1)->get();

                                        @endphp

                                        @if($child2 != '')

                                            @foreach($child2 as $key => $value2)

                                                <option value="{{ $value2->id }}"  @if($data->parent ==  $value2->id) selected @endif>-- {{ $value2->title }}</option>

                                                @php

                                                    $child3 = App\Models\Post::where('parent', $value2->id)->where('type', 'custom_page')->where('level', 4)->where('status', 1)->get();

                                                @endphp

                                                @if($child3 != '')

                                                    @foreach($child3 as $key => $value3)

                                                        <option value="{{ $value3->id }}"  @if($data->parent ==  $value3->id) selected @endif>--- {{ $value3->title }}</option>

                                                    @endforeach

                                                @endif

                                            @endforeach

                                        @endif

                                    @endforeach

                                @endif



                            @endforeach

                        </select>                             

                    </div>

                    <div class="form-group">

                        <label class="form-label">Order</label>                                 

                        <input type="text" name="order" id="order" onchange="is_edited()" class="form-control" placeholder="Order" value="{{ $data->order }}" />                                   

                    </div>

                    <div class="input-group">

                        <div class="input-group-prepend">

                            <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>

                        </div>

                        <input type="date" name="date" id="date" class="form-control" onchange="is_edited()" value="{{  date('Y-m-d', strtotime($data->created_at)) }}">

                    </div>

                    <div class="swal-button-container">

                        <button type="submit" class="btn btn-success btn-round waves-effect dsld-btn-loader" id="submit_btn" disabled="disabled">Update</button>

                    </div>

                    <a href="{{ route('custom-pages.show_custom_page', [$data->slug]) }}" traget="_blank"  class="btn btn-success btn-round waves-effect">Preview</a>

                    <button type="button" class="btn btn-danger btn-round waves-effect" onclick="DSLDDeleteAlert('{{ $data->id }}','{{ route('pages.destory') }}','{{ csrf_token() }}')"><i class="zmdi zmdi-delete"></i></button>

                </div>

            </div>

            <div class="card mb-0">

                <div class="header">

                    <h2><strong>Banner</strong></h2>                        

                </div>

                <div class="body">

                    <div class="form-group">

                        <label class="form-label">Banner </label><a class="btn btn-primary text-white" onclick="media_file_get('{{ @$data->banner }}','put_image_banner', 0)"><i class="zmdi zmdi-collection-image"></i></a><div class="put_image_banner">@if(isset($data->banner))<strong>Selected Image:</strong><i> {{ @$data->banner }}</i>@endif</div>

                        

                        <input type="hidden" class="put_image_banner" name="banner" id="banner" value="{{ @$data->banner }}" onchange="is_edited()">

                        @if($data->banner > 0)

                        <div class="image mt-2">

                            <img src="{{ dsld_uploaded_file_path($data->banner) }}"  alt="{{ dsld_upload_file_title($data->banner) }}" class="img-fluid">

                        </div> 

                        @endif  

                                                                                  

                    </div>

                </div>

            </div>

            <div class="card mb-0">

                <div class="header">

                    <h2><strong>SEO</strong></h2>                        

                </div>

                <div class="body">

                    <div class="row clearfix">

                        <div class="col-lg-12 col-md-12 col-sm-12 form-control-label">

                            <label class="form-label">Meta Title </label>  

                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12">

                            <div class="form-group">

                            <input type="text" name="meta_title" id="meta_title" class="form-control" placeholder="Meta Title" onchange="is_edited()" value="{{ $data->meta_title }}" />

                            </div>

                        </div>

                    </div>

                    <div class="row clearfix">

                        <div class="col-lg-12 col-md-12 col-sm-12 form-control-label">

                            <label class="form-label">Meta Description </label>  

                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12">

                            <div class="form-group">

                            <input type="text" name="meta_description" onchange="is_edited()" id="meta_description" class="form-control" placeholder="Meta Drscription" value="{{ $data->meta_description }}" />                                   

                            </div>

                        </div>

                    </div>

                    <div class="row clearfix">

                        <div class="col-lg-12 col-md-12 col-sm-12 form-control-label">

                            <label class="form-label">Keyword </label>  

                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12">

                            <div class="form-group">

                            <input type="text" class="form-control" onchange="is_edited()" name="keywords" id="keywords" data-role="tagsinput" value="{{ $data->keywords }}">                          

                            </div>

                        </div>

                    </div>
                    <div class="row clearfix">

                        <div class="col-lg-12 col-md-12 col-sm-12 form-control-label">

                            <label class="form-label">Indexing </label>  

                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12">

                            <div class="form-group">      
                            <select class="form-control" name="indexing" id="indexing" onchange="is_edited()">

                                <option value="index, follow" @if($data->indexing == 'index, follow') selected @endif>Index & Follow</option>

                                <option value="noindex" @if($data->indexing == 'noindex') selected @endif>Noindex</option>
                                <option value="nofollow" @if($data->indexing == 'nofollow') selected @endif>Nofollow</option>
                                <option value="noindex, nofollow" @if($data->indexing == 'noindex, nofollow') selected @endif>Noindex & Nofollow</option>

    
                            </select>  
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            

        </div>

    </div>

</form>

<!-- Exportable Table -->

 

<div class="modal fade media" id="edit_pages_section" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-xl" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="title" id="DSLDLargeModalTitle">All Media</h4>

                

            </div>

            <div class="modal-body">

               

            </div>

        </div>

    </div>

</div>





@if(is_array($section) || count($section) > 0)



<hr>

<h4>Extra Section</h4>

<div class="row clearfix">

    <div class="col-lg-12">

        <div class="card mb-0">

            <div class="body">

                

                <!-- Nav tabs -->

                <ul class="nav nav-tabs p-0 mb-3 nav-tabs-success" role="tablist">

                    @foreach($section as $key => $sec)

                        <li class="nav-item"><a class="nav-link @if($key == 0 ) active @endif" data-toggle="tab" href="#page_section-{{ $key }}-{{ $sec->id }}" onclick="edit_pages_section('{{ $sec->id }}', '{{ $data->id }}', '{{ $lang }}')"> {{ $sec->title }} </a></li>

                    @endforeach

                </ul>

                

                <!-- Tab panes -->

                <div class="tab-content">



                    @foreach($section as $key => $sec)

                    @php

                        $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '_', $sec->title));

                        $title_page = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '_', $data->key_title));

                        $name = strtolower($slug);

                        $page_title = strtolower($title_page);

                        

                    @endphp

                    

                    <div role="tabpanel" class="tab-pane  @if($key == 0 ) in active @endif" id="page_section-{{ $key }}-{{ $sec->id }}">

                        

                     

                         <div id="edit_pages_section_body{{ $sec->id }}"></div>

                    </div>

                    @endforeach



                </div>



                

            </div>

        </div>

        

    </div>

</div>



@endif

@endsection



@section('footer')







<script src="{{ dsld_static_asset('backend/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>

<script>

    function edit_pages_section(section_id, page_id, lang){

        // $('#edit_pages_section').modal('show');

        $('#edit_pages_section_body'+section_id).html('<center><img src="{{ dsld_static_asset('backend/assets/images/circle-loading.gif') }}" style="max-width:100px" ></center>');



        $.ajax({

            url: "{{ route('pages.edit_extra') }}",

            type: "post",

            cache : false,

            data: {'_token':'{{ csrf_token() }}', 'section_id':section_id, 'id':page_id, lang:lang},

            success: function(d) {

                $('#edit_pages_section_body'+section_id).html(d);

            }

        });

    }



    $(document).ready(function(){

        $(".summernote").summernote('code');

        $('#update_form').on('submit', function(event){

        event.preventDefault();

        

            var setting_page_name_hide = 'no';

            var setting = $('input[name="setting[]"]').map(function(){ 

                    return this.value; 

                }).get();



            var setting_slider = $('input[name="setting_slider[]"]').map(function(){ 

                    return this.value; 

                }).get();

            var setting_page_slider_heading = $('input[name="setting_page_slider_heading[]"]').map(function(){ 

                    return this.value; 

                }).get();

            var setting_page_slider_content = $('textarea[name="setting_page_slider_content[]"]').map(function(){ 

                    return this.value; 

                }).get();

            var setting_page_slider_btn_link = $('input[name="setting_page_slider_btn_link[]"]').map(function(){ 

                    return this.value; 

                }).get();

            var setting_page_slider_btn_link2 = $('input[name="setting_page_slider_btn_link2[]"]').map(function(){ 

                    return this.value; 

                }).get();

            var setting_page_slider_image = $('input[name="setting_page_slider_image[]"]').map(function(){ 

                    return this.value; 

                }).get();



            if ($('#setting_page_name_hide').is(":checked")) { 

                if($('#setting_page_name_hide').val() == 'yes'){

                    setting_page_name_hide = 'yes';

                }

            }



            $('.dsld-btn-loader').addClass('btnloading');

            var Loader = ".btnloading";

            DSLDButtonLoader(Loader, "start");

            var content =  $("#content").summernote('code');

            $.ajax({

                url: $(this).attr('action'),

                type: $(this).attr('method'),

                cache : false,

                data: {

                    '_token':'{{ csrf_token() }}', 

                    'user_id':'{{ Auth::user()->id }}',

                    'lang':'{{ $lang }}',

                    'id': $('#id').val(),

                    'title': $('#title').val(),

                    'slug': $('#slug').val(),

                    'status': $('#status').val(),

                    'date': $('#date').val(),

                    'banner': $('#banner').val(),

                    'template': $('#template').val(),

                    'short_content': $('#short_content').val(),

                    'parent': $('#parent').val(),

                    'type': $('#type').val(),

                    'meta_title': $('#meta_title').val(),

                    'meta_description': $('#meta_description').val(),

                    'order': $('#order').val(),

                    'keywords': $('#keywords').val(),
                    'indexing': $('#indexing').val(),

                    'status': $('#status').val(),

                    'content': content,

                    'setting': setting,

                    'setting_page_name_hide': setting_page_name_hide,

                    'setting_page_banner_slider': $('#setting_slider').val(),

                    'setting_slider': setting_slider,

                    'setting_page_slider_heading': setting_page_slider_heading,

                    'setting_page_slider_content': setting_page_slider_content,

                    'setting_page_slider_btn_link': setting_page_slider_btn_link,

                    'setting_page_slider_btn_link2': setting_page_slider_btn_link2,

                    'setting_page_slider_image': setting_page_slider_image,

                },

                success: function(data) {

                    DSLDButtonLoader(Loader, "");

                    dsldFlashNotification(data['status'], data['message']);

                    if(data['status'] =='success'){

                        location.reload();

                    }

                    

                }

            });

        });

    });

    function is_edited(){

        $('#submit_btn').removeAttr('disabled');

    }

    function get_pages(){

        window.location.href = "{{ route('pages.index') }}";

    }

    $('.slider_activity').on('click', function(){

       

        if ($(this).is(":checked") && $(this).val() == 'slider') { 

            $('#setting_slider').val('slider');

            $('.slider_card').show();

        }else if ($(this).is(":checked") && $(this).val() == 'banner') { 

            $('#setting_slider').val('banner');

            $('.slider_card').hide();

        }else{

            $('#setting_slider').val('no');

            $('.slider_card').hide();   

        }

   });

     $('.select2').select2({

        dropdownParent: $('.form-group')

    });

</script>

@endsection