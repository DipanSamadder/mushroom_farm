

<table class="table table-bordered table-striped table-hover dataTable">
    <thead>
        <tr class="text-center">
            <th>Sr</th>
            <th>Room Details</th>
            <th>Employee Details</th>
            <th>Type</th>
            <th>Status</th>

            @if(dsld_check_permission(['edit-room-assign', 'delete-room-assign']))
            <th>Action</th>
            @endif

        </tr>
    </thead>
    <tfoot>
        <tr class="text-center">
            <th>Sr</th>
            <th>Room Details</th>
            <th>Employee Details</th>
            <th>Type</th>
            <th>Status</th>

            @if(dsld_check_permission(['edit-room-assign', 'delete-room-assign']))
            <th>Action</th>
            @endif

        </tr>
    </tfoot>
    <tbody>
        @if(is_array($data) || count($data) > 0 )
            @foreach($data as $key => $value)
            <tr @if($value->level ==1) style="background:#ff00001f;" @endif>
                    <th scope="row">{{ $key+1 }}</th>
                    <td>{{ @$value->roomHistory->rooms->name }}</td>
                    <td>
                        <small> 
                            <ul class="list-unstyled team-info margin-0"> 
                            
                                @if(!is_null(@$value->employee_id))
                                    @foreach(json_decode(@$value->employee_id) as $key => $emp)
                                        @php $user = App\Models\User::where('id', $emp)->first(); @endphp
                                        @if($user->avatar_original)
                                            <li><img src="{{ dsld_uploaded_file_path($user->avatar_original) }}" alt="{{ $user->name }}"></li>
                                        @else
                                            <li><img src="{{ dsld_static_asset('backend/assets/images/xs/avatar1.jpg') }}" alt="{{ $user->name }}"></li>
                                        @endif
                                    @endforeach
                                @else
                                    <li><img src="{{ dsld_static_asset('backend/assets/images/xs/avatar1.jpg') }}" alt="profile"></li>
                                @endif                                     
                            </ul>
                        </small>
                    </td>
                    <td>{{ $value->labourRates->name }}</td>
                    
                    <td><span class="badge @if($value->status == 1 ) bg-success @else bg-danger @endif text-white">@if($value->status == 1 ) Active @else Deactive @endif</span></td>

                    @if(dsld_check_permission(['edit-room-assign', 'delete-room-assign']))
                    <td>
                        @if(dsld_check_permission(['edit-room-assign']))
                        <a href="javascript:void(0)"  onclick="edit_lg_modal_form({{ $value->id }}, '{{ route('room_assign.edit') }}', 'Template');" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-primary">
                            <i class="zmdi zmdi-edit"></i>
                        </a>
                        @endif
                        @if(dsld_check_permission(['delete-room-assign']))
                        <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-danger" onclick="DSLDDeleteAlert('{{ $value->id }}','{{ route('room_assign.destory') }}','{{ csrf_token() }}')">
                                <i class="zmdi zmdi-delete"></i>
                        </a>
                        @endif
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

