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
    @if(dsld_check_permission(['add-expenditure']))
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
        @if(dsld_check_permission(['add-expenditure']))
        <div class="card">
            <div class="header">
                <h2><strong>Add New</strong> {{ $name }}s </h2>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-lg-12">
                        <form id="add_new_form" action="{{ route('expenditure.store') }}" method="POST" enctype="multipart/form-data" >
                            <input type="hidden" name="created_by" value="{{ Auth::user()->id }}">
                            @csrf 
                            <div class="modal-body">
                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">Date of Invoice <small class="text-danger">*</small></label>                                 
                                            <input type="date" name="invoice_date" class="form-control" placeholder="Invoice Date" value="{{ date('Y-m-d') }}"/>                                   
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">Date of Delivery <small class="text-danger">*</small></label>                                 
                                            <input type="date" name="delivery_date" class="form-control" placeholder="Delivery Date" value="{{ date('Y-m-d') }}"/>                                   
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Purpose <small class="text-danger">*</small></label>                                 
                                            <input type="text" name="purpose" class="form-control" placeholder="Purpose" />                                   
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Qty <small class="text-danger">*</small></label>                                 
                                            <input type="text" name="qty" class="form-control" placeholder="Qty" />                                   
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">Type of Work <small class="text-danger">*</small></label>                                 
                                            <select class="form-control demo-select2-placeholder" name="work_type">
                                                <option value="service">Service</option>
                                                <option value="purchase">Purchase</option>
                                            </select>                                
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">Amount <small class="text-danger">*</small></label>                                 
                                            <input type="text" name="amount" class="form-control" placeholder="Amount"/>                                   
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Vendor Name</label>                                 
                                            <select class="form-control demo-select2-placeholder" name="vendor_id">
                                                @if(App\Models\User::where('user_type', 'employer')->get())
                                                    @foreach(App\Models\User::where('user_type', 'employer')->get() as $key => $type)
                                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                    @endforeach
                                                @endif
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
    <!--Edit Section-->
    <div class="modal fade" id="edit_larger_modals" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="edit_larger_modals_title"></h4>
                    <button type="button" class="btn btn-danger waves-effect" style="padding: 5px 10px; border-radius: 25px;" data-dismiss="modal">X</button>
                </div>
                <form id="update_form" action="{{ route('expenditure.update') }}" method="POST" enctype="multipart/form-data" >
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
    <input type="hidden" name="get_pages" id="get_pages" value="{{ route('ajax_expenditure') }}">
    @include('backend.inc.crul_ajax')
@endsection