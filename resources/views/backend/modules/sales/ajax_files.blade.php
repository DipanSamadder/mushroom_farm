
<table class="table table-bordered table-striped table-hover dataTable">
    <thead>
            <tr class="text-center">
                <th>Sr</th>
                <th>Room Name</th>
                <th>Production</th>
                <th>Sale</th>
                <th>Stock</th>
                <th>Date</th>
                @if(dsld_check_permission(['edit-sales', 'delete-sales']))
                <th>Action</th>
                @endif
            </tr>
        </thead>
        <tfoot>
            <tr class="text-center">
                <th>Sr</th>
                <th>Room Name</th>
                <th>Production</th>
                <th>Sale</th>
                <th>Stock</th>
                <th>Date</th>
                @if(dsld_check_permission(['edit-sales', 'delete-sales']))
                <th>Action</th>
                @endif
            </tr>
        </tfoot>
    <tbody>
        @if(is_array($data) || count($data) > 0 )
            @foreach($data as $rkey => $production)
                @php 
                    $sale = App\Models\Sale::where('rooms_id', $production->rooms_id)->where('grades_id',  $production->grades_id)->first();
                    $total_prodcution  = round(@$production->qty* $production->grade->rate, 2);
                    $total_sale  = $total_prodcution - @$sale->total;
                @endphp
                <tr @if($total_sale <= 0) style="background:#effff7" @endif>
                    <th scope="row">{{ $rkey+1 }}</th>
                    <td>{{ @$production->room->name }}<br><small>{{ @$production->grade->name }}</small></td>

                    <td>Rate:  <b>{{  $production->grade->rate }} Rs. </b><br><small>Quanty: <b>{{ @$production->qty }} pcs</b></small><br><b>Rs. <span class="text-success">{{ $total_prodcution }}/-</span></td>
                    
                    <td>
                        <b>{{ @$sale->categories->name }}</b><br>
                        <small>Quanty: <b>{{ @$sale->qty }} pcs<b></small><br><b>Rs. <span class="text-primary">{{ @$sale->total }}/-</span>
                    </td>
                    
                    <td>
                        Available<br>
                        <small>Quanty: <b>{{  @$production->qty- @$sale->qty }} pcs<b></small><br><b>Rs. <span @if($total_sale > 0)class="text-danger" @endif>{{ $total_sale }}/-</span>
                    </td>

                    <td>{{ date('d-m-Y', strtotime(@$production->production->created_at)) }}</td>

                    @if(dsld_check_permission(['edit-sales']))
                    <td>
                            @if(dsld_check_permission(['edit-sales']))
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
