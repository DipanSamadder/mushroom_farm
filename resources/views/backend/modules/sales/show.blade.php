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

@endphp
<div class="row clearfix">
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card widget_2 big_icon traffic">
            <div class="body">
                <h6>Today Sales</h6>
                <h2>20 <small class="info">of 1Tb</small></h2>
                <div class="progress">
                    <div class="progress-bar l-amber" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card widget_2 big_icon sales">
            <div class="body">
                <h6>Yesterday Sales</h6>
                <h2>12% <small class="info">of 100</small></h2>
                <div class="progress">
                    <div class="progress-bar l-blue" role="progressbar" aria-valuenow="38" aria-valuemin="0" aria-valuemax="100" style="width: 38%;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card widget_2 big_icon email">
            <div class="body">
                <h6>Stocks</h6>
                <h2>39 <small class="info">of 100</small></h2>
                <div class="progress">
                    <div class="progress-bar l-purple" role="progressbar" aria-valuenow="39" aria-valuemin="0" aria-valuemax="100" style="width: 39%;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card widget_2 big_icon domains">
            <div class="body">
                <h6>Pending</h6>
                <h2>8 <small class="info">of 10</small></h2>
                <div class="progress">
                    <div class="progress-bar l-green" role="progressbar" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100" style="width: 89%;"></div>
                </div>
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

    <!--Sale Section-->

    <div class="modal fade" id="sales_edit_modals" tabindex="-1" role="dialog">

        <div class="modal-dialog modal-lg" role="document">

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

    <input type="hidden" name="get_pages" id="get_pages" value="{{ route('ajax_sale_dashboard') }}">

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