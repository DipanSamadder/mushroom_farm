@if(!is_null($data))
@php 
    $create_date = Carbon\Carbon::parse($room->created_at);
@endphp
@foreach($data as $key => $value)
@php 
    $roomCycle = App\Models\RoomCycle::where('room_id', $room->id)->where('cycle_id', $value->id)->first();
@endphp
<tr   @if(@$roomCycle->status == 2)
            style="background: #ffd2d2;opacity: 0.5;"
        @elseif(@$roomCycle->status == 1)
            style="background: #deffd7;"
        @else
            style="background: #d7e5ff;"
        @endif onclick="edit_lg_modal_form({{ $value->id }}, '{{ route('rooms.details_ajax.edit') }}', 'Edit ({{ $value->day }}) Day data', {{ $room->id }});">
    <td><small>{{ $key+1 }}</small></td>
    <td>{{ Str::limit($value->name, 30) }}<br>
        <small><span class="badge badge-info">{{ $value->day }} Day</span> Date: {{ date('d-m-Y', strtotime($create_date)) }}</small>
    </td>                                        
    <td>
        <small> 
            <ul class="list-unstyled team-info margin-0"> 
               
                @if(!is_null(@$roomCycle->employe_id))
                    @foreach(json_decode(@$roomCycle->employe_id) as $key => $emp)
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
    <td>
        {{ @$roomCycle->remark }}
    </td>
    <td>
        @if(@$roomCycle->status == 2)
            <span class="badge badge-danger"><small>Done</small></span>
        @elseif(@$roomCycle->status == 1)
            <span class="badge badge-success"><small>Running</small></span>
        @else
            <span class="badge badge-primary"><small>Pending</small></span>
        @endif
    </td>
    <td><small></small></td>
</tr>
@php $create_date->addDay(); @endphp
@endforeach
@else
<tr>
    <td colspan="6">Sorry! Data not found.></td>
</tr>
@endif