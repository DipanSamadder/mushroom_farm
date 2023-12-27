@if($data !='')

<input type="hidden" name="id" value="{{ $data->id }}">
<input type="hidden" name="type" value="page_others">
<input type="hidden" name="lang" value="en">
<div class="body">
    <div class="row clearfix">
        <div class="col-sm-8">
            <div class="form-group">
                <label class="form-label">Name <small class="text-danger">*</small></label>                                 
                <input type="text" name="title" class="form-control" placeholder="Name" @if($data->title) value="{{ $data->title }}" @endif  />                                   
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label class="form-label">Category </label>                                 
                <select class="form-control show-tick ms select2" name="cat_type">
                    <option value="0">-- Please select --</option>
                    <option value="achievements" @if($data->cat_type == 'achievements')  selected @endif>Achievements</option>
                    <option value="highlights" @if($data->cat_type == 'highlight')  selected @endif>Highlights</option>
                </select>
            </div>
        </div>


        <div class="col-sm-4">
            <div class="form-group">
                <label class="form-label">Order</label>                                 
                <input type="text" name="order" class="form-control" placeholder="Order" value="{{ $data->order }}" />                                   
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">                                 
                <label class="form-label">Status <small class="text-danger">*</small></label>                                 
                <select class="form-control w-100  ms select2 mr-2" name="status">
                    <option value="">-- Please select --</option>
                    <option value="1"  @if($data->status == 1) selected @endif>Active</option>
                    <option value="0" @if($data->status == 0) selected @endif>Deactive</option>
                </select>                            
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label class="form-label">Banner</label><br>
                 <a class="btn btn-primary text-white" onclick="media_file_get('{{ @$data->banner }}','put_image', 0)"><i class="zmdi zmdi-collection-image"></i></a>@if($data->banner > 0)
                <div class="image mt-2 d-inline">
                    <img src="{{ dsld_uploaded_file_path($data->banner) }}"  alt="{{ dsld_upload_file_title($data->banner) }}" class="img-fluid" width="50">
                </div> 
                @endif 
                 
                 <div class="put_image">@if(isset($data->banner))<strong>Selected Image:</strong><i> {{ @$data->banner }}</i>@endif</div>
                        
                <input type="hidden" class="put_image" name="banner" id="banner" value="{{ @$data->banner }}" onchange="is_edited()">
                
                                                                            
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Content </label> 
                <textarea class="form-control" name="content" onchange="is_edited()" rows="4" cols="50">
                    @if($data->content) {{ $data->content }} @endif
                </textarea>                                
            </div>
        </div>
    </div>

</div>
<script>
    
    $(document).ready(function(){
        $(".summernote").summernote('code');
    });
</script>
@endif
                