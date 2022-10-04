@extends('frontend.athlete.layouts.app')
@section('title', 'Search PANDA Profiles')
@section('content')
<?php 
use App\Models\Country;
use App\Models\User;
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
                            <form action="" method="post">
                                @csrf
                                <input type="text" name="name_search" autocomplete="off"
                                placeholder="Search for connections"
                                value="<?=!empty($name_search) ? $name_search : '' ;?>">
                                <input type="submit" class="searaddathletesbtn" value=''>
                            </form>
                            <div class="clr"></div>

                        </div>
                        <div class="filter" id="filtersec"><a href="javascript:void(0);" data-toggle="modal"
                            data-target="#filterpopup"><img src="{{ asset('public/frontend/athlete/images/filter_option.jpg') }}" alt="" /></a></div>
                        </div>
                        <ul>
                            <li><a href="#" class="tab-a <?php if($tabId==""){?>active-a<?php }?> " data-id="tab1" onclick="checkTab(1)">Search Athletes</a></li>
                            <li><a href="#" class="tab-a" data-id="tab2" onclick="checkTab(2)">Search Coaches</a></li>  
                            <li><a href="#" class="tab-a <?php if($tabId==3){?>active-a<?php }?> " data-id="tab3" onclick="checkTab(3)">People I Follow</a></li>
                            <li><a href="#" class="tab-a  <?php if($tabId==4){?>active-a<?php }?>" data-id="tab4" onclick="checkTab(4)">People Following Me</a></li>       
                        </ul>
                    </div>

                    <div class="tab <?php if($tabId==""){?>tab-active<?php }?>" data-id="tab1">
                        <div class="row createteamingup connectionbox" id="myList">

                            <?php 
                            if(count($athlete) >0){

                              for($i=0; $i<count($athlete); $i++) {
                               $country_name = Country::where('id', @$athlete[$i]->address[0]->country_id)->first();		

                               ?>
                               <div class="col-sm-3">
                                <div class="addathebox">
                                    <!-- <a href="<?= url('athlete/profile'); ?>"> -->
                                        <a href="{{ route('user-profile', $athlete[$i]->id) }}">
                                            <div class="addatheboximg">

                                                <?php if($athlete[$i]['profile_image']!=""){?>
                                                    <img src="{{ asset($athlete[$i]['profile_image']) }}" alt="user_img"/> 

                                                <?php }else{ ?>
                                                    <?php $uname = explode(" ", $athlete[$i]->username);
                                                    $fname= $uname[0];
                                                    $lname= @$uname[1];

                                                    ?>
                                                    <div class="pro-user"><?= ucfirst(@$fname[0]).ucfirst(@$lname[0]);?></div>

                                                <?php } ?>

                                            </div>
                                            <h5>{{ @$athlete[$i]->username }}</h5>
                                        </a>
                                        <span>Athlete, {{ @$country_name->name }}</span>
                                        <?php 
                                        $exit_follower_user = App\Models\Follower::where('status', 1)->where('user_id', Auth()->user()->id)->where('follower_id',$athlete[$i]->id)->first();	?>
                                        @if($exit_follower_user)
                                        <input type="button" id="followers" data-athleteid="{{$athlete[$i]->id}}"
                                        class="added_athbtn followers" value="Followed" />
                                        @else
                                        <input type="button" id="followers" data-athleteid="{{$athlete[$i]->id}}"
                                        class="added_athbtn followers" value="Follow" />
                                        @endif
                                        <input type="button" data-athleteid="{{$athlete[$i]->id}}" style="background:#59a7cd"
                                        class="added_athbtn ConnectViaMessage" value="Message" />

                                    </div>
                                </div>
                            <?php } }else{ ?>
                                <h6>No Result Found!!</h6>

                            <?php } ?>

                        </div>

                        <div class="text-center" style="margin-top: 50px;">
                            <?php if(count($athlete) >10) {?>
                              <button type="button" id="loadMore" class="addevents_btn">View More</button>
                          <?php } ?>
                          <!-- <button type="button" id="continue" class="btn btn-success">Continue</button> -->
                      </div>

                  </div>

                  <div class="tab" data-id="tab2">
                    <!---Coach---->
                    <div class="row createteamingup connectionbox" id="myList2">

                        <?php 
                        if(count($coach)>0){
                            for($i=0; $i<count($coach); $i++) {
                                $country_name = Country::where('id', @$coach[$i]->address[0]->country_id)->first();       

                                ?>
                                <div class="col-sm-3">
                                    <div class="addathebox">      
                                        <!-- <a href="{{ route('user-profile', $coach[$i]->id) }}"> -->
                                            <div class="addatheboximg">

                                                <?php if($coach[$i]['profile_image']!=""){?>
                                                    <img src="{{ asset($coach[$i]['profile_image']) }}" alt="user_img"/> 

                                                <?php }else{ ?>
                                                    <?php $uname = explode(" ", $coach[$i]->username);
                                                    $fname= $uname[0];
                                                    $lname= @$uname[1];

                                                    ?>
                                                    <div class="pro-user"><?= ucfirst(@$fname[0]).ucfirst(@$lname[0]);?></div>

                                                <?php } ?>                                       
                                            </div>
                                            <h5>{{ @$coach[$i]->username }}</h5>
                                            <span>Coach, {{ @$country_name->name }}</span>
                                            <?php 
                                            $exit_follower_user = App\Models\Follower::where('status', 1)->where('user_id', Auth()->user()->id)->where('follower_id',$coach[$i]->id)->first();    ?>
                                            @if($exit_follower_user)
                                            <input type="button" id="followers" data-athleteid="{{$coach[$i]->id}}"
                                            class="added_athbtn followers" value="Followed" />
                                            @else
                                            <input type="button" id="followers" data-athleteid="{{$coach[$i]->id}}"
                                            class="added_athbtn followers" value="Follow" />
                                            @endif
                                            <input type="button" data-athleteid="{{$coach[$i]->id}}" style="background:#59a7cd"
                                            class="added_athbtn ConnectViaMessage" value="Message" />
                                        </div>
                                    </div>
                                <?php } }else{ ?>
                                    <h6>No Result Found!!</h6>
                                <?php } ?>
                            </div>
                    <!-- <div class="text-center" style="margin-top: 50px;">
                        <button type="button" id="loadMore" class="addevents_btn">View More</button>
                        
                    </div> -->
                </div>
                <!---Following--->
                <div class="tab <?php if($tabId==3){?>tab-active<?php }?>" data-id="tab3">                   
                    <div class="row createteamingup connectionbox" id="myList3">

                        <?php 
                        if(count($following)>0){
                            for($i=0; $i<count($following); $i++) {
                             $user_detail = User::where('id', $following[$i]['follower_id'])
                             ->with('address')->first();

                             if(@$user_detail->role_id==1){
                                $role="Athlete";                  
                            }else{
                                $role="Coach";
                            }                                 

                            ?>
                            <div class="col-sm-3">
                                <div class="addathebox">      

                                    <div class="addatheboximg">

                                        <?php if(@$user_detail->profile_image!=""){?>
                                            <img src="{{ asset($user_detail->profile_image) }}" alt="user_img"/> 

                                        <?php }else{ ?>
                                            <?php $uname = explode(" ", @$user_detail->username);
                                            $fname= $uname[0];
                                            $lname= @$uname[1];

                                            ?>
                                            <div class="pro-user"><?= ucfirst(@$fname[0]).ucfirst(@$lname[0]);?></div>
                                        <?php } ?>                                      
                                    </div>
                                    <h5>{{ @$user_detail->username }}</h5>
                                    <span>{{$role}}</span>                               

                                <!-- <input type="button" data-athleteid="{{$following[$i]->id}}" style="background:#59a7cd"
                                    class="added_athbtn ConnectViaMessage" value="Message" /> -->

                                    <input type="button" id="followers" data-athleteid="{{@$following[$i]->follower_id}}"
                                    class="added_athbtn followers" value="Unfollow" />
                                </div>
                            </div>
                        <?php } }else{ ?>
                            <h6>No Result Found!!</h6>
                        <?php } ?>
                    </div>                    
                </div>
                <!----Follower--->
                <div class="tab <?php if($tabId==4){?>tab-active<?php }?>" data-id="tab4">                   
                    <div class="row createteamingup connectionbox " id="myList2" >

                        <?php count($follower);
                        if(count($follower)>0){
                            for($i=0; $i<count($follower); $i++) {
                             $user_detail = User::where('id', $follower[$i]['user_id'])
                             ->with('address')->first();

                             if(@$user_detail->role_id==1){
                                $role="Athlete";                  
                            }else{
                                $role="Coach";
                            }                                 

                            ?>
                            <div class="col-sm-3">
                                <div class="addathebox">
                                    <div class="addatheboximg">

                                        <?php if($user_detail->profile_image!=""){?>
                                            <img src="{{ asset($user_detail->profile_image) }}" alt="user_img"/> 

                                        <?php }else{ ?>
                                            <?php $uname = explode(" ", $user_detail->username);
                                            $fname= $uname[0];
                                            $lname= @$uname[1];

                                            ?>
                                            <div class="pro-user"><?= ucfirst(@$fname[0]).ucfirst(@$lname[0]);?></div>
                                        <?php } ?>                                      
                                    </div>
                                    <h5>{{ @$user_detail->username }}</h5>
                                    <span>{{@$role}}</span>                               

                                    <input type="button"  style="background:#259150"
                                    class="added_athbtn" onclick="request_response(<?= $follower[$i]->id ?>,'2')" value="Accept" />

                                    <input type="button" id="followers" onclick="request_response(<?= $follower[$i]->id ?>,'3')"
                                    class="added_athbtn " value="Deny" />
                                </div>
                            </div>  

                        <?php } }else{ ?>
                            <h6>No Result Found!!</h6>
                        <?php } ?>
                    </div>                    
                </div>
                <!----->
            </div>

        </div>
    </div>
