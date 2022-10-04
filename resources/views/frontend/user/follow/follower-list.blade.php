@extends('frontend.athlete.layouts.app')
@section('title', 'Follower')
@section('content')
<?php 
use App\Models\Country;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Follower;
?>
<style>
#myList div {
    display: none;
}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="tab-container">
                <div class="tab-menu">
                    <div class="searchpanelbox">
                        <div class="searaddathletes">
                            <!-- <form action="" method="post">
                                @csrf -->
                                <input type="text" name="name_search" autocomplete="off"
                                    placeholder="Search for connections"
                                    value="">
                                <input type="submit" class="searaddathletesbtn" value=''>
                            <!-- </form> -->
                            <div class="clr"></div>

                        </div>
                        <div class="filter"><a href="javascript:void(0);" data-toggle="modal"
                                data-target="#filterpopup"><img src="images/filter_option.jpg" alt="" /></a></div>
                    </div>
                    <ul>
                        <li><a href="#" class="tab-a active-a" data-id="tab1">Athletes</a></li>
                        <li><a href="#" class="tab-a " data-id="tab2">Coach</a></li>
                        
                    </ul>
                </div>

                <div class="tab tab-active" data-id="tab1">
                    <div class="row createteamingup connectionbox" id="myList">
						
                        <?php	
                        foreach($follower_list as $list){	
                            $user_detail = User::where('id', $list->user_id)
                             ->with('address')->first(); 
                           
                              $check_follow = Follower::where('user_id', Auth()->user()->id)->where('follower_id', $user_detail->id)->first();

                            if($check_follow===null){
                                $btn= "Follow";
                             }else{
                                $btn= "Unfollow";
                             }                                                       
                             $country_name="";                           
                             if(!empty(@$user_detail->address[0]->country_id)){
                                $country_name = Country::where('id', $user_detail->address[0]->country_id)->first();
                             }
                             if($user_detail->role_id==1){
                                                       
                            
						?>
                        <div class="col-sm-3">
                            <div class="addathebox">                               
                                <a href="{{ route('user-profile', $user_detail->id) }}">
                                    <div class="addatheboximg">
                                        <!-- <img src="{{  asset('public/frontend/athlete/images/defaultuser.jpg') }}"
                                            alt="default-user" /> -->
                                     <img src="{{ isset($user_detail->profile_image) ? asset($user_detail->profile_image) : asset('public/frontend/athlete/images/defaultuser.jpg') }}"
                                            alt="default-user" />
                                    </div>
                                    <h5>{{ @$user_detail->username }}</h5>
                                </a>
                                <span>Athlete, {{ @$country_name->name }}</span>
                                                               
                                <input type="button" data-athleteid="{{@$user_detail->id}}" style="background:#59a7cd"
                                    class="added_athbtn ConnectViaMessage" value="Message" />

                                    <?php if($list->user_id!= Auth()->user()->id){?>
                                

                                     <input type="button" id="followers" data-followid="{{@$user_detail->id}}" data-btntxt="{{@$btn}}"
                                    class="added_athbtn followers" value="<?= $btn ?>" /> 
                                <?php } ?>

                            </div>
                        </div>
                        <?php } }?>

                    </div>

					<!-- <div class="text-center" style="margin-top: 50px;">
						<button type="button" id="loadMore" class="addevents_btn">View More</button>
						
					</div> -->

                </div>

                <!----Coach----->
                <div  class="tab" data-id="tab2">
                              <div class="row createteamingup connectionbox" id="myList1">
                        <?php   
                        foreach($follower_list as $list){  
                            $user_detail = User::where('id', $list->user_id)
                             ->with('address')->first();

                              $check_follow = Follower::where('user_id', Auth()->user()->id)->where('follower_id', $user_detail->id)->first();

                            if($check_follow===null){
                                $btn= "Follow";
                             }else{
                                $btn= "Unfollow";
                             }
                                                       
                             $country_name="";
                           
                             if(!empty(@$user_detail->address[0]->country_id)){
                                $country_name = Country::where('id', $user_detail->address[0]->country_id)->first();
                             }
                             if($user_detail->role_id==2){

                        ?>
                        <div class="col-sm-3">
                            <div class="addathebox">                               
                                <a href="{{ route('user-profile', $user_detail->id) }}">
                                    <div class="addatheboximg">
                                       
                                     <img src="{{ isset($user_detail->profile_image) ? asset($user_detail->profile_image) : asset('public/frontend/athlete/images/defaultuser.jpg') }}"
                                            alt="default-user" />
                                    </div>
                                    <h5>{{ @$user_detail->username }}</h5>
                                </a>
                                <span>Athlete, {{ @$country_name->name }}</span>
                                                               
                                <input type="button" data-athleteid="{{@$user_detail->id}}" style="background:#59a7cd"
                                    class="added_athbtn ConnectViaMessage" value="Message" />

                                  <?php if($list->user_id!= Auth()->user()->id){?>
                                

                                     <input type="button" id="followers" data-followid="{{@$user_detail->id}}" data-btntxt="{{@$btn}}"
                                    class="added_athbtn followers" value="<?= $btn ?>" /> 
                                <?php } ?>

                            </div>
                        </div>
                        <?php } }?>

                    </div>
                       </div>



                <!---------->
            </div>

        </div>
    </div>
</div>
</div>
<div class="clr"></div>
</div>

<!-- Modal -->

<script>
$(document).ready(function() {
    $('.ConnectViaMessage').on('click', function() {
        var athleteid = $(this).data('athleteid');
        // alert(athleteid);
        $.ajax({
            type: "POST",
            url: "{{ route('athlete.add-connections-message') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                athleteid: athleteid
            },
            dataType: "JSON",
            beforeSend: function() {
                //$("#overlay").fadeIn(300);
                // $('#eventsmodaldetails').empty();
            },
            success: function(res) {
                if (res.success == 1) {
                    window.location.href = "{{ route('athlete.chat') }}";
                } else {
                    window.location.href = "{{ route('athlete.chat') }}";
                }
            }
        });
    });


	var size_li = $("#myList div").size();
    var x = 36;
    size_li = $("#myList div").size();
    x = 36;
    $('#myList div:lt(' + x + ')').show();
    $('#loadMore').click(function() {
        x = (x + 36 <= size_li) ? x + 36 : size_li;
        $('#myList div:lt(' + x + ')').show();
    });

});
</script>

@endsection
@section('script')
<script>
$(document).ready(function() {
    $('.followers').on('click', function() {
        var followid = $(this).data('followid');
        var btntxt= $(this).data('btntxt');
        if(btntxt=="Unfollow"){
            $.ajax({
            type: "POST",
            url: "{{ route('athlete.follow_unfollow') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                followid: followid
            },
            dataType: "JSON",
            beforeSend: function() {
                //$("#overlay").fadeIn(300);
                // $('#eventsmodaldetails').empty();
            },
            success: function(res) {
                if (res.success) {
                    swal(res.message, 'Success', 'success')
                        .then(() => {
                            location.reload();
                        });
                }
            }
        });

        }else{
            $.ajax({
            type: "POST",
            url: "{{ route('athlete.follow_unfollow') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                followid: followid
            },
            dataType: "JSON",
            beforeSend: function() {
                //$("#overlay").fadeIn(300);
                // $('#eventsmodaldetails').empty();
            },
            success: function(res) {
                if (res.success) {
                    swal(res.message, 'Success', 'success')
                        .then(() => {
                            location.reload();
                        });
                }
            }
        });

        }

        
    });
});
</script>
@endsection