

<table class="table table-bordered table-striped table-hover dataTable">

    <thead>

            <tr class="text-center">

                <th>Sr</th>

                <th>Room Name</th>

                <th>Production</th>



                @php

                    $pcate = App\Models\ProCategory::where('status', 1)->get();

                @endphp

                @if(!is_null($pcate))

                @foreach($pcate as $key => $value)

                <th>{{ @$value->name }}</th>

                @endforeach

                @endif



                <th>Stock</th>

                <th>Date</th>

                @if(dsld_check_permission(['edit-sale', 'delete-sale']))

                <th>Action</th>

                @endif

            </tr>

        </thead>

        <tfoot>

            <tr class="text-center">

                <th>Sr</th>

                <th>Room Name</th>

                <th>Production</th>

                @php

                    $pcate = App\Models\ProCategory::where('status', 1)->get();

                @endphp

                @if(!is_null($pcate))

                @foreach($pcate as $key => $value)

                <th>{{ @$value->name }}</th>

                @endforeach

                @endif

                <th>Stock</th>

                <th>Date</th>

                @if(dsld_check_permission(['edit-sale', 'delete-sale']))

                <th>Action</th>

                @endif

            </tr>

        </tfoot>

    <tbody>
        @if(is_array($data) || count($data) > 0 )
            @foreach($data as $rkey => $production)
                @php 
                    $total_prodcution  = round(@$production->qty* $production->grade->rate, 2);
                    $total_sale  = 0;
                    $totalqty  = 0;
                @endphp
                <tr>
                    <th scope="row">{{ $rkey+1 }}</th>
                    <td>{{ @$production->roomHistories->rooms->name }}<br><small>({{ @$production->grade->name }})</small></td>
                    <td>
                        <small>Quanty: <b>{{ @$production->qty }} pcs</b><br/>Default Rate: <b>{{  $production->grade->rate }} Rs. </b></small>
                    </td>

                    @php
                        $proCat = App\Models\ProCategory::where('status', 1)->get();
                    @endphp
                    @if(!is_null($proCat))
                        @foreach($proCat as $key => $value)
                            @php 
                                $sale = App\Models\Sale::where('rooms_id', $production->rooms_id)->where('grades_id',  $production->grades_id)->where('categories_id', $value->id)->first();

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
                        <span class="badge @if($production->qty == $totalqty) bg-success @elseif($production->qty > $totalqty)  bg-danger @elseif($production->qty < $totalqty) bg-info @endif text-white">{{  @$production->qty - @$totalqty }} Pcs</span>
                    </td>
                    <td>{{ date('d-m-Y', strtotime(@$production->production->created_at)) }}</td>
                    @if(dsld_check_permission(['edit-sale']))
                    <td>

                            @if(dsld_check_permission(['edit-sale']))

                            <a href="javascript:void(0)"  onclick="sale_edit_lg_modal_form({{  $production->rooms_id }},{{  $production->grades_id }}, '{{ route('sale.edit') }}', 'Sale');" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-primary">

                                <i class="zmdi zmdi-edit"></i>

                            </a>

                            @endif

                        </p>

                    </td>

                    @endif

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

