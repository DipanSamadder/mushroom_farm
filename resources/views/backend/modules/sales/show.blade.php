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
                    <div class="col-lg-9">
                        <button class="btn btn-primary btn-round mb-4" data-toggle="modal" data-target="#sales_add_modals"><i class="zmdi zmdi-hc-fw"></i> Add Sale</button>
                        <button class="btn btn-warning btn-round mb-4"  onclick="stock_lg_modal_form()"><i class="zmdi zmdi-hc-fw"></i> Today Stocks</button>
                        <button class="btn btn-info btn-round mb-4" onclick="get_pages();"><i class="zmdi zmdi-hc-fw"></i> Reload</button>
                    </div>

                    <div class="col-lg-3">
                        <form class="form-inline" id="search_media">
                            <div class="col-lg-12 form-group">                                
                                <select class="form-control" name="sort" onchange="filter()">
                                    <option value="all" selected>All</option>
                                    <option value="today">Today</option>
                                    <option value="yesterday">Yesterday</option>
                                    <option value="newest">Date (New to Old)</option>
                                    <option value="oldest">Date (Old to New)</option>
                                </select>
                            </div>
                            <!-- <div class="col-lg-6 form-group">                                    
                                <input type="text" class="form-control w-100" name="search" onblur="filter()" placeholder="Search..">
                            </div> -->
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

        <div class="modal-dialog modal-lg" style="max-width: 1200px;" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h4 class="title" id="sales_edit_modals_title"></h4>

                    <button type="button" class="btn btn-danger waves-effect" style="padding: 5px 10px; border-radius: 25px;" data-dismiss="modal">X</button>

                </div>

                <div class="modal-body">

                    <div id="sales_edit_modals_body">

                    </div>

                </div>
            </div>

        </div>

    </div>
    <!--Edit Section-->

    <!--Sale Section-->
    <div class="modal fade" id="sales_add_modals" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title">Add Sale</h4>
                    <button type="button" class="btn btn-danger waves-effect" style="padding: 5px 10px; border-radius: 25px;" data-dismiss="modal">X</button>
                </div>
             
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Select Vendor<small class="text-danger">*</small></label>        
                        <select class="form-control show-tick ms select2" name="vendor_id" onChange="change_room()">
                            <option value="">Select Vendor</option>
                            @if(App\Models\User::where('user_type', 'vendors')->where('banned', 0)->get() != '')
                                @foreach(App\Models\User::where('user_type', 'vendors')->where('banned', 0)->get() as $key => $value)
                                    <option value="{{ $value->id }}" @if(dsld_vendor_today_check($value->id) > 0) disabled @endif >{{ $value->name }} ({{ @$value->vendor->framesType->name }}) - @if(dsld_vendor_today_check($value->id) > 0) Solded @endif</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    @if($grades)
                    @foreach($grades as $key => $grade)

                    @if(dsld_total_stock(@$grade->id) > 0)
                    <div class="col-sm-12">
                        <form id="sale_update_form_{{ $grade->id }}" action="javascript:void(0);" method="POST" enctype="multipart/form-data">
                            @csrf 
                            <input type="hidden" name="grades_id" value="{{ $grade->id }}">
                            <input type="hidden" name="vendor_id" class="input_vendor_id" value="{{ @$data->vendor_id }}">

                            <div class="row row_id_{{ @$grade->id }}">  
                                <div class="col-sm-3"> 
                                    <small>{{ @$grade->name }}</small> <small class="text-warning">(<strong class="qty_total_{{ @$grade->id }}">{{ dsld_total_stock(@$grade->id) }}</strong> kg)</small><br><small>Date : {{ date('d-m-Y')}}</small>
                                </div>  
                                <div class="col-sm-2">
                                    <input type="number" name="qty" class="form-control quantity-input qty_id_{{ @$grade->id }}" placeholder="Qty"  maxlength="{{ dsld_total_stock(@$grade->id) }}" onchange="change_sales_qty_items('{{ @$grade->id }}');"/>
                                </div>   
                                <div class="col-sm-2">
                                    <input type="number" name="grades_rate" class="form-control quantity-input grades_rate_{{ @$grade->id }}" placeholder="Grades Rate"  onchange="change_sales_rate_items('{{ @$grade->id }}')" value="{{ $grade->rate }}"/>
                                </div> 
                                <div class="col-sm-3">                          
                                    <small>Total Price: </small> <span class="badge bg-info text-white sale_rate_{{ $grade->id }}"></span><br> 
                                </div>  
                                <div class="col-sm-2">
                                    <button type="submit" class="btn btn-success me-1 mb-1 btn-round btn_grade_{{ $grade->id }}" style="font-size: 11px;width: 95px;padding: 10px 2px" onclick="update_sale_wise_price('{{ $grade->id }}')">
                                        <span style="width: 12px;height: 12px;" role="status" aria-hidden="true"></span>
                                        Update
                                    </button>
                                </div>                              
                            </div>
                            <hr>
                        </form>
                    </div>
                    @endif
                    
                    @endforeach
                    @endif
                     
                </div>
                
            </div>
        </div>
    </div>
    <!--Edit Section-->

    <!--Stock Section-->
    <div class="modal fade" id="stock_modals" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title">Today Stock</h4>
                    <button type="button" class="btn btn-danger waves-effect" style="padding: 5px 10px; border-radius: 25px;" data-dismiss="modal">X</button>
                </div>
                <div class="modal-body">
                    <div id="stock_modals_stock_table">
                    </div>  
                </div>
            </div>
        </div>
    </div>
    <!--Stock Section-->
    

    <input type="hidden" name="page_no" id="page_no" value="1">
    <input type="hidden" name="get_pages" id="get_pages" value="{{ route('ajax_sale_dashboard') }}">
    @include('backend.inc.crul_ajax')

    <script>
    function stock_lg_modal_form(){
        $('#stock_modals_stock_table').html('');
        $('#stock_modals').modal('show');
        $.ajax({
            url: "{{ route('sale.stock.view') }}",
            type: "get",
            cache : false,
            data: {
                '_token':'{{ csrf_token() }}',
            },
            success: function(d) {
                $('#stock_modals_stock_table').html(d);
            }
        });
    }
    function sale_edit_lg_modal_form(rid, gid, route, name){
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
    /**
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
    */

   function change_room(){
    var vendor_id = $('select[name="vendor_id"]').val();
    $('.input_vendor_id').val(vendor_id);
   }
</script>

    
<script>
    function change_sales_qty_items(id){
        checkQtySum(id);
        checkQtyWisePrice(id);
    }

    function change_sales_rate_items(id){
        checkQtyWisePrice(id);
    }

    function checkQtySum(id){
        var total = $('.qty_total_'+id).text();
        var qty = $('.qty_id_'+id).val();
  
        if(parseInt(total) >= parseInt(qty)){
            $('.btn_grade_'+id).attr('disabled', false);
            $('.row_id_'+id).removeClass("bg-danger");
        }else{
            $('.btn_grade_'+id).attr('disabled', true);
            $('.row_id_'+id).addClass("bg-danger");
        }
    }
   
    function checkQtyWisePrice(id){
        var qty = $('.qty_id_'+id).val();
        var grade = $('.grades_rate_'+id).val();
        $('.sale_rate_'+id).text(qty*grade);
    }

    function update_sale_wise_price(gread_id){
        $('.btn_grade_'+gread_id+'> span').addClass('spinner-border');
        $.ajax({
            url: "{{ route('sale.store') }}",
            type: $("#sale_update_form_"+gread_id).attr('method'),
            cache : false,
            data: $("#sale_update_form_"+gread_id).serialize(),
            success: function(data) {
                dsldFlashNotification(data['status'], data['message']);
                $('#sale_update_form_'+gread_id+' .dsld-btn-loader').removeClass('btnloading');
                if(data['status'] =='success'){
                    $('.btn_grade_'+gread_id+' span').removeClass('spinner-border');
                }
            }
        });


    }
</script>
@endsection