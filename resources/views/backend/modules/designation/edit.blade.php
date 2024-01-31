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
                <label class="form-label">Parent</label>        
                <select class="form-control demo-select2-placeholder" name="parent">
                    <option value="0">Select Parent</option>
                    @if(App\Models\Designation::where('level', 1)->whereNotIn('id', [$data->id])->get() != '')
                        @foreach(App\Models\Designation::where('level', 1)->whereNotIn('id', [$data->id])->get() as $key => $value)
                            <option value="{{ $value->id }}" @if($data->parent == $value->id) selected @endif >{{ $value->name}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Level <small class="text-danger">*</small></label>        
                <select class="form-control demo-select2-placeholder" name="level">
                    <option value="0" @if($data->level == 0) selected @endif>Select Level</option>
                    <option value="1" @if($data->level == 1) selected @endif>Level 1</option>
                    <option value="2" @if($data->level == 2) selected @endif>Level 2</option>
                </select>
            </div>
        </div>
        
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Status <small class="text-danger">*</small></label>        
                <select class="form-control demo-select2-placeholder" name="status">
                    <option value="0" @if($data->status == 0) selected @endif>Deactive</option>
                    <option value="1"  @if($data->status == 1) selected @endif>Active</option>
                </select>
            </div>
        </div>
    </div>

</div>
@endif
                