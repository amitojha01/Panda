<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{ env('SITE_TITLE') }} | Admin | @yield('title')</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('public/admin/css/app.min.css') }}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('public/admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('public/admin/css/components.css') }}">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="{{ asset('public/admin/css/custom.css') }}">
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('public/fav.ico') }}"/>
    <!-- Custom css/style -->
    @yield('style')
</head>
<body>
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <!-- Main nav start here -->
            @include('admin.layouts.nav')
            <!-- main nav end -->
            <!-- Main sidebar start here -->
            @include('admin.layouts.sidebar')
            <!-- Main sidebar end -->
            <!-- Main content/Body -->
            @yield('content')
            <!-- end main body -->
            <!-- Footer start here -->
            @include('admin.layouts.footer')
            <!-- end footer -->
        </div>
    </div>
    <!-- General JS Scripts -->
    <script src="{{ asset('public/admin/js/app.min.js') }}"></script>
    <script src="{{ asset('public/admin//bundles/sweetalert/sweetalert.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('public/admin//js/page/sweetalert.js') }}"></script>
    <!-- JS Libraies -->
    <script src="{{ asset('public/admin/bundles/apexcharts/apexcharts.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('public/admin/js/page/index.js') }}"></script>
    <!-- Template JS File -->
    <script src="{{ asset('public/admin/js/scripts.js') }}"></script>
    <!-- Custom JS File -->
    <script src="{{ asset('public/admin/js/custom.js') }}"></script>
    <!-- custom script -->
    @yield('script')
    <script>
        $(document).ready(function(){
            $('.sidebar-menu li.dropdown').removeClass('active');
            var link = '';
            $('.sidebar-menu li.dropdown').each(function(k, v){
                if( $(this).find('ul').length > 0){
                    link = $(this).find('ul li a').prop('href');
                }else{
                    link = $(this).find('a').prop('href');
                }
                let href = window.location.href;
                //console.log(href, link, href.indexOf(link))
                if(href.indexOf(link) >=0 ){
                    $(this).addClass('active');
                }
            })
        })
    </script>
</body>

</html>
    