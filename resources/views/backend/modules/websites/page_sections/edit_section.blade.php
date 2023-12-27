@extends('backend.layouts.app')



@section('header')

<link rel="stylesheet" href="{{ dsld_static_asset('backend/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">

<style>

    .bootstrap-tagsinput{    border: 1px solid #cbcbcb !important;width: 100%;}

    section.content {background: #ffe4e4;}

</style>

@endsection



@section('content')

 <!-- Exportable Table -->

 <form id="update_form" action="{{ route('pages_section_fields.update') }}" method="POST" enctype="multipart/form-data" >

    <div class="row clearfix">

        <div class="col-lg-8">

            @csrf 

            <input type="hidden" name="id" id="id" value="{{ $data->id }}" />

            <div class="card mb-0">

                <div class="header">

                    <h2><strong> <i class="zmdi zmdi-hc-fw"></i> {{ $data->title }}</strong></h2>

                </div>

                <div class="body">

                    <div id="form_elements">

                        @if($data->meta_fields != '')

                        @foreach (json_decode($data->meta_fields) as $key => $element)

                        

								@if ($element->type == 'text' || $element->type == 'image_box'  || $element->type == 'vission_mession' || $element->type =='album_id'  || $element->type == 'message' || $element->type == 'link_box' || $element->type == 'program' || $element->type == 'faculty' || $element->type == 'image_box_repeter'  || $element->type == 'image_repeter' || $element->type == 'thc_repeter' || $element->type == 'button' || $element->type == 'editor' || $element->type == 'file' || $element->type == 'text_repeter' || $element->type == 'file_repeter')

								

									<div class="row clearfix  mb-2">

									    <input type="hidden" name="type[]" value="{{ $element->type }}">

									    <div class="col-lg-3">

									        <label class="col-from-label">{{ ucfirst(str_replace('_', ' ', $element->type)) }}</label>

									    </div>

									    <div class="col-lg-7">

									        <input class="form-control" type="text" name="label[]" value="{{ $element->label }}" placeholder="Label" onchange="is_edited()">

									    </div>

									    <div class="col-lg-2"><button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button></div>

									</div>



								@elseif ($element->type == 'select' || $element->type == 'multi_select' || $element->type == 'radio')





									<div class="row clearfix mb-2">

									    <input type="hidden" name="type[]" value="{{ $element->type }}">

									    <input type="hidden" name="option[]" class="option" value="{{ $key }}">

									    <div class="col-lg-3">

									        <label class="col-from-label">{{ ucfirst(str_replace('_', ' ', $element->type)) }}</label>

									    </div>

									    <div class="col-lg-7">

									        <input class="form-control" type="text" name="label[]" value="{{ $element->label }}" placeholder="Select Label" style="margin-bottom:10px" onchange="is_edited()">

									        <div class="customer_choice_options_types_wrap_child">



												@if (is_array(json_decode($element->options)))

													@foreach (json_decode($element->options) as $value)

														<div class="row clearfix mb-2">

														    <div class="col-sm-6 col-sm-offset-4">

														        <input class="form-control" type="text" name="options_{{ $key }}[]" value="{{ $value }}" required="" onchange="is_edited()">

														    </div>

														    <div class="col-sm-2"> <button type="button" class="btn btn-sm btn-info" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button></div>

														</div>

													@endforeach

												@endif



											</div>

									        <button class="btn btn-info pull-right" type="button" onclick="add_customer_choice_options(this)"><i class="glyphicon glyphicon-plus"></i> Add option</button>

									    </div>

									    <div class="col-lg-2"><button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button></div>

									</div>



								@endif

							@endforeach

                        @endif

                    </div>

                    <div class="row clearfix">

                        <div class="col-lg-12 col-md-12 col-sm-12 form-control-label">

                            <div class="swal-button-container">

                                <button type="submit" class="btn btn-success btn-round waves-effect dsld-btn-loader" id="submit_btn" >Update</button>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card mb-0">

                <div class="header">

                    <h2><strong>All Fields</strong></h2>                        

                </div>

                <div class="body">

                    <ul class="list-group">

                        <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('text')">Text Input</li>

                        <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('text_repeter')">Text Input Repeter</li>

                        <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('editor')">Editor</li>

                        <!-- <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('select')">Select</li>

                        <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('multi-select')">Multiple Select</li> -->

                        <!-- <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('radio')">Radio</li> -->

                        <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('file')">File</li>

                        <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('file_repeter')">File Repeter</li>

                        <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('button')">Button</li>

                        <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('image_box')">Image Box</li>

                        <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('image_box_repeter')">Image Box Repeter</li>

                        <!-- <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('faculty')">Faculty</li>

                        <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('program')">Program</li> -->


                        <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('link_box')">link Box</li>

                        <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('image_repeter')">Image Repeter</li>

                        <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('thc_repeter')">Text Heading Content Repeter</li>
                        <!-- <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('mission')">Mission</li> -->

                        <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('message')">Message</li>

                        <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('vission_mession')">Vission & Mession</li>

                        <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('album_id')">Album ID</li>

                        

                    </ul>

                </div>

            </div>

        </div> 

    </div>

</form>

@endsection



@section('footer')



<script src="{{ dsld_static_asset('backend/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>



<script type="text/javascript">

    var i = 0;

    function  appendToForm(type){

        is_edited();

        if(type == 'text'){

            var str = '<div class="row clearfix mb-2">'

                            +'<div class="col-sm-3">'

                                +'<input type="hidden" name="type[]" value="text">'

                                +'<label class="col-from-label">Text</label>'

                            +'</div>'

                            +'<div class="col-sm-7">'

                                +'<input class="form-control" type="text" name="label[]" placeholder="Label" onchange="is_edited()">'

                            +'</div>'

                            +'<div class="col-sm-2">'

                                +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'

                            +'</div>'

                        +'</div>';

            $('#form_elements').append(str);

        }else if(type == 'faculty'){

            var str = '<div class="row clearfix mb-2">'

                            +'<div class="col-sm-3">'

                                +'<input type="hidden" name="type[]" value="faculty">'

                                +'<label class="col-from-label">Message</label>'

                            +'</div>'

                            +'<div class="col-sm-7">'

                                +'<input class="form-control" type="text" name="label[]" placeholder="Label" onchange="is_edited()">'

                            +'</div>'

                            +'<div class="col-sm-2">'

                                +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'

                            +'</div>'

                        +'</div>';

            $('#form_elements').append(str);

        }else if(type == 'album_id'){

            var str = '<div class="row clearfix mb-2">'

                            +'<div class="col-sm-3">'

                                +'<input type="hidden" name="type[]" value="album_id">'

                                +'<label class="col-from-label">Album ID</label>'

                            +'</div>'

                            +'<div class="col-sm-7">'

                                +'<input class="form-control" type="text" name="label[]" placeholder="Label" onchange="is_edited()">'

                            +'</div>'

                            +'<div class="col-sm-2">'

                                +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'

                            +'</div>'

                        +'</div>';

            $('#form_elements').append(str);

      

        }else if(type == 'vission_mession'){

            var str = '<div class="row clearfix mb-2">'

                            +'<div class="col-sm-3">'

                                +'<input type="hidden" name="type[]" value="vission_mession">'

                                +'<label class="col-from-label">Mission</label>'

                            +'</div>'

                            +'<div class="col-sm-7">'

                                +'<input class="form-control" type="text" name="label[]" placeholder="Label" onchange="is_edited()">'

                            +'</div>'

                            +'<div class="col-sm-2">'

                                +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'

                            +'</div>'

                        +'</div>';

            $('#form_elements').append(str);

      

        }else if(type == 'message'){

            var str = '<div class="row clearfix mb-2">'

                            +'<div class="col-sm-3">'

                                +'<input type="hidden" name="type[]" value="message">'

                                +'<label class="col-from-label">Message</label>'

                            +'</div>'

                            +'<div class="col-sm-7">'

                                +'<input class="form-control" type="text" name="label[]" placeholder="Label" onchange="is_edited()">'

                            +'</div>'

                            +'<div class="col-sm-2">'

                                +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'

                            +'</div>'

                        +'</div>';

            $('#form_elements').append(str);

      

         }else if(type == 'link_box'){

            var str = '<div class="row clearfix mb-2">'

                            +'<div class="col-sm-3">'

                                +'<input type="hidden" name="type[]" value="link_box">'

                                +'<label class="col-from-label">Link Box</label>'

                            +'</div>'

                            +'<div class="col-sm-7">'

                                +'<input class="form-control" type="text" name="label[]" placeholder="Label" onchange="is_edited()">'

                            +'</div>'

                            +'<div class="col-sm-2">'

                                +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'

                            +'</div>'

                        +'</div>';

            $('#form_elements').append(str);

         }else if(type == 'thc_repeter'){

            var str = '<div class="row clearfix mb-2">'

                            +'<div class="col-sm-3">'

                                +'<input type="hidden" name="type[]" value="thc_repeter">'

                                +'<label class="col-from-label">Text Heading Content Repeter</label>'

                            +'</div>'

                            +'<div class="col-sm-7">'

                                +'<input class="form-control" type="text" name="label[]" placeholder="Label" onchange="is_edited()">'

                            +'</div>'

                            +'<div class="col-sm-2">'

                                +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'

                            +'</div>'

                        +'</div>';

            $('#form_elements').append(str);
        }else if(type == 'image_repeter'){

            var str = '<div class="row clearfix mb-2">'

                            +'<div class="col-sm-3">'

                                +'<input type="hidden" name="type[]" value="image_repeter">'

                                +'<label class="col-from-label">Image Repeter</label>'

                            +'</div>'

                            +'<div class="col-sm-7">'

                                +'<input class="form-control" type="text" name="label[]" placeholder="Label" onchange="is_edited()">'

                            +'</div>'

                            +'<div class="col-sm-2">'

                                +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'

                            +'</div>'

                        +'</div>';

            $('#form_elements').append(str);

        }else if(type == 'program'){

            var str = '<div class="row clearfix mb-2">'

                            +'<div class="col-sm-3">'

                                +'<input type="hidden" name="type[]" value="program">'

                                +'<label class="col-from-label">Program</label>'

                            +'</div>'

                            +'<div class="col-sm-7">'

                                +'<input class="form-control" type="text" name="label[]" placeholder="Label" onchange="is_edited()">'

                            +'</div>'

                            +'<div class="col-sm-2">'

                                +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'

                            +'</div>'

                        +'</div>';

            $('#form_elements').append(str);

        }else if(type == 'image_box'){

            var str = '<div class="row clearfix mb-2">'

                            +'<div class="col-sm-3">'

                                +'<input type="hidden" name="type[]" value="image_box">'

                                +'<label class="col-from-label">Image Box</label>'

                            +'</div>'

                            +'<div class="col-sm-7">'

                                +'<input class="form-control" type="text" name="label[]" placeholder="Label" onchange="is_edited()">'

                            +'</div>'

                            +'<div class="col-sm-2">'

                                +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'

                            +'</div>'

                        +'</div>';

            $('#form_elements').append(str);

        }else if(type == 'image_box_repeter'){

            var str = '<div class="row clearfix mb-2">'

                            +'<div class="col-sm-3">'

                                +'<input type="hidden" name="type[]" value="image_box_repeter">'

                                +'<label class="col-from-label">Image Box Repeter</label>'

                            +'</div>'

                            +'<div class="col-sm-7">'

                                +'<input class="form-control" type="text" name="label[]" placeholder="Label" onchange="is_edited()">'

                            +'</div>'

                            +'<div class="col-sm-2">'

                                +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'

                            +'</div>'

                        +'</div>';

            $('#form_elements').append(str);

        }  else if (type == 'text_repeter') {

            i++;

            var str = '<div class="row clearfix mb-2">'

                            +'<div class="col-sm-3">'

                                +'<input type="hidden" name="type[]" value="text_repeter">'

                                +'<label class="col-from-label">Text Repeter</label>'

                            +'</div>'

                            +'<div class="col-sm-7">'

                                +'<input class="form-control" type="text" name="label[]" placeholder="Label" onchange="is_edited()">'

                            +'</div>'

                            +'<div class="col-sm-2">'

                                +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'

                            +'</div>'

                        +'</div>';

            $('#form_elements').append(str);

        }

        else if (type == 'editor') {

            i++;

            var str = '<div class="row clearfix mb-2">'

                            +'<div class="col-sm-3">'

                                +'<input type="hidden" name="type[]" value="editor">'

                                +'<label class="col-from-label">Editor</label>'

                            +'</div>'

                            +'<div class="col-sm-7">'

                                +'<input class="form-control" type="text" name="label[]" placeholder="Editor Label" onchange="is_edited()">'

                            +'</div>'

                            +'<div class="col-sm-2">'

                                +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'

                            +'</div>'

                        +'</div>';

            $('#form_elements').append(str);

        }else if (type == 'select') {

            i++;

            var str = '<div class="row clearfix mb-2">'

                            +'<input type="hidden" name="type[]" value="select"><input type="hidden" name="option[]" class="option" value="'+i+'">'

                            +'<div class="col-sm-3">'

                                +'<label class="col-from-label">Select</label>'

                            +'</div>'

                            +'<div class="col-lg-7">'

                                +'<input class="form-control" type="text" name="label[]" placeholder="Select Label" style="margin-bottom:10px" onchange="is_edited()">'

                                +'<div class="customer_choice_options_types_wrap_child">'



                                +'</div>'

                                +'<button class="btn btn-sm btn-info" type="button" onclick="add_customer_choice_options(this)"><i class="glyphicon glyphicon-plus"></i> Add option</button>'

                            +'</div>'

                            +'<div class="col-lg-2">'

                                +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'

                            +'</div>'

                        +'</div>';

            $('#form_elements').append(str);

        }

        else if (type == 'multi-select') {

            i++;

            var str = '<div class="row clearfix mb-2">'

                            +'<input type="hidden" name="type[]" value="multi_select"><input type="hidden" name="option[]" class="option" value="'+i+'">'

                            +'<div class="col-lg-3">'

                                +'<label class="col-from-label">Multiple select</label>'

                            +'</div>'

                            +'<div class="col-lg-7">'

                                +'<input class="form-control" type="text" name="label[]" onchange="is_edited()" placeholder="Multiple Select Label" style="margin-bottom:10px">'

                                +'<div class="customer_choice_options_types_wrap_child">'



                                +'</div>'

                                +'<button class="btn btn-sm btn-info" type="button" onclick="add_customer_choice_options(this)"><i class="glyphicon glyphicon-plus"></i> Add option</button>'

                            +'</div>'

                            +'<div class="col-lg-2">'

                                +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'

                            +'</div>'

                        +'</div>';

            $('#form_elements').append(str);

        }

        else if (type == 'radio') {

            // i++;

            // var str = '<div class="row clearfix mb-2">'

            //                 +'<input type="hidden" name="type[]" value="radio"><input type="hidden" name="option[]" class="option" value="'+i+'">'

            //                 +'<div class="col-lg-3">'

            //                     +'<label class="col-from-label">Radio</label>'

            //                 +'</div>'

            //                 +'<div class="col-lg-7">'

            //                     +'<div class="customer_choice_options_types_wrap_child">'

            //                     +'<input class="form-control" type="text" name="label[]" onchange="is_edited()" placeholder="Radio Label" style="margin-bottom:10px">'



            //                     +'</div>'

            //                     +'<button class="btn btn-sm btn-info" type="button" onclick="add_customer_choice_options(this)"><i class="glyphicon glyphicon-plus"></i> Add option</button>'

            //                 +'</div>'

            //                 +'<div class="col-lg-2">'

            //                     +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'

            //                 +'</div>'

            //             +'</div>';

            // $('#form_elements').append(str);

        }

        else if (type == 'file') {

            var str = '<div class="row clearfix mb-2">'

                            +'<input type="hidden" name="type[]" value="file">'

                            +'<div class="col-lg-3">'

                                +'<label class="col-from-label">File</label>'

                            +'</div>'

                            +'<div class="col-lg-7">'

                                +'<input class="form-control" type="text" name="label[]" onchange="is_edited()" placeholder="Label">'

                            +'</div>'

                            +'<div class="col-lg-2">'

                                +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'

                            +'</div>'

                        +'</div>';

            $('#form_elements').append(str);

        }

        else if (type == 'file_repeter') {

            var str = '<div class="row clearfix mb-2">'

                            +'<input type="hidden" name="type[]" value="file_repeter">'

                            +'<div class="col-lg-3">'

                                +'<label class="col-from-label">File Repeter</label>'

                            +'</div>'

                            +'<div class="col-lg-7">'

                                +'<input class="form-control" type="text" name="label[]" onchange="is_edited()" placeholder="Label">'

                            +'</div>'

                            +'<div class="col-lg-2">'

                                +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'

                            +'</div>'

                        +'</div>';

            $('#form_elements').append(str);

        }

        else if (type == 'button') {

            var str = '<div class="row clearfix mb-2">'

                            +'<input type="hidden" name="type[]" value="button">'

                            +'<div class="col-lg-3">'

                                +'<label class="col-from-label">Button</label>'

                            +'</div>'

                            +'<div class="col-lg-7">'

                                +'<input class="form-control" type="text" name="label[]" onchange="is_edited()" placeholder="Label">'

                            +'</div>'

                            +'<div class="col-lg-2">'

                                +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'

                            +'</div>'

                        +'</div>';

            $('#form_elements').append(str);

        }

    }



    function add_customer_choice_options(em){

        var j = $(em).closest('.clearfix.row').find('.option').val();

        var str = '<div class="row clearfix mb-2 ">'

                        +'<div class="col-sm-6 col-sm-offset-4">'

                            +'<input class="form-control" type="text" name="options_'+j+'[]" value="" required>'

                        +'</div>'

                        +'<div class="col-sm-2"> <span class="btn btn-sm btn-primary" onchange="is_edited()" onclick="delete_choice_clearfix(this)"><i class="zmdi zmdi-hc-fw"></i></span>'

                        +'</div>'

                    +'</div>'

        $(em).parent().find('.customer_choice_options_types_wrap_child').append(str);

    }

    function delete_choice_clearfix(em){

        $(em).parent().parent().remove();

    }





   

    function is_edited(){

        $('#submit_btn').removeAttr('disabled');

    }

    function get_pages(){

        window.location.href = "{{ route('pages_section.index') }}";

    }





</script>

@endsection