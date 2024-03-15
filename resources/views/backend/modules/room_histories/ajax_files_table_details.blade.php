
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

@foreach($data as $key => $value)

@php 

    $roomCycle = App\Models\RoomCycle::where('room_histories_id', $roomHistory->id)->where('cycle_id', $value->id)->first();
    $roomEmployee = App\Models\RoomEmployee::where('room_history_id', $roomHistory->id)->where('labours_type', $value->cycles->labours_type)->first();
@endphp

    <div class="col-lg-2">
        <div @if(@$value->status != 2) onclick="edit_lg_modal_form({{ $value->id }}, '{{ route('rooms.details_ajax.edit') }}', 'Edit ({{ $value->day }}) Day data', {{ $roomHistory->id }});" @endif>
            <div class="card info-box-2 hover-zoom-effect social-widget facebook-widget pt-2" 

                @if(@$value->status == 2) 
                    @if(@$value->is_delay == 1)
                        style="background: red; opacity: 1"
                    @else
                        style="background: #0000ff29; opacity: 0.6;"
                    @endif

                @elseif(@$value->status == 1)
                    @if(@$value->is_delay == 1)
                        style="background: red; opacity: 1"
                    @else
                        style="background: #00800059;"
                    @endif
                    
                @else
                    style="background: #54bbff38; opacity: 0.6"
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
                    <small class="text-center">Date: {{ date('d-m-Y', strtotime($value->date)) }}<br>
                    <i>{{ @$value->remark }}</i></small>
                </div>
            </div>
        </div>
    </div>


@endforeach

@else

    {{--
        <tr>
            <td colspan="6">Sorry! Data not found.></td>
        </tr>
    --}}

@endif