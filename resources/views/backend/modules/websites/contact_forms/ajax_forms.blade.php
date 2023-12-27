
<table class="table table-bordered table-striped table-hover dataTable">
    <thead>
            <tr class="text-center">
                <th>Sr</th>
                <th>Title</th>
                <th>Page Name</th>
                <th>Date</th>

                @if(dsld_check_permission(['edit-contactfs']))
                <th>Status</th>
                @endif

                @if(dsld_check_permission(['edit-contactfs']) || dsld_have_user_permission('delete-contactfs'))
                <th>Action</th>
                @endif
            </tr>
        </thead>
        <tfoot>
            <tr class="text-center">
                <th>Sr</th>
                <th>Title</th>
                <th>Page Name</th>
                <th>Date</th>

                @if(dsld_check_permission(['edit-contactfs']))
                <th>Status</th>
                @endif
                
                @if(dsld_check_permission(['edit-contactfs']) || dsld_have_user_permission('delete-contactfs'))
                <th>Action</th>
                @endif
            </tr>
        </tfoot>
    <tbody>
        @if(is_array($data) || count($data) > 0 )
            @foreach($data as $key => $value)
            @php $key++; @endphp
                <tr>
                    <th scope="row">{{ $key }}</th>
                    <td>{{ $value->title }}</td>
                    <td>{{ $value->title }}</td>
                    <td><small>U: {{ date('h:i:s d M, Y', strtotime($value->updated_at)) }}<br>C: {{ date('h:i:s d M, Y', strtotime($value->created_at)) }}</small></td>

                    @if(dsld_check_permission(['edit-contactfs']))
                    <td>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="status_{{$value->id }}" onchange="DSLDStatusUpdate('{{ $value->id }}','{{ $value->status == 1 ? 0 : 1  }}', '{{ route('pages.status') }}','{{ csrf_token() }}')" @if($value->status == 1) checked @endif >
                            <label class="custom-control-label" for="status_{{$value->id }}"></label>
                        </div>
                    </td>
                    @endif

                    @if(dsld_check_permission(['edit-contactfs']) || dsld_have_user_permission('delete-contactfs'))
                    <td>
                        <p class="text-center mb-0 action_items">
                            @if(dsld_check_permission(['edit-contactfs']))
                            <a href="{{ route('contact_form_fields.edit', [$value->id]) }}" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-primary">
                                <i class="zmdi zmdi-hc-fw"></i>
                            </a>
                            @endif
                            @if(dsld_check_permission(['edit-contactfs']))
                            <a href="javascript:void(0)"  onclick="edit_lg_modal_form({{ $value->id }});" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-primary">
                                <i class="zmdi zmdi-edit"></i>
                            </a>
                            @endif
                            @if(dsld_check_permission(['delete-contactfs']))
                            <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-danger" onclick="DSLDDeleteAlert('{{ $value->id }}','{{ route('pages.destory') }}','{{ csrf_token() }}')">
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
