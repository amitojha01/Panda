<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panda | Coach | @yield('title')</title>
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('public/fav.ico') }}"/>
    <link href="{{ asset('public/frontend/coach/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap" rel="stylesheet">

    <link href="{{ asset('public/frontend/coach/css/bootstrap-submenu.min.css') }}" rel="stylesheet" >
    <link href="{{ asset('public/frontend/coach/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/coach/css/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/coach/css/owl.theme.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/coach/css/theme.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/coach/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('public/common/jquery-ui.min.css') }}" rel="stylesheet">

    @yield('style')
</head>

<body class="dashboardbg">
    <div class="dashboard">
        <div class="dashboard_l">
            <a href="#" class="dashlogo text-center">
                <img src="{{ asset('public/frontend/coach/images/logo_icon.png') }}" alt="logo_icon" style="width:80%"/>
            </a>
            @include('frontend.coach.layouts.header')
        </div>    
        <div class="dashboard_r">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8 col-md-4 col-sm-12 col-xs-12-12 col-xs-12">
                        <div class="dashboard_r_top_l">
                             <?php if(Request::segment(4) && Request::segment(4) == 'invite-member'){ ?>
                            <h1>
                                Add 
                                    <a href="{{ route('coach.teamingup-group-details', $teaming_group->id)}}">{{$teaming_group->group_name}}</a>
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
                            
                            <span>Welcome Back!</span>
                        </div>
                    </div>
                    <div class="col-md-4 col-md-4 col-sm-12 col-xs-12-12 col-xs-12">
                        <div class="dashboard_r_top_r {{ Request::segment(2) != 'dashboard' ? 'nobg' : '' }}">
                            <!-- <div class="serch">
                                <input type="button" class="searcgbtn" />
                                <input type="text" placeholder="Search" />
                            </div> -->
                            {{-- <a class="messageicon" href="{{url('coach/chat')}}">
                                <img src="{{ asset('public/frontend/athlete/images/message_icon.png') }}"
                                    alt="message_icon" />
                                <span>
                                    <?php
                                //     $all_chat_details = DB::table('message_chat')->where('receiver_id', '=', Auth()->user()->id)->where('status', '=', 'U')->get();
                                //    echo count($all_chat_details);
                                    ?>
                                </span>
                            </a> --}}

                            <?php
                           $all_chat_details = DB::table('message_chat')->where('receiver_id', '=', Auth()->user()->id)->where('status', '=', 'U')->get();
                        $all_chat_details = count($all_chat_details);
                            ?>
                            <a class="<?=$all_chat_details != 0 ? 'messageicon' : '' ?>" href="{{url('coach/chat')}}">
                                <img src="{{ asset('public/frontend/athlete/images/message_icon.png') }}"
                                    alt="message_icon" />
                                <span>
                                   
                                </span>
                            </a>
                            
                            <!---Notification---->
                             <?php 
                            use App\Models\Follower;
                            use App\Models\User;
                            use App\Models\Recommendation;


                            $req_accept = Follower::where('user_id', Auth()->user()->id)->where('status', 2)->where('read_status', 0)->get();

                            $new_request = Follower::where('follower_id', Auth()->user()->id)->where('status', 1)->where('read_status', 0)->get();

                            $contact_req = Recommendation::where('receiver_id', Auth()->user()->id)->where('status', 3)->where('read_status', 0)->get();

                            $notification_num= count($req_accept)+count($new_request)+count($contact_req);

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
                                        <li><a href="<?= url('coach/connections?tab=accept'); ?>"><?= $msg ?></a></li>

                                        <?php } ?>
                                        <?php foreach($new_request as $list){
                                         
                                            $user_detail=  User::where('id', $list->user_id)
                                            ->first();
                                            $msg= @$user_detail->username. "  sent you follow request";            

                                            ?>
                                            <li><a href="<?= url('coach/connections?tab=request'); ?>"><?= $msg ?></a></li>

                                        <?php } ?>
                                        <?php foreach($contact_req as $list){
                                         
                                            $user_detail=  User::where('id', $list->sender_id)
                                            ->first();
                                            $msg= @$user_detail->username. "  contacted you";            

                                            ?>
                                            <li><a href="<?= url('coach/recommendation'); ?>"><?= $msg ?></a></li>

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
    <script src="{{ asset('public/frontend/coach/js/jquery.js') }}"></script>
    <script src="{{ asset('public/frontend/coach/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/common/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/frontend/coach/js/owl.carousel.js') }}"></script> 
    <script src="{{ asset('public/frontend/coach/js/theme1.js') }}"></script>
    <script src="{{ asset('public/frontend/coach/js/jquery.slimscroll.js') }}"></script> 
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
            url:"{{url('coach/change-read-status')}}",
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