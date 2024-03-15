@if($data !='')

<input type="hidden" name="id" value="{{ $data->id }}">
<div class="body">
    <div class="row clearfix">
        
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Room Select <small class="text-danger">*</small></label>        
                <select class="form-control show-tick ms select2" name="room_history_id">
                    <option value="">Select Room</option>
                    @if(App\Models\RoomHistory::where('status', 1)->get() != '')
                        @foreach(App\Models\RoomHistory::where('status', 1)->get() as $key => $value)
                            <option value="{{ $value->id }}" @if($data->room_history_id == $value->id) selected @endif>{{ $value->rooms->name }} ({{ date('d-m-Y', strtotime($value->start_date)) }})</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>        
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Status <small class="text-danger">*</small></label>        
                <select class="form-control show-tick ms select2" name="status">
                    <option value="0" @if($data->status == 0) selected @endif>Deactive</option>
                    <option value="1"  @if($data->status == 1) selected @endif>Active</option>
                </select>
            </div>
        </div>
    </div>

</div>
@endif
                