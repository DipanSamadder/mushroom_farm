@extends('backend.layouts.app')

@section('content')
<div class="row clearfix">
    <div class="col-lg-4 col-md-12">
        <div class="card">
            <div class="header">
                <h2><strong>Profile</strong> Details</h2>
            </div>
            <div class="body mcard_3">
                @if(Auth::user()->avatar_original !='')
                    <img src="{{ dsld_uploaded_file_path(Auth::user()->avatar_original) }}" class="rounded-circle shadow " alt="profile-image" style="max-height: 120px;">
                @else
                    <img src="{{ dsld_static_asset('backend/assets/images/profile_av.jpg') }}" class="rounded-circle shadow " alt="profile-image">
                @endif
                <h4 class="m-t-10">{{ Auth::user()->name }}</h4>                            
                <div class="row">
                    <div class="col-12">
                        <p class="text-muted">{{ Auth::user()->address, Auth::user()->city, Auth::user()->country, Auth::user()->postal_code  }}</p>
                    </div>                           
                </div>
                <hr>
                @if(Auth::user()->email != '')
                    <small class="text-muted">Email address: </small>
                    <p>{{ Auth::user()->email }}</p>
                    <hr>
                @endif
               
                @if(Auth::user()->phone != '')
                    <small class="text-muted">Phone: </small>
                    <p>{{ Auth::user()->phone }}</p>
                @endif
            </div>
        </div>                  
    </div>
    <div class="col-lg-8 col-md-12">
        <div class="card">
            <div class="header">
                <h2><strong>Profile</strong> Edit</h2>
            </div>
            <div class="body">
                <form action="{{ route('profiles.update') }}" id="profile_update" method="POST" enctype="multipart/form-data">
                   @csrf
                   
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 form-control-label">
                            <label class="form-label">Name <small class="text-danger">*</small></label>  
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name" onchange="is_edited()" value="{{ Auth::user()->name }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 form-control-label">
                            <label class="form-label">Email <small class="text-danger">*</small></label>  
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <input type="text" name="email" id="email" class="form-control" placeholder="Email" onchange="is_edited()" value="{{ Auth::user()->email }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 form-control-label">
                            <label class="form-label">Phone <small class="text-danger">*</small></label>  
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone" onchange="is_edited()" value="{{ Auth::user()->phone }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 form-control-label">
                            <label class="form-label">Photo <small class="text-danger">*</small></label>  
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                                <a class="btn btn-primary text-white" onclick="media_file_get('{{ @Auth::user()->avatar_original }}','avatar_original', 0)"><i class="zmdi zmdi-collection-image"></i></a><div class="avatar_original">@if(isset(Auth::user()->avatar_original))<strong>Selected Image:</strong><i> {{ @Auth::user()->avatar_original }}</i>@endif</div>
                        
                                <input type="hidden" class="avatar_original" name="avatar_original" id="avatar_original" value="{{ @Auth::user()->avatar_original }}" onchange="is_edited()">
                                @if(Auth::user()->avatar_original > 0)
                                <div class="image mt-2">
                                    <img src="{{ dsld_uploaded_file_path(Auth::user()->avatar_original) }}"  alt="{{ dsld_upload_file_title(Auth::user()->avatar_original) }}" class="img-fluid">
                                </div> 
                                @endif 
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 form-control-label">
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <button type="submit" class="btn btn-success btn-round waves-effect dsld-btn-loader mt-3" id="submit_btn" disabled="disabled">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')
<script>
    
    $(document).ready(function(){
        $('#profile_update').on('submit', function(event){
        event.preventDefault();
            $('.dsld-btn-loader').addClass('btnloading');
            var Loader = ".btnloading";
            DSLDButtonLoader(Loader, "start");
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                cache : false,
                data: {
                    '_token':'{{ csrf_token() }}', 
                    'user_id':'{{ Auth::user()->id }}',
                    'name': $('#name').val(),
                    'email': $('#email').val(),
                    'phone': $('#phone').val(),
                    'avatar_original': $('#avatar_original').val(),
                },
                success: function(data) {
                    DSLDButtonLoader(Loader, "");
                    dsldFlashNotification(data['status'], data['message']);
                    if(data['status'] =='success'){
                        location.reload();
                    }
                    
                }
            });
        });
    });
    function is_edited(){
        $('#submit_btn').removeAttr('disabled');
    }
    function get_pages(){
        window.location.href = "{{ route('profiles.update') }}";
    }

</script>
@endsection