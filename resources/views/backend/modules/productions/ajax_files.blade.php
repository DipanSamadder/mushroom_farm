

<table class="table table-bordered table-striped table-hover dataTable">
    <thead>
        <tr class="text-center">
            <th>Sr</th>
            <th>Room Name</th>
            <th>Date</th>
            @php
                $grades = App\Models\Grade::where('status', 1)->get();
            @endphp
            @if(!is_null($grades))
            @foreach($grades as $key => $value)
            <th>{{ @$value->name }}</th>
            @endforeach
            <th>Total Q</th>
            <th>Left Q</th>
            @endif
            @if(dsld_check_permission(['edit-productions', 'delete-productions']))
            <th>Action</th>
            @endif
        </tr>
    </thead>
    <tfoot>
        <tr class="text-center">
            <th>Sr</th>
            <th>Room Name</th>
            <th>Date</th>
            @php
                $grades = App\Models\Grade::where('status', 1)->get();
            @endphp
            @if(!is_null($grades))
            @foreach($grades as $key => $value)
            <th>{{ @$value->name }}</th>
            @endforeach
            @endif
            <th>Total Q</th>
            <th>Left Q</th>
            @if(dsld_check_permission(['edit-productions', 'delete-productions']))
            <th>Action</th>
            @endif
        </tr>
    </tfoot>
    <tbody>
        @if(is_array($data) || count($data) > 0 )
            @foreach($data as $rkey => $room)
                <tr>
                    <th scope="row">{{ $rkey+1 }}</th>
                    <td>{{ @$room->rooms->name }}</td>
                    <td>{{ date('d-m-Y', strtotime(@$room->end_date)) }}</td>

                    @php
                    $grades = App\Models\Grade::where('status', 1)->get();
                    $total =0;
                    $stockTotal =0;
                    @endphp

                    @if(!is_null($grades))
                    @foreach($grades as $key => $grade)
                        @php

                        @$sale = 0;
                        $datas = App\Models\Production::where('rooms_id', $room->id)->where('grades_id', $grade->id)->first();
                        if(!empty(App\Models\Sale::where('rooms_id', $room->id)->where('grades_id',  $grade->id)->get()->count())){
                            @$sale = App\Models\Sale::where('rooms_id', $room->id)->where('grades_id',  $grade->id)->sum('qty');
                        }
                        

                        $total += @$datas->qty;
                        $stock  = @$datas->qty - @$sale;
                        $stockTotal  += $stock;

                        @endphp

                        <td>
                            Quantity: <b> {{ @$datas->qty }} Pcs <small @if($sale > 0) class="text-success" @endif> - {{ @$sale }} Pcs</small></b><br>
                            Left : <small @if($stock > 0) class="text-danger" @endif>{{ @$stock }} Pcs</small></b></td>

                    @endforeach
                    @endif
                    <td><b><span class="text-info">{{ $total }} Pcs</span></b></td>
                    <td><b><span class="text-danger">{{ $stockTotal }} Pcs</span></b></td>

                    @if(dsld_check_permission(['edit-productions']))
                    <td>
                            @if(dsld_check_permission(['edit-productions']))
                            <a href="javascript:void(0)"  onclick="edit_lg_modal_form({{ $room->id }}, '{{ route('rooms.production.edit') }}', 'Production');" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-primary">
                                <i class="zmdi zmdi-edit"></i>
                            </a>
                            @endif
                            {{-- 
                            @if(dsld_check_permission(['edit-productions']))
                            <a href="javascript:void(0)"  onclick="sale_all_edit_lg_modal_form({{  $room->id }},{{  $grade->id }}, '{{ route('sale.edit.bluk') }}', 'Sale BLuk');" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-primary">
                                <i class="zmdi zmdi-hc-fw"></i>
                            </a>
                            @endif
                            --}}
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

