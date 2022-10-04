@extends('frontend.coach.layouts.app')
@section('title', 'Search PANDA Profiles')
@section('content')
<?php 
use App\Models\Country;
use App\Models\User;
use App\Models\UserSport;
use App\Models\UserSportPosition;
use App\Models\State;
use App\Models\City;
use App\Models\CoachInformation;
?>

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
                                <input type="hidden" name="tabId" id="tabId" value="<?= @$tabId ?>">
                                <input type="submit" class="searaddathletesbtn" value=''>
                            </form>
                            <div class="clr"></div>

                        </div>
                        <div class="filter" id="filtersec"><a href="javascript:void(0);" data-toggle="modal"
                            data-target="#filterpopup"><img src="{{ asset('public/frontend/athlete/images/filter_option.jpg') }}" alt="" /></a>
                        </div>


                        <div class="filter" id="coachfiltersec" style="display:none"><a href="javascript:void(0);" data-toggle="modal"
                            data-target="#coachfilterpopup"><img src="{{ asset('public/frontend/athlete/images/filter_option.jpg') }}" alt="" /></a>
                        </div> 
                        </div>
                       
                        <ul>
                            <li><a href="#" class="tab-a <?php if($tabId==1 && $tab_name=="") {?>active-a <?php }?>" data-id="tab1" onclick="checkTab(1)">Search Athletes</a></li>
                            <li><a href="#" class="tab-a <?php if($tabId==2) {?>active-a <?php }?>" data-id="tab2" onclick="checkTab(2)">Search Coach</a></li>  
                            <li><a href="#" class="tab-a <?php if($tab_name=="accept"){?>active-a<?php }?>" data-id="tab3" onclick="checkTab(3)">People I Follow</a></li>  
                            <li><a href="#" class="tab-a" data-id="tab4" onclick="checkTab(4)">People Following Me</a></li>
                            <li><a href="#" class="tab-a <?php if($tab_name=="request"){?>active-a<?php }?>" data-id="tab5" onclick="checkTab(5)">Pending Requests</a></li>        
                        </ul>
                    </div>

                    <div class="tab <?php if($tabId==1  && $tab_name=="") {?>tab-active <?php }?>" data-id="tab1">
                        <div class="row createteamingup connectionbox" id="myList">

                            <?php 
                            if(count($athlete) >0){

                                for($i=0; $i<count($athlete); $i++) {
                                 $country_name = Country::where('id', @$athlete[$i]->address[0]->country_id)->first();

                                 $st_name = State::where('id', @$athlete[$i]->address[0]->state_id)->first();
                                 $city_name= City::where('id', @$athlete[$i]->address[0]->city_id)->first();

                                 $athlete_sport=UserSport::leftJoin('sports', 'user_sports.sport_id', '=', 'sports.id')->where('user_sports.user_id', @$athlete[$i]['id'])->get();

                                 $ath_sport=array();
                                 for($j=0; $j<count($athlete_sport); $j++){

                                    array_push($ath_sport, @$athlete_sport[$j]->name);                                
                                }

                                $sportName= implode("/",@$ath_sport);
                                $athlete_competition= UserSportPosition::leftJoin('competitions', 'user_sport_positions.competition_id', '=', 'competitions.id')->where('user_sport_positions.user_id', @$athlete[$i]['id'])->first();



                                ?>
                                <div class="col-sm-3">
                                    <div class="addathebox">

                                        <?php if(@$athlete[$i]['profile_type']==0){

                                         $prclass="public_l";
                                         $prtype="Public Profile";
                                     }else{
                                        $prclass="public_r";
                                        $prtype="Private Profile";

                                    }

                                    $is_follow= DB::select("SELECT * FROM  followers  WHERE (follower_id = '".$athlete[$i]['id']."' OR  user_id = '".$athlete[$i]['id']."') AND  (follower_id = '".Auth()->user()->id."' OR  user_id = '".Auth()->user()->id."') AND status=2");


                                    ?>
                                    <div class="<?= @$prclass ?>"><?= @$prtype ?></div>
                                    <div class="clr"></div>


                                    <?php 
                                    if(count($is_follow) >0 || @$athlete[$i]['profile_type']==0){ ?>


                                        <a href="{{ url('athlete-profile/'.$athlete[$i]['id'].'/'.'coach') }}" >
                                        <?php }else{ ?>

                                            <a href="#" onclick="private_msg()">

                                            <?php } ?>
                                            
                                            <div class="addatheboximg">

                                                <?php if($athlete[$i]['profile_image']!=""){?>
                                                    <img src="{{ asset($athlete[$i]['profile_image']) }}" alt="user_img"/> 

                                                <?php }else{ ?>
                                                    <?php $uname = explode(" ", $athlete[$i]['username']);
                                                    $fname= $uname[0];
                                                    $lname= @$uname[1];

                                                    ?>
                                                    <div class="pro-user"><?= ucfirst(@$fname[0]).ucfirst(@$lname[0]);?></div>
                                                <?php } ?>

                                            </div>
                                            <h5>{{ @$athlete[$i]->username }}</h5>
                                        </a>
                                        <span>Athlete, {{ @$sportName }}</span>
                                        <span>{{ @$st_name->name }}, {{ @$city_name->name }} </span>
                                        <span><?= @$athlete_competition->name ;?></span>
                                        <?php 
                                        $exit_follower_user = App\Models\Follower::where('user_id', Auth()->user()->id)->where('follower_id',$athlete[$i]->id)->first();
                                        ?>
                                        @if($exit_follower_user)
                                        <input type="button" id="followers" 
                                        class="added_athbtn " value="Follow" disabled style="background: #dd6565; padding:7px 20px;" onclick="unfollow(<?= @$exit_follower_user->id ?>)"/>
                                        @else
                                        <input type="button" id="followers" data-athleteid="{{$athlete[$i]->id}}"
                                        class="added_athbtn followers" style="padding:7px 20px;" value="Follow" />
                                        @endif

                                         <input type="button" data-athleteid="{{$athlete[$i]->id}}" style="background:#59a7cd; padding:7px 20px;"
                            class="added_athbtn ConnectViaMessage" value="Message" />


                                    </div>
                                </div>
                            <?php } }else{ ?>
                                <h6>No Result Found!!</h6>

                            <?php } ?>

                        </div>
                        <?php if($is_search==1){?>
                       <div class="text-center" style="margin-top: 50px;">
                               <a href="{{ route('coach.connections') }}">
                                <button type="button" id="continue" class="btn btn-success">Reset</button>
                               </a>
                           </div> 
                       <?php } ?>

          </div>
           

          <div class="tab <?php if($tabId==2) {?>tab-active <?php }?>" data-id="tab2">
            <!---Coach---->
            <div class="row createteamingup connectionbox" id="myList2">

                <?php 
                if(count($coach)>0){

                    for($i=0; $i<count($coach); $i++) {
                        $country_name = Country::where('id', @$coach[$i]->address[0]->country_id)->first();

                        $st_name = State::where('id', @$coach[$i]->address[0]->state_id)->first();
                        $city_name= City::where('id', @$coach[$i]->address[0]->city_id)->first();

                        $coach_sport=UserSport::leftJoin('sports', 'user_sports.sport_id', '=', 'sports.id')->where('user_sports.user_id', @$coach[$i]['id'])->get();

                        $coachSport=array();
                        for($j=0; $j<count($coach_sport); $j++){

                            array_push($coachSport, @$coach_sport[$j]->name);                                
                        }

                        $sportName= implode("/",@$coachSport);

                        $coach_level= CoachInformation::leftJoin('coaching_level', 'coach_informations.coaching_level', '=', 'coaching_level.id')->where('coach_informations.user_id', @$coach[$i]['id'])->first();



                        ?>
                        <div class="col-sm-3">
                            <div class="addathebox">

                                <?php if(@$coach[$i]['profile_type']==0){
                                  $type="athlete";

                                  $prclass="public_l";
                                  $prtype="Public Profile";
                              }else{
                                $prclass="public_r";
                                $prtype="Private Profile";

                            }?> 


                            <div class="<?= @$prclass ?>"><?= @$prtype ?></div>
                            <div class="clr"></div> 


                            <?php 


                            $is_follow= DB::select("SELECT * FROM  followers  WHERE (follower_id = '".$coach[$i]['id']."' OR  user_id = '".$coach[$i]['id']."') AND  (follower_id = '".Auth()->user()->id."' OR  user_id = '".Auth()->user()->id."') AND status=2");

                            if(count($is_follow) >0 || @$coach[$i]['profile_type']==0){ ?>

                              <a href="{{ url('coach-profile/'.$coach[$i]['id'].'/'.'coach') }}" >
                              <?php }else{ ?>

                                <a href="#" onclick="private_msg()">

                                <?php } ?>


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
                            </a>
                            <span>Coach, {{ @$sportName }}</span>
                            <span>{{@$st_name->name }},{{ @$city_name->name }}</span>
                            <span><?= @$coach_level->name ;?></span>
                            <?php 
                            $exit_follower_user = App\Models\Follower::where('status', 1)->where('user_id', Auth()->user()->id)->where('follower_id',$coach[$i]->id)->first();    ?>
                            @if($exit_follower_user)
                            <input type="button" id="followers" data-athleteid="{{$coach[$i]->id}}"
                            class="added_athbtn followers" value="Follow" disabled="" style="background: #dd6565; padding:7px 20px;" />
                            @else
                            <input type="button" id="followers" data-athleteid="{{$coach[$i]->id}}"
                            class="added_athbtn followers" value="Follow" style="padding:7px 20px;"/>
                            @endif
                                 <input type="button" data-athleteid="{{$coach[$i]->id}}" style="background:#59a7cd; padding:7px 20px;"
                                    class="added_athbtn ConnectViaMessage" value="Message" /> 
                                </div>
                            </div>
                        <?php } }else{ ?>
                            <h6>No Result Found!!</h6>
                        <?php } ?>
                    </div> 
                    <?php if($is_search==1){?>
                       <div class="text-center" style="margin-top: 50px;">
                               <a href="{{ route('coach.connections') }}">
                                <button type="button" id="continue" class="btn btn-success">Reset</button>
                               </a>
                           </div> 
                       <?php } ?>                   
                </div>

                <!---Following--->
                <div class="tab <?php if($tab_name=="accept"){?>tab-active<?php }?>" data-id="tab3">                   
                    <div class="row createteamingup connectionbox" id="myList3">

                        <?php 
                        if(count($following)>0){
                            for($i=0; $i<count($following); $i++) {
                               $user_detail = User::where('id', $following[$i]['follower_id'])
                               ->with('address')->first();

                               $st_name = State::where('id', @$user_detail->address[0]->state_id)->first();
                               $city_name= City::where('id', @$user_detail->address[0]->city_id)->first();

                               $sport=UserSport::leftJoin('sports', 'user_sports.sport_id', '=', 'sports.id')->where('user_sports.user_id', @$user_detail->id)->get();

                               $sportArr=array();
                               for($j=0; $j<count($sport); $j++){

                                array_push($sportArr, @$sport[$j]->name);                                
                            }

                            $sportName= implode("/",@$sportArr);

                            if(@$user_detail->role_id==1){
                                $role="Athlete";
                                $level= UserSportPosition::leftJoin('competitions', 'user_sport_positions.competition_id', '=', 'competitions.id')->where('user_sport_positions.user_id', @$user_detail->id)->first();                  
                            }else{
                                $role="Coach";
                                $level= CoachInformation::leftJoin('coaching_level', 'coach_informations.coaching_level', '=', 'coaching_level.id')->where('coach_informations.user_id', @$user_detail->id)->first();
                            }                                 

                            ?>
                            <div class="col-sm-3">
                                <div class="addathebox">  

                                    <?php 
                                    if(@$user_detail->profile_type==0){
                                        $prclass="public_l";
                                        $prtype="Public Profile";
                                    }else{
                                        $prclass="public_r";
                                        $prtype="Private Profile";

                                    }?>
                                    <div class="<?= @$prclass ?>"><?= @$prtype ?></div>
                                    <div class="clr"></div> 

                                    
                                    <?php if(@$user_detail->role_id==1){

                                        ?>

                                        <a href="{{ url('athlete-profile/'.$user_detail->id.'/'.'coach') }}" > 
                                        <?php }else{ 
                                           ?>
                                           <a href="{{ url('coach-profile/'.$user_detail->id.'/'.'coach') }}" > 

                                           <?php } ?>
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
                                    </a>
                                    <span>{{$role}}</span>
                                    <span>{{ @$sportName }}</span>
                                    <span>{{@$st_name->name }},{{ @$city_name->name }},</span>
                                    <span>{{ @$level->name; }}</span>                           
                                    <input type="button" onclick="unfollow(<?= $following[$i]->id ?>)"
                                    class="added_athbtn" value="Unfollow" />
                                </div>
                            </div>
                        <?php } }else{ ?>
                            <h6>No Result Found!!</h6>
                        <?php } ?>
                    </div>                    
                </div>

                <!----Follower--->
                <div class="tab" data-id="tab4">                   
                    <div class="row createteamingup connectionbox " id="myList2" >

                        <?php count($follower);
                        if(count($follower)>0){
                            for($i=0; $i<count($follower); $i++) {
                               $user_detail = User::where('id', $follower[$i]['user_id'])
                               ->with('address')->first();

                               $st_name = State::where('id', @$user_detail->address[0]->state_id)->first();

                               $city_name= City::where('id', @$user_detail->address[0]->city_id)->first();

                               $sport=UserSport::leftJoin('sports', 'user_sports.sport_id', '=', 'sports.id')->where('user_sports.user_id', @$user_detail->id)->get();

                               $sportArr=array();
                               for($j=0; $j<count($sport); $j++){

                                array_push($sportArr, @$sport[$j]->name);                                
                            }

                            $sportName= implode("/",@$sportArr);

                            if(@$user_detail->role_id==1){
                                $role="Athlete";
                                $level= UserSportPosition::leftJoin('competitions', 'user_sport_positions.competition_id', '=', 'competitions.id')->where('user_sport_positions.user_id', @$user_detail->id)->first();                  
                            }else{
                                $role="Coach";
                                $level= CoachInformation::leftJoin('coaching_level', 'coach_informations.coaching_level', '=', 'coaching_level.id')->where('coach_informations.user_id', @$user_detail->id)->first();
                            }                                 

                            ?>
                            <div class="col-sm-3">
                                <div class="addathebox">

                                    <?php 
                                    if(@$user_detail->profile_type==0){
                                        $prclass="public_l";
                                        $prtype="Public Profile";
                                    }else{
                                        $prclass="public_r";
                                        $prtype="Private Profile";

                                    }?>
                                    <div class="<?= @$prclass ?>"><?= @$prtype ?></div>
                                    <div class="clr"></div>

                                    <?php if(@$user_detail->role_id==1){

                                        ?>

                                        <a href="{{ url('athlete-profile/'.$user_detail->id.'/'.'coach') }}" > 
                                        <?php }else{ 
                                           ?>
                                           <a href="{{ url('coach-profile/'.$user_detail->id.'/'.'coach') }}" >                                     

                                           <?php } ?>
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
                                    </a>
                                    <span>{{@$role}}</span>
                                    <span>{{ @$sportName }}</span>
                                    <span>{{@$st_name->name }},{{ @$city_name->name }}</span>
                                    <span>{{ @$level->name }}</span>

                                    <input type="button" data-athleteid="{{$follower[$i]->id}}" style="background:#59a7cd"
                                    class="added_athbtn ConnectViaMessage" value="Message" />                               

                                </div>
                            </div>  

                        <?php } }else{ ?>
                            <h6>No Result Found!!</h6>
                        <?php } ?>
                    </div>                    
                </div>
                <!---Pending Request-->
                <div class="tab <?php if($tab_name=="request"){?>tab-active<?php }?>" data-id="tab5"> 
                    <button type="button" class="followbtn  followingTab <?php if($tab_name==""){?>activebutton<?php }?>" onclick="followingRequest(this)">People I want to follow</button>

                    <button type="button" class="followbtn followerTab <?php if($tab_name=="request"){?>activebutton<?php }?>" onclick="followerRequest(this)">People that want to follow me</button> 

                    <!---Pending Following--->
                    <?php if($tab_name=="request"){?>
                    <div class="row createteamingup connectionbox pending_following_list" id="myList2" style="display:none"> 
                    <?php }else{?>  
                         <div class="row createteamingup connectionbox pending_following_list" id="myList2" > 

                    <?php } ?>                        

                        <?php 
                        if(count($pending_following)>0){
                            for($i=0; $i<count($pending_following); $i++) {
                               $user_detail = User::where('id', $pending_following[$i]['follower_id'])
                               ->with('address')->first();


                               $st_name = State::where('id', @$user_detail->address[0]->state_id)->first();

                               $city_name= City::where('id', @$user_detail->address[0]->city_id)->first();

                               $sport=UserSport::leftJoin('sports', 'user_sports.sport_id', '=', 'sports.id')->where('user_sports.user_id', @$user_detail->id)->get();

                               $sportArr=array();
                               for($j=0; $j<count($sport); $j++){

                                array_push($sportArr, @$sport[$j]->name);                                
                            }

                            $sportName= implode("/",@$sportArr);



                            if(@$user_detail->role_id==1){
                                $role="Athlete";
                                $level= UserSportPosition::leftJoin('competitions', 'user_sport_positions.competition_id', '=', 'competitions.id')->where('user_sport_positions.user_id', @$user_detail->id)->first();                  
                            }else{
                                $role="Coach";
                                $level= CoachInformation::leftJoin('coaching_level', 'coach_informations.coaching_level', '=', 'coaching_level.id')->where('coach_informations.user_id', @$user_detail->id)->first();
                            }  
                            if($pending_following[$i]['status']==3){
                                $btn_value= "Rejected";
                                $btn_css= "reject_btn";
                            }else{
                                $btn_value= "Pending";
                                $btn_css= "pending_btn";
                            }                              

                            ?>
                            <div class="col-sm-3">
                                <div class="addathebox">
                                   <?php if($user_detail->profile_type==0){
                                    $type="coach";
                                    ?>
                                    <div class="public_l ">Public Profile</div>
                                    <div class="clr"></div>

                                    <?php if($user_detail->role_id==1){

                                        ?>

                                        <a href="{{ url('athlete-profile/'.$user_detail->id.'/'.$type) }}" > 
                                        <?php } else{ 
                                           ?>
                                           <a href="{{ url('coach-profile/'.$user_detail->id.'/'.$type) }}" > 


                                           <?php } }else{ ?>
                                            <div class="public_r">Private Profile</div>
                                            <div class="clr"></div>
                                            <a href="#" onclick="private_msg()"> 

                                            <?php } ?>

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
                                        </a>

                                        <span>{{@$role}}</span>
                                        <span>{{ @$sportName }}</span>
                                        <span>{{@$st_name->name }},{{ @$city_name->name }}</span>
                                        <span><?= @$level->name ;?></span>

                                        <input type="button" id="followers"
                                        class="added_athbtn <?= @$btn_css ?>" value="<?= @$btn_value ?>" />

                                    </div>
                                </div>  

                            <?php } }else{ ?>
                                <h6>No Result Found!!</h6>
                            <?php } ?>
                        </div> 

                        <!---Pending Follower--->    
                         <?php if($tab_name=="request"){?>              
                        <div class="row createteamingup connectionbox pending_follower_list" id="myList2" > 
                        <?php }else{?> 
                             <div class="row createteamingup connectionbox pending_follower_list" id="myList2" style="display:none">   

                            <?php }?>                       

                            <?php count($pending_follower);
                            if(count($pending_follower)>0){
                                for($i=0; $i<count($pending_follower); $i++) {
                                   $user_detail = User::where('id', $pending_follower[$i]['user_id'])
                                   ->with('address')->first();


                                   $st_name = State::where('id', @$user_detail->address[0]->state_id)->first();

                                   $city_name= City::where('id', @$user_detail->address[0]->city_id)->first();

                                   $sport=UserSport::leftJoin('sports', 'user_sports.sport_id', '=', 'sports.id')->where('user_sports.user_id', @$user_detail->id)->get();

                                   $sportArr=array();
                                   for($j=0; $j<count($sport); $j++){

                                    array_push($sportArr, @$sport[$j]->name);                                
                                }

                                $sportName= implode("/",@$sportArr);



                                if(@$user_detail->role_id==1){
                                    $role="Athlete";

                                    $level= UserSportPosition::leftJoin('competitions', 'user_sport_positions.competition_id', '=', 'competitions.id')->where('user_sport_positions.user_id', @$user_detail->id)->first();                  
                                }else{
                                    $role="Coach";
                                    $level= CoachInformation::leftJoin('coaching_level', 'coach_informations.coaching_level', '=', 'coaching_level.id')->where('coach_informations.user_id', @$user_detail->id)->first();
                                }                                 

                                ?>
                                <div class="col-sm-3">
                                    <div class="addathebox">
                                       <?php if($user_detail->profile_type==0){
                                        $type="coach";

                                        ?>
                                        <div class="public_l">Public Profile</div>
                                        <div class="clr"></div>
                                        
                                        <?php if($user_detail->role_id==1){

                                            ?>

                                            <a href="{{ url('athlete-profile/'.$user_detail->id.'/'.$type) }}" > 
                                            <?php } else{ 
                                               ?>
                                               <a href="{{ url('coach-profile/'.$user_detail->id.'/'.$type) }}" > 

                                               <?php }}else{ ?>
                                                <div class="public_r">Private Profile</div>
                                                <div class="clr"></div>
                                                <a href="#" onclick="private_msg()">

                                                <?php } ?>

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
                                            </a>

                                            <span>{{@$role}}</span>
                                            <span>{{ @$sportName }}</span>
                                            <span>{{@$st_name->name }},{{ @$city_name->name }}</span>
                                            <span><?= @$level->name ;?></span>

                                            <?php if($pending_follower[$i]->status==1){?>

                                               <input type="button"  style="background:#259150"
                                               class="added_athbtn" onclick="request_response(<?= $pending_follower[$i]->id ?>,'2')" value="Accept" />

                                               <input type="button" id="followers" onclick="request_response(<?= $pending_follower[$i]->id ?>,'3')"
                                               class="added_athbtn " value="Deny" /> 
                                           <?php }else{ ?>
                                               <input type="button" id="followers"
                                               class="added_athbtn reject_btn" value="Rejected" />


                                           <?php }?>
                                       </div>
                                   </div>  

                               <?php } }else{ ?>
                                <h6>No Result Found!!</h6>
                            <?php } ?>
                        </div>                    
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="clr"></div>
</div>
<!---Filter modal---->
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
                                    <li><a href="#" class="tab-a01" data-id="tab8">Zip Code</a></li>                          

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

                        @foreach($sport_list as $sport_value)
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
            <!-- <ul>
                <select class="form-control" name="states" id="state"
                style="width: 100% !important;">
                <option value=''>Select </option>
                @foreach($states as $states_value)
                <option value="{{$states_value['id']}}"> {{$states_value['name']}}
                </option>
                @endforeach
            </select>
        </ul> -->
        <ul>
         @foreach($states as $states_value)
         <li>
            {{$states_value['name']}}
            <div class="radioboxsub">
                <input type="checkbox" id="state{{$states_value['id']}}" name="states[]"
                value="{{$states_value['id']}}">
                <label for="state{{$states_value['id']}}"></label>
            </div>
        </li>
        @endforeach
    </ul>
    </div> 
  
    <div class="tab01" data-id="tab8">
        <input type="number" class="form-control" name="zip_code" value=""
        placeholder="Enter zip code" autocomplete="off" />
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

