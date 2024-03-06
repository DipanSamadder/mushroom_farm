@if($data !='')



<input type="hidden" name="id" value="{{ $data->id }}">
<div class="body">
    <div class="row clearfix">
        <div class="col-sm-12 mb-2">
            <label class="form-label">Room Select <small class="text-danger">*</small></label>        
            <select class="form-control show-tick ms select2" name="room_id" disabled>
                <option value="">Select Room</option>
                @if(App\Models\Room::where('name', '!=', '')->get() != '')
                    @foreach(App\Models\Room::where('name', '!=', '')->get() as $key => $value)
                        @if($value->status == 0)
                        <option value="{{ $value->id }}">{{ $value->name }} @if($value->status == 1) (Occupied) @endif</option>
                        @else
                            @if($value->id == $data->room_id)
                                <option value="{{ $value->id }}" @if($data->room_id == $value->id) selected @endif>{{ $value->name }} @if($value->status == 1) (Occupied) @endif</option>
                            @endif
                        @endif
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-sm-6">
            <label class="form-label">Start Date <small class="text-danger">*</small></label>  
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                </div>
                <input type="date" name="start_date" id="start_date" class="form-control" onchange="is_edited()" @if($data->start_date) value="{{  date('Y-m-d', strtotime($data->start_date)) }}" @else value="{{  date('Y-m-d') }}" @endif>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label">Status <small class="text-danger">*</small></label>        
                <select class="form-control demo-select2-placeholder" name="status">
                    <option value="0" @if($data->status == 0) selected @endif>Running</option>
                    <option value="1"  @if($data->status == 1) selected @endif>Active</option>
                    <option value="2"  @if($data->status == 2) selected @endif>Finished</option>
                </select>
            </div>
        </div>
    </div>
</div>

@endif

                