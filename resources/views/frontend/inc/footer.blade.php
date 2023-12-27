

<div class="container">

    <div class="row">

        <div class="col-lg-8 mb-4">

            

            <div class="ftrlist scndList ">

                <h4 class="mb-4">QUICK LINKS</h4>

                <ul class="ftrUl">
                @if (App\Models\Menu::where('type', 'quick_link')->where('status', 0)->where('level', 1)->orderBy('order', 'ASC')->get() != '')

                    @foreach (App\Models\Menu::where('type', 'quick_link')->where('level', 1)->where('status', 0)->orderBy('order', 'ASC')->get() as $key => $value)
                    
                        <li><a href=""{{ $value->url != '' ? $value->url : '#' }}" class="ftlItem">{{ $value->name }}</a></li>
                    @endforeach

                @endif 
                    

                </ul>

            </div>

        </div>

       <!--  <div class="col-lg-3 mb-4">

            

            <div class="ftrlist ftrlist____mobile scndList pt-4">

            <h4 class="mb-4"></h4>

                <ul class="ftrUl">

                    <li>

                        <a href="#" class="ftlItem">Eligibility Criteria </a>

                    </li>

                    <li>

                        <a href="#" class="ftlItem">Fee Structure</a>

                    </li>

                    <li>

                        <a href="#" class="ftlItem">Document Checklist </a>

                    </li>

                    <li>

                        <a href="#" class="ftlItem">Sports Quota Scholarship </a>

                    </li>

                    

                </ul>

            </div>

        </div>

        <div class="col-lg-3 mb-4">

            

            <div class="ftrlist ftrlist____mobile scndList pt-4">

            <h4 class="mb-4"></h4>

                <ul class="ftrUl">

                    <li>

                        <a href="#" class="ftlItem">Terms </a>

                    </li>

                    <li>

                        <a href="#" class="ftlItem">Privacy Policy </a>

                    </li>

                    <li>

                        <a href="#" class="ftlItem">Disclaimer  </a>

                    </li>

                    <li>

                        <a href="#" class="ftlItem"> Sitemap</a>

                    </li>

                    

                </ul>

            </div>

        </div> -->

        <div class="col-lg-4 mb-4">

            <div class="ftrlist ftrlist____mobile___icon ">

                <h4 class="mb-4">REACH US</h4>

                <address class="mb-4">Address: {{ dsld_get_setting('site_footer_address') }}</address>

                <div class="contactList mb-4">

                    <ul class="cntctUl">
                    <li class="cntctItem____title"><span>Phone: </span></li>
                        <li class="cntctItem d-flex align-items-center">

                            <a href="tel:{{ dsld_get_setting('site_footer_phone_number1') }}" class="mx-1"> {{ dsld_get_setting('site_footer_phone_number1') }}</a>

                            <a href="tel:{{ dsld_get_setting('site_footer_phone_number2') }}" >, {{ dsld_get_setting('site_footer_phone_number2') }}</a>

                        </li>
                        <li class="cntctItem____title"><span>Email: </span></li>
                        <li class="cntctItem d-flex align-items-center">

                            <a href="mailto:{{ dsld_get_setting('site_footer_email1') }}" >{{ dsld_get_setting('site_footer_email1') }}</a>

                        </li>

                        <li class="cntctItem d-flex align-items-center">

                            <a href="mailto:{{ dsld_get_setting('site_footer_email2') }}" >{{ dsld_get_setting('site_footer_email2') }}</a>

                        </li>

                        <li class="cntctItem d-flex align-items-center">

                            <a href="mailto:{{ dsld_get_setting('site_footer_email3') }}" >{{ dsld_get_setting('site_footer_email3') }}</a>

                        </li>

                    </ul>

                </div>

                <div class="cntctSocial">

                    

                    <ul class="d-flex align-items-center SocialUl">

                        @if(dsld_get_setting('social_link_url') != '' )

                            @foreach(json_decode(dsld_get_setting('social_link_url'), true) as $key => $value)

                                @php

                                    $url = json_decode(dsld_get_setting('social_link_url'), true)[$key];

                                    $name = json_decode(dsld_get_setting('social_link_name'), true)[$key];

                                @endphp

                                @if($name == 'fb')

                                    <li><a href="{{ $url }}" target="_blank" class="SocialItem"><img src="{{ dsld_static_asset('frontend/images/fb.png') }}" class="img-fluid"></a></li>

                                @endif

                                @if($name == 'li')

                                    <li><a href="{{ $url }}"  target="_blank" class="SocialItem"><img src="{{ dsld_static_asset('frontend/images/in.png') }}" class="img-fluid"></a></li>

                                @endif

                                @if($name == 'In')

                                    <li><a href="{{ $url }}"  target="_blank" class="SocialItem"><img src="{{ dsld_static_asset('frontend/images/insta.png') }}" class="img-fluid"></a></li>

                                @endif

                                @if($name == 'yt')

                                    <li><a href="{{ $url }}" target="_blank" class="SocialItem"><img src="{{ dsld_static_asset('frontend/images/yout.png') }}" class="img-fluid"></a></li>

                                @endif

                                @if($name == 'tw')

                                    <li><a href="{{ $url }}" target="_blank" class="SocialItem"><img src="{{ dsld_static_asset('frontend/images/tw.png') }}" class="img-fluid"></a></li>

                                @endif

                            @endforeach

                        @endif

                    </ul>

                </div>

            </div>

        </div>

    </div>

</div>

<div class="ftrBtm">    

    <ul class="d-flex justify-content-center align-items-center">

        <li>© Copyright 2018, all rights reserved with GALGOTIA COLLEGE</li>

        

    </ul>

</div>

