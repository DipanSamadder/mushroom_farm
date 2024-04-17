

<input type="hidden" name="rooms_id" value="{{ @$rid }}">
<input type="hidden" name="grades_id" value="{{ @$gid }}">
<div class="body">
    <div class="row clearfix">

        @if(!is_null(App\Models\ProCategory::where('status', 1)->get()))  
        @php
            $pro = @App\Models\Production::where('rooms_id', $rid)->where('grades_id', $gid)->first();
            $totalq = 0;
        @endphp
        <div class="col-sm-12"><b>Tolal Qty <small class="text-danger">* (<span class="totalQty">{{ @$pro->qty }}</span> Pcs)</small></b><hr></div>

        @foreach(App\Models\ProCategory::where('status', 1)->get()  as $key => $value)
            @php
                $sale = @App\Models\Sale::where('rooms_id', $rid)->where('grades_id', $gid)->where('categories_id', @$value->id)->first();
                $totalq += @$sale->qty;
            @endphp
            <div class="col-sm-12">
                <input type="hidden" name="category[]" value="{{ @$value->id }}" /> 
                <div class="row">  
                    <div class="col-sm-3"> 
                        <label class="form-label">{{ $value->name }} :</label> 
                    </div>  
                    <div class="col-sm-2">                               
                        <input type="text" name="qty[]" class="form-control quantity-input qty_id_{{ @$value->id }}" placeholder="Qty"  onchange="change_sales_qty_items('{{ @$value->id }}');" @if(@$sale->qty) value="{{ @$sale->qty }}" @else value="0" @endif />  
                    </div> 
                    <div class="col-sm-2">                          
                        <input type="text" name="grades_rate[]" class="form-control grades_rate_{{ @$value->id }}" placeholder="Grade Rate" onchange="change_sales_rate_items('{{ @$value->id }}')" @if(@$sale->grades_rate) value="{{ @$sale->grades_rate }}" @else value="0" @endif  />  
                    </div> 
                    <div class="col-sm-3"> 
                        @if(!is_null(App\Models\User::where('user_type','vendors')->where('banned', 0)->get()))  
                        <select class="form-control demo-select2-placeholder" name="vendor_id[]">
                            <option value="">Select Vendor</option>
                            @foreach(App\Models\User::where('user_type','vendors')->where('banned', 0)->get()  as $key => $vendors)
                                <option value="{{ $vendors->id }}" @if(@$sale->vendor_id == $vendors->id) selected @endif>{{ $vendors->name }}</option>
                            @endforeach
                        </select>
                        @endif
                    </div> 
                    <div class="col-sm-2">                          
                        <span class="badge bg-info text-white sale_rate_{{ $value->id }}">{{ @$sale->rate }}</span>  
                    </div>                                  
                </div>
            </div>
            @endforeach
            @endif

        {{--
            @if(!is_null(App\Models\User::where('user_type','vendors')->where('banned', 0)->get()))  
            <div class="col-sm-12">
                <div class="row">  
                    <div class="col-sm-6">
                        <label class="form-label">Vendor</label>
                    </div>  
                    <div class="col-sm-6"> 
                        <select class="form-control demo-select2-placeholder" name="vendor_id">
                            <option value="">Select Vendor</option>
                            @foreach(App\Models\User::where('user_type','vendors')->where('banned', 0)->get()  as $key => $value)
                                <option value="{{ $value->id }}" @if(@$data->vendor_id == $value->id) selected @endif>{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>                                 
                </div>
                <hr>
            </div>
            @endif
        --}}

        <div class="col-sm-3">Stock:</div>
        <div class="col-sm-4">@if(@$totalq) <span class="text-danger stock-info"> {{ @$pro->qty - @$totalq }} pcs</span:@endif</div>
    </div>
</div>
        
<script>

    // $('.quantity-input').on('input', function() {
    //     var totalEnteredQuantity = 0;
    //     $('.quantity-input').each(function() {
    //         totalEnteredQuantity += parseInt($(this).val()) || 0;
    //     });
    //     var totalQty = parseInt($('.totalQty').text()) || 0;
    //     var qty = totalQty - totalEnteredQuantity;
    //     if (qty >= 0) {
    //         $('.stock-info').text(qty + ' Pcs');
    //         $('.modal-footer button.btn-success').attr('disabled', false);
    //     }else{
    //         $('.stock-info').text('Over ('+ qty + ' Pcs )');
    //         $('.modal-footer button.btn-success').attr('disabled', true);
    //     }
    // });


    function change_sales_qty_items(id){
        checkQtySum();
        checkQtyWisePrice(id);
    }

    function change_sales_rate_items(id){
        checkQtyWisePrice(id);
    }

    function checkQtySum(){
        var rowRrade = $('.totalQty').text();
  
        var sum = 0;
        $(".quantity-input").each(function(){
            sum += +$(this).val();
        });

        if(rowRrade >= sum){
            $('.modal-footer button.btn-success').attr('disabled', false);
            $('.stock-info').html('<small class="text-info">'+sum+' Pcs</small>');
        }else{
            $('.modal-footer button.btn-success').attr('disabled', true);
            $('.stock-info').html('<small class="text-danger">Over</small>');
        }
    }
   
    function checkQtyWisePrice(id){
        var qty = $('.qty_id_'+id).val();
        var grade = $('.grades_rate_'+id).val();
        $('.sale_rate_'+id).text(qty*grade);
    }
</script>