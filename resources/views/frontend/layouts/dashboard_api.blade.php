<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panda | @yield('title')</title>
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('public/fav.ico') }}"/>
    <link href="{{ asset('public/frontend/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('public/frontend/css/bootstrap-submenu.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/athlete/css/theme.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/css/responsive.css') }}" rel="stylesheet">
</head>

<body class="signin">
    @yield('content')
<script src="{{ asset('public/frontend/js/jquery.js') }}"></script>
<script src="{{ asset('public/frontend/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/frontend/athlete/js/theme1.js') }}"></script>
<script src="{{ asset('public/frontend/athlete/js/owl.carousel.js') }}"></script>

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