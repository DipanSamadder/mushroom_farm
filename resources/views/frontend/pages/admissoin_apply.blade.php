@extends('frontend.layouts.app')
@include('frontend.partials.page_meta')
@section('content')

    @if(dsld_page_meta_value_by_meta_key('setting_page_banner_slider', $page->id) == 'banner') 
        <section class="bgpdeta" style="background: url(<?php if(!is_null($page->banner) || $page->banner != 0) { echo dsld_uploaded_file_path($page->banner); } ?>)">
            <div class="container">
                <div class="row lklsq">
                <div class="col-lg-12 mobile____banner__5">
                    <img src="http://127.0.0.1:8000/uploads/all/1/logo.png" alt="">
                </div>
                <div class="col-lg-8 p-5 mt-5 mb-5 formblhide">
                        <div class="lndBnrCnt">
                        </div>
                    </div>
                    <div class="col-lg-4 bg-whitegrey py-3 px-4">
                        <h2 class="f32 gothambold colorred">Get Started</h2>
                        <p class="2a2a2a f13 gothamnarrow325">Register Now to Get Information.</p>
                        <div id="npf_form" data-ww="70" style="max-width:400px; height:300px;"></div>
                        <form>
                            <input type="text" class="form-control rounded-0 my-2" id="fname" placeholder="Full Name">
                            <input type="text" class="form-control rounded-0 my-2" id="fname" placeholder="Email ID">
                            <input type="text" class="form-control rounded-0 my-2" id="fname" placeholder="Contact No.">
                            <div class="row py3">
                                <div class="col-md-6 selecot___drop">
                                    <select class="form-select rounded-0" aria-label="Default select example">
                                        <option selected>Select Program</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <div class="col-md-6  selecot___drop___once">
                                    <select class="form-select rounded-0" aria-label="Default select example">
                                        <option selected>Select Cource</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row py-3">
                                <div class="col-md-6 selecot___drop">
                                    <select class="form-select rounded-0" aria-label="Default select example">
                                        <option selected>Select State</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <div class="col-md-6 selecot___drop">
                                    <select class="form-select rounded-0" aria-label="Default select example">
                                        <option selected>Select City</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row d-flex">
                                <div class="input-group  rounded-0">
                                    <span class="input-group-text rounded-0 w-50" id="basic-addon1">AvnMZ</span>
                                    <input type="text" class="form-control rounded-0 w-50" placeholder="Enter text as shown"
                                        aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input mt-4 mb-3 rounded-0" type="checkbox" value=""
                                    id="flexCheckDefault">
                                <label class="form-check-label mt-3 mb-3 f10 gothamnarrow325" for="flexCheckDefault">
                                I agree to receive information by signing up on Galgotias College
                                </label>
                            </div>
                            <div class="form-group  text-center">
                                <a href="#" class="btn text-decoration-none f19 gothamnarrow325 applynowwe rounded-0">
                                    <b>APPLY NOW<b>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if(!is_null(dsld_page_meta_value_by_meta_key('admissionapply_admissionapply_file_0', $page->id)))
        <section class="ingpa5">
            <div class="container py-3">
                <div class="row py-5 my-5">
                    <img src="{{ dsld_uploaded_file_path(dsld_page_meta_value_by_meta_key('admissionapply_admissionapply_file_0', $page->id)) }}">
                </div>
            </div>
        </section>
    @endif

    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="instnts">
                        <h2>
                            {{ $page->title }}
                            @auth()
                                <a href="{{ route('pages.edit', [$page->id]) }}"><i class="fas fa-edit"></i> </a>
                            @endauth
                        </h2>

                        @if(!is_null($page->short_content))
                            <p>{{ $page->short_content }}</p>
                        @endif

                        @if(!is_null($page->content))
                            <p>
                                @php $str = $page->content; @endphp
                                <?php echo htmlspecialchars_decode($str); ?>
                            </p>
                        @endif

                        <hr>
                        <h3>{{ dsld_page_meta_value_by_meta_key('admissionapply_admissionapply_text_1', $page->id) }}</h3>

                        @if(dsld_page_meta_value_by_meta_key('admissionapply_admissionapply_text_repeter_2', $page->id) != '')
                                @foreach(json_decode(dsld_page_meta_value_by_meta_key('admissionapply_admissionapply_text_repeter_2', $page->id), true) as $key3 => $value) 
                                <div class="d-flex">
                                    <div class="pointersa"></div>
                                    <p>{{ $value }}<p>
                                </div>
                                <hr>
                            @endforeach
                        @endif
                        
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="inerssd">
                        <h2>STEPS TO FOLLOW</h2>
                        @if(dsld_page_meta_value_by_meta_key('admissionapply_admissionapply_text_repeter_3', $page->id) != '')
                                @foreach(json_decode(dsld_page_meta_value_by_meta_key('admissionapply_admissionapply_text_repeter_3', $page->id), true) as $key3 => $value) 
                                <div class="dsdfA d-flex mt-4">
                                    <div class="kite">STEPS <br><span>{{ $key3+1 }}</span>
                                    </div><p>{{ $value }}</p>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer')
<script type="text/javascript">
var s=document.createElement("script");s.type="text/javascript",s.async=!0,s.src="{{ dsld_static_asset('frontend/js/widget.js') }}", document.body.appendChild(s);
</script>
@endsection