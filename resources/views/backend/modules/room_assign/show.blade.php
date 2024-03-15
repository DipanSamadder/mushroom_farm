@extends('backend.layouts.app')



@section('header')

<style>

    .table tbody td, .table tbody th {padding: 0.25rem 0.55rem;}



</style>





@endsection



@section('content')

@php

$name = 'page';

if(isset($page) && !empty($page['name'])){

    $name = $page['name'];

}

@endphp

 <!-- Exportable Table -->

 <div class="row clearfix">

    @if(dsld_check_permission(['add-room-assign']))

    <div class="col-lg-8">

    @else

    <div class="col-lg-12">

    @endif

        <div class="card">

            <div class="header">

                <h2><strong>All</strong> {{ $name }}s </h2>

            </div>

            <div class="body">

                <div class="row">

                    <div class="col-lg-4">

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

    <div class="col-lg-4">

        @if(dsld_check_permission(['add-room-assign']))

        <div class="card">

            <div class="header">

                <h2><strong>Add New</strong> {{ $name }}s </h2>

            </div>

            <div class="body">

                <div class="row">

                    <div class="col-lg-12">

                        <form id="add_new_form" action="{{ route('room_assign.store') }}" method="POST" enctype="multipart/form-data" >

                            <input type="hidden" name="created_by" value="{{ Auth::user()->id }}">

                            @csrf 

                            <div class="modal-body">
                                <div class="row clearfix">

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Room Select <small class="text-danger">*</small></label>        
                                            <select class="form-control show-tick ms select2" name="room_history_id">
                                                <option value="">Select Room</option>
                                                @if(App\Models\RoomHistory::where('status', 1)->get() != '')
                                                    @foreach(App\Models\RoomHistory::where('status', 1)->get() as $key => $value)
                                                        <option value="{{ $value->id }}">{{ $value->rooms->name }} ({{ date('d-m-Y', strtotime($value->start_date)) }})</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Labours Type <small class="text-danger">*</small></label>        
                                            <select class="form-control show-tick ms select2" name="labours_type" onchange="fatch_labures()">
                                                <option value="0">Select Type</option>
                                                @if(App\Models\LabourRate::where('status', 1)->get() != '')
                                                    @foreach(App\Models\LabourRate::where('status', 1)->get() as $key => $value)
                                                        <option value="{{ $value->id }}" >{{ $value->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Labour <small class="text-danger">*</small> <span id="emp-loading"></span></label>        
                                            <select class="form-control show-tick ms select2" name="employee_id[]" id="employe" multiple>
                                                <option value="0" disabled>Select Labour</option>
                                            
                                            </select>  
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="swal-button-container">
                                            <button type="submit" class="btn btn-success btn-round waves-effect dsld-btn-loader">SUBMIT</button>
                                        </div>
                                    </div>
                                    
                                </div>  
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>

</div>

@endsection



@section('footer')

<script src="{{ dsld_static_asset('backend/assets/js/pages/forms/advanced-form-elements.js') }}"></script>
    <!--Edit Section-->

    <div class="modal fade" id="edit_larger_modals" tabindex="-1" role="dialog">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h4 class="title" id="edit_larger_modals_title"></h4>

                    <button type="button" class="btn btn-danger waves-effect" style="padding: 5px 10px; border-radius: 25px;" data-dismiss="modal">X</button>

                </div>

                <form id="update_form" action="{{ route('room_assign.update') }}" method="POST" enctype="multipart/form-data" >

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





    <input type="hidden" name="page_no" id="page_no" value="1">

    <input type="hidden" name="get_pages" id="get_pages" value="{{ route('ajax_room_assign') }}">

    @include('backend.inc.crul_ajax')


    <script>
      
        function fatch_labures(){
            
            $('#emp-loading').html("<span class='text-danger'>loading..</span>");
            var id = $('select[name=labours_type]').val();
            $.ajax({
                url: "{{ route('room_assign.employee.find') }}",
                type: "post",
                cache : false,
                data: {
                    '_token':'{{ csrf_token() }}',
                    'id': id,
                },
                success: function(d) {
                    console.log(d.data);
                       // Clear existing options from Select2
                    $('#employe').empty().trigger('change');

                    // Add new options to Select2
                    $.each(d.data, function (index, value) {
                        $('#employe').append(new Option(value.user.name, value.user_id, false, false));
                    });

                    // Trigger Select2 to update the UI
                    $('#employe').trigger('change');
                    $('#emp-loading').html("<span class='text-success'>Updated</span>");
                }
            });
        }

    </script>
    
@endsection