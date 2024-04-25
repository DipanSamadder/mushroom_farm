@php 
    $orderPending = App\Models\Order::where('vendor_id', $vendor)->orderBy('created_at', 'desc')->limit(10)->get();
    $hasPending = 0;
@endphp
<!-- Nav tabs -->
<ul class="nav nav-tabs p-0 mb-3">
    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home">TODAY PRODUCTS</a></li>
    <li class="nav-item"><a class="nav-link " data-toggle="tab" href="#invoice">CREATE INVOICE</a></li>
    <li class="nav-item"><a class="nav-link " data-toggle="tab" href="#order">ORDER</a></li>
    <li class="nav-item"><a class="nav-link " data-toggle="tab" href="#profile">PROFILE</a></li>
</ul>                        
<!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane in active" id="home">
        @if($grades)
            @foreach($grades as $key => $grade)

            @php 
                $grade_rate = 0;
                $buy_qty = 0;
                $buy_total = 0;
                $buy = 0;
                $startOfDay = Carbon\Carbon::today()->startOfDay();
                $endOfDay = Carbon\Carbon::today()->endOfDay();

                $sales = App\Models\Sale::where('grades_id', $grade->id)->where('vendor_id', $vendor)->whereBetween('created_at', [$startOfDay, $endOfDay])->first();

                if(!empty($sales)){
                    $buy= 1;
                    $grade_rate = $sales->grades_rate;
                    $buy_total = $sales->total;
                    $buy_qty = $sales->qty;
                }else{
                    $grade_rate = $grade->rate;
                }
            @endphp
            <div class="col-sm-12">
                <form id="sale_update_form_{{ $grade->id }}" action="javascript:void(0);" method="POST" enctype="multipart/form-data">
                @csrf 
                <input type="hidden" name="rooms_id" value="{{ @$orders->id }}">
                <input type="hidden" name="grades_id" value="{{ $grade->id }}">
                <input type="hidden" name="categories_id" value="{{ @$sales->categories_id }}">
                <input type="hidden" name="vendor_id" value="{{ $vendor }}">

                <div class="row edit_row_id_{{ @$grade->id }}" @if($buy==1) style="background: #cdffea;" @endif>  
                    <div class="col-sm-3"> 
                        <small>{{ @$grade->name }}</small><small> ({{ date('d-m-Y')}})</small><br><small class="text-warning">MS:<strong class="edit_qty_total_{{ @$grade->id }}">{{ dsld_total_stock_without_qty(@$grade->id, $buy_qty) }}</strong> KG | AS: {{ dsld_total_stock(@$grade->id)}} KG</small>
                    </div>  
                    <div class="col-sm-2">
                        <input type="number" name="qty" class="form-control quantity-input edit_qty_id_{{ @$grade->id }}" placeholder="Qty" value="{{ $buy_qty }}" maxlength="{{ dsld_total_stock(@$grade->id) }}" onchange="edit_change_sales_qty_items('{{ @$grade->id }}');"/>
                    </div>   
                    <div class="col-sm-2">
                        <input type="number" name="grades_rate" class="form-control quantity-input edit_grades_rate_{{ @$grade->id }}" placeholder="Grades Rate"  onchange="edit_change_sales_rate_items('{{ @$grade->id }}')" value="{{ $grade_rate }}"/>
                    </div> 
                    <div class="col-sm-3">                          
                        <small>Total Price: </small> <span class="badge bg-info text-white edit_sale_rate_{{ $grade->id }}">{{ $buy_total }} Rs</span><br> 
                    </div>  
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-success me-1 mb-1 btn-round edit_btn_grade_{{ $grade->id }}" style="font-size: 11px;width: 95px;padding: 10px 2px" onclick="update_sale_wise_price('{{ $grade->id }}')">
                            <span style="width: 12px;height: 12px;" role="status" aria-hidden="true"></span>
                            Update
                        </button>
                    </div>                              
                </div>
                <hr>
                </form>
            </div>
            
            @endforeach
            @endif
    </div>
    <div role="tabpanel" class="tab-pane" id="order">
    <table class="table table-bordered table-striped table-hover dataTable">
        <thead>
            <tr class="text-center thead-dark">
                <th>Sr</th>
                <th>Order</th>
                <th>Total</th>
                <th>Invoice</th>
            </tr>
        </thead>
        <tbody>
           
            @if(!Empty($orderPending))
                @foreach($orderPending as $okey => $order)
                @php 
                    if($order->paid == 0){
                        $hasPending = 1;
                    }
                     
                    $sales = App\Models\Sale::where('rooms_id', $order->id)->orderBy('created_at', 'desc')->limit(10)->get();
                @endphp
                    <tr>
                        <td>{{ $okey+1 }}</td>
                        <td>
                            @if(!Empty($sales)) 
                            @foreach($sales as $key => $sale)
                            <span class="badge bg-warning text-white">{{ $sale->grades->name }}</span> <small style="font-size:10px">Order Date: <strong>{{ date('d-m-Y', strtotime($order->created_at)) }}</strong> ( Qty:{{ $sale->qty }} X Rate:{{ $sale->rate }} = Total: Rs. {{ $sale->rate }}/- ) </small><br>
                            @endforeach 
                            @endif
                        </td>
                        <td>Rs. {{ $order->grand_total }}/-</td>
                        <td>@if($order->paid == 0) <span class="badge bg-danger text-white">Pending</span> @else <span class="badge bg-success text-white">Paid</span> @endif</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    </div>
    <div role="tabpanel" class="tab-pane" id="profile">
        <div class="card mcard_1">
            <div class="img">
                <img src="{{ dsld_static_asset('backend/assets/images/image-gallery/2.jpg') }}" class="img-fluid" alt="">
            </div>
            <div class="body">
                <div class="user">
                    @if($data->users->avatar_original > 0)
                        <img src="{{ dsld_uploaded_file_path($data->users->avatar_original) }}" style="width: 103px; height: 103px;" alt="{{ dsld_upload_file_title($data->users->avatar_original) }}" class="rounded-circle img-raised">
                    @else
                        <img src="{{ dsld_static_asset('backend/assets/images/xs/avatar1.jpg') }}" alt="Dummy Image" class="rounded-circle img-raised" style="width: 103px; height: 103px;">
                    @endif
                    
                    <h5 class="mt-3 mb-1">{{ @$data->users->name }}</h5>
                    <span>Email : {{ @$data->users->email }}</span>  <br> 
                    <span>Phone : {{ @$data->users->phone }}</span>                                
                </div>
            </div>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane mb-4" id="invoice">
        <hr>
        <form id="generate_inv_form"  action="javascript:void(0);" method="POST" enctype="multipart/form-data">
            @csrf  
            @php 
                $preBalance = 0;
                $balance = App\Models\Payment::where('vendor_id', $vendor)->orderBy('created_at', 'desc')->first();
                if(!empty($balance)){
                    $preBalance = $balance->balance;
                }
            @endphp
            <input type="hidden" name="type" value="credit">
            <input type="hidden" name="vendor_id" value="{{ @$vendor }}">
            <input type="hidden" name="previous_balance" id="previous_balance" class="form-control disabled" value ="{{ $preBalance }}"/> 
            <input type="hidden" name="balance" id="balance" class="form-control" placeholder="Balance"  value="0" /> 
                                             
            <input type="hidden" name="grand_total" id="grand_total" class="form-control" placeholder="Grand Total" onchange="grandTotalHandler()"/> 

            @if($hasPending == 1 )
            <div class="row">
                <div class="col-md-5">
                    <h6>Select Orders</h6>
                    <hr>
                    <table class="table table-hover c_table inbox_table c_table theme-color">
                        <thead>
                            <tr>
                                <th width="10">#</th>
                                <th width="40">Date</th>
                                <th width="50">Price</th>
                            </tr>
                        </thead>    
                        <tbody>
                        @if(!Empty($orderPending))
                            @foreach($orderPending as $iKey => $iOrder)
                                <tr>
                                    <td class="chb">
                                        <div class="checkbox simple">
                                            <input id="order_id_{{ $iKey }}" name="order_id[]" value="{{ $iOrder->id }}" type="checkbox">
                                            <label for="order_id_{{ $iKey }}"></label>
                                        </div>
                                    </td>
                                    <td class="u_name"><h5 class="font-15 mt-0 mb-0">{{ date('d-m-Y', strtotime($order->created_at)) }}</h5></td>
                                    <td class="u_name"><h5 class="font-15 mt-0 mb-0">Rs. <span id="order_price_{{ $iKey }}">{{ $order->grand_total }}</span>/-</h5></td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    <hr>
                    <div class="text-right">
                        <ul class="list-unstyled">
                            
                        
                            <li><strong>Previous Balance:-</strong> Rs. <strong class="text-success" id="pre_blance_invoice">{{ $preBalance }}</strong>/-</li>
                        
                            <li><strong>Total:-</strong> Rs. <strong class="text-success" id="final_price_invoice">00.00</strong>/-</li>
                        </ul>                              
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-6">
                    <h6>Payment Details</h6>
                    <hr>
                    
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Payment Model <small class="text-danger">*</small></label>                                 
                                    <select class="form-control demo-select2-placeholder" name="payment_mode">
                                        @if(App\Models\Type::where('type', 'payment_mode')->get())
                                        @foreach(App\Models\Type::where('type', 'payment_mode')->get() as $key => $type)
                                            <option value="{{ $type->id }}">{{ $type->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>                                
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Pay to</label>                                 
                                    <select class="form-control demo-select2-placeholder" name="emp_id">
                                        @if(App\Models\User::where('user_type', 'employer')->get())
                                            @foreach(App\Models\User::where('user_type', 'employer')->get() as $key => $type)
                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>                                
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Transaction ID</label>                                 
                                    <input type="text" name="transaction_id" class="form-control" placeholder="Transaction ID"/>                                   
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Payble Amount <small class="text-danger">*</small></label>                                 
                                    <input type="text" onchange="grandTotalHandler()" name="payable_amount" id="payable_amount" class="form-control" placeholder="Payable Amount" value="0" />                                   
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Next Balance</label>                                 
                                    <input type="number" name="balancenext" id="next_balance" class="form-control" placeholder="Balance" disabled  value="0" />                                   
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Status <small class="text-danger">*</small></label>        
                                    <select class="form-control demo-select2-placeholder" name="status">
                                        <option value="0">Pending</option>
                                        <option value="1" selected>Paid</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success me-1 mb-1 btn-round edit_btn_payment_{{ @$vendor }}" style="font-size: 11px;width: 95px;padding: 10px 2px" onclick="payment_submit('{{ @$vendor }}')">
                                    <span style="width: 12px;height: 12px;" role="status" aria-hidden="true"></span>
                                    Update
                                </button>
                            </div>
                        </div>
                    
                </div>
            </div>

            @else
                <p>Already Paid today.</p>
            @endif
        </form>
    </div>
</div>


 
<script>
    
    $(document).ready(function() {
 
        function updateTotal() {
            var total = parseInt($('#previous_balance').val());
            $('input[name="order_id[]"]:checked').each(function() {
                var index = $(this).attr('id').split('_').pop();
                var price = parseFloat($('#order_price_' + index).text());
                total += price;
            });
            
            $('#final_price_invoice').text(total.toFixed(2));
            $('#grand_total').val(total.toFixed(2));
            $('#payable_amount').val(total.toFixed(2));
            grandTotalHandler();
        }

        $('input[name="order_id[]"]').change(function() {
            updateTotal();
        });
    });

    function grandTotalHandler(){
       
        var payable = $("#payable_amount").val();
        var grand = $("#grand_total").val();
        var balance = parseFloat(grand) - parseFloat(payable);
        $("#balance").val(balance.toFixed(2));
        $("#next_balance").val(balance.toFixed(2));
    }
    function edit_change_sales_qty_items(id){
        edit_checkQtySum(id);
        edit_checkQtyWisePrice(id);
    }

    function edit_change_sales_rate_items(id){
        edit_checkQtyWisePrice(id);
    }

    function edit_checkQtySum(id){
        var total = $('.edit_qty_total_'+id).text();
        var qty = $('.edit_qty_id_'+id).val();
  
        if(parseInt(total) >= parseInt(qty)){
            $('.edit_btn_grade_'+id).attr('disabled', false);
            $('.edit_row_id_'+id).removeClass("bg-danger");
        }else{
            $('.edit_btn_grade_'+id).attr('disabled', true);
            $('.edit_row_id_'+id).addClass("bg-danger");
        }
    }
   
    function edit_checkQtyWisePrice(id){
        var qty = $('.edit_qty_id_'+id).val();
        var grade = $('.edit_grades_rate_'+id).val();
        $('.edit_sale_rate_'+id).text(qty*grade);
    }

    function update_sale_wise_price(gread_id){
        $('.edit_btn_grade_'+gread_id+'> span').addClass('spinner-border');
        $.ajax({
            url: "{{ route('sale.store') }}",
            type: $("#sale_update_form_"+gread_id).attr('method'),
            cache : false,
            data: $("#sale_update_form_"+gread_id).serialize(),
            success: function(data) {
                dsldFlashNotification(data['status'], data['message']);
                $('#sale_update_form_'+gread_id+' .dsld-btn-loader').removeClass('btnloading');
                if(data['status'] =='success'){
                    $('.edit_btn_grade_'+gread_id+' span').removeClass('spinner-border');
                }
            }
        });
    }
    function payment_submit(vendor){
        $('.edit_btn_payment_'+vendor+'> span').addClass('spinner-border');
        $.ajax({
            url: "{{ route('payment.store') }}",
            type: $("#generate_inv_form").attr('method'),
            cache : false,
            data: $("#generate_inv_form").serialize(),
            success: function(data) {
                dsldFlashNotification(data['status'], data['message']);
                $('#generate_inv_form'+' .dsld-btn-loader').removeClass('btnloading');
                if(data['status'] =='success'){
                    $('.edit_btn_payment_'+vendor+'> span').removeClass('spinner-border');
                   location.reload(true);
                }
            }
        });
    }
</script>   