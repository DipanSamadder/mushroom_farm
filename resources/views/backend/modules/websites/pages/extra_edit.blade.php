

@php

    $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '_', $sec->title));

    $title_page = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '_', $data->key_title));

    $name = strtolower($slug);

    $page_title = strtolower($title_page);

    

@endphp



<form id="update_form" action="{{ route('pages_extra_content.update') }}" method="POST" enctype="multipart/form-data" >

    <input type="hidden" name="page_id" value="{{ $data->id }}" />

    <input type="hidden" name="lang" value="{{ $lang }}" />

    <input type="hidden" name="page_name" value="{{ $page_title }}" />

    <input type="hidden" name="section_name" value="{{ $name }}" />

    <input type="hidden" name="section_id" value="{{ $sec->id }}" />



    @csrf 

        @if($sec->meta_fields !="")

        @foreach (json_decode($sec->meta_fields) as $key2 => $element)

            @php 

                $page_meta_key = $page_title."_".$name."_".$element->type."_".$key2;

            @endphp



            @if ($element->type == 'text' || $element->type == 'album_id')

            

                <div class="row clearfix">

                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">

                        <label class="form-label">{{ ucfirst($element->label) }}</label>  

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-8">

                        <div class="form-group">

                            <input type="hidden" name="type[]" value="{{ $page_meta_key }}">

                            <input type="text" name="{{ $page_meta_key }}" class="form-control" placeholder="{{ ucfirst($element->label) }}" onchange="is_edited()" value="{{ dsld_page_meta_value_by_meta_key($page_meta_key, $data->id) }}" />

                            <small>Meta Key: {{ $page_meta_key }}</small>

                        </div>

                    </div>

                </div>



                @elseif ($element->type == 'vission_mession')

                @php

                    $page_vision_image= $page_meta_key."_vimage";

                    $page_vision_heading= $page_meta_key."_vheading";

                    $page_vision_content = $page_meta_key."_vcontent";



                    $page_mission_image= $page_meta_key."_mimage";

                    $page_mission_heading= $page_meta_key."_mheading";

                    $page_mission_list = $page_meta_key."_mlist";

                @endphp

                <div class="row clearfix">

                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">

                        <label class="form-label">Vision Image</label>  

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-8">

                        <div class="form-group">

                            <input type="hidden" name="type[]" value="{{ $page_vision_image }}">

                            <a class="btn btn-primary text-white" onclick="media_file_get('{{ @dsld_page_meta_value_by_meta_key($page_vision_image, $data->id) }}','put_image_{{ $page_vision_image }}', 0)"><i class="zmdi zmdi-collection-image"></i></a>

                            @if(dsld_page_meta_value_by_meta_key($page_vision_image, $data->id) > 0)

                            <div class="image mt-2 d-inline">

                                <img src="{{ dsld_uploaded_file_path(dsld_page_meta_value_by_meta_key($page_vision_image, $data->id)) }}"  alt="{{ dsld_upload_file_title(dsld_page_meta_value_by_meta_key($page_vision_image, $data->id)) }}" class="img-fluid" width="60px">

                            </div> 

                            @endif 

                            <div class="put_image_{{ $page_vision_image }}">@if(dsld_page_meta_value_by_meta_key(@$page_vision_image, $data->id))<strong>Selected Image:</strong><i> {{ @dsld_page_meta_value_by_meta_key($page_vision_image, $data->id) }}</i>@endif</div>

                        

                            <input type="hidden" class="put_image_{{ $page_vision_image }}" name="{{ $page_vision_image }}" value="{{ @dsld_page_meta_value_by_meta_key($page_vision_image, $data->id) }}" onchange="is_edited()">



                        </div><small>Meta Key: {{ $page_vision_image }}</small>

                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">

                        <label class="form-label">Vision Heading</label>  

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-8">

                        <div class="form-group">

                            <input type="hidden" name="type[]" value="{{ $page_vision_heading }}">

                            <input class="form-control" name="{{ $page_vision_heading }}" value="{{ dsld_page_meta_value_by_meta_key($page_vision_heading, $data->id)}}"> 

                        </div><small>Meta Key: {{ $page_vision_heading }}</small>

                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">

                        <label class="form-label">Vision Content</label>  

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-8">

                        <div class="form-group">

                            <input type="hidden" name="type[]" value="{{ $page_vision_content }}">

                            <textarea  class="summernote" name="{{ $page_vision_content }}"><?php $str = dsld_page_meta_value_by_meta_key($page_vision_content, $data->id); echo htmlspecialchars_decode($str); ?></textarea >  

                        </div><small>Meta Key: {{ $page_vision_content }}</small>

                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">

                        <label class="form-label">Mission Image</label>  

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-8">

                        <div class="form-group">

                            <input type="hidden" name="type[]" value="{{ $page_mission_image }}">



                            <a class="btn btn-primary text-white" onclick="media_file_get('{{ @dsld_page_meta_value_by_meta_key($page_mission_image, $data->id) }}','put_image_{{ $page_mission_image }}', 0)"><i class="zmdi zmdi-collection-image"></i></a>

                            @if(dsld_page_meta_value_by_meta_key($page_mission_image, $data->id) > 0)

                            <div class="image mt-2 d-inline">

                                <img src="{{ dsld_uploaded_file_path(dsld_page_meta_value_by_meta_key($page_mission_image, $data->id)) }}"  alt="{{ dsld_upload_file_title(dsld_page_meta_value_by_meta_key($page_mission_image, $data->id)) }}" class="img-fluid" width="60px">

                            </div> 

                            @endif 

                            <div class="put_image_{{ $page_mission_image }}">

                                @if(dsld_page_meta_value_by_meta_key(@$page_mission_image, $data->id))<strong>Selected Image:</strong><i> {{ @dsld_page_meta_value_by_meta_key($page_mission_image, $data->id) }}</i>

                                @endif

                            </div>

                        

                            <input type="hidden" class="put_image_{{ $page_mission_image }}" name="{{ $page_mission_image }}" value="{{ @dsld_page_meta_value_by_meta_key($page_mission_image, $data->id) }}" onchange="is_edited()">



                        </div> 

                        <small>Meta Key: {{ $page_mission_image }}</small>

                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">

                        <label class="form-label">Mission Heading</label>  

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-8">

                        <div class="form-group">

                            <input type="hidden" name="type[]" value="{{ $page_mission_heading }}">

                            <input class="form-control" name="{{ $page_mission_heading }}" value="{{ dsld_page_meta_value_by_meta_key($page_mission_heading, $data->id) }}"> 

                        </div><small>Meta Key: {{ $page_mission_heading }}</small>

                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">

                        <label class="form-label">Mission List</label>  

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-8">

                        <div class="text_repeter{{ $sec->id }}_{{ $key2 }}">

                            <input type="hidden" name="type[]" value="{{ $page_mission_list }}">

                            

                            @if(dsld_page_meta_value_by_meta_key($page_mission_list, $data->id) != '')

                                @foreach(json_decode(dsld_page_meta_value_by_meta_key($page_mission_list, $data->id), true) as $key3 => $value) 

                                    

                                    <div class="row clearfix">

                                        <div class="col-sm-10">

                                            <div class="form-group">

                                                <input type="text" class="form-control"  name="{{ $page_mission_list }}[]" placeholder="{{ ucfirst($element->label) }}" value="{{ $value }}">  

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

                        <small>Meta Key: {{ $page_mission_list }}</small>

                    </div>

                </div>

                <div class="row clearfix">

                    <div class="col-lg-2 col-md-2 col-sm-4">

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-10">

                        <div class="input-group mb-4">

                            <button

                                type="button"

                                class="btn btn-primary addMoreBtn"

                                data-toggle="add-more"

                                data-content='<div class="row clearfix">

                                    <div class="col-sm-10">

                                        <div class="form-group"><input type="text" class="form-control"  name="{{ $page_mission_list }}[]" placeholder="{{ ucfirst($element->label) }}">  

                                        </div>

                                    </div>

                                    <div class="col-auto">

                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row">

                                            <i class="zmdi zmdi-hc-fw"></i>

                                        </button>

                                    </div>

                                </div>'

                                data-target=".text_repeter{{ $sec->id }}_{{ $key2 }}">

                                <i class="zmdi zmdi-hc-fw"></i>

                            </button>

                        </div><small>Meta Key: {{ $page_mission_list }}</small>

                    </div>

                </div>

                

                @elseif ($element->type == 'message')

                @php

                    $page_message_image = $page_meta_key."_image";

                    $page_message_name = $page_meta_key."_name";

                    $page_message_institute = $page_meta_key."_institute";

                    $page_message_designations = $page_meta_key."_designations";

                @endphp

                <div class="row clearfix">

                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">

                        <label class="form-label">Photo</label>  

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-8">

                        <div class="form-group">

                            <input type="hidden" name="type[]" value="{{ $page_message_image }}">

                            <a class="btn btn-primary text-white" onclick="media_file_get('{{ dsld_page_meta_value_by_meta_key($page_message_image, $data->id) }}','{{ $page_message_image }}', 0)"><i class="zmdi zmdi-collection-image"></i></a>@if(dsld_page_meta_value_by_meta_key($page_message_image, $data->id) != '')

                            <div class="image mt-2 d-inline">

                                <img src="{{ dsld_uploaded_file_path(dsld_page_meta_value_by_meta_key($page_message_image, $data->id)) }}"  alt="{{ dsld_upload_file_title(dsld_page_meta_value_by_meta_key($page_message_image, $data->id)) }}" class="img-fluid" width="100"><div style="cursor: pointer;display: initial;" onclick="media_file_remove('{{ dsld_page_meta_value_by_meta_key($page_message_image, $data->id) }}','{{ $page_message_image }}', 0)"><i class="zmdi zmdi-hc-fw"></i></div>

                            </div> 

                            @endif <div class="{{ $page_message_image }}">@if(isset($data->banner))<strong>Selected Image:</strong><i> {{ @$data->banner }}</i>@endif</div>

                        

                            <input type="hidden" class="{{ $page_message_image }}" name="{{ $page_message_image }}" id="banner" value="{{ dsld_page_meta_value_by_meta_key($page_message_image, $data->id) }}" >

                            

                            

                        </div><small>Meta Key: {{ $page_message_image }}</small>

                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">

                        <label class="form-label">Name</label>  

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-8">

                        <div class="form-group">

                            <input type="hidden" name="type[]" value="{{ $page_message_name }}">

                            <input type="text" name="{{ $page_message_name }}" class="form-control" value="{{ dsld_page_meta_value_by_meta_key($page_message_name, $data->id) }}"> 

                        </div><small>Meta Key: {{ $page_message_name }}</small>

                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">

                        <label class="form-label">Designation</label>  

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-8">

                        <div class="form-group">

                            <input type="hidden" name="type[]" value="{{ $page_message_designations }}">

                            <input type="text" name="{{ $page_message_designations }}" class="form-control" value="{{ dsld_page_meta_value_by_meta_key($page_message_designations, $data->id) }}"> 

                        </div><small>Meta Key: {{ $page_message_designations }}</small>

                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">

                        <label class="form-label">Institute</label>  

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-8">

                        <div class="form-group">

                            <input type="hidden" name="type[]" value="{{ $page_message_institute }}">

                            <input type="text" name="{{ $page_message_institute }}" class="form-control" value="{{ dsld_page_meta_value_by_meta_key($page_message_institute, $data->id) }}"> 

                        </div><small>Meta Key: {{ $page_message_institute }}</small>

                    </div>

                </div>

                @elseif ($element->type == 'image_box')

                @php 

                    $page_meta_key_heading = $page_meta_key."_heading";

                    $page_meta_key_subheading = $page_meta_key."_subheading";

                    $page_meta_key_img = $page_meta_key."_img";

                    $page_meta_key_content = $page_meta_key."_content";

                    $page_meta_key_btn = $page_meta_key."_btn";

                    $page_meta_key_link = $page_meta_key."_link";

                @endphp

                <div class="row clearfix">

                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">

                        <label class="form-label">{{ ucfirst($element->label) }}</label>  

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-8">

                        <div class="row">

                            <div class="col-lg-6 col-md-6 col-sm-6">

                                <div class="form-group">

                                    <input type="hidden" name="type[]" value="{{ $page_meta_key_heading }}">

                                    <input type="text" name="{{ $page_meta_key_heading }}" class="form-control" placeholder="Heading" onchange="is_edited()" value="{{ dsld_page_meta_value_by_meta_key($page_meta_key_heading, $data->id) }}" />

                                    <small>Meta Key: {{ $page_meta_key_heading }}</small>

                                </div>

                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6">

                                <div class="form-group">

                                    <input type="hidden" name="type[]" value="{{ $page_meta_key_subheading }}">

                                    <input type="text" name="{{ $page_meta_key_subheading }}" class="form-control" placeholder="Sub Heading" onchange="is_edited()" value="{{ dsld_page_meta_value_by_meta_key($page_meta_key_subheading, $data->id) }}" />

                                    <small>Meta Key: {{ $page_meta_key_subheading }}</small>

                                </div>

                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6">

                                <div class="form-group">

                                    <input type="hidden" name="type[]" value="{{ $page_meta_key_img }}">

                                    <label class="form-label">Banner </label><a class="btn btn-primary text-white" onclick="media_file_get('{{ dsld_page_meta_value_by_meta_key($page_meta_key_img, $data->id) }}','{{ $page_meta_key_img }}', 0)"><i class="zmdi zmdi-collection-image"></i></a>
                                    @if(dsld_page_meta_value_by_meta_key($page_meta_key_img, $data->id) != '')

                                    <div class="image mt-2">

                                        <img src="{{ dsld_uploaded_file_path(dsld_page_meta_value_by_meta_key($page_meta_key_img, $data->id)) }}"  alt="{{ dsld_upload_file_title(dsld_page_meta_value_by_meta_key($page_meta_key_img, $data->id)) }}" class="img-fluid" width="100">

                                    </div> 

                                    @endif
                                    
                                    <div class="{{ $page_meta_key_img }}">@if(@dsld_page_meta_value_by_meta_key($page_meta_key_img, $data->id) != '')<strong>Selected Image:</strong><i> {{ @dsld_page_meta_value_by_meta_key($page_meta_key_img, $data->id) }}</i>@endif</div>

                        

                                    <input type="hidden" class="{{ $page_meta_key_img }}" name="{{ $page_meta_key_img }}" id="banner" value="{{ dsld_page_meta_value_by_meta_key($page_meta_key_img, $data->id) }}" >

                                    

                                </div>

                                <small>Meta Key: {{ $page_meta_key_img }}</small>

                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6">

                                <div class="form-group">

                                    <input type="hidden" name="type[]" value="{{ $page_meta_key_content }}">

                                    <textarea name="{{ $page_meta_key_content }}" class="form-control" placeholder="Content" onchange="is_edited()">{{ dsld_page_meta_value_by_meta_key($page_meta_key_content, $data->id) }}</textarea>

                                    <small>Meta Key: {{ $page_meta_key_content }}</small>

                                </div>

                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6">

                                <div class="form-group">

                                    <input type="hidden" name="type[]" value="{{ $page_meta_key_btn }}">

                                    <input type="text" name="{{ $page_meta_key_btn }}" class="form-control" placeholder="Button name" onchange="is_edited()" value="{{ dsld_page_meta_value_by_meta_key($page_meta_key_btn, $data->id) }}" />

                                    <small>Meta Key: {{ $page_meta_key_btn }}</small>

                                </div>

                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6">

                                <div class="form-group">

                                    <input type="hidden" name="type[]" value="{{ $page_meta_key_link }}">

                                    <input type="text" name="{{ $page_meta_key_link }}" class="form-control" placeholder="Button link" onchange="is_edited()" value="{{ dsld_page_meta_value_by_meta_key($page_meta_key_link, $data->id) }}" />

                                    <small>Meta Key: {{ $page_meta_key_link }}</small>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            @elseif ($element->type == 'image_box_repeter')

            @php 

                $page_meta_key_repeter_heading = $page_meta_key."_heading";

                $page_meta_key_repeter_subheading = $page_meta_key."_subheading";

                $page_meta_key_repeter_img = $page_meta_key."_img";

                $page_meta_key_repeter_content = $page_meta_key."_content";

                $page_meta_key_repeter_btn = $page_meta_key."_btn";

                $page_meta_key_repeter_link = $page_meta_key."_link";

            @endphp

            <div class="row clearfix">

                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">

                        <label class="form-label">{{ ucfirst($element->label) }}</label>  

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-8">

                        <div class="text_repeter{{ $sec->id }}_{{ $key2 }}">



                            <input type="hidden" name="type[]" value="{{ $page_meta_key }}">



                            <input type="hidden" name="{{ $page_meta_key }}[]" value="{{ $page_meta_key_repeter_heading }}">

                            <input type="hidden" name="{{ $page_meta_key }}[]" value="{{ $page_meta_key_repeter_subheading }}">

                            <input type="hidden" name="{{ $page_meta_key }}[]" value="{{ $page_meta_key_repeter_img }}">

                            <input type="hidden" name="{{ $page_meta_key }}[]" value="{{ $page_meta_key_repeter_content }}">

                            <input type="hidden" name="{{ $page_meta_key }}[]" value="{{ $page_meta_key_repeter_btn }}">

                            <input type="hidden" name="{{ $page_meta_key }}[]" value="{{ $page_meta_key_repeter_link }}">



                            @if(dsld_page_meta_value_by_meta_key($page_meta_key_repeter_img, $data->id) != '')

                                @foreach(@json_decode(dsld_page_meta_value_by_meta_key($page_meta_key_repeter_img, $data->id), true) as $key3 => $value) 

                                    <div class="row clearfix">

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <input type="hidden" name="type[]" value="{{ $page_meta_key_repeter_heading }}">

                                                <input type="text" class="form-control"  name="{{ $page_meta_key_repeter_heading }}[]" placeholder="Heading" value="{{json_decode(dsld_page_meta_value_by_meta_key($page_meta_key_repeter_heading, $data->id), true)[$key3] }}">  

                                            </div>

                                        </div>

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                            <input type="hidden" name="type[]" value="{{ $page_meta_key_repeter_subheading }}"><input type="text" class="form-control"  name="{{ $page_meta_key_repeter_subheading }}[]" placeholder="Sub Heading" value="{{json_decode(dsld_page_meta_value_by_meta_key($page_meta_key_repeter_subheading, $data->id), true)[$key3] }}">  

                                            </div>

                                        </div>

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                            <input type="hidden" name="type[]" value="{{ $page_meta_key_repeter_content }}"><input type="text" class="form-control"  name="{{ $page_meta_key_repeter_content }}[]" placeholder="Content" value="{{json_decode(dsld_page_meta_value_by_meta_key($page_meta_key_repeter_content, $data->id), true)[$key3] }}">  

                                            </div>

                                        </div>

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <input type="hidden" name="type[]" value="{{ $page_meta_key_repeter_img }}">



                                                <label class="form-label">Banner </label><a class="btn btn-primary text-white" onclick="media_file_get('{{ json_decode(dsld_page_meta_value_by_meta_key($page_meta_key_repeter_img, $data->id), true)[$key3] }}','{{ $page_meta_key_repeter_img }}{{$key3}}', 0)"><i class="zmdi zmdi-collection-image"></i></a><div class="{{ $page_meta_key_repeter_img }}{{$key3}}">@if(isset(json_decode(dsld_page_meta_value_by_meta_key($page_meta_key_repeter_img, $data->id), true)[$key3]))<strong>Selected Image:</strong><i> {{ @json_decode(dsld_page_meta_value_by_meta_key($page_meta_key_repeter_img, $data->id), true)[$key3] }}</i>@endif</div>

                        

                                                <input type="hidden" class="{{ $page_meta_key_repeter_img }}{{$key3}}" name="{{ $page_meta_key_repeter_img }}[]" id="banner" value="{{ json_decode(dsld_page_meta_value_by_meta_key($page_meta_key_repeter_img, $data->id), true)[$key3] }}" >



                                            

                                                @if(json_decode(dsld_page_meta_value_by_meta_key($page_meta_key_repeter_img, $data->id), true)[$key3] != "")

                                                <div class="image mt-2">

                                                    <img src="{{ dsld_uploaded_file_path(json_decode(dsld_page_meta_value_by_meta_key($page_meta_key_repeter_img, $data->id), true)[$key3]) }}"  alt="{{ dsld_upload_file_title(json_decode(dsld_page_meta_value_by_meta_key($page_meta_key_repeter_img, $data->id), true)[$key3]) }}" class="img-fluid" width="100">

                                                </div> 

                                                @endif 

                                            </div>

                                        </div>

                                        

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                            <input type="hidden" name="type[]" value="{{ $page_meta_key_repeter_btn }}"><input type="text" class="form-control"  name="{{ $page_meta_key_repeter_btn }}[]" placeholder="Button Name" value="{{json_decode(dsld_page_meta_value_by_meta_key($page_meta_key_repeter_btn, $data->id), true)[$key3] }}">  

                                            </div>

                                        </div>

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                            <input type="hidden" name="type[]" value="{{ $page_meta_key_repeter_link }}"><input type="text" class="form-control"  name="{{ $page_meta_key_repeter_link }}[]" placeholder="Button Link" value="{{json_decode(dsld_page_meta_value_by_meta_key($page_meta_key_repeter_link, $data->id), true)[$key3] }}">  

                                            </div>

                                        </div>

                                        <div class="col-sm-12">

                                            <button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row">

                                                <i class="zmdi zmdi-hc-fw"></i>

                                            </button>

                                        </div>

                                    </div>

                                @endforeach

                            @endif

                        </div>

                        <small>Meta Key: {{ $page_meta_key }}</small><br>

                        <small>

                            {{ $page_meta_key_repeter_heading }}<br>

                            {{ $page_meta_key_repeter_subheading }}<br>

                            {{ $page_meta_key_repeter_content }}<br>

                            {{ $page_meta_key_repeter_img }}<br>

                            {{ $page_meta_key_repeter_btn }}<br>

                            {{ $page_meta_key_repeter_link }}<br>

                        </small>

                    </div>

                </div>

                <div class="row clearfix">

                    <div class="col-lg-2 col-md-2 col-sm-4">

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-10">

                        <div class="input-group mb-4">

                            <button

                                type="button"

                                class="btn btn-primary addMoreBtn"

                                data-toggle="add-more"

                                data-content='<div class="row clearfix">

                                    <div class="col-sm-6">

                                        <div class="form-group">

                                            <input type="hidden" name="type[]" value="{{ $page_meta_key_repeter_heading }}">

                                            <input type="text" class="form-control"  name="{{ $page_meta_key_repeter_heading }}[]" placeholder="Heading">  

                                        </div>

                                    </div>

                                    <div class="col-sm-6">

                                        <div class="form-group">

                                        <input type="hidden" name="type[]" value="{{ $page_meta_key_repeter_subheading }}"><input type="text" class="form-control"  name="{{ $page_meta_key_repeter_subheading }}[]" placeholder="Sub Heading">  

                                        </div>

                                    </div>

                                    <div class="col-sm-6">

                                        <div class="form-group">

                                        <input type="hidden" name="type[]" value="{{ $page_meta_key_repeter_content }}"><input type="text" class="form-control"  name="{{ $page_meta_key_repeter_content }}[]" placeholder="Content">  

                                        </div>

                                    </div>

                                    <div class="col-sm-6">

                                        <div class="form-group">

                                            <input type="hidden" name="type[]" value="{{ $page_meta_key_repeter_img }}">



                                                <label class="form-label">Banner </label><a class="btn btn-primary text-white" onclick="media_file_get(`120`,`{{ $page_meta_key_repeter_img }}`, 0)"><i class="zmdi zmdi-collection-image"></i></a><div class="{{ $page_meta_key_repeter_img }}"></div>

                        

                                                <input type="hidden" class="{{ $page_meta_key_repeter_img }}" name="{{ $page_meta_key_repeter_img }}[]" id="banner" value="{{ dsld_page_meta_value_by_meta_key($page_meta_key, $data->id) }}" >



                                            

                                            @if(dsld_page_meta_value_by_meta_key($page_meta_key, $data->id) != "")

                                            <div class="image mt-2">

                                                <img src="{{ dsld_uploaded_file_path(dsld_page_meta_value_by_meta_key($page_meta_key, $data->id)) }}"  alt="{{ dsld_upload_file_title(dsld_page_meta_value_by_meta_key($page_meta_key, $data->id)) }}" class="img-fluid" width="100">

                                            </div> 

                                            @endif 

                                        </div>

                                    </div>

                                    

                                    <div class="col-sm-6">

                                        <div class="form-group">

                                        <input type="hidden" name="type[]" value="{{ $page_meta_key_repeter_btn }}"><input type="text" class="form-control"  name="{{ $page_meta_key_repeter_btn }}[]" placeholder="Button Name">  

                                        </div>

                                    </div>

                                    <div class="col-sm-6">

                                        <div class="form-group">

                                        <input type="hidden" name="type[]" value="{{ $page_meta_key_repeter_link }}"><input type="text" class="form-control"  name="{{ $page_meta_key_repeter_link }}[]" placeholder="Button Link">  

                                        </div>

                                    </div>

                                    <div class="col-sm-12">

                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row">

                                            <i class="zmdi zmdi-hc-fw"></i>

                                        </button>

                                    </div>

                                </div>'

                                data-target=".text_repeter{{ $sec->id }}_{{ $key2 }}">

                                <i class="zmdi zmdi-hc-fw"></i>

                            </button>

                        </div>

                    </div>

                </div>
