<input type="hidden" name="id" value="{{ @$data->id }}">
<input type="hidden" name="cycle_id" value="{{ @$cycle->id }}">
<input type="hidden" name="room_id" value="{{ @$rooms->id }}">
@php 
    $create_date = Carbon\Carbon::parse(@$rooms->created_at);
@endphp
<input type="hidden" name="date" value="{{ $create_date->addDay($cycle->day) }}">
<div class="body">
    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Employe<small class="text-danger">*</small></label>  
                <select class="form-control show-tick ms select2" name="employe_id[]" id="employe" multiple>
                    <option value="0" disabled>Select Employe</option>
                    @if(App\Models\User::where('user_type', 'employer')->where('banned', 0)->get() != '')
                        @foreach(App\Models\User::where('user_type', 'employer')->where('banned', 0)->get() as $key => $value)
                            <option value="{{ $value->id }}"  @if(@$data->employe_id)()@if(in_array($value->id, json_decode(@$data->employe_id))) selected @endif @endif>{{ $value->name}}</option>
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
    </div>

</div>

<script>
    $("#employe").select2();
</script>

                