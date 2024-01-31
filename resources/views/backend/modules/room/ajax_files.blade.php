
<table class="table table-bordered table-striped table-hover dataTable">
    <thead>
            <tr class="text-center">
                <th>Sr</th>
                <th>Name</th>
                <th>About</th>
                <th>Status</th>
                @if(dsld_check_permission(['edit-room', 'delete-room']))
                <th>Action</th>
                @endif
            </tr>
        </thead>
        <tfoot>
            <tr class="text-center">
                <th>Sr</th>
                <th>Name</th>
                <th>About</th>
                <th>Status</th>
                @if(dsld_check_permission(['edit-room', 'delete-room']))
                <th>Action</th>
                @endif
            </tr>
        </tfoot>
    <tbody>
        @if(is_array($data) || count($data) > 0 )
            @foreach($data as $key => $value)
        
                <tr>
                    <th scope="row">{{ $key+1 }}</th>
                    <td>{{ $value->name }}</td>
                    <td>{{ $value->remark }}</td>
                    <td><span class="badge @if($value->status == 1 ) bg-success @else bg-danger @endif text-white">@if($value->status == 1 ) Running @else Done @endif</span></td>
                    @if(dsld_check_permission(['edit-room', 'delete-room']))
                    <td>
                            @if(dsld_check_permission(['edit-room']))
                            <a href="{{ route('rooms.details.edit', ['id'=> $value->id]) }}" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-primary">
                                <i class="zmdi zmdi-hc-fw"></i>
                            </a>
                            @endif
                            @if(dsld_check_permission(['edit-room']))
                            <a href="javascript:void(0)"  onclick="edit_lg_modal_form({{ $value->id }}, '{{ route('rooms.edit') }}', 'Template');" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-primary">
                                <i class="zmdi zmdi-edit"></i>
                            </a>
                            @endif
                            @if(dsld_check_permission(['delete-room']))
                            <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-danger" onclick="DSLDDeleteAlert('{{ $value->id }}','{{ route('rooms.destory') }}','{{ csrf_token() }}')">
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
