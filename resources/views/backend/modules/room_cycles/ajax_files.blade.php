
<table class="table table-bordered table-striped table-hover dataTable">
    <thead>
            <tr class="text-center">
                <th>Sr</th>
                <th>Name</th>
                <th>Type</th>
                <th>Days</th>
                @if(dsld_check_permission(['edit-cycle', 'delete-cycle']))
                <th>Action</th>
                @endif
            </tr>
        </thead>
        <tfoot>
            <tr class="text-center">
                <th>Sr</th>
                <th>Name</th>
                <th>Type</th>
                <th>Days</th>
                @if(dsld_check_permission(['edit-cycle', 'delete-cycle']))
                <th>Action</th>
                @endif
            </tr>
        </tfoot>
    <tbody>
        @if(is_array($data) || count($data) > 0 )
            @foreach($data as $key => $value)
                @php $start +=1; @endphp
                <tr>
                    <th scope="row">{{ $start }}</th>
                    <td>{{ $value->name }}</td>
                    <td><span class="badge badge-info">{{ @$value->laboursRates->name }}</span></td>
                    <td>{{ $value->day }}</td>
                    @if(dsld_check_permission(['edit-cycle', 'delete-cycle']))
                    <td>
                            @if(dsld_check_permission(['edit-cycle']))
                            <a href="javascript:void(0)"  onclick="edit_lg_modal_form({{ $value->id }}, '{{ route('room_cycles.edit') }}', 'Template');" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-primary">
                                <i class="zmdi zmdi-edit"></i>
                            </a>
                            @endif
                            @if(dsld_check_permission(['delete-cycle']))
                            <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-danger" onclick="DSLDDeleteAlert('{{ $value->id }}','{{ route('room_cycles.destory') }}','{{ csrf_token() }}')">
                                    <i class="zmdi zmdi-delete"></i>
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
