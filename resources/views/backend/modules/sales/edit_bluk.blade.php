

<input type="hidden" name="rooms_id" value="{{ @$rid }}">
<input type="hidden" name="grades_id" value="{{ @$gid }}">
<div class="body">
    <div class="row clearfix">
        @if(!is_null(App\Models\Grade::where('status', 1)->get()))  
        @php
            $pro = @App\Models\Production::where('rooms_id', $rid)->where('grades_id', $gid)->first();
            $totalq = 0;
        @endphp
        <div class="col-sm-12">
            <table class="table table-bordered table-striped table-hover">
                <thead> 
                    <tr class="text-center">
                        <th>Grade</th>
                        <th>Production</th>
                        @php
                        $cat = App\Models\ProCategory::where('status', 1)->get();
                            @endphp
                        @if(!is_null($cat))
                        @foreach($cat as $key => $value)
                        <th>{{ @$value->name }}</th>
                        @endforeach
                        <th>Total</th>
                        @endif
                        @if(dsld_check_permission(['edit-productions', 'delete-productions']))
                        <th>Action</th>
                        @endif
                    </tr>
            </thead>
            <tbody>
                @foreach(App\Models\Grade::where('status', 1)->get()  as $key => $gread)
                @php
                    $saleCount = @App\Models\Sale::where('rooms_id', $rid)->where('grades_id', $gread->id)->sum('qty');
                    $production = @App\Models\Production::where('rooms_id', $rid)->where('grades_id', $gread->id)->first();
                @endphp
                <tr class="row_{{$gread->id}}">
                    <td scope="row">{{ $gread->name }}</td>
                    <td>{{ @$production->qty }}</td>
                    @foreach($cat as $key => $value)
                    <td>
                        @php
                            $saleCateWise = @App\Models\Sale::where('rooms_id', $rid)->where('grades_id', $gread->id)->where('categories_id', $value->id)->first();
                        @endphp
                        <div class="row">  
                            <div class="col-sm-6"><small>Quantity:</small>
                                <input type="text" name="qty[]" class="form-control quantity" placeholder="Qty" @if(@$saleCateWise->qty) value="{{ @$saleCateWise->qty }}" @else value="0" @endif  />
                            </div> 
                            <div class="col-sm-6"><small>Rate:</small>
                                <input type="text" name="grades_rate[]" class="form-control grades_rate" placeholder="Qty" @if(@$saleCateWise->grades_rate) value="{{ @$saleCateWise->grades_rate }}" @else value="0" @endif  />
                            </div>  
                            <div class="col-sm-8 mt-2"> 
                                <select class="form-control show-tick ms select2" name="vendor_id" id="vendor_{{ $gread->id }}_{{ $value->id }}">
                                    <option value="">Select Vendor</option>
                                    @foreach(App\Models\User::where('user_type','vendors')->where('banned', 0)->get()  as $key => $vendor)
                                        <option value="{{ $vendor->id }}" @if(@$data->vendor_id == $vendor->id) selected @endif>{{ $vendor->name }}</option>
                                    @endforeach
                                </select>
                                <script>
                                    $('#vendor_{{ $gread->id }}_{{ $value->id }}').select2();
                                </script>
                            </div> 
                            <div class="col-sm-4"><span class="badge bg-info text-white">@if(@$saleCateWise->rate) {{ @$saleCateWise->rate }} @else 0 @endif </span>
                            </div>                                  
                        </div>
                    </td>
                    @endforeach
                    <td>{{ $saleCount }}</td>
                    <td><button type="submit" class="btn btn-success btn-round waves-effect dsld-btn-loader">UPDATE</button></td>
                </tr>
            
                @endforeach
                @endif
            </tbody>
        </table>
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

</script>