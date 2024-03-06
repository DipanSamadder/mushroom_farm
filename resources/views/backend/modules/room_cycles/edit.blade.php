@if($data !='')

<input type="hidden" name="id" value="{{ $data->id }}">
<div class="body">
    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Name <small class="text-danger">*</small></label>                                 
                <input type="text" name="name" class="form-control" placeholder="Name" @if($data->name) value="{{ $data->name }}" @endif  />                                   
            </div>
        </div>
        
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Labours Type</label>        
                <select class="form-control show-tick ms select2" name="labours_type">
                    <option value="0">Select Type</option>
                    @if(App\Models\LabourRate::where('status', 1)->get() != '')
                        @foreach(App\Models\LabourRate::where('status', 1)->get() as $key => $value)
                            <option value="{{ $value->id }}" @if($data->labours_type == $value->id) selected @endif>{{ $value->name}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Days <small class="text-danger">*</small></label>                                 
                <input type="text" name="day" class="form-control" placeholder="day" @if(!is_null($data->day)) value="{{ $data->day }}" @endif  />                                   
            </div>
        </div>
    </div>

</div>
@endif
                