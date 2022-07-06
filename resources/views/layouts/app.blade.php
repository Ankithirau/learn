<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="Travel Master" name="description">
    <meta content="Travel Master" name="author">
    <meta name="keywords" content="Travel Master" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{URL::asset('assets/images/brand/favicon.ico')}}" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="{{URL::asset('assets/images/brand/favicon.ico')}}" />

    <!--Bootstrap.min css-->
    <link rel="stylesheet" href="{{URL::asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}">

    <!-- Dashboard css -->
    <link href="{{URL::asset('assets/css/style.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/css/dark-style.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/css/skin-mode.css')}}" rel="stylesheet" />

    <!-- Perfect scroll bar css-->
    <link href="{{URL::asset('assets/plugins/pscrollbar/perfect-scrollbar.css')}}" rel="stylesheet" />

    <!-- Sidemenu css -->
    <link rel="stylesheet" href="{{URL::asset('assets/css/sidemenu-icon.css')}}">

    <!--Daterangepicker css-->
    <link href="{{URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet" />

    <!-- Sidebar Accordions css -->
    <link href="{{URL::asset('assets/css/easy-responsive-tabs.css')}}" rel="stylesheet">

    <!-- Rightsidebar css -->
    <link href="{{URL::asset('assets/plugins/sidebar/sidebar.css')}}" rel="stylesheet">

    <!--News ticker css -->
    <link href="{{URL::asset('assets/plugins/newsticker/breaking-news-ticker.css')}}" rel="stylesheet" />

    <!---Icons css-->
    <link href="{{URL::asset('assets/plugins/icons/icons.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('assets/css/toastr.css')}}">
    <script src="https://cdn.tiny.cloud/1/kothksyhpff81bgsijulfiomprya4bh7pgouemraodj2oetp/tinymce/6/tinymce.min.js">
    </script>
    @yield('styles')

    <!--Fonts-->
    <link id="font" rel="stylesheet" type="text/css" media="all" href="{{URL::asset('assets/css/fonts/font1.css')}}" />

    <!-- Color-skins css -->
    <link id="theme" rel="stylesheet" type="text/css" media="all"
        href="{{URL::asset('assets/css/colors/color.css')}}" />
</head>



<body class="app sidebar-mini">
    <div id="app">
        @guest
        <main class="page">
            @yield('content')
        </main>
        @else
        <!--Global-Loader-->
        @if (isset($is_home))
        <div id="global-loader">
            <img src="{{URL::asset('assets/images/brand/Ellipsis-1.4s-200px.gif')}}" alt="loader">
        </div>
        @endif

        <div id="ajax-loader" style="display: none;" class="active">
            <img src="{{URL::asset('assets/images/brand/icon.png')}}" alt="loader">
        </div>

        <div class="page">
            <div class="page-main">
                <!--app-header-->
                <div class="app-header header d-flex">
                    <div class="container-fluid">
                        @include('layouts.components.app-header')
                    </div>
                </div>
                <!--/app-header-->

                @include('layouts.components.sidebar-menu')

                <!-- app-content-->
                <div class="app-content  my-3 my-md-5">
                    <div class="side-app">
                        @yield('content')
                    </div>
                    @yield('modals')
                </div>
                <!-- End app-content-->
            </div>

            @include('layouts.components.footer')

        </div>
        @endguest
        <!-- End Page -->
    </div>
    <audio style="display: none;" id="audio" src="{{URL::asset('assets/success-notification.wav')}}"></audio>
    <audio style="display: none;" id="abe-yaar" src="{{URL::asset('assets/abe-yaar.mp3')}}"></audio>
    <!-- Back to top -->
    <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

    <!-- Jquery js-->
    <script src="{{URL::asset('assets/plugins/vendors/jquery.min.js')}}">
    </script>

    <!--Bootstrap.min js-->
    <script src="{{URL::asset('assets/plugins/bootstrap/popper.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>

    <!--Moment js-->
    <script src="{{URL::asset('assets/plugins/moment/moment.min.js')}}"></script>

    <!-- Daterangepicker js-->
    <script src="{{URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

    <!--Side-menu js-->
    <script src="{{URL::asset('assets/plugins/sidemenu/sidemenu-icon.js')}}"></script>

    <!--News Ticker js-->
    <script src="{{URL::asset('assets/plugins/newsticker/breaking-news-ticker.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/newsticker/newsticker.js')}}"></script>

    <!-- Sidebar Accordions js -->
    <script src="{{URL::asset('assets/plugins/sidemenu-responsive-tabs/js/easyResponsiveTabs.js')}}"></script>

    <!-- Perfect scroll bar js-->
    <script src="{{URL::asset('assets/plugins/pscrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/pscrollbar/p-scroll.js')}}"></script>

    <!-- Rightsidebar js -->
    <script src="{{URL::asset('assets/plugins/sidebar/sidebar.js')}}"></script>

    @yield('scripts')

    <!-- Custom js-->
    <script src="{{URL::asset('assets/js/custom.js')}}"></script>
    <script src="{{asset('assets/js/sweetalert.min.js')}}"></script>

    <script src="{{asset('assets/js/toastr.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/common-action.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDR44kcH-9BWx43vlGYZ2jxDC7HqlVU0Js&callback=initMap"
        defer></script>
</body>

</html>