@extends('backend.layouts.app')
@section('header')
<link rel="stylesheet" href="{{ dsld_static_asset('backend/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
<style>
  .bootstrap-tagsinput {
    border: 1px solid #cbcbcb !important;
    width: 100%;
  }
</style> 
@endsection 

@section('content')


<!-- Exportable Table -->

  <div class="row clearfix">
    <div class="col-lg-12"> 
      <div class="card project_list">
        <div class="row">
            <div class="col-lg-4">
                <button class="btn btn-info btn-round mb-4" onclick="reload_table_room_details()"><i class="zmdi zmdi-hc-fw"></i> Reload</button>
            </div>
            <div class="col-lg-4">
                <div class="form-group">                                
                    <select class="form-control" name="sort" onchange="reload_table_room_details()">
                        <option value="newest">New to Old</option>
                        <option value="oldest">Old to New</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-inline">                                 
                    <input type="text" class="form-control w-100" name="search" onblur="reload_table_room_details()" placeholder="Search..">
                </div>
            </div>
        </div>
        <div class="row" id="table_room_details_data">
        </div>
        <!-- <div class="table-responsive">
            <table class="table table-hover c_table theme-color">
                <thead>
                    <tr>           
                        <th width="10%">S.N.</th>                            
                        <th width="40%">Room Details</th>                                       
                        <th width="20%">Team</th>
                        <th width="10%">Remark</th>
                        <th width="10%">Status</th>
                        <th width="10%">Date</th>
                    </tr>
                </thead>
                <tbody id="table_room_details_data"></tbody>
            </table>
        </div> -->
    </div>
    </div>
    <!-- <div class="col-lg-4">
        <form id="update_form" action="{{ route('rooms.update') }}" method="POST" enctype="multipart/form-data">
            @csrf 
            <input type="hidden" name="id" id="id" value="{{ $data->id }}" />
            <div class="card mb-0">
                <div class="header">
                <h2>
                    <strong>Publish</strong>
                </h2>
                </div>
                <div class="body">
                    <div class="form-group">
                        <label class="form-label">Name <small class="text-danger">*</small></label>                                 
                        <input type="text" name="name" class="form-control" placeholder="Name"  onchange="is_edited()" @if($data->name) value="{{ $data->name }}" @endif  />                                   
                    </div>
                <div class="form-group">
                    <div class="form-group">
                        <label class="form-label">Remark <small class="text-danger">*</small></label>                                 
                        <input type="text" name="remark" class="form-control" placeholder="Remark" onchange="is_edited()" @if($data->remark) value="{{ $data->remark }}" @endif  />                                   
                    </div>
                </div>
                <div class="swal-button-container">
                    <button type="submit" class="btn btn-success btn-round waves-effect dsld-btn-loader" id="submit_btn" disabled="disabled">Update</button>
                </div>
                <button type="button" class="btn btn-danger btn-round waves-effect" onclick="DSLDDeleteAlert('{{ $data->id }}','{{ route('pages.destory') }}','{{ csrf_token() }}')">
                    <i class="zmdi zmdi-delete"></i>
                </button>
                </div>
            </div>
            <div class="card mb-0">
                <div class="header">
                <h2>
                    <strong>Banner</strong>
                </h2>
                </div>
                <div class="body">
                <div class="form-group">
                    <label class="form-label">Banner </label>
                    <a class="btn btn-primary text-white" onclick="media_file_get('{{ @$data->banner }}','put_image_banner', 0)">
                    <i class="zmdi zmdi-collection-image"></i>
                    </a>
                    <div class="put_image_banner">@if(isset($data->banner)) <strong>Selected Image:</strong>
                    <i> {{ @$data->banner }}</i>@endif
                    </div>
                    <input type="hidden" class="put_image_banner" name="banner" id="banner" value="{{ @$data->banner }}" onchange="is_edited()"> @if($data->banner > 0) <div class="image mt-2">
                    <img src="{{ dsld_uploaded_file_path($data->banner) }}" alt="{{ dsld_upload_file_title($data->banner) }}" class="img-fluid">
                    </div> @endif
                </div>
                </div>
            </div>
        </form>
    </div> -->
  </div>


@endsection 
@section('footer')

 <!--Edit Section-->
 <div class="modal fade" id="edit_larger_modals" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="edit_larger_modals_title"></h4>
                </div>
                <form id="ajax_update_form" action="{{ route('rooms.details.update') }}" method="POST" enctype="multipart/form-data" >
                @csrf 
                <div class="modal-body">
                    <div id="edit_larger_modals_body">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                    <div class="swal-button-container">
                        <button type="submit" class="btn btn-success btn-round waves-effect dsld-btn-loader">UPDATE</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!--Edit Section-->

    <script>
        reload_table_room_details();
         function edit_lg_modal_form(id, route, name, room_id){
            $('#edit_larger_modals_body').html('');
            $('#edit_larger_modals').modal('show');
            $('#edit_larger_modals_title').text(name);
            $.ajax({
                url: route,
                type: "post",
                cache : false,
                data: {
                    '_token':'{{ csrf_token() }}',
                    'id': id,
                    'room_id': room_id 
                },
                success: function(d) {
                    $('#edit_larger_modals_body').html(d);
                }
            });
        }
         function reload_table_room_details(){
            var search = $('input[name=search]').val();
            var sort = $('select[name=sort]').val();
            $.ajax({
                url: '{{ route("rooms.table.details") }}',
                type: "post",
                cache : false,
                data: {'_token':'{{ csrf_token() }}', 'room_id': '{{ $data->id }}', 'search': search,'sort': sort},
                success: function(d) {
                    $('#table_room_details_data').html(d);
                }
            });
        }

        
    $(document).ready(function(){
        $('#ajax_update_form').on('submit', function(event){
        event.preventDefault();
            var Loader = "#ajax_update_form .dsld-btn-loader";

            DSLDButtonLoader(Loader, "start");
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                cache : false,
                data: $(this).serialize(),
                success: function(data) {
                    DSLDButtonLoader(Loader, "");
                    dsldFlashNotification(data['status'], data['message']);
                    
                    $('#ajax_update_form .dsld-btn-loader').removeClass('btnloading');
                    if(data['status'] =='success'){
                        $('#edit_larger_modals').modal('hide');
                        reload_table_room_details();
                    }
                }
            });
        });
    });
    function is_edited(){
        $('#submit_btn').removeAttr('disabled');
    }    
    $(document).ready(function(){
        $('#update_form').on('submit', function(event){
        event.preventDefault();
            var Loader = "#update_form .dsld-btn-loader";
            DSLDButtonLoader(Loader, "start");
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                cache : false,
                data: $(this).serialize(),
                success: function(data) {
                    DSLDButtonLoader(Loader, "");
                    dsldFlashNotification(data['status'], data['message']);
                    
                    $('#update_form .dsld-btn-loader').removeClass('btnloading');
                    if(data['status'] =='success'){
                        location.reload();
                    }
                }
            });
        });
    });
    </script>


@endsection