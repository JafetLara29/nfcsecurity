<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    
    {{-- <link rel="icon" href="../files/assets/images/favicon.ico" type="image/x-icon"> --}}
    <!-- Google font-->
    {{-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet"> --}}
    
    {{-- Styles --}}
    @vite([
        'resources/bower_components/bootstrap/dist/css/bootstrap.min.css',
        "resources/assets/icon/themify-icons/themify-icons.css",
        "resources/assets/icon/icofont/css/icofont.css",
        "resources/assets/css/style.css",
    ])
    <!-- Scripts -->
    @vite(['resources/js/app.js'])
</head>
<body>
    <div id="app">
        <!-- Pre-loader start -->
        <div class="theme-loader">
            <div class="ball-scale">
                <div class='contain'>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pre-loader end -->
        
        <main>
            @yield('content')
        </main>
    </div>
    @vite([
        "resources/bower_components/jquery/dist/jquery.min.js",
        "resources/bower_components/jquery-ui/jquery-ui.min.js",
        "resources/bower_components/popper.js/dist/umd/popper.min.js",
        "resources/bower_components/bootstrap/dist/js/bootstrap.min.js",
        
        "resources/bower_components/jquery-slimscroll/jquery.slimscroll.js",
        
        "resources/bower_components/modernizr/modernizr.js",
        "resources/bower_components/modernizr/feature-detects/css-scrollbars.js",
        
        "resources/bower_components/i18next/i18next.min.js",
        "resources/bower_components/i18next-xhr-backend/i18nextXHRBackend.min.js",
        "resources/bower_components/i18next-browser-languagedetector/i18nextBrowserLanguageDetector.min.js",
        "resources/bower_components/jquery-i18next/jquery-i18next.min.js",
        "resources/assets/js/common-pages.js",
    ])
</body>
</html>
