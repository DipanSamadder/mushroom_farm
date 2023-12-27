@if($data !='')

<input type="hidden" name="id" value="{{ $data->id }}">
<div class="body">
    <div class="row clearfix">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label">Name <small class="text-danger">*</small></label>                                 
                <input type="text" name="name" class="form-control" placeholder="Name" @if($data->name) value="{{ $data->name }}" @endif  />                                   
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label">Code <small class="text-danger">*</small></label>                                 
                <input type="text" name="code" class="form-control" placeholder="Code" @if($data->code) value="{{ $data->code }}" @endif  />                                   
            </div>
        </div>
    </div>

</div>
@endif
                