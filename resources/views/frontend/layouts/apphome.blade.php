<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Panda | @yield('title')</title>
    <link href="{{ asset('public/frontend/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('public/fav.ico') }}"/>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="{{ asset('public/frontend/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('public/frontend/css/bootstrap-submenu.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/css/theme.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/css/stellarnav.css') }}" rel="stylesheet">
    @yield('style')
</head>

<body class="homepagecontent">
    @include('frontend.layouts.headerhome')
    @yield('content')
    @include('frontend.layouts.footerhome')
<script src="{{ asset('public/frontend/js/jquery.js') }}"></script>
<script src="{{ asset('public/frontend/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/frontend/js/theme1.js') }}"></script>
<script src="{{ asset('public/frontend/js/owl.carousel.js') }}"></script>
<script src="{{ asset('public/frontend/js/stellarnav.js') }}"></script>
<script src="{{ asset('public/frontend/js/jquery.slimscroll.js') }}"></script> 
<!-- swal -->
<script src="{{ asset('public/admin/bundles/sweetalert/sweetalert.min.js') }}"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('public/admin/js/page/sweetalert.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
    const base_url = "{{ url('/') }}";
</script>
@if ($message = Session::get('error'))  
    <script>
    swal('{{ $message }}', 'Warning', 'error');
    </script>
@endif
@if ($message = Session::get('success'))  
    <script>
    swal('{{ $message }}', 'Success', 'success');
    </script>

  
@endif
@yield('script')
</body>

</html>