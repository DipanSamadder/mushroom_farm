<form class="form-inline" action="javascript:void(0)" id="put_media_form">
    <input type="hidden" name="select_media_image_field" @if(isset($id)) value="{{ $id}}" @endif>
    <input type="hidden" name="put_media_image_field_class" value="{{ @$class }}">
    <div class="row clearfix mt-3 media_library"> 
    @if(is_array($data) || count($data) > 0)
                    
        <div class="col-lg-12 col-md-12 col-sm-12">
            
            <ul>
            @foreach($data as $key => $value) 

            <li>
                <div class="card media_library" style="background: #fff8f8; padding: 10px; border: 1px solid #ededed;">
               
                
                <a href="javascript:void(0);" class="file">
                    @if(strtok($value->mime_type, '/') == 'image')
                    <div class="image">
                        
                        <input type="radio"  name="select_media_image" style="display:none;" id="cb{{ $value->id }}" value="{{ $value->id }}" @if($id == $value->id) checked @endif />
                        <label for="cb{{ $value->id }}"><img onclick="selected_image('{{ $value->id }}')" src="{{ dsld_uploaded_file_path($value->id) }}" alt="img" class="img-fluid" style="height:100px"></label>
                    </div>
                    @elseif(strtok($value->mime_type, '/') == 'video')
                        <div class="icon">
                            <i class="zmdi zmdi-collection-video"></i>
                        </div>
                    @elseif(strtok($value->mime_type, '/') == 'pdf')
                        <div class="icon">
                            <i class="zmdi zmdi-collection-pdf"></i>
                        </div>
                    @elseif(strtok($value->mime_type, '/') == 'document')
                        <div class="icon">
                            <i class="zmdi zmdi-file-text"></i>
                        </div>
                    @elseif(strtok($value->mime_type, '/') == 'mp3')
                        <div class="icon">
                            <i class="zmdi zmdi-playlist-audio"></i>
                        </div>
                    @endif
                    <div class="file-name">
                        
                        <small> <p class="m-b-5 text-muted">({{ $value->id }}) - {{ substr($value->name, 0, 10) }} </p></small>
                    </div>
                </a>
            </div>
            </li>
            @endforeach
            </ul>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            {{  $data->links('backend.pagination.custom') }}
        </div>
    @else 
        <div class="col-lg-12 col-md-12 col-sm-12">Sorry!. Noting Found.</div>
    @endif
</div>
<div class="col-lg-12 col-md-12 col-sm-12">
    <button type="button" class="btn btn-danger btn-round waves-effect" data-dismiss="modal">CLOSE</button>
    <div class="swal-button-container">
        <button type="submit" class="btn btn-success btn-round waves-effect dsld-btn-loader"  id="put_media_form_btn" style="display: none;">SET IMAGE</button>
    </div>
</div>
</form>
<style>
    .media_library ul {
  list-style-type: none;
}

.media_library li {
  display: inline-block;max-width: 120px;
}

.media_library  input[type="checkbox"][id^="myCheckbox"] {
  display: none;
}

.media_library label {
  border: 1px solid #fff;
  display: block;
  cursor: pointer;
}

.media_library label:before {
  background-color: white;
  color: white;
  content: " ";
  display: block;
  border-radius: 50%;
  border: 1px solid grey;
  position: absolute;
  top: -5px;
  left: -5px;
  width: 25px;
  height: 25px;
  text-align: center;
  line-height: 28px;
  transition-duration: 0.4s;
  transform: scale(0);
}

.media_library label img {
  height: 100px;
  width: 100px;
  transition-duration: 0.2s;
  transform-origin: 50% 50%;
}

.media_library  :checked + label {
  border-color: #ddd;
}

.media_library  :checked + label:before {
  content: "✓";
  background-color: grey;
  transform: scale(1);
}

.media_library  :checked + label img {
  transform: scale(0.9);
  /* box-shadow: 0 0 5px #333; */
  z-index: -1;
}

</style>