
<table class="table table-bordered table-striped table-hover dataTable">
    <thead>
            <tr class="text-center">
                <th>Sr</th>
                <th>Date</th>
                <th>Purpose</th>
                <th>Amount</th>
                <th>Jugal</th>
                @if(dsld_check_permission(['edit-cash', 'delete-cash']))
                <th>Action</th>
                @endif
            </tr>
        </thead>
        <tfoot>
            <tr class="text-center">
                <th>Sr</th>
                <th>Date</th>
                <th>Purpose</th>
                <th>Amount</th>
                <th>Jugal</th>
                @if(dsld_check_permission(['edit-cash', 'delete-cash']))
                <th>Action</th>
                @endif
            </tr>
        </tfoot>
    <tbody>
        @if(is_array($data) || count($data) > 0 )
            @php 
                $amnt = 0;
                $balance = 0;
                $previousBalance = 0;
            @endphp
            @foreach($data as $key => $value)
                @php 
                    $previousRow = App\Models\Transaction::where('id', '<', $value->id)->latest('id')->first();
                    if(!is_null($previousRow)){
                        $previousBalance = $previousRow->balance;
                    }else{
                        $previousBalance = 0;
                    }
                @endphp
                <tr>
                    <th scope="row">{{ $key+1 }}</th>
                    <td>{{ $value->date }}</td>

                    <td>{{ $value->purpose }}<br> <small>PM: {{ $value->payment_modes->title }}</small> |  <small>R: {{ $value->users->name }}</small> <span class="badge @if($value->type == 'credit' ) bg-success @else bg-danger @endif text-white">@if($value->type == 'credit' ) Credit @else Debit @endif</span></td>

                    <td>
                        <small>₹ {{ $previousBalance }}
                        @if($value->type != 'credit' ) 
                            - <b class="text-danger">₹{{ $value->amount }}</b>
                        @else 
                            + <b class="text-success">₹</b>{{ $value->amount }} 
                        @endif 
                        </small>  
                    </td>

                    <td>₹ {{ $value->balance }}/-</td>

                    @if(dsld_check_permission(['edit-cash', 'delete-cash']))
                    <td>
                            @if(dsld_check_permission(['edit-cash']))
                            <a href="javascript:void(0)"  onclick="edit_lg_modal_form({{ $value->id }}, '{{ route('cash.imprest.edit') }}', 'Template');" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-primary">
                                <i class="zmdi zmdi-edit"></i>
                            </a>
                            @endif
                            @if(dsld_check_permission(['delete-cash']))
                            <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-danger" onclick="DSLDDeleteAlert('{{ $value->id }}','{{ route('cash.imprest.destory') }}','{{ csrf_token() }}')">
                                    <i class="zmdi zmdi-delete"></i>
                            </a>
                            @endif
                        </p>
                    </td>
                    @endif
                    @php 
                        $previousBalance = $value->balance;
                    @endphp
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
