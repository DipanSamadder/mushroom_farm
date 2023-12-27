<div class="row clearfix"> 
    @if(is_array($data) || count($data) > 0)
        @foreach($data as $key => $value)             
        <div class="col-lg-3 col-md-4 col-sm-12">
            <div class="card">
                <a href="javascript:void(0);" class="file">
                    <div class="hover">
                        @if(dsld_have_user_permission('media_delete') == 1)  
                        <button type="button" class="btn btn-icon btn-icon-mini btn-round btn-danger" onclick="file_delete('{{ $value->id }}')">
                            <i class="zmdi zmdi-delete"></i>
                        </button>
                        @endif 
                        <button type="button" class="btn btn-icon btn-icon-mini btn-round btn-success" onclick="file_copy('{{ dsld_uploaded_file_path($value->id) }}')">
                            <i class="zmdi zmdi-hc-fw"></i>
                        </button>

                        @if(dsld_have_user_permission('media_edit') == 1)  
                        <button type="button" class="btn btn-icon btn-icon-mini btn-round btn-primary" onclick="popup_media({{ $value->id }})">
                            <i class="zmdi zmdi-edit"></i>
                        </button>
                        @endif
                    </div>
                    @if(strtok($value->mime_type, '/') == 'image')
                    <div class="image">
                        <img src="{{ dsld_uploaded_file_path($value->id) }}" alt="img" class="img-fluid">
                    </div>
                    @elseif(strtok($value->mime_type, '/') == 'video')
                        <div class="icon">
                            <!-- <i class="zmdi zmdi-collection-video"></i> -->
                            <img src="{{ dsld_static_asset('frontend/images/video.png') }}" alt="img" class="img-fluid" style="width: 100px;">
                        </div>
                    @elseif(strtok($value->mime_type, '/') == 'pdf')
                        <div class="icon">
                            <img src="{{ dsld_static_asset('frontend/images/pdf.png') }}" alt="img" class="img-fluid" style="width: 100px;">
                           
                        </div>
                    @elseif(strtok($value->mime_type, '/') == 'document')
                        <div class="icon">
                            <img src="{{ dsld_static_asset('frontend/images/pdf.png') }}" alt="img" class="img-fluid" style="width: 100px;">
                        </div>
                    @elseif(strtok($value->mime_type, '/') == 'mp3')
                        <div class="icon">
                            <i class="zmdi zmdi-playlist-audio"></i>
                        </div>
                    @endif
                    <div class="file-name">
                        <p class="mb-2 mt-2 text-muted"><a href="{{ dsld_uploaded_file_path($value->id) }}" target="_blank">({{ $value->id }}) - {{ $value->name }}</a> </p>
                        <small> 
                        @if(strtok($value->mime_type, '/') == 'image')<i class="zmdi zmdi-collection-image"></i>
                        @elseif(strtok($value->mime_type, '/') == 'video') <i class="zmdi zmdi-collection-video"></i>
                        @elseif(strtok($value->mime_type, '/') == 'pdf')<i class="zmdi zmdi-collection-pdf"></i>
                        @elseif(strtok($value->mime_type, '/') == 'document')<i class="zmdi zmdi-file-text"></i>
                        @elseif(strtok($value->mime_type, '/') == 'mp3')<i class="zmdi zmdi-playlist-audio"></i>
                        @endif
                            Size: {{ dsld_formatSize($value->size) }}  <span class="date">{{ date("M d Y", strtotime($value->created_at)) }}</span></small>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
        <div class="col-lg-12 col-md-12 col-sm-12">
            {{  $data->links('backend.pagination.custom') }}
        </div>
    @else 
        <div class="col-lg-12 col-md-12 col-sm-12">Sorry!. Noting Found.</div>
    @endif
</div>