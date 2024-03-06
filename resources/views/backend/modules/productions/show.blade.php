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

    @if(dsld_check_permission(['add-productions']))

    <div class="col-lg-9">

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

    <div class="col-lg-3">

        @if(dsld_check_permission(['add-productions']))

        <div class="card">

            <div class="header">

                <h2><strong>Add New</strong> {{ $name }}s </h2>

            </div>

            <div class="body">

                <div class="row">

                    <div class="col-lg-12">

                        <form id="add_new_form" action="{{ route('production.store') }}" method="POST" enctype="multipart/form-data" >

                            <input type="hidden" name="created_by" value="{{ Auth::user()->id }}">

                            @csrf 

                            <div class="modal-body">

                                <div class="row clearfix">

                                    <div class="col-sm-12">

                                        <div class="form-group">

                                            <label class="form-label">Status <small class="text-danger">*</small></label>        

                                            <select class="form-control demo-select2-placeholder" name="room_id">

                                                <option value="0">Select Room</option>

                                                @foreach(App\Models\Room::where('status', 1)->get() as $key => $value)

                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>

                                                @endforeach

                                            </select>

                                        </div>

                                    </div>

                                    @foreach(App\Models\Grade::where('status', 1)->get() as $key => $grade)

                                    <div class="col-sm-12">

                                        <input type="hidden" name="gid[]" value="{{ $grade->id }}">

                                        <div class="form-group">

                                            <label class="form-label">Stock Qty ({{ $grade->name }}) <small class="text-danger">*</small></label>                                 

                                            <input type="text" name="qty[]" class="form-control" placeholder="1"/>                                   

                                        </div>

                                    </div>

                                    @endforeach

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

    <!--Edit Section-->

    <div class="modal fade" id="edit_larger_modals" tabindex="-1" role="dialog">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h4 class="title" id="edit_larger_modals_title"></h4>

                    <button type="button" class="btn btn-danger waves-effect" style="padding: 5px 10px; border-radius: 25px;" data-dismiss="modal">X</button>

                </div>

                <form id="update_form" action="{{ route('production.store') }}" method="POST" enctype="multipart/form-data" >

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

    <!--Sale Section-->

    <div class="modal fade" id="sales_edit_modals" tabindex="-1" role="dialog">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h4 class="title" id="sales_edit_modals_title"></h4>

                    <button type="button" class="btn btn-danger waves-effect" style="padding: 5px 10px; border-radius: 25px;" data-dismiss="modal">X</button>

                </div>

                <form id="sale_update_form" action="{{ route('sale.store') }}" method="POST" enctype="multipart/form-data" >

                @csrf 

                <div class="modal-body">

                    <div id="sales_edit_modals_body">

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

    <input type="hidden" name="get_pages" id="get_pages" value="{{ route('ajax_production') }}">

    @include('backend.inc.crul_ajax')



    <script>



    function sale_edit_lg_modal_form(rid,gid, route, name){

        $('#sales_edit_modals_body').html('');

        $('#sales_edit_modals').modal('show');

        $('#sales_edit_modals_title').text('Edit '+name);

        $.ajax({

            url: route,

            type: "post",

            cache : false,

            data: {

                '_token':'{{ csrf_token() }}',

                'rid': rid,

                'gid': gid,

            },

            success: function(d) {

                $('#sales_edit_modals_body').html(d);

            }

        });

    }





    $(document).ready(function(){

        $('#sale_update_form').on('submit', function(event){

        event.preventDefault();

            var Loader = "#sale_update_form .dsld-btn-loader";



            DSLDButtonLoader(Loader, "start");

            $.ajax({

                url: $(this).attr('action'),

                type: $(this).attr('method'),

                cache : false,

                data: $(this).serialize(),

                success: function(data) {

                    DSLDButtonLoader(Loader, "");

                    dsldFlashNotification(data['status'], data['message']);

                    

                    $('#sale_update_form .dsld-btn-loader').removeClass('btnloading');

                    if(data['status'] =='success'){

                        get_pages();

                        $('#sales_edit_modals').modal('hide');

                    }

                }

            });

        });

    });

</script>

@endsection