
<table class="table table-bordered table-striped table-hover dataTable">
    <thead>
            <tr class="text-center">
                <th>Sr</th>
                <th>Invoice Date</th>
                <th style="width: 50%;">Purpose</th>
                <th>Amount</th>
                @if(dsld_check_permission(['edit-expenditure', 'delete-expenditure']))
                <th>Action</th>
                @endif
            </tr>
        </thead>
        <tfoot>
            <tr class="text-center">
                <th>Sr</th>
                <th>Invoice Date</th>
                <th>Purpose</th>
                <th>Amount</th>
                @if(dsld_check_permission(['edit-expenditure', 'delete-expenditure']))
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
                    $currentRow = App\Models\Transaction::where('id', $value->payment_id)->where('category', 'expenditures')->first();
                    if(!is_null($currentRow)){
                        $amnt = $currentRow->amount;
                    }else{
                        $amnt=0;
                    }
                    $due = $value->amount - $amnt;
                @endphp
                <tr @if($value->work_type =='purchase') style="background:#ff000014" @endif>
                    <th scope="row">{{ $key+1 }}</th>
                    <td>{{ date('d-m-Y', strtotime($value->invoice_date)) }}</td>

                    <td>{{ $value->purpose }}<br><small>Q {{ $value->qty }} | {{ @$currentRow->payee_name }}</small></td>
                    <td>₹{{ $value->amount }}<br><b><small class="text-primary"> Paid: ₹{{ $amnt }}</small><b>@if($due> 0)<br><b><small class="text-danger"> Due: ₹{{ $value->amount - $amnt }} </small></b>@endif</td>

                    @if(dsld_check_permission(['edit-expenditure', 'delete-expenditure']))
                  
                    <td>
                        @if(dsld_check_permission(['edit-expenditure']))
                        <a href="javascript:void(0)"  onclick="edit_lg_modal_form({{ $value->id }}, '{{ route('expenditure.edit') }}', 'Template');" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-primary">
                            <i class="zmdi zmdi-edit"></i>
                        </a>
                        @endif
                        @if(dsld_check_permission(['delete-expenditure']))
                        <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-danger" onclick="DSLDDeleteAlert('{{ $value->id }}','{{ route('expenditure.destory') }}','{{ csrf_token() }}')">
                                <i class="zmdi zmdi-delete"></i>
                        </a>
                        @endif
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