<!----Coach Filter Modal----->
<!---Filter modal---->
<div class="modal fade" id="coachfilterpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
                aria-hidden="true">&times;</span> </button>
                <h5>Apply Filter</h5>
                <form action="{{ route('coach.search-coach') }}" method="post"  enctype="multipart/form-data">
                    @csrf
                    <div class="tab-container">
                        <div class="filtertabopoup_l">
                            <div class="tab-menu01">
                                <ul>
                                 <ul>
                                    <li><a href="#" class="tab-a01 active-a01" data-id="tab1">Level Coaching</a></li>

                                    <li><a href="#" class="tab-a01" data-id="tab2">Sport Coaching</a></li>
                                    <li><a href="#" class="tab-a01" data-id="tab3">Gender of Sport Coaching</a></li>

                                    <li><a href="#" class="tab-a01" data-id="tab4">  Primary Age Group Coaching</a></li>
                                    <li><a href="#" class="tab-a01" data-id="tab5">School or University</a></li>

                                    <li><a href="#" class="tab-a01 " data-id="tab6">High School Name/Middle School Name/Club Name.</a></li>
                                    
                                </ul>
                            </ul>
                        </div>
                    </div>
                    <div class="filtertabopoup_r">
                        <div class="tab01 tab-active01" data-id="tab1">
                            <?php //print_r($coach_level);?>
                            <select class="form-control" name="coaching_level" id="coach_level"
                style="width: 100% !important;">
                <option value=''>Select </option>               
                    @foreach($coaching_level_list as $level)
                    <option value="<?= $level->id ?>"><?= $level->name ?></option>

                    
                    @endforeach
               
            </select>    


                    </div>
                    <div class="tab01 " data-id="tab2">
                      <ul>

                        @foreach($sport_list as $sport_value)
                        <li>
                            {{$sport_value->name}}
                            <div class="radioboxsub">
                                <input type="checkbox" id="coachsport{{$sport_value->id}}" name="coachsports[]"
                                value="{{$sport_value->id}}">
                                <label for="coachsport{{$sport_value->id}}"></label>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="tab01" data-id="tab3">
                 <select class="form-control" name="gender" id="gender"
                            style="width: 100% !important;">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="both">Both</option>
                        </select>
            </div>
            <div class="tab01" data-id="tab4">
                <select class="form-control" name="primary_age_group" >
                    <option value="">--Select--</option>
                    <option value="U6 to U9" >U6 to U9</option>
                    <option value="U10 to U13">U10 to U13</option>
                    <option value="U14 to U19" >U14 to U19</option>
                    <option value="U21 and above" >U21 and above</option>

                    <option value="International Competition" >International Competition(non-professional) </option>
                    <option value="Collegiate" >Collegiate</option>
                    <option value="Professional" >Professional</option>
                </select>
            </div>
            <div class="tab01" data-id="tab5">
               
                <input type="text" value="" id="college_name" class="form-control input-lg" placeholder="Enter College Name" />
                <input type="hidden" name="college_id" id="collegeId">
                    <div id="collegeList" style="position: relative; top:0">
                    </div>
            </div>
            <div class="tab01" data-id="tab6">
                <input type="text" class="form-control input-lg" placeholder="Enter name" name="level_name">
            </select>
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

    function checkTab(tabId){        
        if(tabId==1){
             $('#tabId').val(tabId);
            $('#filtersec').show();
            $('#coachfiltersec').hide();
        }
        else if(tabId==2){
            $('#tabId').val(tabId);
            $('#filtersec').hide();
            $('#coachfiltersec').show();
        }
        else{
            $('#tabId').val(1);
            $('#filtersec').hide();
             $('#coachfiltersec').hide();
        }
    }