</div>
</div>
<div class="clr"></div>
</div>

<!-- Modal -->
<div class="modal fade" id="filterpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
                aria-hidden="true">&times;</span> </button>
                <h5>Apply Filter</h5>
                <form method="post"  enctype="multipart/form-data">
                    @csrf
                    <div class="tab-container">
                        <div class="filtertabopoup_l">
                            <div class="tab-menu01">
                                <ul>
                                 <ul>
                                    <li><a href="#" class="tab-a01 active-a01" data-id="tab1">Gender</a></li>

                                    <li><a href="#" class="tab-a01" data-id="tab2">Sports</a></li>
                                    <li><a href="#" class="tab-a01" data-id="tab3">Position</a></li>

                                    <li><a href="#" class="tab-a01" data-id="tab4"> Birth year</a></li>
                                    <li><a href="#" class="tab-a01" data-id="tab5">Graduation Year</a></li>

                                    <li><a href="#" class="tab-a01 " data-id="tab6">City</a></li>
                                    <li><a href="#" class="tab-a01" data-id="tab7">State</a></li>                          

                                    <li><a href="#" class="tab-a01" data-id="tab11">Competition Level</a></li>
                                </ul>
                            </ul>
                        </div>
                    </div>
                    <div class="filtertabopoup_r">
                        <div class="tab01 tab-active01" data-id="tab1">
                            <select class="form-control" name="gender" id="gender"
                            style="width: 100% !important;">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="both">Both</option>
                        </select>


                    </div>
                    <div class="tab01 " data-id="tab2">
                      <ul>
                        @foreach($sport as $sport_value)
                        <li>
                            {{$sport_value->name}}
                            <div class="radioboxsub">
                                <input type="checkbox" id="sport{{$sport_value->id}}" name="sports[]"
                                value="{{$sport_value->id}}">
                                <label for="sport{{$sport_value->id}}"></label>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="tab01" data-id="tab3">
                 <ul>
                    @foreach($sport_position as $position_value)
                    <li>
                        {{$position_value->name}}
                        <div class="radioboxsub">
                            <input type="checkbox" id="position{{$position_value->id}}" name="position[]"
                            value="{{$position_value->id}}">
                            <label for="position{{$position_value->id}}"></label>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="tab01" data-id="tab4">
                <input type="number" class="form-control" name="start_year" value=""
                placeholder="Year" autocomplete="off" />To
                <input type="number" class="form-control" name="end_year" value=""
                placeholder="Year" autocomplete="off" />
            </div>
            <div class="tab01" data-id="tab5">
                <input type="number" class="form-control" name="graduation_year" value=""
                placeholder="Year" autocomplete="off" />
            </div>
            <div class="tab01" data-id="tab6">
                <select class="form-control" name="cities" id="cities"
                style="width: 100% !important;">
                <option value=''>Select </option>
                <?php if(count($cities)>0){?>
                    @foreach($cities as $cities_value)
                    <option value="{{$cities_value->id}}"> {{$cities_value->name}}
                    </option>
                    @endforeach
                <?php } ?>
            </select>
        </div>

        <div class="tab01" data-id="tab7">
            <ul>
                <select class="form-control" name="states" id="state"
                style="width: 100% !important;">
                <option value=''>Select </option>
                @foreach($states as $states_value)
                <option value="{{$states_value['id']}}"> {{$states_value['name']}}
                </option>
                @endforeach
            </select>
        </ul>
    </div>    
    <div class="tab01" data-id="tab11">
       <ul>
        <select class="form-control" name="competition" id="competition"
        style="width: 100% !important;">
        <option value=''>Select </option>
        @foreach($competition_level as $competition_value)
        <option value="{{$competition_value['id']}}"> {{$competition_value['name']}}
        </option>
        @endforeach
    </select>
</ul>
</div>
</div>
<div class="clr"></div>

<input type="submit" class="applybtn" value="Apply" />
</div>
</form>
</div>
</div>
</div>
</div>
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
                    window.location.href = "chat";
                } else {
                    window.location.href = "chat";
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
            var follower_id = $(this).data('athleteid');
            $.ajax({
                type: "POST",
                url: "{{ route('athlete.add-follow') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    follower_id: follower_id
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
        });
    });


    function request_response(follower_id, status){              
        $.ajax({
            type: "POST",
            url: "{{ route('athlete.request-response') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                follower_id: follower_id,
                status:status

            },
            dataType: "JSON",
            beforeSend: function() {
                //$("#overlay").fadeIn(300);
                // $('#eventsmodaldetails').empty();
            },
            success: function(res) {
                console.log(res);
                if (res.success) {
                    swal(res.message, 'Success', 'success')
                    .then(() => {
                        location.reload();
                    });
                }
            }
        });
    }

    function checkTab(tabId){
        if(tabId==1){
            $('#filtersec').show();
        }else{
            $('#filtersec').hide();
        }
    }
</script>
@endsection