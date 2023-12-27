@if($data !='')
<input type="hidden" id="edit_id" value="{{ $data->id }}">                               
<div class="body">
    <div class="row clearfix">
        <div class="col-sm-9">
            <div class="form-group">
                <label class="form-label">Alt Tag <small class="text-danger">*</small></label>                                 
                <input type="text" name="file_title" id="edit_file_title" class="form-control" placeholder="Title" @if($data->name) value="{{ $data->name }}" @endif />                                      
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label class="form-label">Order<small class="text-danger">*</small></label>                                 
                <input type="text" name="edit_order" id="edit_order" class="form-control" placeholder="Order" value="{{ $data->order_column }}" />                                   
            </div>
        </div>
    </div>
</div>
@endif
                