@extends('backend.layouts.app')

@section('header')
<link rel="stylesheet" href="{{ dsld_static_asset('backend/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
<style>
    .bootstrap-tagsinput{    border: 1px solid #cbcbcb !important;width: 100%;}
</style>
@endsection

@section('content')
 <!-- Exportable Table -->
 <form id="update_form" action="{{ route('users.update') }}" method="POST" enctype="multipart/form-data" >
    <div class="row clearfix">
        <div class="col-lg-8">
            @csrf 
            <input type="hidden" name="id" id="id" value="{{ $data->id }}" />
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
                            <label class="form-label">Roll</label>  
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8">
                            <div class="form-group">
                            <select class="form-control" name="role" id="role" onchange="is_edited()">
                                <option value="">-- Please select --</option>
                                @foreach(App\Models\Role::whereNotIn('id', [1])->get() as $key => $value)
                                    <option value="{{ $value->id }}" @if($data->hasRole($value->id) ==  1) selected @endif> {{ $value->name}} </option>
                                @endforeach
                            </select> 
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
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                        </div>
                        <input type="date" name="date" id="date" class="form-control" onchange="is_edited()" value="{{  date('Y-m-d', strtotime($data->created_at)) }}">
                    </div>
                    <div class="swal-button-container">
                        <button type="submit" class="btn btn-success btn-round waves-effect dsld-btn-loader" id="submit_btn" disabled="disabled">Update</button>
                    </div>
                    <button type="button" class="btn btn-danger btn-round waves-effect" onclick="DSLDDeleteAlert('{{ $data->id }}','{{ route('users.destory') }}','{{ csrf_token() }}')"><i class="zmdi zmdi-delete"></i></button>
                </div>
            </div>
            <div class="card mb-0">
                <div class="header">
                    <h2><strong>Profile</strong></h2>                        
                </div>
                <div class="body">
                    <div class="form-group">
                        <label class="form-label">Profile</label>
                        <select class="form-control show-tick ms select2" name="avatar_original" id="avatar_original" onchange="is_edited()">
                            <option value="">-- Please select --</option>
                            @foreach(App\Models\Upload::where('mime_type', 'like', 'image'.'%')->get() as $key => $value)
                                <option value="{{ $value->id }}" @if($data->avatar_original == $value->id) selected @endif>({{ $value->id }}) - {{ $value->file_title}} </option>
                            @endforeach
                        </select>
                        @if($data->avatar_original > 0)
                        <div class="image mt-2">
                            <img src="{{ dsld_uploaded_asset($data->avatar_original) }}"  alt="{{ dsld_upload_file_title($data->avatar_original) }}" class="img-fluid">
                        </div> 
                        @endif                                                            
                    </div>
                </div>
            </div>
        </div> 
    </div>
</form>
 <div class="card mb-0">
    <div class="header">
        <h2><strong> <i class="zmdi zmdi-hc-fw"></i> Permissions</strong></h2>
    </div>
        <div class="body">
            <div class="row">
                <div class="col-lg-4">
                    <button class="btn btn-info btn-round mb-4" onclick="get_permissions();"><i class="zmdi zmdi-hc-fw"></i> Reload</button>
                </div>
                <div class="col-lg-8">
                    <form class="form-inline" id="search_media_permissions">
                        <div class="col-lg-6 form-group">                                
                            <select class="form-control" name="sort_permissions" onchange="filter_permissions()">
                                <option value="newest">New to Old</option>
                                <option value="oldest">Old to New</option>
                                <option value="active">Active</option>
                                <option value="deactive">Deactive</option>
                            </select>
                        </div>
                        <div class="col-lg-6 form-group">                                    
                            <input type="text" class="form-control w-100" name="search_permissions" onblur="filter_permissions()" placeholder="Search..">
                        </div>
                    </form><br>  
                </div>
            </div>
            <div class="table-responsive">
                <div id="data_table"></div>
            </div>
        </div>
</div>
 <input type="hidden" name="page_no_permissions" id="page_no_permissions" value="1">
@endsection

@section('footer')

<script>


    function get_permissions(){
        var search_permissions = $('input[name=search_permissions]').val();
        var sort_permissions = $('select[name=sort_permissions]').val();
        var page_permissions = $('#page_no_permissions').val();
        $('#data_table').html('<center><img src="{{ dsld_static_asset('backend/assets/images/circle-loading.gif') }}" style="max-width:100px" ></center>');

        $.ajax({
            url: "{{ route('users.show_permissions') }}",
            type: "post",
            cache : false,
            data: {
                    '_token':'{{ csrf_token() }}',
                    'user_id':'{{ $data->id }}',
                    'search': search_permissions,
                    'page': page_permissions,
                    'sort': sort_permissions
                },
            success: function(d) {
                $('#data_table').html(d);
            }
        });
    }

    $(document).ready(function(){
        $('#page_no').val(1);
        //get_pages();
        get_permissions();
    });
    function filter(){
        $('#page_no').val(1);
        get_pages();
    } 
    function filter_permissions(){
        $('#page_no_permissions').val(1);
        get_permissions();
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
            get_permissions();
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
    function get_pages(){
        get_permissions();
    }

</script>
@endsection