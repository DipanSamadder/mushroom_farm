

<input type="hidden" name="rooms_id" value="{{ @$rid }}">
<input type="hidden" name="grades_id" value="{{ @$gid }}">
<div class="body">
    <div class="row clearfix">
        @if(!is_null(App\Models\ProCategory::where('status', 1)->get()))  
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Category <small class="text-danger">*</small></label>
                <select class="form-control demo-select2-placeholder" name="categories_id">
                    <option value="">Select Category</option>
                    @foreach(App\Models\ProCategory::where('status', 1)->get()  as $key => $value)
                        <option value="{{ $value->id }}" @if(@$data->categories_id == $value->id) selected @endif>{{ $value->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endif

        @if(!is_null(App\Models\Vendor::where('status', 1)->get()))  
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Vendor</label>
                <select class="form-control demo-select2-placeholder" name="vandor">
                    <option value="">Select Vendor</option>
                    @foreach(App\Models\Vendor::where('status', 1)->get()  as $key => $value)
                        <option value="{{ $value->id }}" @if(@$data->vandor == $value->id) selected @endif>{{ $value->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endif

        <div class="col-sm-12">
            <div class="form-group">
                @php
                    $pro = @App\Models\Production::where('rooms_id', $rid)->where('grades_id', $gid)->first();
                @endphp
                <label class="form-label">Qty <small class="text-danger">* ({{ @$pro->qty }} Pcs)</small> </label>                                 
                <input type="text" name="qty" class="form-control" placeholder="Qty" @if(@$data->qty) value="{{ @$data->qty }}" @endif  />                                   
            </div>
        </div>
    </div>
</div>
        