@elseif ($element->type == 'image_repeter')

            @php 

                $page_meta_key_repeter_img = $page_meta_key."_img";

            @endphp

            <div class="row clearfix">

                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">

                        <label class="form-label">{{ ucfirst($element->label) }}</label>  

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-8">

                        <div class="text_repeter{{ $sec->id }}_{{ $key2 }}">

                            <input type="hidden" name="type[]" value="{{ $page_meta_key }}">

                            <input type="hidden" name="{{ $page_meta_key }}[]" value="{{ $page_meta_key_repeter_img }}">


                            @if(dsld_page_meta_value_by_meta_key($page_meta_key_repeter_img, $data->id) != '')

                                @foreach(@json_decode(dsld_page_meta_value_by_meta_key($page_meta_key_repeter_img, $data->id), true) as $key3 => $value) 

                                    <div class="row clearfix">
                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <input type="hidden" name="type[]" value="{{ $page_meta_key_repeter_img }}">



                                                <label class="form-label">Banner </label><a class="btn btn-primary text-white" onclick="media_file_get('{{ json_decode(dsld_page_meta_value_by_meta_key($page_meta_key_repeter_img, $data->id), true)[$key3] }}','{{ $page_meta_key_repeter_img }}{{$key3}}', 0)"><i class="zmdi zmdi-collection-image"></i></a><div class="{{ $page_meta_key_repeter_img }}{{$key3}}">@if(isset(json_decode(dsld_page_meta_value_by_meta_key($page_meta_key_repeter_img, $data->id), true)[$key3]))<strong>Selected Image:</strong><i> {{ @json_decode(dsld_page_meta_value_by_meta_key($page_meta_key_repeter_img, $data->id), true)[$key3] }}</i>@endif</div>


                                                <input type="hidden" class="{{ $page_meta_key_repeter_img }}{{$key3}}" name="{{ $page_meta_key_repeter_img }}[]" id="banner" value="{{ json_decode(dsld_page_meta_value_by_meta_key($page_meta_key_repeter_img, $data->id), true)[$key3] }}" >


                                                @if(json_decode(dsld_page_meta_value_by_meta_key($page_meta_key_repeter_img, $data->id), true)[$key3] != "")

                                                <div class="image mt-2">

                                                    <img src="{{ dsld_uploaded_file_path(json_decode(dsld_page_meta_value_by_meta_key($page_meta_key_repeter_img, $data->id), true)[$key3]) }}"  alt="{{ dsld_upload_file_title(json_decode(dsld_page_meta_value_by_meta_key($page_meta_key_repeter_img, $data->id), true)[$key3]) }}" class="img-fluid" width="100">

                                                </div> 

                                                @endif 

                                            </div>

                                        </div>

                                        <div class="col-sm-12">

                                            <button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row">

                                                <i class="zmdi zmdi-hc-fw"></i>

                                            </button>

                                        </div>

                                    </div>

                                @endforeach

                            @endif

                        </div>

                        <small>Meta Key: {{ $page_meta_key }}</small><br>

                        <small>

                            {{ $page_meta_key_repeter_img }}<br>

                        </small>

                    </div>

                </div>

                <div class="row clearfix">

                    <div class="col-lg-2 col-md-2 col-sm-4">

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-10">

                        <div class="input-group mb-4">

                            <button

                                type="button"

                                class="btn btn-primary addMoreBtn"

                                data-toggle="add-more"

                                data-content='<div class="row clearfix">

                                    <div class="col-sm-6">

                                        <div class="form-group">

                                            <input type="hidden" name="type[]" value="{{ $page_meta_key_repeter_img }}">

                                                <label class="form-label">Banner </label><a class="btn btn-primary text-white" onclick="media_file_get(`120`,`{{ $page_meta_key_repeter_img }}`, 0)"><i class="zmdi zmdi-collection-image"></i></a><div class="{{ $page_meta_key_repeter_img }}"></div>

                                                <input type="hidden" class="{{ $page_meta_key_repeter_img }}" name="{{ $page_meta_key_repeter_img }}[]" id="banner" value="{{ dsld_page_meta_value_by_meta_key($page_meta_key, $data->id) }}" >


                                            @if(dsld_page_meta_value_by_meta_key($page_meta_key, $data->id) != "")

                                            <div class="image mt-2">

                                                <img src="{{ dsld_uploaded_file_path(dsld_page_meta_value_by_meta_key($page_meta_key, $data->id)) }}"  alt="{{ dsld_upload_file_title(dsld_page_meta_value_by_meta_key($page_meta_key, $data->id)) }}" class="img-fluid" width="100">

                                            </div> 

                                            @endif 

                                        </div>

                                    </div>

                                    <div class="col-sm-12">

                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row">

                                            <i class="zmdi zmdi-hc-fw"></i>

                                        </button>

                                    </div>

                                </div>'

                                data-target=".text_repeter{{ $sec->id }}_{{ $key2 }}">

                                <i class="zmdi zmdi-hc-fw"></i>

                            </button>

                        </div>

                    </div>

                </div>
            @elseif ($element->type == 'thc_repeter')

            @php 

                $page_meta_key_repeter_heading = $page_meta_key."_heading";
                $page_meta_key_repeter_subheading = $page_meta_key."_subheading";
                $page_meta_key_repeter_content = $page_meta_key."_content";

            @endphp

            <div class="row clearfix">

                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">

                        <label class="form-label">{{ ucfirst($element->label) }}</label>  

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-8">

                        <div class="text_repeter{{ $sec->id }}_{{ $key2 }}">



                            <input type="hidden" name="type[]" value="{{ $page_meta_key }}">



                            <input type="hidden" name="{{ $page_meta_key }}[]" value="{{ $page_meta_key_repeter_heading }}">

                            <input type="hidden" name="{{ $page_meta_key }}[]" value="{{ $page_meta_key_repeter_subheading }}">

                            <input type="hidden" name="{{ $page_meta_key }}[]" value="{{ $page_meta_key_repeter_content }}">



                            @if(dsld_page_meta_value_by_meta_key($page_meta_key_repeter_heading, $data->id) != '')

                                @foreach(@json_decode(dsld_page_meta_value_by_meta_key($page_meta_key_repeter_heading, $data->id), true) as $key3 => $value) 

                                    <div class="row clearfix">

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <input type="hidden" name="type[]" value="{{ $page_meta_key_repeter_heading }}">

                                                <input type="text" class="form-control"  name="{{ $page_meta_key_repeter_heading }}[]" placeholder="Heading" value="{{json_decode(dsld_page_meta_value_by_meta_key($page_meta_key_repeter_heading, $data->id), true)[$key3] }}">  

                                            </div>

                                        </div>

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                            <input type="hidden" name="type[]" value="{{ $page_meta_key_repeter_subheading }}"><input type="text" class="form-control"  name="{{ $page_meta_key_repeter_subheading }}[]" placeholder="Sub Heading" value="{{json_decode(dsld_page_meta_value_by_meta_key($page_meta_key_repeter_subheading, $data->id), true)[$key3] }}">  

                                            </div>

                                        </div>

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                            <input type="hidden" name="type[]" value="{{ $page_meta_key_repeter_content }}"><input type="text" class="form-control"  name="{{ $page_meta_key_repeter_content }}[]" placeholder="Content" value="{{json_decode(dsld_page_meta_value_by_meta_key($page_meta_key_repeter_content, $data->id), true)[$key3] }}">  

                                            </div>

                                        </div>


                                        <div class="col-sm-12">

                                            <button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row">

                                                <i class="zmdi zmdi-hc-fw"></i>

                                            </button>

                                        </div>

                                    </div>

                                @endforeach

                            @endif

                        </div>

                        <small>Meta Key: {{ $page_meta_key }}</small><br>

                        <small>

                            {{ $page_meta_key_repeter_heading }}<br>

                            {{ $page_meta_key_repeter_subheading }}<br>

                            {{ $page_meta_key_repeter_content }}<br>


                        </small>

                    </div>

                </div>

                <div class="row clearfix">

                    <div class="col-lg-2 col-md-2 col-sm-4">

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-10">

                        <div class="input-group mb-4">

                            <button

                                type="button"

                                class="btn btn-primary addMoreBtn"

                                data-toggle="add-more"

                                data-content='<div class="row clearfix">

                                    <div class="col-sm-6">

                                        <div class="form-group">

                                            <input type="hidden" name="type[]" value="{{ $page_meta_key_repeter_heading }}">

                                            <input type="text" class="form-control"  name="{{ $page_meta_key_repeter_heading }}[]" placeholder="Heading">  

                                        </div>

                                    </div>

                                    <div class="col-sm-6">

                                        <div class="form-group">

                                        <input type="hidden" name="type[]" value="{{ $page_meta_key_repeter_subheading }}"><input type="text" class="form-control"  name="{{ $page_meta_key_repeter_subheading }}[]" placeholder="Sub Heading">  

                                        </div>

                                    </div>

                                    <div class="col-sm-6">

                                        <div class="form-group">

                                        <input type="hidden" name="type[]" value="{{ $page_meta_key_repeter_content }}"><input type="text" class="form-control"  name="{{ $page_meta_key_repeter_content }}[]" placeholder="Content">  

                                        </div>

                                    </div>

                                    <div class="col-sm-12">

                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row">

                                            <i class="zmdi zmdi-hc-fw"></i>

                                        </button>

                                    </div>

                                </div>'

                                data-target=".text_repeter{{ $sec->id }}_{{ $key2 }}">

                                <i class="zmdi zmdi-hc-fw"></i>

                            </button>

                        </div>

                    </div>

                </div>
            @elseif ($element->type == 'text_repeter')



                <div class="row clearfix">

                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">

                        <label class="form-label">{{ ucfirst($element->label) }}</label>  

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-8">

                        <div class="text_repeter{{ $sec->id }}_{{ $key2 }}">

                            <input type="hidden" name="type[]" value="{{ $page_meta_key }}">

                            

                            @if(dsld_page_meta_value_by_meta_key($page_meta_key, $data->id) != '')

                                @foreach(json_decode(dsld_page_meta_value_by_meta_key($page_meta_key, $data->id), true) as $key3 => $value) 

                                    

                                    <div class="row clearfix">

                                        <div class="col-sm-10">

                                            <div class="form-group">

                                                <input type="text" class="form-control"  name="{{ $page_meta_key }}[]" placeholder="{{ ucfirst($element->label) }}" value="{{ $value }}">  

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

                        <small>Meta Key: {{ $page_meta_key }}</small>

                    </div>

                </div>

                <div class="row clearfix">

                    <div class="col-lg-2 col-md-2 col-sm-4">

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-10">

                        <div class="input-group mb-4">

                            <button

                                type="button"

                                class="btn btn-primary addMoreBtn"

                                data-toggle="add-more"

                                data-content='<div class="row clearfix">

                                    <div class="col-sm-10">

                                        <div class="form-group"><input type="text" class="form-control"  name="{{ $page_meta_key }}[]" placeholder="{{ ucfirst($element->label) }}">  

                                        </div>

                                    </div>

                                    <div class="col-auto">

                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row">

                                            <i class="zmdi zmdi-hc-fw"></i>

                                        </button>

                                    </div>

                                </div>'

                                data-target=".text_repeter{{ $sec->id }}_{{ $key2 }}">

                                <i class="zmdi zmdi-hc-fw"></i>

                            </button>

                        </div><small>Meta Key: {{ $page_meta_key }}</small>

                    </div>

                </div>



            

            @elseif ($element->type == 'link_box')



                @php

                    $page_link_box_text = $page_meta_key."_text";

                    $page_link_box_color = $page_meta_key."_color";

                    $page_link_box_link = $page_meta_key."_link";

                    $page_link_box_block = $page_meta_key."_block";

                @endphp



                <div class="row clearfix">

                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">

                        <label class="form-label">{{ ucfirst($element->label) }}</label>  

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-8">

                        <div class="text_repeter{{ $sec->id }}_{{ $key2 }}">



                            <input type="hidden" name="type[]" value="{{ $page_meta_key }}">



                            <input type="hidden" name="{{ $page_meta_key }}[]" value="{{ $page_link_box_text }}">

                            <input type="hidden" name="{{ $page_meta_key }}[]" value="{{ $page_link_box_color }}">

                            <input type="hidden" name="{{ $page_meta_key }}[]" value="{{ $page_link_box_link }}">

                            <input type="hidden" name="{{ $page_meta_key }}[]" value="{{ $page_link_box_block }}">

                            

                            @if(dsld_page_meta_value_by_meta_key($page_link_box_text, $data->id) != '')

                                @foreach(json_decode(@dsld_page_meta_value_by_meta_key($page_link_box_text, $data->id), true) as $key3 => $value) 



                                <div class="row clearfix">



                                    <div class="col-sm-3">

                                        <div class="form-group">



                                            <input type="hidden" name="type[]" value="{{ $page_link_box_text }}">



                                            <input type="text" class="form-control"  name="{{ $page_link_box_text }}[]" placeholder="Text" @if($page_link_box_text !='') value="{{ json_decode(@dsld_page_meta_value_by_meta_key($page_link_box_text, $data->id), true)[$key3] }}" @endif> 



                                        </div>

                                    </div>



                                    <div class="col-sm-3">

                                        <div class="form-group">

                                            <input type="hidden" name="type[]" value="{{ $page_link_box_link }}">



                                            <input type="text" class="form-control"  name="{{ $page_link_box_link }}[]" placeholder="Link" value="{{ json_decode(@dsld_page_meta_value_by_meta_key($page_link_box_link, $data->id), true)[$key3] }}">  

                                        </div>

                                    </div>

                                    

                                    <div class="col-sm-3">

                                        <div class="form-group">

                                            <input type="hidden" name="type[]" value="{{ $page_link_box_color }}">



                                            <input type="text" class="form-control"  name="{{ $page_link_box_color }}[]" placeholder="Color Code" value="{{ json_decode(@dsld_page_meta_value_by_meta_key($page_link_box_color, $data->id), true)[$key3] }}">  

                                        </div>

                                    </div>

                                    

                                    <div class="col-sm-2">

                                        <div class="form-group">

                                            <input type="hidden" name="type[]" value="{{ $page_link_box_block }}">

                                            <div class="input-group">

                                                <select class="form-control" name="{{ $page_link_box_block }}[]">

                                                    <option value="block" @if(json_decode(@dsld_page_meta_value_by_meta_key($page_link_box_block, $data->id), true)[$key3] == 'block') Selected @endif>-- Block --</option>

                                                    <option value="inline"  @if(json_decode(@dsld_page_meta_value_by_meta_key($page_link_box_block, $data->id), true)[$key3] == 'inline') Selected @endif>-- Inline --</option>

                                            </select>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-sm-1">

                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row">

                                            <i class="zmdi zmdi-hc-fw"></i>

                                        </button>

                                    </div>



                                </div>



                                @endforeach

                            @endif

                        </div>

                        <small>Meta Key: {{ $page_meta_key }}</small>

                    </div>

                </div>

                <div class="row clearfix">

                    <div class="col-lg-2 col-md-2 col-sm-4">

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-10">

                        <div class="input-group mb-4">

                            <button

                                type="button"

                                class="btn btn-primary addMoreBtn"

                                data-toggle="add-more"

                                data-content='<div class="row clearfix">

                                    <div class="col-sm-3">

                                        <div class="form-group"><input type="hidden" name="type[]" value="{{ $page_link_box_text }}"><input type="text" class="form-control"  name="{{ $page_link_box_text }}[]" placeholder="Text">  

                                        </div>

                                    </div>  

                                    <div class="col-sm-3">

                                        <div class="form-group"><input type="hidden" name="type[]" value="{{ $page_link_box_link }}"><input type="text" class="form-control"  name="{{ $page_link_box_link }}[]" placeholder="Link">  

                                        </div>

                                    </div>

                                    <div class="col-sm-3">

                                        <div class="form-group">

                                            <div class="input-group"><input type="hidden" name="type[]" value="{{ $page_link_box_color }}">

                                                <input type="text" name="{{ $page_link_box_color }}[]" class="form-control" placeholder="Color Code" value="#991d1f">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-sm-2">

                                        <div class="form-group">

                                            <div class="input-group"><input type="hidden" name="type[]" value="{{ $page_link_box_block }}">

                                                <select class="form-control" name="{{ $page_link_box_block }}[]">

                                                    <option value="block">-- Block --</option>

                                                <option value="inline">-- Inline --</option>

                                            </select>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-sm-1">

                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row">

                                            <i class="zmdi zmdi-hc-fw"></i>

                                        </button>

                                    </div>

                                </div>'

                                data-target=".text_repeter{{ $sec->id }}_{{ $key2 }}">

                                <i class="zmdi zmdi-hc-fw"></i>

                            </button>

                        </div><small>Meta Key: {{ $page_meta_key }}</small>

                    </div>

                </div>

            

            @elseif ($element->type == 'file_repeter')



                <div class="row clearfix">

                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">

                        <label class="form-label">{{ ucfirst($element->label) }}</label>  

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-8">

                        <div class="file_repeter{{ $sec->id }}_{{ $key2 }}">

                            <div class="form-group">

                                <input type="hidden" name="type[]" value="{{ $page_meta_key }}">

                                <select class="form-control show-tick ms select2" name="{{ $page_meta_key }}[]" multiple>

                                    <option value="">-- Please select --</option>

                                    @foreach(App\Models\Upload::orderBy('id', 'Desc')->get() as $key => $value)

                                        <option value="{{ $value->id }}" @if(dsld_page_meta_value_by_meta_key($page_meta_key, $data->id) != 'Null') @if(is_array(json_decode(dsld_page_meta_value_by_meta_key($page_meta_key, $data->id), true)))@if(in_array($value->id, json_decode(dsld_page_meta_value_by_meta_key($page_meta_key, $data->id), true))) selected @endif @endif @endif>({{ $value->id }}) - {{ $value->file_title}} - {{ $value->extension}} </option>

                                    @endforeach

                                </select>

                                

                                @if(is_array(json_decode(dsld_page_meta_value_by_meta_key($page_meta_key, $data->id), true)) && count(json_decode(dsld_page_meta_value_by_meta_key($page_meta_key, $data->id), true)) > 0)

                                <div class="image mt-2">

                                    @foreach(json_decode(dsld_page_meta_value_by_meta_key($page_meta_key, $data->id), true) as $key => $value)

                                        <img src="{{ dsld_uploaded_file_path($value) }}"  alt="{{ dsld_upload_file_title($value) }}" class="img-fluid mr-2" width="100">

                                    @endforeach

                                    </div> 

                                @endif 

                            </div>

                        </div><small>Meta Key: {{ $page_meta_key }}</small>

                        

                    </div>

                </div>



            @elseif ($element->type == 'multi_select')



                <div class="row clearfix">

                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">

                        <label class="form-label">{{ ucfirst($element->label) }}</label>  

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-8">

                        <div class="file_repeter{{ $sec->id }}_{{ $key2 }}">

                            <div class="form-group">

                                <input type="hidden" name="type[]" value="{{ $page_meta_key }}">

                                <select class="form-control show-tick ms select2" name="{{ $page_meta_key }}[]"  multiple>

                                    <option value="">-- Please select --</option>

                                    @if (is_array(json_decode($element->options)))

                                        @foreach (json_decode($element->options) as $value)

                                            <option value="{{ $value }}" @if(dsld_page_meta_value_by_meta_key($page_meta_key, $data->id) != 'Null')  @if(in_array($value, json_decode(dsld_page_meta_value_by_meta_key($page_meta_key, $data->id), true))) selected @endif @endif>{{ $value }}</option>

                                        @endforeach

                                    @endif

                                </select>

                                

                            </div>

                        </div><small>Meta Key: {{ $page_meta_key }}</small>

                        

                    </div>

                </div>



            @elseif ($element->type == 'select' || $element->type == 'radio')



                <div class="row clearfix mb-2">

                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">

                        <label class="form-label">{{ ucfirst(str_replace('_', ' ', $element->type)) }}</label>  

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-8">

                        <div class="form-group">

                            <input type="hidden" name="type[]" value="{{ $page_meta_key }}">

                            <select class="form-control" name="{{ $page_meta_key }}">

                                <option value="">-- Please select --</option>

                                @if (is_array(json_decode($element->options)))

                                    @foreach (json_decode($element->options) as $value)

                                        <option value="{{ $value }}" @if($value == dsld_page_meta_value_by_meta_key($page_meta_key, $data->id)) selected @endif>{{ $value }}</option>

                                    @endforeach

                                @endif

                            </select>

                        </div><small>Meta Key: {{ $page_meta_key }}</small>

                    </div>

                </div>



            @elseif ($element->type == 'file')



                <div class="row clearfix">

                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">

                        <label class="form-label">{{ ucfirst($element->label) }}</label>  

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-8">

                        <div class="form-group">

                            <input type="hidden" name="type[]" value="{{ $page_meta_key }}">



                             <label class="form-label">Banner </label><a class="btn btn-primary text-white" onclick="media_file_get('{{ dsld_page_meta_value_by_meta_key($page_meta_key, $data->id) }}','{{ $page_meta_key }}', 0)"><i class="zmdi zmdi-collection-image"></i></a><div class="{{ $page_meta_key }}">@if(@dsld_page_meta_value_by_meta_key($page_meta_key, $data->id) != '')<strong>Selected Image:</strong><i> {{ @dsld_page_meta_value_by_meta_key($page_meta_key, $data->id) }}</i>@endif</div>

                        

                            <input type="hidden" class="{{ $page_meta_key }}" name="{{ $page_meta_key }}" id="banner" value="{{ dsld_page_meta_value_by_meta_key($page_meta_key, $data->id) }}" >

                            

                            @if(dsld_page_meta_value_by_meta_key($page_meta_key, $data->id) != '')

                            <div class="image mt-2">

                                <img src="{{ dsld_uploaded_file_path(dsld_page_meta_value_by_meta_key($page_meta_key, $data->id)) }}"  alt="{{ dsld_upload_file_title(dsld_page_meta_value_by_meta_key($page_meta_key, $data->id)) }}" class="img-fluid" width="100">

                            </div> 

                            @endif 

                        </div><small>Meta Key: {{ $page_meta_key }}</small>

                    </div>

                </div>



            @elseif ($element->type == 'button')



                <div class="row clearfix">

                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">

                        <label class="form-label">{{ ucfirst($element->label) }}</label>  

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-8">

                        <div class="form-group">

                            <input type="hidden" name="type[]" value="{{ $page_meta_key }}">

                            <input type="text" name="{{ $page_meta_key }}" class="form-control" placeholder="Url" onchange="is_edited()" value="{{ dsld_page_meta_value_by_meta_key($page_meta_key, $data->id) }}" />

                        </div><small>Meta Key: {{ $page_meta_key }}</small>

                    </div>

                </div>



            @elseif ($element->type == 'editor')



                <div class="row clearfix">

                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">

                        <label class="form-label">{{ ucfirst($element->label) }}</label>  

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-8">

                        <div class="form-group">

                            <input type="hidden" name="type[]" value="{{ $page_meta_key }}">

                            <textarea  class="summernote" name="{{ $page_meta_key }}"><?php $str = dsld_page_meta_value_by_meta_key($page_meta_key, $data->id); echo htmlspecialchars_decode($str); ?></textarea >  

                        </div><small>Meta Key: {{ $page_meta_key }}</small>

                    </div>

                </div>

            @endif

        @endforeach

        @endif

        <div class="row clearfix">

            <div class="col-lg-12 col-md-12 col-sm-12 form-control-label">

                <div class="swal-button-container">

                    <button type="submit" class="btn btn-success btn-round waves-effect dsld-btn-loader" id="submit_btn">Update</button>

                </div>

            </div>

        </div>



</form>

<script type="text/javascript">

    $(function(){

    $('[data-toggle="add-more"]').each(function () {

        var $this = $(this);

        var content = $this.data("content");

        var target = $this.data("target");



        $this.on("click", function (e) {

            e.preventDefault();

            $(target).append(content);

        });

    });

});

    $(".summernote").summernote('code');

    $('.select2').select2({

        dropdownParent: $('.form-group')

    });

    

        

    



</script>