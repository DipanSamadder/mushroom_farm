@extends('backend.layouts.app')

@section('header')
<style>
    .table tbody td, .table tbody th {padding: 0.25rem 0.55rem;}
    .table .bg_warging{background:#ff000012 !important}
</style>


@endsection

@section('content')
@php
$name = 'page';
if(isset($page) && !empty($page['name'])){
    $name = $page['name'];
}

$all_room = App\Models\Room::all();
$all_roomhistory = App\Models\RoomHistory::all();
@endphp

<div class="row clearfix">
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card widget_2 big_icon domains">
            <div class="body">
                <h6>Running</h6>
                <h2>{{ $all_roomhistory->where('status', 1)->count() }} <small class="info">of {{ $all_roomhistory->count() }} (Total History)</small></h2>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card widget_2 big_icon traffic">
            <div class="body">
                <h6>Occupid Rooms</h6>
                <h2>{{ $all_room->where('status', 1)->count() }} <small class="info"> out of {{ $all_room->count() }} (Total Room)</small></h2>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card widget_2 big_icon sales">
            <div class="body">
                <h6>Empty Room</h6>
                <h2>{{ $all_room->where('status', 0)->count() }} <small class="info"> out of {{ $all_room->count() }} (Total Room)</small></h2>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card widget_2 big_icon email">
            <div class="body">
                <h6>Done</h6>
                <h2>{{ $all_roomhistory->where('status', 2)->count() }} <small class="info">of {{ $all_roomhistory->count() }} (Total History)</small></h2>
            </div>
        </div>
    </div>
</div>
 <!-- Exportable Table -->
 <div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>All</strong> {{ $name }}s </h2>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-lg-4">
                        @if(dsld_check_permission(['add-room-history']))
                        <button class="btn btn-primary btn-round mb-4" data-toggle="modal" data-target="#add_larger_modals"><i class="zmdi zmdi-hc-fw"></i> Add New</button>
                        @endif
                        <button class="btn btn-info btn-round mb-4" onclick="get_pages();"><i class="zmdi zmdi-hc-fw"></i> Reload</button>
                    </div>
                    <div class="col-lg-8">
                        <form class="form-inline" id="search_media">
                            <div class="col-lg-6 form-group">                                
                                <select class="form-control" name="sort" onchange="filter()">
                                    <option value="newest">New to Old</option>
                                    <option value="oldest">Old to New</option>
                                </select>
                            </div>
                            <div class="col-lg-6 form-group">                                    
                                <input type="text" class="form-control w-100" name="search" onblur="filter()" placeholder="Search..">
                            </div>
                        </form><br>  
                    </div>
                </div>
                <div class="table-responsive">
                    <div id="data_table"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script src="{{ dsld_static_asset('backend/assets/js/pages/forms/advanced-form-elements.js') }}"></script>
    <!--Add Section-->
    <div class="modal fade" id="add_larger_modals" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6><strong>Add New</strong> {{ $name }}s </h6>
                </div>
                <form id="add_new_form" action="{{ route('rooms.history.store') }}" method="POST" enctype="multipart/form-data" >
                <input type="hidden" name="created_by" value="{{ Auth::user()->id }}">
                @csrf 
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-sm-12">

                            <div class="form-group">
                                <label class="form-label">Room Select <small class="text-danger">*</small></label>        
                                <select class="form-control show-tick ms select2" name="room_id">
                                    <option value="">Select Room</option>
                                    @if(App\Models\Room::where('status', 0)->get() != '')
                                        @foreach(App\Models\Room::where('status', 0)->get() as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                                </div>
                                <input type="date" name="start_date" id="start_date" class="form-control" onchange="is_edited()" value="{{  date('Y-m-d') }}">
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
                    <button type="button" class="btn btn-danger waves-effect" style="padding: 5px 10px; border-radius: 25px;" data-dismiss="modal">X</button>
                </div>
                <form id="update_form" action="{{ route('rooms.history.update') }}" method="POST" enctype="multipart/form-data" >
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

   <!--Switch Section-->
   <div class="modal fade" id="switch_edit_larger_modals" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="switch_edit_larger_modals_title"></h4>
                    <button type="button" class="btn btn-danger waves-effect" style="padding: 5px 10px; border-radius: 25px;" data-dismiss="modal">X</button>
                </div>
                <form id="switch_update_form" action="{{ route('production.store') }}" method="POST" enctype="multipart/form-data" >
                @csrf 
                <div class="modal-body">
                    <div id="switch_edit_larger_modals_body">
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
    <input type="hidden" name="page_no" id="page_no" value="1">
    <input type="hidden" name="get_pages" id="get_pages" value="{{ route('ajax_rooms_history') }}">
    @include('backend.inc.crul_ajax')

    
<script>

    function switch_edit_lg_modal_form(id, route, name){
        $('#switch_edit_larger_modals_body').html('');
        $('#switch_edit_larger_modals').modal('show');
        $('#switch_edit_larger_modals_title').text('Edit '+name);
        $.ajax({
            url: route,
            type: "post",
            cache : false,
            data: {
                '_token':'{{ csrf_token() }}',
                'id': id,
            },
            success: function(d) {
                $('#switch_edit_larger_modals_body').html(d);
            }
        });
    }


    $(document).ready(function(){
        $('#switch_update_form').on('submit', function(event){
        event.preventDefault();
            var Loader = "#switch_update_form .dsld-btn-loader";

            DSLDButtonLoader(Loader, "start");
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                cache : false,
                data: $(this).serialize(),
                success: function(data) {
                    DSLDButtonLoader(Loader, "");
                    dsldFlashNotification(data['status'], data['message']);
                    
                    $('#switch_update_form .dsld-btn-loader').removeClass('btnloading');
                    if(data['status'] =='success'){
                        get_pages();
                        $('#switch_edit_larger_modals').modal('hide');
                    }
                }
            });
        });
    });
</script>
@endsection