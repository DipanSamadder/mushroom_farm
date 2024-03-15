
<div class="body">
    <div class="row clearfix">
        @if(!is_null(App\Models\Grade::where('status', 1)->get()))  
        @php
            $pro = @App\Models\Production::where('rooms_id', $rid)->where('grades_id', $gid)->first();
            $totalq = 0;
        @endphp
        @php
            $cat = App\Models\ProCategory::where('status', 1)->get();
        @endphp
        <div class="col-sm-12">
            
                @foreach(App\Models\Grade::where('status', 1)->get()  as $key => $gread)

                
                @php
                    $saleCount = @App\Models\Sale::where('rooms_id', $rid)->where('grades_id', $gread->id)->sum('qty');
                    $production = @App\Models\Production::where('rooms_id', $rid)->where('grades_id', $gread->id)->first();
                @endphp

      
                    <form id="sale_update_form_{{ $gread->id }}" action="javascript:void(0);" method="POST" enctype="multipart/form-data">

                        @csrf 
                        <input type="hidden" name="grades_id" value="{{  $gread->id }}" />
                        <input type="hidden" name="room_id" value="{{  $rid }}" />

                        <table class="table table-bordered table-hover dataTable">
                            <thead> 
                                <tr class="text-center bg-light">
                                    <th>Grade</th>
                                    <th>Production</th>
                                

                                    @if(!is_null($cat))
                                    @foreach($cat as $key => $value)
                                        <th>{{ @$value->name }}</th>
                                    @endforeach
                                    @endif

                                    <th>Total</th>

                                    @if(dsld_check_permission(['edit-productions', 'delete-productions']))
                                    <th>Action</th>
                                    @endif

                                </tr>
                            </thead>
                            <tbody>
                                <tr class="row_gread_{{  $gread->id }}">
                                    <td scope="row">
                                        {{ $gread->name }}
                                    </td>
                                    <td class="production_qty_{{ $gread->id }}">{{ @$production->qty }}</td>

                                    @foreach($cat as $key => $value)
                                    <td>
                                        <input type="hidden" name="cate_{{ $gread->id }}[]" value="{{ $value->id }}" />
                                        @php
                                            $saleCateWise = @App\Models\Sale::where('rooms_id', $rid)->where('grades_id', $gread->id)->where('categories_id', $value->id)->first();
                                        @endphp
                                        <div class="row row_cat_{{ $value->id }}">  
                                            <div class="col-sm-6"><small>Quantity:</small>
                                                <input type="text" name="qty_{{ $gread->id }}[]" class="form-control quantity_grade_{{ $gread->id }} quantity_{{ $gread->id }}_{{ $value->id }}" placeholder="Qty" @if(@$saleCateWise->qty) value="{{ @$saleCateWise->qty }}" @else value="0" @endif onchange="change_sales_qty_items('{{ $gread->id }}', '{{ $value->id }}');" />
                                            </div> 
                                            <div class="col-sm-6"><small>Rate:</small>
                                                <input type="text" name="grades_rate_{{ $gread->id }}[]" class="form-control grades_rate grades_{{ $gread->id }}_{{ $value->id }}" placeholder="Qty" @if(@$saleCateWise->grades_rate) value="{{ @$saleCateWise->grades_rate }}" @else value="0" @endif onchange="change_sales_rate_items('{{ $gread->id }}', '{{ $value->id }}');" />
                                            </div>  
                                            <div class="col-sm-8 mt-2"> 
                                                <select class="form-control show-tick ms select2" name="vendor_id_{{ $gread->id }}[]" id="vendor_{{ $gread->id }}_{{ $value->id }}">
                                                    <option value="">Select Vendor</option>
                                                    @foreach(App\Models\User::where('user_type','vendors')->where('banned', 0)->get()  as $key => $vendor)
                                                        <option value="{{ $vendor->id }}" @if(@$saleCateWise->vendor_id == $vendor->id) selected @endif>{{ $vendor->name }}</option>
                                                    @endforeach
                                                </select>
                                                <script>
                                                    $('#vendor_{{ $gread->id }}_{{ $value->id }}').select2();
                                                </script>
                                            </div> 
                                            <div class="col-sm-4 mt-2"><span class="badge bg-info text-white rate_sale_wise_{{ $gread->id }}_{{ $value->id }}">@if(@$saleCateWise->rate) {{ @$saleCateWise->rate }} @else 0 @endif </span>
                                            </div>                                  
                                        </div>
                                    </td>
                                    @endforeach

                                    <td class="sale_count_{{ $gread->id }}"><small class="text-info">{{ $saleCount }}</small></td>
                                    <td>
                                        <button type="submit" class="btn btn-success me-1 mb-1 btn-round btn_grade_{{ $gread->id }}" style="font-size: 11px;width: 95px;padding: 10px 2px" onclick="update_sale_wise_price('{{ $gread->id }}')">
                                            <span style="width: 12px;height: 12px;" role="status" aria-hidden="true"></span>
                                            Update
                                        </button>
                                    </td>
                                    
                                
                                </tr>
                            </tbody>
                        </table>
                        
                    </form>

                
                @endforeach
                @endif
           
        </div>
    </div>
</div>
        
<script>

    $('.quantity').on('input', function() {
        var totalEnteredQuantity = 0;
        $('.quantity').each(function() {
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
    
    function change_sales_qty_items(gread_id, cat_id){
        checkQtySum(gread_id, cat_id);
        checkQtyWisePrice(gread_id, cat_id);
    }

    function change_sales_rate_items(gread_id, cat_id){
        checkQtyWisePrice(gread_id, cat_id);
    }

    function checkQtySum(gread_id, cat_id){
        var rowRrade = $('.production_qty_'+gread_id).text();
        var rowSaleCount = $('.sale_count_'+gread_id).text();
        
        var sum = 0;
        $(".quantity_grade_"+gread_id).each(function(){
            sum += +$(this).val();
        });

        if(rowRrade >= sum){
            $('.row_gread_'+gread_id).removeClass('bg_warging');
            $('.btn_grade_'+gread_id).show();
            $('.sale_count_'+gread_id).html('<small class="text-info">'+sum+'</small>');
        }else{
            $('.sale_count_'+gread_id).html('<small class="text-danger">'+sum+'</small>');
            $('.row_gread_'+gread_id).addClass('bg_warging');
            $('.btn_grade_'+gread_id).hide();
        }
    }

    function checkQtyWisePrice(gread_id, cat_id){
        var qty = $('.quantity_'+gread_id+'_'+cat_id).val();
        var grade = $('.grades_'+gread_id+'_'+cat_id).val();
        $('.rate_sale_wise_'+gread_id+'_'+cat_id).text(qty*grade);
    }

    function update_sale_wise_price(gread_id){
        $('.btn_grade_'+gread_id+'> span').addClass('spinner-border');
        $.ajax({
            url: "{{ route('sale.bluk.store') }}",
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