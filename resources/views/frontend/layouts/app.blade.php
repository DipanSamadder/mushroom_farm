<!DOCTYPE html>

<html>

  <head>

    <meta charset="utf-8">

    <link rel="preconnect" href="https://fonts.gstatic.com">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ dsld_get_base_URL() }}">
    <meta http-equiv="Permissions-Policy" content="interest-cohort=()">
    <meta name="robots" content="@yield('indexing', 'index, follow')">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('meta_title', dsld_get_setting('site_title'))</title>

    

    @yield('canonical')



    <meta name="description" content="@yield('meta_description', dsld_get_setting('site_meta_description') )" />

    <meta name="keywords" content="@yield('meta_keywords', dsld_get_setting('site_meta_keyword') )"> 



    <link rel="icon" type="image/png" sizes="32x32" href="{{ dsld_uploaded_file_path(dsld_get_setting('site_fav_icon')) }}" />

    

    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css'>



    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css'>



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">



    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />


    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    
       @production
        @php
            $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
        @endphp
        <script type="module" src="{{ dsld_get_base_URL() }}/public/build/{{ $manifest['resources/js/main.js']['file']}}"></script>
        <link rel="stylesheet" href="{{ dsld_get_base_URL() }}/public/build/{{$manifest['resources/css/style.css']['file']}}">
        <link rel="stylesheet" href="{{ dsld_get_base_URL() }}/public/build/{{$manifest['resources/css/mystyle.css']['file']}}">
    @else
        @vite(['resources/css/style.css','resources/css/mystyle.css'])
    @endproduction
   
    <style>

        .editor-content p, .short-content p{padding:0px !important;margin:0px !important;}

    </style>

    @yield('head')



  </head>

  <body>

    <header class="main____header">

        @include('frontend.inc.header')

    </header>

    

    @yield('content')



    <footer class="z9 pos-rel">

        @include('frontend.inc.footer')

    </footer>



    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>

    <script src="https://cdn.jsdelivr.net/jquery.counterup/1.0/jquery.counterup.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="{{ dsld_static_asset('frontend/js/wpds.js') }}"></script>

	  @vite(['resources/js/main.js'])

    @yield('footer')

  </body>

</html>