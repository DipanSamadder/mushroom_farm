@if($data !='')

<input type="hidden" name="id" value="{{ $data->id }}">
<div class="body">
    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Name <small class="text-danger">*</small></label>                                 
                <input type="text" name="title" class="form-control" placeholder="Title" @if($data->title) value="{{ $data->title }}" @endif  />                                   
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Template <small class="text-danger">*</small></label>                                 
                <input type="text" name="template" class="form-control" placeholder="Value" @if($data->template) value="{{ $data->template }}" @endif  />                                   
            </div>
        </div>
    </div>

</div>
@endif
                