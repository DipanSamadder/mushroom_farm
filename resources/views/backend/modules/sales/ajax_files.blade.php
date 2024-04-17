

<table class="table table-bordered table-striped table-hover dataTable">
    <thead>
            <tr class="text-center">
                <th>Sr</th>
                <th>Vendor</th>
                <th>Room Name</th>
                @php
                    $pcate = App\Models\Grade::where('status', 1)->get();
                @endphp
                @if(!is_null($pcate))
                @foreach($pcate as $key => $value)
                <th>{{ @$value->name }}</th>
                @endforeach
                @endif



                <th>Total</th>

                <th>Date</th>

                @if(dsld_check_permission(['edit-sale', 'delete-sale']))

                <th>Action</th>

                @endif

            </tr>

        </thead>

        <tfoot>

            <tr class="text-center">

                <th>Sr</th>

                <th>Vendor</th>

                <th>Room Name</th>

                @php

                    $pcate = App\Models\Grade::where('status', 1)->get();

                @endphp

                @if(!is_null($pcate))

                @foreach($pcate as $key => $value)

                <th>{{ @$value->name }}</th>

                @endforeach

                @endif

                <th>Total</th>

                <th>Date</th>

                @if(dsld_check_permission(['edit-sale', 'delete-sale']))

                <th>Action</th>

                @endif

            </tr>

        </tfoot>

    <tbody>
        @if(is_array($data) || count($data) > 0 )
            @foreach($data as $rkey => $sale)

                <tr>
                    <th scope="row">{{ $rkey+1 }}</th>
                    
                    <td><strong class="text-success">{{ @$sale->users->name }}</strong><br><strong>{{ @$sale->vendors->framesType->name }}</strong><br>{{ @$sale->users->phone }}</td>
                   
                    <td>
                        <strong  class="text-success">{{ @$sale->roomsHistory->rooms->name }}</strong><br>
                        <small>ProDate : {{ date('d-m-Y', strtotime(@$sale->roomsHistory->created_at)) }}
                        <br>
                        Pro : {{ dsld_Production_total_check($sale->rooms_id) }} | <span class="text-danger">Stock : {{ dsld_Production_stock_check($sale->rooms_id) }}</span></small>

                    </td>
                    @php
                        $proCat = App\Models\Grade::where('status', 1)->get();
                        $today_total = 0;
                    @endphp
                    @if(!is_null($proCat))
                        @foreach($proCat as $key => $value)
                            @php 
                                $sales = App\Models\Sale::where('rooms_id', $sale->rooms_id)->where('grades_id',  $value->id)->first();
                                if(!Empty($sales)){
                                    $today_total += $sales->total;
                                }
                                
                            @endphp
                            <td>
                                @if(@$sales->qty > 0)
                                <small>Quanty: <b>{{ @$sales->qty }} Pcs<b></small><br>
                                <small>Rate: <b>{{ @$sales->grades_rate }} Rs<b></small><br>
                                <b>Rs. <span class="text-primary">{{ @$sales->total }}/-</span>
                                @endif
                            </td>
                        @endforeach
                    @endif
                    <td>{{ $today_total }}</td>
                    <td>{{ date('d-m-Y', strtotime(@$sale->created_at)) }}</td>
                    @if(dsld_check_permission(['edit-sale']))
                    <td>
                        @if(dsld_check_permission(['edit-sale']))
                        <a href="javascript:void(0)"  onclick="sale_edit_lg_modal_form({{  $sale->rooms_id }},{{  $sale->grades_id }}, '{{ route('sale.edit') }}', 'Sale');" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-primary">
                            <i class="zmdi zmdi-edit"></i>
                        </a>
                        @endif
                    </td>
                    @endif

                    {{--
                    <td>{{ @$sale->categories_id }}</td>
                    <td>{{ @$sale->vendor_id }}</td>
                    <td>{{ @$sale->grades_rate }}</td>
                    <td>{{ @$sale->rate }}</td>
                    <td>{{ @$sale->qty }}</td>
                    <td>{{ @$sale->expense }}</td>
                    <td>{{ @$sale->total }}</td>

                   
                    
                    <td>
                        <small>Quanty: <b>{{ @$sale->qty }} pcs</b><br/>Default Rate: <b>{{  $sale->grade->rate }} Rs. </b></small>
                    </td>
                   
                    @php
                        $proCat = App\Models\Grade::where('status', 1)->get();
                    @endphp
                    @if(!is_null($proCat))
                        @foreach($proCat as $key => $value)
                            @php 
                                $sale = App\Models\Sale::where('rooms_id', $sale->rooms_id)->where('grades_id',  $sale->grades_id)->where('categories_id', $value->id)->first();

                                $total_sale  += @$sale->total;

                                $totalqty += @$sale->qty;
                            @endphp
                            <td>
                                @if(@$sale->qty > 0)
                                <small>Quanty: <b>{{ @$sale->qty }} Pcs<b></small><br>
                                <small>Rate: <b>{{ @$sale->grades_rate }} Rs<b></small><br>
                                <b>Rs. <span class="text-primary">{{ @$sale->total }}/-</span>
                                @endif
                            </td>
                        @endforeach
                    @endif
                    <td>
                        @php 
                            $total_sales = 0;
                            if($total_prodcution > $total_sale){
                                $total_sales = $total_prodcution - $total_sale;
                            }else{
                                $total_sales =  $total_sale - $total_prodcution;
                            }
                        @endphp

                        <small><i class="zmdi zmdi-hc-fw" style="font-size:10px"></i> Rs: <b>{{  @$total_prodcution }}/-</b></small><br>
                        <small><i class="zmdi zmdi-hc-fw" style="font-size:10px"></i> Rs. {{ $total_sale }}/-</small><br/>
                        <b><small class="@if($total_prodcution == $total_sale) text-success @elseif($total_prodcution > $total_sale)  text-danger @elseif($total_prodcution < $total_sale) text-success @endif" >
                            @php 
                                if($total_prodcution > $total_sale){
                                    echo '<i class="zmdi zmdi-hc-fw" style="font-size:10px"></i>';
                                }else{
                                    echo '<i class="zmdi zmdi-hc-fw" style="font-size:10px"></i>';
                                }
                            @endphp
                            Rs. <span>
                        
                        {{ $total_sales }}/-
                    
                        </span></small></b><br>
                        <span class="badge @if($sale->qty == $totalqty) bg-success @elseif($sale->qty > $totalqty)  bg-danger @elseif($sale->qty < $totalqty) bg-info @endif text-white">{{  @$sale->qty - @$totalqty }} Pcs</span>
                    </td>
                    

                    --}}
                </tr>

            @endforeach

        @else

            <tr>

                <td colspan="8" class="text-center">Nothing Found</td>

            </tr>

        @endif

    </tbody>

</table>



{{  $data->links('backend.pagination.custom') }}

