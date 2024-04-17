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
                        <option value="oldest" selected>Old to New</option>
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
 <!--Add Section-->
 <div class="modal fade" id="add_larger_modals" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="add_larger_modals_title"></h4>
            </div>
            <form id="ajax_room_add_form" action="{{ route('rooms.details.update') }}" method="POST" enctype="multipart/form-data" >
            @csrf 
            <input type="hidden" name="room_histories_id" id="get_room_histories_id" value="{{ $data->id }}">
            <input type="hidden" name="room_id" value="{{ $data->rooms->id }}">
            <div class="modal-body">
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Cycle <small class="text-danger">*</small> <small id="cycle-loading"></small></label>  
                                <select class="form-control show-tick ms select2 cycle_id" name="cycle_id" id="update_cycle">
                                        <option value="0" disabled>Select Cycle</option>
                                        
                                   {{-- 
                                    @if(App\Models\Cycle::orderby('id', 'asc')->get() != '')
                                        @foreach(App\Models\Cycle::orderby('id', 'asc')->get() as $key => $value)
                                            <option value="{{ $value->id }}">({{ $value->day}} days) {{ $value->name }}</option>
                                        @endforeach
                                    @endif
                                    --}}
                                </select>                                
                            </div>
                        </div>
                        
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Remark</label>                                 
                                <input type="text" name="remark" class="form-control" placeholder="Remark"/>                                   
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Status <small class="text-danger">*</small></label>        
                                <select class="form-control demo-select2-placeholder" name="status">
                                    <option value="0">Pending</option>
                                    <option value="1">Running</option>
                                    <option value="2">Done</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="checkbox">
                                <input type="checkbox" id="add_is_delay" name="add_is_delay" class="form-control"/> 
                                <label class="form-label" for="add_is_delay">Is Delay?</label> 
                            </div>
                        </div>
                    </div>
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
<!--Add Section-->


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

        
         $(".cycle_id").select2();
         
        function add_larger_modals(){
            $('#add_larger_modals_body').html('');
            $('#add_larger_modals').modal('show');
            $('#add_larger_modals_title').text("Menualy Add Cycle");
            var id = $('#get_room_histories_id').val();
            fatch_cycle(id, '#cycle-loading', '#update_cycle');
        }

        reload_table_room_details();

        function edit_lg_modal_form(id, route, name, room_histories_id){
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
                    'room_histories_id': room_histories_id 
                },
                success: function(d) {
                    $('#edit_larger_modals_body').html(d);
                    var id = $('#edit_room_histories_id').val();
                    fatch_cycle(id, '#cycle-loading-edit', '#cycle_id');
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


        
    $(document).ready(function(){

        $('#ajax_room_add_form').on('submit', function(event){

            event.preventDefault();
            var Loader = "#ajax_room_add_form .dsld-btn-loader";

            DSLDButtonLoader(Loader, "start");

            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                cache : false,
                data: $(this).serialize(),
                success: function(data) {
                    DSLDButtonLoader(Loader, "");
                    dsldFlashNotification(data['status'], data['message']);
                    
                    $('#ajax_room_add_form .dsld-btn-loader').removeClass('btnloading');
                    if(data['status'] =='success'){
                        $('#edit_larger_modals').modal('hide');
                        reload_table_room_details();
                    }
                }
            });
            
        });

    });
    
    function fatch_cycle(id, loading_id, append_id){
            
        $(loading_id).html("<span class='text-danger'>loading..</span>");
        
        $.ajax({
            url: "{{ route('rooms.details.pending_cycle') }}",
            type: "post",
            cache : false,
            data: {
                '_token':'{{ csrf_token() }}',
                'id': id,
            },
            success: function(d) {
                console.log(d.data);
                $(append_id).find('option:not(:first-child)').remove().end().trigger('change');

                $.each(d.data, function (index, value) {
                    $(append_id).append(new Option('('+ value.day + ' Days ) ' + value.name, value.id, false, false));
                });
                $(append_id).trigger('change');
                $(loading_id).html("<span class='text-success'>Updated</span>");
            }
        });
    }


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