</script>

@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('.followers').on('click', function() {
            var follower_id = $(this).data('athleteid');
            
            $.ajax({
                type: "POST",
                url: "{{ route('coach.add-follow') }}",
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
            url: "{{ route('request-response') }}",
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

    function followerRequest(dis){

        $('.followingTab').removeClass('activebutton');
        
        $(dis).addClass('activebutton');
        $('.pending_follower_list').show();
        $('.pending_following_list').hide();
    }

    function followingRequest(dis){

        $('.followerTab').removeClass('activebutton');
        
        $(dis).addClass('activebutton');
        $('.pending_follower_list').hide();
        $('.pending_following_list').show();

    }

     //===Unfollow==
     function unfollow(followId){
        $.ajax({
            type: "POST",
            url: "{{ route('coach.unfollow') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                followid: followId
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

    function private_msg(){        
        swal( "You cannot open a 'Private Profile' until your 'Follow' request has been accepted.", ' ', 'warning');
        return false;
    }

    $( document ).ready(function() {
        var tabId= $('#tabId').val();
        if(tabId==1){           
            $('#filtersec').show();            
            $('#coachfiltersec').hide();
        }
        else if(tabId==2){           
            $('#filtersec').hide();
            $('#coachfiltersec').show();
        }else{            
            $('#filtersec').hide();
            $('#coachfiltersec').hide();
        }
    });

    $('#college_name').keyup(function(){ 
            var searchTxt = $(this).val();

            if(searchTxt != '')
            {
                $.ajax({
                    type : "POST",
                    url:"{{ route('autocomplete.college') }}",

                    data: {
                        searchTxt: searchTxt,
                        _token: '{{csrf_token()}}'
                    },

                    success: function(data){
                        console.log(data);
                        if(data!=""){
                            $('#collegeList').fadeIn();  
                        $('#collegeList').html(data);
                        }
                        

                    }
                });
            }
        });


        $(document).on('click', '#collegedropdown li', function(){  
            $('#college_name').val($(this).text());
            if($(this).val()!=""){
                $('#collegeId').val($(this).val());
            }else{
                $('#college_name').val('');
            }           
            
            $('#collegeList').fadeOut();  
        }); 

    
</script>
@endsection