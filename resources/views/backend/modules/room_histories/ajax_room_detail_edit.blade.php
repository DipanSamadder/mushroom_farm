<input type="hidden" name="id" value="{{ @$data->id }}">
<input type="hidden" name="room_id" value="{{ @$rooms->room_id }}">
<input type="hidden" name="room_histories_id" id="edit_room_histories_id" value="{{ @$rooms->id }}">

@php 
    $create_date = Carbon\Carbon::parse(@$rooms->created_at);
    
    $roomEmp = App\Models\RoomEmployee::where('room_history_id', @$rooms->id)->where('labours_type', @$data->cycles->labours_type)->first();


@endphp

<input type="hidden" name="date" value="{{ $create_date->addDay($cycle->day) }}">
<div class="body">
    <div class="row clearfix">
 
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Cycle<small class="text-danger">*</small> <small id="cycle-loading-edit"></small></label>  
                <select class="form-control show-tick ms select2 cycle_id" name="cycle_id" id="cycle_id">
                        <option value="{{ @$data->cycle_id }}" selected>({{ @$data->cycles->day}} days) {{ @$data->cycles->name }} (✓)</option>
                        @if(App\Models\Cycle::where('id', @$rooms->cycle_id)->get() != '')
                            @foreach(App\Models\Cycle::where('id', @$rooms->cycle_id)->get() as $key => $value)
                                <option value="{{ $value->id }}">({{ $value->day}} days) {{ $value->name }}</option>
                            @endforeach
                        @endif
                </select>                                
            </div>
        </div>
        
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Employe<small class="text-danger">*</small></label>  
                <select class="form-control show-tick ms select2" name="employe_id[]" id="employe" multiple>
                    <option value="0" disabled>Select Employe</option>
                    @if($roomEmp != '')
                        @foreach(json_decode($roomEmp->employee_id, true) as $key => $emp)
                            @php
                                $user  = App\Models\User::where('id', $emp)->where('banned', 0)->first();
                            @endphp
                            <option value="{{ $user->id }}" @if($data->employe_id != '' && !is_null(@$data->employe_id)) @if(in_array($emp, json_decode(@$data->employe_id))) selected @endif @endif>{{ $user->name }}</option>
                        @endforeach
                    @endif
                </select>                                
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Remark</label>                                 
                <input type="text" name="remark" class="form-control" placeholder="Remark" @if(@$data->remark) value="{{ @$data->remark }}" @endif  />                                   
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Status <small class="text-danger">*</small></label>        
                <select class="form-control demo-select2-placeholder" name="status">
                    <option value="0" @if(@$data->status == 0) selected @endif>Pending</option>
                    <option value="1"  @if(@$data->status == 1) selected @endif>Running</option>
                    <option value="2"  @if(@$data->status == 2) selected @endif>Done</option>
                </select>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="checkbox">
                <input type="checkbox" id="is_delay" name="is_delay" class="form-control" @if(@$data->is_delay) checked @endif /> 
                <label class="form-label" for="is_delay">Is Delay?</label> 
            </div>
        </div>

    </div>
</div>

<script>
    $("#cycle_id").select2();
    $("#employe").select2();
</script>


