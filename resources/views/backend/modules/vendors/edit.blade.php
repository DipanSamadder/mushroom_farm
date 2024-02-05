@extends('backend.layouts.app')

@section('header')
<link rel="stylesheet" href="{{ dsld_static_asset('backend/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
<style>
    .bootstrap-tagsinput{    border: 1px solid #cbcbcb !important;width: 100%;}
</style>
@endsection

@section('content')
 <!-- Exportable Table -->
 <form id="update_form" action="{{ route('vendor.update') }}" method="POST" enctype="multipart/form-data" >
    <div class="row clearfix">
        <div class="col-lg-8">
            @csrf 
            <input type="hidden" name="id" id="id" value="{{ $data->id }}" />
            <input type="hidden" name="role" id="role" value="8" />

            <div class="card mb-0">
                <div class="header">
                    <h2><strong> <i class="zmdi zmdi-hc-fw"></i> {{ $data->name }}</strong></h2>
                </div>
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                            <label class="form-label">Name <small class="text-danger">*</small></label>  
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8">
                            <div class="form-group">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name" onchange="is_edited()" value="{{ $data->name }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                            <label class="form-label">Email <small class="text-danger">*</small></label>  
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8">
                            <div class="form-group">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email" onchange="is_edited()" value="{{ $data->email }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                            <label class="form-label">Phone <small class="text-danger">*</small></label>  
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8">
                            <div class="form-group">
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone" onchange="is_edited()" value="{{ $data->phone }}" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                            <label class="form-label">Aadhaar Card <small class="text-danger">*</small></label>  
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8">
                            <div class="form-group">
                            <input type="number" name="aadhar" id="aadhar" class="form-control" placeholder="Aadhaar Card" onchange="is_edited()" value="{{ @$data->vendor->aadhar }}" />
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                            <label class="form-label">Bank </label>  
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8">
                            <div class="form-group">
                            <textarea name="bank_details" id="bank_details" class="form-control" placeholder="Bank Detials" onchange="is_edited()">{{ @$data->vendor->bank_details }}</textarea>
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
                        <label class="form-label">Status <small class="text-danger">*</small></label>                                 
                        <select class="form-control" name="banned" id="banned" onchange="is_edited()">
                            <option value="">-- Please select --</option>
                            <option value="0" @if($data->status == 0) selected @endif>Active</option>
                            <option value="1" @if($data->status == 1) selected @endif>Deactive</option>
                        </select>                             
                    </div>
                    <div class="input-group">  
                        <label class="form-label">Publish Date <small class="text-danger">*</small></label>                            
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
                    <button type="button" class="btn btn-danger btn-round waves-effect" onclick="DSLDDeleteAlert('{{ $data->id }}','{{ route('vendor.destory') }}','{{ csrf_token() }}')"><i class="zmdi zmdi-delete"></i></button>
                </div>
            </div>
            <div class="card mb-0">
                <div class="header">
                    <h2><strong>Profile</strong></h2>                        
                </div>
                <div class="body">
                    <div class="form-group">
                        <label class="form-label">Profile </label><a class="btn btn-primary text-white" onclick="media_file_get('{{ @$data->banner }}','put_image_banner', 0)"><i class="zmdi zmdi-collection-image"></i></a> @if($data->avatar_original > 0)
                        <div class="image mt-2 d-inline" >
                            <img src="{{ dsld_uploaded_file_path($data->avatar_original) }}"  alt="{{ dsld_upload_file_title($data->avatar_original) }}" style="width: 50px;" class="put_image_banner">
                        </div> 
                        @endif  
                        <div class="put_image_banner">@if(isset($data->avatar_original))<strong>Selected Image:</strong><i> {{ @$data->avatar_original }}</i> @if($data->avatar_original > 0)<span class="badge badge-danger" style="cursor: pointer;" onclick="clear_media_file('.put_image_banner')">X</span>@endif  @endif</div>

                        

                        <input type="hidden" class="put_image_banner" name="avatar_original" id="avatar_original" value="{{ @$data->avatar_original }}" onchange="is_edited()">

                                                                                   
                    </div>
                </div>
            </div>
        </div> 
    </div>
</form>

 <input type="hidden" name="page_no_permissions" id="page_no_permissions" value="1">
@endsection

@section('footer')

<script>

    $(document).ready(function(){
        $('#page_no').val(1);
    });
    function filter(){
        $('#page_no').val(1);
        get_pages();
    } 
   
    $(document).ready(function()
{
        $(document).on('click', '.pagination a',function(event)
        {
            $('li').removeClass('active');
            $(this).parent('li').addClass('active');
            event.preventDefault();
            var myurl = $(this).attr('href');
            var page=$(this).attr('href').split('page=')[1];
            $('#page_no').val(page);
        });
    });

</script>

<script src="{{ dsld_static_asset('backend/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
<script>
    
    $(document).ready(function(){
        $('#update_form').on('submit', function(event){
        event.preventDefault();
            $('.dsld-btn-loader').addClass('btnloading');
            var Loader = ".btnloading";
            DSLDButtonLoader(Loader, "start");
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                cache : false,
                data: {
                    '_token':'{{ csrf_token() }}', 
                    'user_id':'{{ Auth::user()->id }}',
                    'id': $('#id').val(),
                    'name': $('#name').val(),
                    'phone': $('#phone').val(),
                    'user_type': $('#user_type').val(),
                    'email': $('#email').val(),
                    'date': $('#date').val(),
                    'banned': $('#banned').val(),
                    'aadhar': $('#aadhar').val(),
                    'type': $('#type').val(),
                    'bank_details': $('#bank_details').val(),
                    'avatar_original': $('#avatar_original').val(),
                    'role': $('#role').val()
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

</script>
@endsection