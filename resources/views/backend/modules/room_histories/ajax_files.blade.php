
<table class="table table-bordered table-striped table-hover dataTable">
    <thead>
            <tr class="text-center">
                <th>Sr</th>
                <th>Name</th>
                <th>Current Cycle</th>
                <th>Today Emplyee</th>
                <th>Date</th>
                <th>Status</th>
                @if(dsld_check_permission(['edit-room-histories', 'delete-room-histories']))
                <th>Action</th>
                @endif
            </tr>
        </thead>
        <tfoot>
            <tr class="text-center">
                <th>Sr</th>
                <th>Name</th>
                <th>Current Cycle</th>
                <th>Today Emplyee</th>
                <th>Date</th>
                <th>Status</th>
                @if(dsld_check_permission(['edit-room-histories', 'delete-room-histories']))
                <th>Action</th>
                @endif
            </tr>
        </tfoot>
    <tbody>
        @if(is_array($data) || count($data) > 0 )
            @foreach($data as $key => $value)

            @php 
                $cycle = App\Models\RoomCycle::where('room_histories_id', $value->id)->where('status', 2)->latest()->first();
                dsldCheckTodayUpdateRoomData($value->id);
            @endphp
        
                <tr>
                    <th scope="row">{{ $key+1 }} </th>
                    <td>{{ $value->rooms->name }}</td>
                    <td>
                        @if(!is_null($value->current_status))
                        {{ @$value->cycles->name }} ({{ @$value->cycles->day }} days)
                        @endif
                    </td>
                    <td>
                       
                        <small> 
                            <ul class="list-unstyled team-info margin-0"> 

                                @if(!is_null(@$cycle->employe_id))
                                    @foreach(json_decode(@$cycle->employe_id) as $key => $emp)
                                        @php $user = App\Models\User::where('id', $emp)->first(); @endphp
                                        @if($user->avatar_original)
                                            <li><img src="{{ dsld_uploaded_file_path($user->avatar_original) }}" alt="{{ $user->name }}"></li>
                                        @else
                                            <li><img src="{{ dsld_static_asset('backend/assets/images/xs/avatar1.jpg') }}" alt="{{ $user->name }}"></li>
                                        @endif
                                    @endforeach
                                @endif                                     
                            </ul>
                        </small>
                    </td>
                    <td @if($value->status == 2 ) class="text-success" @endif>
                        <i class="zmdi zmdi-hc-fw"></i> {{ date('d-m-Y', strtotime($value->start_date)) }}<br>
                        <i class="zmdi zmdi-hc-fw"></i> {{ date('d-m-Y', strtotime($value->end_date)) }}
                    </td>
                    <td><span class="badge @if($value->status == 1 ) bg-success @else bg-danger @endif text-white">@if($value->status == 1 ) Running @elseif($value->status == 2 ) Done @else Pending @endif</span></td>
                    @if(dsld_check_permission(['edit-room-histories', 'delete-room-histories']))
                    <td>
                        @if($value->status != 2 )
                            @if(dsld_check_permission(['edit-room-histories']))
                            <a href="{{ route('rooms.details.edit', ['id'=> $value->id]) }}" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-primary">
                                <i class="zmdi zmdi-hc-fw"></i>
                            </a>
                            @endif

                            @if(is_null($cycle))
                            @if(dsld_check_permission(['edit-room-histories']))
                            <a href="javascript:void(0)"  onclick="edit_lg_modal_form({{ $value->id }}, '{{ route('rooms.history.edit') }}', 'Template');" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-primary">
                                <i class="zmdi zmdi-edit"></i>
                            </a>
                            @endif
                            @endif
                            
                            @if(!is_null($cycle) && $cycle->day > 30)
                            @if(dsld_check_permission(['edit-room-histories']))
                            <a href="javascript:void(0)"  onclick="switch_edit_lg_modal_form({{ $value->id }}, '{{ route('rooms.production.edit') }}', 'Production');" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-primary">
                                <i class="zmdi zmdi-hc-fw"></i>
                            </a>
                            @endif
                            @else
                                @if(dsld_check_permission(['delete-room-histories']))
                                <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-danger" onclick="DSLDDeleteAlert('{{ $value->id }}','{{ route('rooms.history.destory') }}','{{ csrf_token() }}')">
                                    <i class="zmdi zmdi-delete"></i>
                                </a>
                                @endif
                            @endif 
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
