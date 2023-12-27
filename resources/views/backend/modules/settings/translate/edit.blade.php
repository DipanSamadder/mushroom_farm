@if($data !='')

<input type="hidden" name="id" value="{{ $data->id }}">
<div class="body">
    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Language <small class="text-danger">*</small></label> 
                <select class="form-control" name="lang">
                    @foreach (\App\Models\Language::all() as $key => $language)
                        <option value="{{ $language->code }}" @if($data->lang == $language->code) selected @endif>{{ $language->name }}</option>
                    @endforeach
                </select>                                
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Key <small class="text-danger">*</small></label>                                 
                <input type="text" name="lang_key" class="form-control" placeholder="Key" @if($data->lang_key) value="{{ $data->lang_key }}" @endif  />                                   
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Value <small class="text-danger">*</small></label>                                 
                <input type="text" name="lang_value" class="form-control" placeholder="Value" @if($data->lang_value) value="{{ $data->lang_value }}" @endif  />                                   
            </div>
        </div>
    </div>

</div>
@endif
                