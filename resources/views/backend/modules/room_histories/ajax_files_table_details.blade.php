
@php
$countHistory = App\Models\RoomCycle::where('room_histories_id', $roomHistory->id)->count();
$countCycle = App\Models\Cycle::where('id', '!=', '')->count();
@endphp

@if($countCycle > $countHistory)
<div class="col-lg-2">
    <div onclick="add_larger_modals();">
        <div class="card info-box-2 hover-zoom-effect social-widget facebook-widget pt-2 align-items-center justify-content-center" style="background: #e5e5e5;">
            <div class="icon"><i class="zmdi zmdi-hc-fw"></i>
            </div>
        </div>
    </div>
</div>
@endif

@if(!is_null($data))

@php 
    $create_date = Carbon\Carbon::parse($roomHistory->start_date);
@endphp

@foreach($data as $key => $value)

@php 

    $roomCycle = App\Models\RoomCycle::where('room_histories_id', $roomHistory->id)->where('cycle_id', $value->id)->first();
    $roomEmployee = App\Models\RoomEmployee::where('room_history_id', $roomHistory->id)->where('labours_type', $value->cycles->labours_type)->first();
@endphp

@php
    $today = now();
    $daysDifference = $today->diffInDays($create_date);
    $opacity = 1 - ($daysDifference * 0.1);
    $opacity = max(1, $opacity);

    $bgColor = '#b4c20142';

    if($today->isSameDay($create_date)){

        $bgColor = '#00800059';
    }else if($today > $create_date){

        $bgColor = '#0000ff29';
    }else if($today < $create_date){

        $bgColor = '#54bbff38';
    }
    print_r($value->labours_type);
@endphp

    <div class="col-lg-2">
        <div onclick="edit_lg_modal_form({{ $value->id }}, '{{ route('rooms.details_ajax.edit') }}', 'Edit ({{ $value->day }}) Day data', {{ $roomHistory->id }});">
            <div class="card info-box-2 hover-zoom-effect social-widget facebook-widget pt-2" 

                @if(@$roomCycle->status == 2) 
                    style="background: {{ $bgColor }}; opacity: 0.6;"
                @elseif(@$roomCycle->status == 1)
                    style="background: {{ $bgColor }}; opacity: 1"
                @elseif(@$value->is_delay == 1)
                    style="background: #ffabab; opacity: 1"
                @else
                    style="background: {{ $bgColor }}; opacity: {{ $opacity }}"
                @endif 
                
            >
                <div class="content">
                    <span class="badge badge-info">{{ $value->day }} Day</span>
                </div>
                <div class="icon">
                    <small> 
                        <ul class="list-unstyled team-info margin-0"> 
                            @if(!is_null(@$value->employe_id))
                                @foreach(json_decode(@$value->employe_id) as $key => $emp)
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
                </div>
                <div class="content">
                    <div class="text"><b>{{ Str::limit($value->cycle_name, 30) }}</b></div>
                    <small class="text-center">Date: {{ date('d-m-Y', strtotime($create_date)) }}<br>
                    <i>{{ @$value->remark }}</i></small>
                </div>
            </div>
        </div>
    </div>
    
    {{--
        <tr @if(@$roomCycle->status == 2)
                style="background: #ffd2d2;opacity: 0.5;"
            @elseif(@$roomCycle->status == 1)
                style="background: #deffd7;"
            @else
                style="background: #d7e5ff;"
            @endif onclick="edit_lg_modal_form({{ $value->id }}, '{{ route('rooms.details_ajax.edit') }}', 'Edit ({{ $value->day }}) Day data', {{ $roomHistory->id }});">
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
    --}}

@php $create_date->addDay(); @endphp

@endforeach

@else

    {{--
        <tr>
            <td colspan="6">Sorry! Data not found.></td>
        </tr>
    --}}

@endif