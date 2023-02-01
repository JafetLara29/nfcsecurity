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
    {{-- Scripts --}}
    {{-- @vite(["resources/bower_components/jquery/dist/jquery.min.js"]) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <!-- Font Awesome -->
    @vite(['resources/assets/icon/font-awesome/css/font-awesome.min.css'])

    {{-- Styles --}}
    @vite([
        'resources/assets/css/sweetalert.css',
        'resources/bower_components/bootstrap/dist/css/bootstrap.min.css',
        "resources/assets/icon/feather/css/feather.css",
        "resources/assets/css/style.css",
        "resources/assets/css/jquery.mCustomScrollbar.css",
    ])
    {{-- DataTables --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/r-2.3.0/sp-2.0.2/datatables.min.css"/>

    <script>
        var timer;
        $(document).ready(function () {
            ringtone = new Audio("{{ asset('storage/rigtones/AlarmClock.mp3') }}");
            
            // setInterval(() => {
                timer = new Timer(function() {
                    fetchdata();
                }, 10000);
            // }, 10000); 
        });
        
        var Timer = function(callback, delay) {
            var timerId, start, remaining = delay;

            this.pause = function() {
                window.clearTimeout(timerId);
                timerId = null;
                remaining -= Date.now() - start;
            };

            this.resume = function() {
                if (timerId) {
                    return;
                }

                start = Date.now();
                timerId = window.setTimeout(callback, remaining);
            };

            this.resume();
        };

        function fetchdata(){
            $.ajax({
                type: "post",
                url: "/sos/check",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(response){
                    if(response["alert"] == true){
                        timer.pause();

                        ringtone.play();
                        ringtone.loop = true;
                        
                        // Perform operation on return value
                        swal({
                            title: "SOS",
                            text: "Parece que un oficial necesita ayuda!",
                            type: "warning",
                            showCancelButton: false,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "Entendido",
                            closeOnConfirm: false
                        },
                        function(){
                            swal("Atendida", "Alarma atendida", "success");
                            ringtone.pause();
                            timer = new Timer(function() {
                                fetchdata();
                            }, 10000);
                        });
                    }else{
                        timer = new Timer(function() {
                            fetchdata();
                        }, 10000);
                    }
                },
            });
        }
        
        function makeSOSCall(){
            $.ajax({
                type: "post",
                url: "/sos",
                dataType: "json",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (response) {
                    if(response["success"] == true){
                        alert('alerta hecha');
                        swal("Correcto", "SOS enviado", "success");
                    }else{
                        swal("Error", "Ha ocurrido un erro al realizar el llamado sos", "error");
                    }
                }
            });
        }
    </script>
    
</head>
<body>
    <div id="app">

        <input type="hidden" id="continue" value="true">
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
    
        <div id="pcoded" class="pcoded">
            <div class="pcoded-overlay-box"></div>
            <div class="pcoded-container navbar-wrapper">

                {{-- Navbar --}}
                <nav class="navbar header-navbar pcoded-header">
                    <div class="navbar-wrapper">

                        {{-- Logo y SOS --}}
                        <div class="navbar-logo d-flex">
                            <a class="mobile-menu" id="mobile-collapse" href="#!">
                                <i class="feather icon-menu"></i>
                            </a>
                            {{-- Si no es un usuario admin muestra el boton de panico --}}
                            @if (Auth::user()->is_admin == false)
                                <button type="submit" class="btn btn-danger" onclick="makeSOSCall()">SOS</button>
                            @else
                            <a class="navbar-brand" href="#">
                                NFC Security
                            </a>
                            @endif

                            <a class="mobile-options">
                                <i class="feather icon-more-horizontal"></i>
                            </a>
                        </div>

                        <div class="navbar-container">
                            {{-- Iconos de la parte izquierda del navbar (Ampliador de pantalla etc) --}}
                            <ul class="nav-left">
                                <li>
                                    <a href="#!" id="full-screen-icon" class="waves-effect waves-light">
                                        <i class="full-screen feather icon-maximize"></i>
                                    </a>
                                </li>
                            </ul>
                            {{-- Opciones de la parte derecha del navbar --}}
                            <ul class="nav-right">
                                <li class="header-notification">
                                    <div class="dropdown-primary dropdown">
                                        <div class="dropdown-toggle" data-bs-toggle="dropdown">
                                            <i class="feather icon-bell"></i>
                                            <span class="badge bg-c-pink">5</span>
                                        </div>
                                        <ul class="show-notification notification-view dropdown-menu"
                                            data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                            <li>
                                                <h6>Notifications</h6>
                                                <label class="form-label label label-danger">New</label>
                                            </li>
                                            <li>
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0">
                                                    <img class="d-flex align-self-center img-radius"
                                                        src="{{ asset('storage/images/avatar-4.jpg') }}"
                                                        alt="Generic placeholder image">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h5 class="notification-user">John Doe</h5>
                                                        <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer
                                                            elit.</p>
                                                        <span class="notification-time">30 minutes ago</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0">
                                                        <img class="d-flex align-self-center img-radius"
                                                            src="{{ asset('storage/images/avatar-3.jpg') }}"
                                                            alt="Generic placeholder image">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h5 class="notification-user">Joseph William</h5>
                                                        <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer
                                                            elit.</p>
                                                        <span class="notification-time">30 minutes ago</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0">
                                                        <img class="d-flex align-self-center img-radius"
                                                            src="{{ asset('storage/images/avatar-4.jpg') }}"
                                                            alt="Generic placeholder image">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h5 class="notification-user">Sara Soudein</h5>
                                                        <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer
                                                            elit.</p>
                                                        <span class="notification-time">30 minutes ago</span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="header-notification">
                                    <div class="dropdown-primary dropdown">
                                        <div class="displayChatbox dropdown-toggle" id="chat-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="feather icon-message-square"></i>
                                            <span class="badge bg-c-green">3</span>
                                        </div>
                                    </div>
                                </li>
                                {{-- Dropdown de las opciones de configuracion --}}
                                <li class="user-profile header-notification">
                                    <div class="dropdown-primary dropdown">
                                        <div class="dropdown-toggle" data-bs-toggle="dropdown">
                                            <img src="{{ asset('storage/images/avatar-4.jpg') }}" class="img-radius"
                                                alt="User-Profile-Image">
                                            <span>John Doe</span>
                                            <i class="feather icon-chevron-down"></i>
                                        </div>
                                        <ul class="show-notification profile-notification dropdown-menu"
                                            data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                            <li>
                                                <a href="#!">
                                                    <i class="feather icon-settings"></i> Settings
                                                </a>
                                            </li>
                                            <li>
                                                <a href="user-profile.html">
                                                    <i class="feather icon-user"></i> Profile
                                                </a>
                                            </li>
                                            <li>
                                                <a href="email-inbox.html">
                                                    <i class="feather icon-mail"></i> My Messages
                                                </a>
                                            </li>
                                            <li>
                                                <a href="auth-lock-screen.html">
                                                    <i class="feather icon-lock"></i> Lock Screen
                                                </a>
                                            </li>
                                            <li>
                                                <form action="{{ route('logout') }}" method="post">
                                                    @csrf
                                                    <button class="btn btn-dark w-100">
                                                        <i class="feather icon-log-out"></i> Logout
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>

                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                {{-- End navbar --}}

                <!-- Sidebar chat start -->
                <div id="sidebar" class="users p-chat-user showChat" aria-labelledby="chat-dropdown">
                    <div class="had-container">
                        <div class="card card_main p-fixed users-main">
                            <div class="user-box">
                                <div class="chat-inner-header">
                                    <div class="back_chatBox">
                                        <div class="right-icon-control">
                                            <input type="text" class="form-control  search-text" placeholder="Search Friend"
                                                id="search-friends">
                                            <div class="form-icon">
                                                <i class="icofont icofont-search"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="main-friend-list">
                                    <div class="media userlist-box" data-id="1" data-status="online"
                                        data-username="Josephin Doe" data-bs-toggle="tooltip" data-bs-placement="left"
                                        title="Josephin Doe">
                                        <a class="media-left" href="#!">
                                            <img class="media-object img-radius img-radius"
                                                src="{{ asset('storage/images/avatar-3.jpg') }}" alt="Generic placeholder image ">
                                            <div class="live-status bg-success"></div>
                                        </a>
                                        <div class="media-body">
                                            <div class="f-13 chat-header">Josephin Doe</div>
                                        </div>
                                    </div>
                                    <div class="media userlist-box" data-id="2" data-status="online"
                                        data-username="Lary Doe" data-bs-toggle="tooltip" data-bs-placement="left"
                                        title="Lary Doe">
                                        <a class="media-left" href="#!">
                                            <img class="media-object img-radius" src="{{ asset('storage/images/avatar-2.jpg') }}"
                                                alt="Generic placeholder image">
                                            <div class="live-status bg-success"></div>
                                        </a>
                                        <div class="media-body">
                                            <div class="f-13 chat-header">Lary Doe</div>
                                        </div>
                                    </div>
                                    <div class="media userlist-box" data-id="3" data-status="online" data-username="Alice"
                                        data-bs-toggle="tooltip" data-bs-placement="left" title="Alice">
                                        <a class="media-left" href="#!">
                                            <img class="media-object img-radius" src="{{ asset('storage/images/avatar-4.jpg') }}"
                                                alt="Generic placeholder image">
                                            <div class="live-status bg-success"></div>
                                        </a>
                                        <div class="media-body">
                                            <div class="f-13 chat-header">Alice</div>
                                        </div>
                                    </div>
                                    <div class="media userlist-box" data-id="4" data-status="online" data-username="Alia"
                                        data-bs-toggle="tooltip" data-bs-placement="left" title="Alia">
                                        <a class="media-left" href="#!">
                                            <img class="media-object img-radius" src="{{ asset('storage/images/avatar-3.jpg') }}"
                                                alt="Generic placeholder image">
                                            <div class="live-status bg-success"></div>
                                        </a>
                                        <div class="media-body">
                                            <div class="f-13 chat-header">Alia</div>
                                        </div>
                                    </div>
                                    <div class="media userlist-box" data-id="5" data-status="online" data-username="Suzen"
                                        data-bs-toggle="tooltip" data-bs-placement="left" title="Suzen">
                                        <a class="media-left" href="#!">
                                            <img class="media-object img-radius" src="{{ asset('storage/images/avatar-2.jpg') }}"
                                                alt="Generic placeholder image">
                                            <div class="live-status bg-success"></div>
                                        </a>
                                        <div class="media-body">
                                            <div class="f-13 chat-header">Suzen</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar inner chat start-->
                <div class="showChat_inner">
                    <div class="media chat-inner-header">
                        <a class="back_chatBox">
                            <i class="feather icon-chevron-left"></i> Josephin Doe
                        </a>
                    </div>
                    <div class="d-flex chat-messages">
                        <div class="flex-shrink-0">
                            <a class="media-left photo-table" href="#!">
                                <img class="media-object img-radius img-radius m-t-5" src="{{ asset('storage/images/avatar-3.jpg') }}"
                                    alt="Generic placeholder image">
                            </a>
                        </div>
                        <div class="flex-grow-1 chat-menu-content">
                            <div class="">
                                <p class="chat-cont">I'm just looking around. Will you tell me something about yourself?</p>
                                <p class="chat-time">8:20 a.m.</p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex chat-messages">
                        <div class="flex-grow-1 chat-menu-reply">
                            <div class="">
                                <p class="chat-cont">I'm just looking around. Will you tell me something about yourself?</p>
                                <p class="chat-time">8:20 a.m.</p>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="media-right photo-table">
                                <a href="#!">
                                    <img class="media-object img-radius img-radius m-t-5"
                                        src="{{ asset('storage/images/avatar-4.jpg') }}" alt="Generic placeholder image">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="chat-reply-box p-b-20">
                        <div class="right-icon-control">
                            <input type="text" class="form-control search-text" placeholder="Share Your Thoughts">
                            <div class="form-icon">
                                <i class="feather icon-navigation"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Sidebar inner chat end-->

                {{-- Contenido de la pagina --}}
                <div class="pcoded-main-container">
                    <div class="pcoded-wrapper">
                        
                        {{-- Sidebar --}}
                        <nav class="pcoded-navbar">
                            <div class="pcoded-inner-navbar main-menu">
                                <div class="pcoded-navigatio-lavel">Mantenimiento</div>
                                <ul class="pcoded-item pcoded-left-item">
                                    <li class=" ">
                                        <a href="{{ route('users.index') }}">
                                            <span class="pcoded-micon"><i class="fa fa-users"></i><b>A</b></span>
                                            <span class="pcoded-mtext">Usuarios</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="pcoded-navigatio-lavel">Reportes</div>
                                <ul class="pcoded-item pcoded-left-item">
                                    <li class=" ">
                                        <a href="{{ route('sos.report') }}">
                                            <span class="pcoded-micon"><i class="fa fa-warning"></i><b>A</b></span>
                                            <span class="pcoded-mtext">SOS</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="pcoded-navigatio-lavel">UI Element</div>
                                <ul class="pcoded-item pcoded-left-item">
                                    <li class="pcoded-hasmenu">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="feather icon-box"></i></span>
                                            <span class="pcoded-mtext">Basic Components</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class=" ">
                                                <a href="alert.html">
                                                    <span class="pcoded-mtext">Alert</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="breadcrumb.html">
                                                    <span class="pcoded-mtext">Breadcrumbs</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="button.html">
                                                    <span class="pcoded-mtext">Button</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="box-shadow.html">
                                                    <span class="pcoded-mtext">Box-Shadow</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="accordion.html">
                                                    <span class="pcoded-mtext">Accordion</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="generic-class.html">
                                                    <span class="pcoded-mtext">Generic Class</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="tabs.html">
                                                    <span class="pcoded-mtext">Tabs</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="color.html">
                                                    <span class="pcoded-mtext">Color</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="label-badge.html">
                                                    <span class="pcoded-mtext">Label Badge</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="progress-bar.html">
                                                    <span class="pcoded-mtext">Progress Bar</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="preloader.html">
                                                    <span class="pcoded-mtext">Pre-Loader</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="list.html">
                                                    <span class="pcoded-mtext">List</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="tooltip.html">
                                                    <span class="pcoded-mtext">Tooltip And Popover</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="typography.html">
                                                    <span class="pcoded-mtext">Typography</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="other.html">
                                                    <span class="pcoded-mtext">Other</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="pcoded-hasmenu">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="feather icon-gitlab"></i></span>
                                            <span class="pcoded-mtext">Advance Components</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class=" ">
                                                <a href="draggable.html">
                                                    <span class="pcoded-mtext">Draggable</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="bs-grid.html">
                                                    <span class="pcoded-mtext">Grid Stack</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="light-box.html">
                                                    <span class="pcoded-mtext">Light Box</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="modal.html">
                                                    <span class="pcoded-mtext">Modal</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="notification.html">
                                                    <span class="pcoded-mtext">Notifications</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="notify.html">
                                                    <span class="pcoded-mtext">PNOTIFY</span>
                                                    <span class="pcoded-badge label label-info">NEW</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="rating.html">
                                                    <span class="pcoded-mtext">Rating</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="range-slider.html">
                                                    <span class="pcoded-mtext">Range Slider</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="slider.html">
                                                    <span class="pcoded-mtext">Slider</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="syntax-highlighter.html">
                                                    <span class="pcoded-mtext">Syntax Highlighter</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="tour.html">
                                                    <span class="pcoded-mtext">Tour</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="treeview.html">
                                                    <span class="pcoded-mtext">Tree View</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="nestable.html">
                                                    <span class="pcoded-mtext">Nestable</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="toolbar.html">
                                                    <span class="pcoded-mtext">Toolbar</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="x-editable.html">
                                                    <span class="pcoded-mtext">X-Editable</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="pcoded-hasmenu">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="feather icon-package"></i></span>
                                            <span class="pcoded-mtext">Extra Components</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class=" ">
                                                <a href="session-timeout.html">
                                                    <span class="pcoded-mtext">Session Timeout</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="session-idle-timeout.html">
                                                    <span class="pcoded-mtext">Session Idle Timeout</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="offline.html">
                                                    <span class="pcoded-mtext">Offline</span>
                                                </a>
                                            </li>

                                        </ul>
                                    </li>
                                    <li class=" ">
                                        <a href="animation.html">
                                            <span class="pcoded-micon"><i
                                                    class="feather icon-aperture rotate-refresh"></i><b>A</b></span>
                                            <span class="pcoded-mtext">Animations</span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="sticky.html">
                                            <span class="pcoded-micon"><i class="feather icon-cpu"></i></span>
                                            <span class="pcoded-mtext">Sticky Notes</span>
                                            <span class="pcoded-badge label label-danger">HOT</span>
                                        </a>
                                    </li>
                                    <li class="pcoded-hasmenu">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="feather icon-command"></i></span>
                                            <span class="pcoded-mtext">Icons</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class=" ">
                                                <a href="icon-font-awesome.html">
                                                    <span class="pcoded-mtext">Font Awesome</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="icon-themify.html">
                                                    <span class="pcoded-mtext">Themify</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="icon-simple-line.html">
                                                    <span class="pcoded-mtext">Simple Line Icon</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="icon-ion.html">
                                                    <span class="pcoded-mtext">Ion Icon</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="icon-material-design.html">
                                                    <span class="pcoded-mtext">Material Design</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="icon-icofonts.html">
                                                    <span class="pcoded-mtext">Ico Fonts</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="icon-weather.html">
                                                    <span class="pcoded-mtext">Weather Icon</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="icon-typicons.html">
                                                    <span class="pcoded-mtext">Typicons</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="icon-flags.html">
                                                    <span class="pcoded-mtext">Flags</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                                <div class="pcoded-navigatio-lavel">Forms</div>
                                <ul class="pcoded-item pcoded-left-item">
                                    <li class="pcoded-hasmenu">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="feather icon-clipboard"></i></span>
                                            <span class="pcoded-mtext">Form Components</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class=" ">
                                                <a href="form-elements-component.html">
                                                    <span class="pcoded-mtext">Form Components</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="form-elements-add-on.html">
                                                    <span class="pcoded-mtext">Form-Elements-Add-On</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="form-elements-advance.html">
                                                    <span class="pcoded-mtext">Form-Elements-Advance</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="form-validation.html">
                                                    <span class="pcoded-mtext">Form Validation</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class=" ">
                                        <a href="form-picker.html">
                                            <span class="pcoded-micon"><i class="feather icon-edit-1"></i></span>
                                            <span class="pcoded-mtext">Form Picker</span>
                                            <span class="pcoded-badge label label-warning">NEW</span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="form-select.html">
                                            <span class="pcoded-micon"><i class="feather icon-feather"></i></span>
                                            <span class="pcoded-mtext">Form Select</span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="form-masking.html">
                                            <span class="pcoded-micon"><i class="feather icon-shield"></i></span>
                                            <span class="pcoded-mtext">Form Masking</span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="form-wizard.html">
                                            <span class="pcoded-micon"><i class="feather icon-tv"></i></span>
                                            <span class="pcoded-mtext">Form Wizard</span>
                                        </a>
                                    </li>
                                    <li class="pcoded-hasmenu">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="feather icon-book"></i></span>
                                            <span class="pcoded-mtext">Ready To Use</span>
                                            <span class="pcoded-badge label label-danger">HOT</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class=" ">
                                                <a href="ready-cloned-elements-form.html">
                                                    <span class="pcoded-mtext">Cloned Elements Form</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="ready-currency-form.html">
                                                    <span class="pcoded-mtext">Currency Form</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="ready-form-booking.html">
                                                    <span class="pcoded-mtext">Booking Form</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="ready-form-booking-multi-steps.html">
                                                    <span class="pcoded-mtext">Booking Multi Steps Form</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="ready-form-comment.html">
                                                    <span class="pcoded-mtext">Comment Form</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="ready-form-contact.html">
                                                    <span class="pcoded-mtext">Contact Form</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="ready-job-application-form.html">
                                                    <span class="pcoded-mtext">Job Application Form</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="ready-js-addition-form.html">
                                                    <span class="pcoded-mtext">JS Addition Form</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="ready-login-form.html">
                                                    <span class="pcoded-mtext">Login Form</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="ready-popup-modal-form.html" target="_blank">
                                                    <span class="pcoded-mtext">Popup Modal Form</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="ready-registration-form.html">
                                                    <span class="pcoded-mtext">Registration Form</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="ready-review-form.html">
                                                    <span class="pcoded-mtext">Review Form</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="ready-subscribe-form.html">
                                                    <span class="pcoded-mtext">Subscribe Form</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="ready-suggestion-form.html">
                                                    <span class="pcoded-mtext">Suggestion Form</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="ready-tabs-form.html">
                                                    <span class="pcoded-mtext">Tabs Form</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                                <div class="pcoded-navigatio-lavel">Tables</div>
                                <ul class="pcoded-item pcoded-left-item">
                                    <li class="pcoded-hasmenu">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="feather icon-credit-card"></i></span>
                                            <span class="pcoded-mtext">Bootstrap Table</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class=" ">
                                                <a href="bs-basic-table.html">
                                                    <span class="pcoded-mtext">Basic Table</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="bs-table-sizing.html">
                                                    <span class="pcoded-mtext">Sizing Table</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="bs-table-border.html">
                                                    <span class="pcoded-mtext">Border Table</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="bs-table-styling.html">
                                                    <span class="pcoded-mtext">Styling Table</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="pcoded-hasmenu">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="feather icon-inbox"></i></span>
                                            <span class="pcoded-mtext">Data Table</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class=" ">
                                                <a href="dt-basic.html">
                                                    <span class="pcoded-mtext">Basic Initialization</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="dt-advance.html">
                                                    <span class="pcoded-mtext">Advance Initialization</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="dt-styling.html">
                                                    <span class="pcoded-mtext">Styling</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="dt-api.html">
                                                    <span class="pcoded-mtext">API</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="dt-ajax.html">
                                                    <span class="pcoded-mtext">Ajax</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="dt-server-side.html">
                                                    <span class="pcoded-mtext">Server Side</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="dt-plugin.html">
                                                    <span class="pcoded-mtext">Plug-In</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="dt-data-sources.html">
                                                    <span class="pcoded-mtext">Data Sources</span>
                                                </a>
                                            </li>

                                        </ul>
                                    </li>
                                    <li class="pcoded-hasmenu">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="feather icon-server"></i></span>
                                            <span class="pcoded-mtext">Data Table Extensions</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class=" ">
                                                <a href="dt-ext-autofill.html">
                                                    <span class="pcoded-mtext">AutoFill</span>
                                                </a>
                                            </li>
                                            <li class="pcoded-hasmenu">
                                                <a href="javascript:void(0)">
                                                    <span class="pcoded-mtext">Button</span>
                                                </a>
                                                <ul class="pcoded-submenu">
                                                    <li class=" ">
                                                        <a href="dt-ext-basic-buttons.html">
                                                            <span class="pcoded-mtext">Basic Button</span>
                                                        </a>
                                                    </li>
                                                    <li class=" ">
                                                        <a href="dt-ext-buttons-html-5-data-export.html">
                                                            <span class="pcoded-mtext">Html-5 Data Export</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class=" ">
                                                <a href="dt-ext-col-reorder.html">
                                                    <span class="pcoded-mtext">Col Reorder</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="dt-ext-fixed-columns.html">
                                                    <span class="pcoded-mtext">Fixed Columns</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="dt-ext-fixed-header.html">
                                                    <span class="pcoded-mtext">Fixed Header</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="dt-ext-key-table.html">
                                                    <span class="pcoded-mtext">Key Table</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="dt-ext-responsive.html">
                                                    <span class="pcoded-mtext">Responsive</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="dt-ext-row-reorder.html">
                                                    <span class="pcoded-mtext">Row Reorder</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="dt-ext-scroller.html">
                                                    <span class="pcoded-mtext">Scroller</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="dt-ext-select.html">
                                                    <span class="pcoded-mtext">Select Table</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class=" ">
                                        <a href="foo-table.html">
                                            <span class="pcoded-micon"><i class="feather icon-hash"></i></span>
                                            <span class="pcoded-mtext">FooTable</span>
                                        </a>
                                    </li>
                                    <li class="pcoded-hasmenu ">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="feather icon-airplay"></i></span>
                                            <span class="pcoded-mtext">Handson Table</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="">
                                                <a href="handson-appearance.html">
                                                    <span class="pcoded-mtext">Appearance</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="handson-data-operation.html">
                                                    <span class="pcoded-mtext">Data Operation</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="handson-rows-cols.html">
                                                    <span class="pcoded-mtext">Rows Columns</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="handson-columns-only.html">
                                                    <span class="pcoded-mtext">Columns Only</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="handson-cell-features.html">
                                                    <span class="pcoded-mtext">Cell Features</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="handson-cell-types.html">
                                                    <span class="pcoded-mtext">Cell Types</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="handson-integrations.html">
                                                    <span class="pcoded-mtext">Integrations</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="handson-rows-only.html">
                                                    <span class="pcoded-mtext">Rows Only</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="handson-utilities.html">
                                                    <span class="pcoded-mtext">Utilities</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="">
                                        <a href="editable-table.html">
                                            <span class="pcoded-micon"><i class="feather icon-edit"></i></span>
                                            <span class="pcoded-mtext">Editable Table</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="pcoded-navigatio-lavel">Chart And Maps</div>
                                <ul class="pcoded-item pcoded-left-item">
                                    <li class="pcoded-hasmenu ">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="feather icon-pie-chart"></i></span>
                                            <span class="pcoded-mtext">Charts</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="">
                                                <a href="chart-google.html">
                                                    <span class="pcoded-mtext">Google Chart</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="chart-echart.html">
                                                    <span class="pcoded-mtext">Echarts</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="chart-chartjs.html">
                                                    <span class="pcoded-mtext">ChartJs</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="chart-list.html">
                                                    <span class="pcoded-mtext">List Chart</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="chart-float.html">
                                                    <span class="pcoded-mtext">Float Chart</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="chart-knob.html">
                                                    <span class="pcoded-mtext">Knob chart</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="chart-morris.html">
                                                    <span class="pcoded-mtext">Morris Chart</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="chart-nvd3.html">
                                                    <span class="pcoded-mtext">Nvd3 Chart</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="chart-peity.html">
                                                    <span class="pcoded-mtext">Peity Chart</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="chart-radial.html">
                                                    <span class="pcoded-mtext">Radial Chart</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="chart-rickshaw.html">
                                                    <span class="pcoded-mtext">Rickshaw Chart</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="chart-sparkline.html">
                                                    <span class="pcoded-mtext">Sparkline Chart</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="chart-c3.html">
                                                    <span class="pcoded-mtext">C3 Chart</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="pcoded-hasmenu ">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="feather icon-map"></i></span>
                                            <span class="pcoded-mtext">Maps</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="">
                                                <a href="map-google.html">
                                                    <span class="pcoded-mtext">Google Maps</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="map-vector.html">
                                                    <span class="pcoded-mtext">Vector Maps</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="map-api.html">
                                                    <span class="pcoded-mtext">Google Map Search API</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="location.html">
                                                    <span class="pcoded-mtext">Location</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="">
                                        <a href="storage/extra-pages/landingpage/index.html" target="_blank">
                                            <span class="pcoded-micon"><i class="feather icon-navigation-2"></i></span>
                                            <span class="pcoded-mtext">Landing Page</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="pcoded-navigatio-lavel">Pages</div>
                                <ul class="pcoded-item pcoded-left-item">
                                    <li class="pcoded-hasmenu ">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="feather icon-unlock"></i></span>
                                            <span class="pcoded-mtext">Authentication</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="">
                                                <a href="auth-normal-sign-in.html" target="_blank">
                                                    <span class="pcoded-mtext">Login With BG Image</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="auth-sign-in-social.html" target="_blank">
                                                    <span class="pcoded-mtext">Login With Social Icon</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="auth-sign-in-social-header-footer.html" target="_blank">
                                                    <span class="pcoded-mtext">Login Social With Header And Footer</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="auth-normal-sign-in-header-footer.html" target="_blank">
                                                    <span class="pcoded-mtext">Login With Header And Footer</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="auth-sign-up.html" target="_blank">
                                                    <span class="pcoded-mtext">Registration BG Image</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="auth-sign-up-social.html" target="_blank">
                                                    <span class="pcoded-mtext">Registration Social Icon</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="auth-sign-up-social-header-footer.html" target="_blank">
                                                    <span class="pcoded-mtext">Registration Social With Header And
                                                        Footer</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="auth-sign-up-header-footer.html" target="_blank">
                                                    <span class="pcoded-mtext">Registration With Header And Footer</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="auth-multi-step-sign-up.html" target="_blank">
                                                    <span class="pcoded-mtext">Multi Step Registration</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="auth-reset-password.html" target="_blank">
                                                    <span class="pcoded-mtext">Forgot Password</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="auth-lock-screen.html" target="_blank">
                                                    <span class="pcoded-mtext">Lock Screen</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="auth-modal.html" target="_blank">
                                                    <span class="pcoded-mtext">Modal</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="pcoded-hasmenu ">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="feather icon-sliders"></i></span>
                                            <span class="pcoded-mtext">Maintenance</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="">
                                                <a href="error.html">
                                                    <span class="pcoded-mtext">Error</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="comming-soon.html">
                                                    <span class="pcoded-mtext">Comming Soon</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="offline-ui.html">
                                                    <span class="pcoded-mtext">Offline UI</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="pcoded-hasmenu ">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                                            <span class="pcoded-mtext">User Profile</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="">
                                                <a href="timeline.html">
                                                    <span class="pcoded-mtext">Timeline</span>
                                                </a>
                                            </li>
                                            <!-- <li class="">
                                                <a href="timeline-social.html">
                                                    <span class="pcoded-mtext">Timeline Social</span>
                                                </a>
                                            </li> -->
                                            <li class="">
                                                <a href="user-profile.html">
                                                    <span class="pcoded-mtext">User Profile</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="user-card.html">
                                                    <span class="pcoded-mtext">User Card</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="pcoded-hasmenu ">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="feather icon-shopping-cart"></i></span>
                                            <span class="pcoded-mtext">E-Commerce</span>
                                            <span class="pcoded-badge label label-danger">NEW</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="">
                                                <a href="product.html">
                                                    <span class="pcoded-mtext">Product</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="product-list.html">
                                                    <span class="pcoded-mtext">Product List</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="product-edit.html">
                                                    <span class="pcoded-mtext">Product Edit</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="product-detail.html">
                                                    <span class="pcoded-mtext">Product Detail</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="product-cart.html">
                                                    <span class="pcoded-mtext">Product Card</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="product-payment.html">
                                                    <span class="pcoded-mtext">Credit Card Form</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="pcoded-hasmenu ">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="feather icon-mail"></i></span>
                                            <span class="pcoded-mtext">Email</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="">
                                                <a href="email-compose.html">
                                                    <span class="pcoded-mtext">Compose Email</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="email-inbox.html">
                                                    <span class="pcoded-mtext">Inbox</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="email-read.html">
                                                    <span class="pcoded-mtext">Read Mail</span>
                                                </a>
                                            </li>
                                            <li class="pcoded-hasmenu ">
                                                <a href="javascript:void(0)">
                                                    <span class="pcoded-mtext">Email Template</span>
                                                </a>
                                                <ul class="pcoded-submenu">
                                                    <li class="">
                                                        <a href="resources/extra-pages/email-templates/email-welcome.html">
                                                            <span class="pcoded-mtext">Welcome Email</span>
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="resources/extra-pages/email-templates/email-password.html">
                                                            <span class="pcoded-mtext">Reset Password</span>
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <a
                                                            href="resources/extra-pages/email-templates/email-newsletter.html">
                                                            <span class="pcoded-mtext">Newsletter Email</span>
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="resources/extra-pages/email-templates/email-launch.html">
                                                            <span class="pcoded-mtext">App Launch</span>
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <a
                                                            href="resources/extra-pages/email-templates/email-activation.html">
                                                            <span class="pcoded-mtext">Activation Code</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                                <div class="pcoded-navigatio-lavel">App</div>
                                <ul class="pcoded-item pcoded-left-item">
                                    <li class=" ">
                                        <a href="chat.html">
                                            <span class="pcoded-micon"><i class="feather icon-message-square"></i></span>
                                            <span class="pcoded-mtext">Chat</span>
                                        </a>
                                    </li>
                                    <li class="pcoded-hasmenu ">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="feather icon-globe"></i></span>
                                            <span class="pcoded-mtext">Social</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="">
                                                <a href="fb-wall.html">
                                                    <span class="pcoded-mtext">Wall</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="message.html">
                                                    <span class="pcoded-mtext">Messages</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="pcoded-hasmenu ">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="feather icon-check-circle"></i></span>
                                            <span class="pcoded-mtext">Task</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="">
                                                <a href="task-list.html">
                                                    <span class="pcoded-mtext">Task List</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="task-board.html">
                                                    <span class="pcoded-mtext">Task Board</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="task-detail.html">
                                                    <span class="pcoded-mtext">Task Detail</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="issue-list.html">
                                                    <span class="pcoded-mtext">Issue List</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="pcoded-hasmenu ">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="feather icon-bookmark"></i></span>
                                            <span class="pcoded-mtext">To-Do</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="">
                                                <a href="todo.html">
                                                    <span class="pcoded-mtext">To-Do</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="notes.html">
                                                    <span class="pcoded-mtext">Notes</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="pcoded-hasmenu ">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="feather icon-image"></i></span>
                                            <span class="pcoded-mtext">Gallery</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="">
                                                <a href="gallery-grid.html">
                                                    <span class="pcoded-mtext">Gallery-Grid</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="gallery-masonry.html">
                                                    <span class="pcoded-mtext">Masonry Gallery</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="gallery-advance.html">
                                                    <span class="pcoded-mtext">Advance Gallery</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="pcoded-hasmenu ">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="feather icon-search"></i><b>S</b></span>
                                            <span class="pcoded-mtext">Search</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="">
                                                <a href="search-result.html">
                                                    <span class="pcoded-mtext">Simple Search</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="search-result2.html">
                                                    <span class="pcoded-mtext">Grouping Search</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="pcoded-hasmenu ">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="feather icon-award"></i></span>
                                            <span class="pcoded-mtext">Job Search</span>
                                            <span class="pcoded-badge label label-danger">NEW</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <!-- <li class="">
                                                <a href="job-card-view.html">
                                                    <span class="pcoded-mtext">Card View</span>
                                                </a>
                                            </li> -->
                                            <li class="">
                                                <a href="job-details.html">
                                                    <span class="pcoded-mtext">Job Detailed</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="job-find.html">
                                                    <span class="pcoded-mtext">Job Find</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="job-panel-view.html">
                                                    <span class="pcoded-mtext">Job Panel View</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                                <div class="pcoded-navigatio-lavel">Extension</div>
                                <ul class="pcoded-item pcoded-left-item">
                                    <li class="pcoded-hasmenu ">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="feather icon-file-plus"></i></span>
                                            <span class="pcoded-mtext">Editor</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="">
                                                <a href="ck-editor.html">
                                                    <span class="pcoded-mtext">CK-Editor</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="wysiwyg-editor.html">
                                                    <span class="pcoded-mtext">WYSIWYG Editor</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="ace-editor.html">
                                                    <span class="pcoded-mtext">Ace Editor</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="long-press-editor.html">
                                                    <span class="pcoded-mtext">Long Press Editor</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                                <ul class="pcoded-item pcoded-left-item">
                                    <li class="pcoded-hasmenu ">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="feather icon-file-minus"></i></span>
                                            <span class="pcoded-mtext">Invoice</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="">
                                                <a href="invoice.html">
                                                    <span class="pcoded-mtext">Invoice</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="invoice-summary.html">
                                                    <span class="pcoded-mtext">Invoice Summary</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="invoice-list.html">
                                                    <span class="pcoded-mtext">Invoice List</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="pcoded-hasmenu ">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="feather icon-calendar"></i></span>
                                            <span class="pcoded-mtext">Event Calendar</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="">
                                                <a href="event-full-calender.html">
                                                    <span class="pcoded-mtext">Full Calendar</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="event-clndr.html">
                                                    <span class="pcoded-mtext">CLNDER</span>
                                                    <span class="pcoded-badge label label-info">NEW</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="">
                                        <a href="image-crop.html">
                                            <span class="pcoded-micon"><i class="feather icon-scissors"></i></span>
                                            <span class="pcoded-mtext">Image Cropper</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="file-upload.html">
                                            <span class="pcoded-micon"><i class="feather icon-upload-cloud"></i></span>
                                            <span class="pcoded-mtext">File Upload</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="change-loges.html">
                                            <span class="pcoded-micon"><i
                                                    class="feather icon-briefcase"></i><b>CL</b></span>
                                            <span class="pcoded-mtext">Change Loges</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="pcoded-navigatio-lavel">Other</div>
                                <ul class="pcoded-item pcoded-left-item">
                                    <li class="pcoded-hasmenu ">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="feather icon-list"></i></span>
                                            <span class="pcoded-mtext">Menu Levels</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="">
                                                <a href="javascript:void(0)">
                                                    <span class="pcoded-mtext">Menu Level 2.1</span>
                                                </a>
                                            </li>
                                            <li class="pcoded-hasmenu ">
                                                <a href="javascript:void(0)">
                                                    <span class="pcoded-mtext">Menu Level 2.2</span>
                                                </a>
                                                <ul class="pcoded-submenu">
                                                    <li class="">
                                                        <a href="javascript:void(0)">
                                                            <span class="pcoded-mtext">Menu Level 3.1</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="">
                                                <a href="javascript:void(0)">
                                                    <span class="pcoded-mtext">Menu Level 2.3</span>
                                                </a>
                                            </li>

                                        </ul>
                                    </li>
                                    <li class="">
                                        <a href="javascript:void(0)" class="disabled">
                                            <span class="pcoded-micon"><i class="feather icon-power"></i></span>
                                            <span class="pcoded-mtext">Disabled Menu</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="sample-page.html">
                                            <span class="pcoded-micon"><i class="feather icon-watch"></i></span>
                                            <span class="pcoded-mtext">Sample Page</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="pcoded-navigatio-lavel">Support</div>
                                <ul class="pcoded-item pcoded-left-item">
                                    <li class="">
                                        <a href="http://html.codedthemes.com/Adminty/doc" target="_blank">
                                            <span class="pcoded-micon"><i class="feather icon-monitor"></i></span>
                                            <span class="pcoded-mtext">Documentation</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="#" target="_blank">
                                            <span class="pcoded-micon"><i class="feather icon-help-circle"></i></span>
                                            <span class="pcoded-mtext">Submit Issue</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </nav>

                        <div class="pcoded-content">
                            <div class="pcoded-inner-content">
                                <div class="main-body">
                                    <div class="page-wrapper">
    
                                        <div class="page-body">
                                            {{-- row del contenido --}}
                                            <div class="row">
                                                @yield('content')
                                            </div>
                                            {{-- termina row de contenido --}}
                                        </div>
                                    </div>
    
                                    <div id="styleSelector">
    
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    @vite([
        
        "resources/bower_components/jquery-ui/jquery-ui.min.js",
        'resources/js/app.js',
        // "resources/bower_components/bootstrap/dist/js/bootstrap.min.js",
        // "resources/bower_components/popper.js/dist/umd/popper.min.js",
        "resources/bower_components/jquery-slimscroll/jquery.slimscroll.js",
        // "resources/bower_components/modernizr/modernizr.js",
        "resources/bower_components/chart.js/dist/Chart.js",
        "resources/assets/pages/widget/amchart/amcharts.js",
        "resources/assets/pages/widget/amchart/serial.js",
        "resources/assets/pages/widget/amchart/light.js",
        "resources/assets/js/jquery.mCustomScrollbar.concat.min.js",
        // "resources/assets/js/SmoothScroll.js",
        
        "resources/assets/js/sweetalert.js",
        // "resources/assets/js/modal.js", 
        
        "resources/assets/js/modalEffects.js",
        "resources/assets/js/classie.js",
        "resources/assets/js/pcoded.min.js",
        "resources/assets/js/vartical-layout.min.js",
        "resources/assets/pages/dashboard/custom-dashboard.js",
        "resources/assets/js/script.js",
    ])
    

    {{-- Datatables --}}
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/r-2.3.0/sp-2.0.2/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
</body>
</html>
