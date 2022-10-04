<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Panda | Athlete | @yield('title')</title>
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('public/fav.ico') }}"/>
    <link href="{{ asset('public/frontend/athlete/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap" rel="stylesheet">

    <link href="{{ asset('public/frontend/athlete/css/bootstrap-submenu.min.css') }}" rel="stylesheet" >
    <link href="{{ asset('public/frontend/athlete/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/athlete/css/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/athlete/css/owl.theme.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/athlete/css/theme.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/athlete/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('public/common/jquery-ui.min.css') }}" rel="stylesheet">
     <script src="{{ asset('public/frontend/athlete/js/jquery.js') }}"></script>
    @yield('style')
</head>
<body class="dashboardbg">
    <div class="dashboard">
        <div class="dashboard_l">
            <a href="{{ url('/athlete/dashboard') }}" class="dashlogo text-center">
                <img src="{{ asset('public/frontend/athlete/images/panda_logo.png') }}" alt="logo_icon" style="width:80%"/>
            </a>
            @include('frontend.athlete.layouts.header')
        </div>
        <div class="dashboard_r">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8 col-md-4 col-sm-12 col-xs-12-12 col-xs-12">
                        <div class="dashboard_r_top_l">
                        
                            <h1>
                                @yield('title')
                            </h1>
                       
                        </div>
                    </div>
                    <div class="col-md-4 col-md-4 col-sm-12 col-xs-12-12 col-xs-12">
                        <div class="dashboard_r_top_r {{ Request::segment(2) != 'dashboard' ? 'nobg' : '' }}">
                            <!-- <div class="serch">
                                <input type="button" class="searcgbtn" />
                                <input type="text" placeholder="Search" />
                            </div> -->
                            <a class="messageicon" href="{{url('athlete/chat')}}">
                                <img src="{{ asset('public/frontend/athlete/images/message_icon.png') }}"
                                    alt="message_icon" />
                                <span>
                                    <?php
                                   
                                    ?>
                                </span>
                            </a>
                            
                            <?php 
                            use App\Models\Follower;
                            use App\Models\User;
                            use App\Models\Recommendation;

                            ?>

                            <b class="messageicon"  href="">
                                <img src="{{ asset('public/frontend/athlete/images/notification_icon.png') }}"
                                    alt="message_icon" />
                                <?php if(@$notification_num > 0){?>
                                <span class="notificationnumber" ><?= @$notification_num ?></span>
                                <?php } ?>

                                <div class="notificationlist"  style="display:none">
                                    <ul>
                                        
                                        
                                    </ul>
                                </div>


                            </b>
                            <div class="clr"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clr"></div>
            @yield('content')
            <div class="clr"></div>        
        </div>
    </div>
   
    <script src="{{ asset('public/frontend/athlete/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/common/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/frontend/athlete/js/owl.carousel.js') }}"></script> 
    <script src="{{ asset('public/frontend/athlete/js/theme1.js') }}"></script>
    <script src="{{ asset('public/frontend/athlete/js/jquery.slimscroll.js') }}"></script> 
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- swal -->
    <script src="{{ asset('public/admin/bundles/sweetalert/sweetalert.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('public/admin/js/page/sweetalert.js') }}"></script>
    <script>
        const base_url = "{{ url('/') }}";

       
    </script>
   
    @yield('script')
</body>
</html>