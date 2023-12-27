<div class="tpHeader">
    <div class="container">
        <ul class="tpUl"> 
        @if (App\Models\Menu::where('type', 'topbar_menu')->where('status', 0)->where('level', 1)->orderBy('order', 'ASC')->get() != '')
            @foreach (App\Models\Menu::where('type', 'topbar_menu')->where('level', 1)->where('status', 0)->orderBy('order', 'ASC')->get() as $key => $value)
                @php
                    $header_menu2 = App\Models\Menu::where('type', 'topbar_menu')
                        ->where('level', 2)
                        ->where('status', 0)
                        ->where('parent', $value->id)
                        ->orderBy('order', 'ASC')
                        ->get();
                    
                @endphp
                <li>
                    <a href="{{ $value->url != '' ? $value->url : '#' }}"
                        class="nav-link @if (is_array($header_menu2) || count($header_menu2) > 0) dropdown-toggle  @endif @if (json_decode($value->setting, true)['class'] != '') {{ json_decode($value->setting, true)['class'] }} @endif" id="{{ strtolower(dsld_generate_slug_by_text($value->name)) }}"
                        @if (json_decode($value->setting, true)['target'] != '0') target="_blank"@endif
                        >
                        {{ $value->name != '' ? $value->name : 'Title Empty' }}
                    </a>

                    @if (is_array($header_menu2) || count($header_menu2) > 0)
                        <ul class="login">
                            @foreach ($header_menu2 as $key2 => $value2)
                                <li class="item"><a class="dropdown-item"
                                        href="{{ $value2->url != '' ? $value2->url : '#' }}"@if (json_decode($value2->setting, true)['target'] != '0') target="_blank" @endif
                                        @if (json_decode($value2->setting, true)['class'] != '') class="{{ json_decode($value2->setting, true)['class'] }}" @endif>{{ $value2->name != '' ? $value2->name : 'Title Empty' }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        @endif    
        </ul>
    </div>
</div>
<div class="container">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ dsld_uploaded_file_path(dsld_get_setting('site_logo')) }}" class="img-fluid">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>  
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav side____bar__sec">
                
                @if (App\Models\Menu::where('type', 'header_menu')->where('status', 0)->where('level', 1)->orderBy('order', 'ASC')->get() != '')
                @foreach (App\Models\Menu::where('type', 'header_menu')->where('level', 1)->where('status', 0)->orderBy('order', 'ASC')->get() as $key => $value)
                    @php
                        $header_menu2 = App\Models\Menu::where('type', 'header_menu')
                            ->where('level', 2)
                            ->where('status', 0)
                            ->where('parent', $value->id)
                            ->orderBy('order', 'ASC')
                            ->get();
                        
                    @endphp
                    <li class="nav-item dropdown">
                        <a href="{{ $value->url != '' ? $value->url : '#' }}"
                            class="nav-link @if (is_array($header_menu2) || count($header_menu2) > 0) dropdown-toggle  @endif @if (json_decode($value->setting, true)['class'] != '') {{ json_decode($value->setting, true)['class'] }} @endif" id="{{ strtolower(dsld_generate_slug_by_text($value->name)) }}"
                            @if (json_decode($value->setting, true)['target'] != '0') target="_blank"@endif
                            >
                            {{ $value->name != '' ? $value->name : 'Title Empty' }}
                        </a>

                        @if (is_array($header_menu2) || count($header_menu2) > 0)
                            <ul class="login">
                                @foreach ($header_menu2 as $key2 => $value2)
                                    <li class="item"><a class="dropdown-item"
                                            href="{{ $value2->url != '' ? $value2->url : '#' }}"@if (json_decode($value2->setting, true)['target'] != '0') target="_blank" @endif
                                            @if (json_decode($value2->setting, true)['class'] != '') class="{{ json_decode($value2->setting, true)['class'] }}" @endif>{{ $value2->name != '' ? $value2->name : 'Title Empty' }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            @endif    
            </ul>
            
            </div>

            
        </div>
    </nav>
</div> 