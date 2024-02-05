

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
                <div class="col-sm-6"> 
                    <label class="form-label">{{ $value->name }} :</label> 
                </div>  
                <div class="col-sm-6">                               
                    <input type="text" name="qty[]" class="form-control quantity-input" placeholder="Qty" @if(@$sale->qty) value="{{ @$sale->qty }}" @else value="0" @endif  />  
                </div>                                 
            </div>
        </div>
        @endforeach
        @endif

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

        <div class="col-sm-6">Stock:</div>
        <div class="col-sm-6">@if(@$totalq) <span class="text-danger stock-info"> {{ @$pro->qty - @$totalq }} pcs</span:@endif</div>
    </div>
</div>
        
<script>

    $('.quantity-input').on('input', function() {
            var totalEnteredQuantity = 0;
            $('.quantity-input').each(function() {
                totalEnteredQuantity += parseInt($(this).val()) || 0;
            });
            var totalQty = parseInt($('.totalQty').text()) || 0;
            var qty = totalQty - totalEnteredQuantity;
            if (qty >= 0) {
                $('.stock-info').text(qty + ' Pcs');
                $('.modal-footer button.btn-success').attr('disabled', false);
            }else{
                $('.stock-info').text('Over ('+ qty + ' Pcs )');
                $('.modal-footer button.btn-success').attr('disabled', true);
            }
            
        });

</script>