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
                        <?php if(Request::segment(4) && Request::segment(4) == 'invite-member'){ ?>
                            <h1>
                                Add 
                                    <a href="{{ route('athlete.teamingup-group-details', $teaming_group->id)}}">{{$teaming_group->group_name}}</a>
                                 group  participants
                            </h1>
                           <?php }elseif(Request::segment(2) == 'teamingup-group' || Request::segment(2) == 'teamingup-group-details'){?>
                           <h1>TeamingUP<sup>TM</sup> Group</h1>
                       
                       <?php }elseif(Request::segment(2) == 'create-teamingup-group' ){?>
                           <h1>Create TeamingUP<sup>TM</sup> Group</h1>

                        <?php }else{ ?>
                            <h1>
                                @yield('title')
                            </h1>
                        <?php } ?>
                        <?php if(Request::segment(2) == 'comparison-details'){?>
                            <span>{{$CompareGroup->comparison_name}}!</span>
                        <?php }else{?>
                            <span>Welcome Back!</span>
                        <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-md-4 col-sm-12 col-xs-12-12 col-xs-12">
                        <div class="dashboard_r_top_r {{ Request::segment(2) != 'dashboard' ? 'nobg' : '' }}">
                            <!-- <div class="serch">
                                <input type="button" class="searcgbtn" />
                                <input type="text" placeholder="Search" />
                            </div> -->
                            <?php
                            $all_chat_details = DB::table('message_chat')->where('receiver_id', '=', Auth()->user()->id)->where('status', '=', 'U')->get();
                           $all_chat_details = count($all_chat_details);
                            ?>
                            <a class="<?=$all_chat_details != 0 ? 'messageicon' : '' ?>" href="{{url('athlete/chat')}}">
                                <img src="{{ asset('public/frontend/athlete/images/message_icon.png') }}"
                                    alt="message_icon" />
                                <span>
                                   
                                </span>
                            </a>
                            
                            <?php 
                            use App\Models\Follower;
                            use App\Models\User;
                            use App\Models\Recommendation;


                            $req_accept = Follower::where('user_id', Auth()->user()->id)->where('status', 2)->where('read_status', 0)->get();

                            $new_request = Follower::where('follower_id', Auth()->user()->id)->where('status', 1)->where('read_status', 0)->get();

                            $updated_rec = Recommendation::where('sender_id', Auth()->user()->id)->where('recommend_status', 1)->where('athlete_read_status', 0)->get();
                            $notification_num= count($req_accept)+count($new_request)+count($updated_rec);


                            ?>

                            <b class="messageicon" onclick="requestList()" href="">
                                <img src="{{ asset('public/frontend/athlete/images/notification_icon.png') }}"
                                    alt="message_icon" />
                                <?php if(@$notification_num > 0){?>
                                <span class="notificationnumber" ><?= @$notification_num ?></span>
                                <?php } ?>

                                <div class="notificationlist"  style="display:none">
                                    <ul>
                                        <?php  $msg="";
                                        foreach($req_accept as $list){

                                            $user_detail=  User::where('id', $list->follower_id)
                                            ->first();
                                            $msg= @$user_detail->username. "  accepted your request";    

                                            ?>
                                        <li><a href="<?= url('athlete/connections?tab=accept'); ?>"><?= $msg ?></a></li>

                                        <?php } ?>
                                        <?php foreach($new_request as $list){
                                         
                                            $user_detail=  User::where('id', $list->user_id)
                                            ->first();
                                            $msg= @$user_detail->username. "  sent you follow request";             

                                            ?>
                                            <li><a href="<?= url('athlete/connections?tab=request'); ?>"><?= $msg ?></a></li>

                                        <?php } ?>
                                        <?php foreach($updated_rec as $list){
                                         
                                            $user_detail=  User::where('id', $list->receiver_id)
                                            ->first();
                                            $msg= @$user_detail->username. "  updated recommendation";            

                                            ?>
                                            <li><a href="<?= url('athlete/coach-recomendation'); ?>"><?= $msg ?></a></li>

                                        <?php } ?>
                                        
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

        function requestList(){
            if ($('.notificationlist').css('display') == 'none') {
            $('.notificationlist').show();
            $.ajax({
            url:"{{url('athlete/change-read-status')}}",
            type: "GET",
            data: {
               _token: '{{csrf_token()}}' 
            },
            dataType : 'json',
            success: function(result){
                console.log(result);
                if(result==1){
                   // location.reload();
                }            
            }
        });
        }else{
            $('.notificationlist').hide(); 
            $('.notificationnumber').hide();            
        }
        }
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