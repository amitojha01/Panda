@extends('frontend.athlete.layouts.app')
@section('title', 'Dashboard')
@section('style')
<style>
    #aci-score{
        padding-right: 5px;
    }
    #myChart {
        width: 100%;
        height: 300px;
    }
    g[aria-labelledby="id-66-title"]{
        display:none !important;
    }

    
</style>
@endsection
@section('content')
<?php 
use App\Models\CoachInformation;
use App\Models\CoachLevel;
use App\Models\UserSportPosition;
use App\Models\Sport;

use App\Models\UserWorkoutLibrary;
use App\Models\WorkoutLibrary;
use App\Models\WorkoutCategory;
use App\Models\Competition;
use App\Models\SchoolPlaying;


?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h6 style="color:#FFD500">Monthly Highest Graph</h6>
                    <div class="dashboard_r_top">
                        @if(empty($score_dataset))
                        <img src="{{ asset('public/frontend/images/no-grap.png') }}" alt="graph_img" />
                        @else
                        <div id="myChart" width="400" height="170"></div>
                        @endif
                    </div>
                </div>
                
                
                <div class="col-md-12">
                <div class="newgamehighlight">
                	<div id="gamehighlightnew" class="owl-carousel">
                        @if(!$game_highlight->isEmpty())
                            @foreach($game_highlight as $key=> $game_list)
                		<div class="item">
                		<div class="row">
                			<div class="col-md-6 col-sm-12 col-xs-12">
                				<div class="gamehighlightedsummery">
                					<h3>Game Highlight Summary</h3>

                                    <div class="gamehighlight_box">

                                    <span><img src="{{ asset('public/frontend/athlete/images/blackcalender.png') }}" alt="blackcalender" /></span>
                                        <h4>{{ date('Y-m-d', strtotime($game_list->record_date)) }}</h4>
                                        
                                        <p>{{ substr(($game_list->description),0,70) }}<?php if(strlen($game_list->description)>110) {?><a href="javascript:void(0);" data-toggle="modal" data-target="#gamepopup" onclick="getDescription(<?= @$game_list->id ?>)">...Read More </a><?php } ?></p>
              					
                                    </div>
                				</div>
                			</div>
                			<div class="col-md-6 col-sm-12 col-xs-12">
                				<div class="gamehighlightedvideo">
                					<h3>Game Highlight Video</h3>
                                    <?php $videoLink = @$game_list->video;
                                $rx = '~^(?:https?://)?(?:www[.])?(?:youtube[.]com/watch[?]v=|youtu[.]be/)([^&]{11})~x';
                                $has_match = preg_match($rx, $videoLink, $matches);
                                $videoId = @$matches[1]; 

                                ?>
                                <a href="{{ @$videoLink }}" target="_blank"><img src="{{ 'https://img.youtube.com/vi/' . $videoId . '/mqdefault.jpg' }}" width="85%" height="85%" alt="videoimg" /></a>
                                
                				</div>
                			</div>
                			</div>
                		</div>
                        @endforeach
                        @endif
                		
					</div>
                </div>
                </div>
                
                
                
                
                
                
                
                
                <!--<div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="dashboard_l_top">
                        <a href="{{ route('athlete.game-highlights')}}"><h3>Game Highlight Summary  </h3></a>
                        <?php if(count($game_highlight) !=1){?>
                        <div id="gamehighlight" class="owl-carousel">
                        <?php }?>
                           
                            @if(!$game_highlight->isEmpty())

                            @foreach($game_highlight as $key=> $game_list)
                           
                                <div class="item">
                                    <div class="gamehighlight_box">
                                        <span><img src="{{ asset('public/frontend/athlete/images/blackcalender.png') }}" alt="blackcalender" /></span>
                                        <h4>{{ date('Y-m-d', strtotime($game_list->record_date)) }}</h4>
                                        
                                        <p>{{ substr(($game_list->description),0,70) }}<?php if(strlen($game_list->description)>110) {?><a href="javascript:void(0);" data-toggle="modal" data-target="#gamepopup" onclick="getDescription(<?= @$game_list->id ?>)">...Read More </a><?php } ?></p>

                                        <a href="{{ @$game_list->video }}" target="_blank"><p>{{ @$game_list->video }}</p></a>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="item">
                                    <div class="gamehighlight_box">
                                        <p>There are no game highlight founds</p>
                                    </div>
                                </div>
                                @endif
                                <?php if(count($game_highlight)!=1){?>
                            </div>
                        <?php }?>
                        </div>
                    </div>-->
                       <!-- <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="dashboard_l_bottom">
                           <a href="{{ route('athlete.video-evidence') }}"><h3>Game Highlight Video</h3></a>
                        <div id="videoevidence" class="owl-carousel">

                            @if($game_highlight)
                            @foreach($game_highlight as $key => $game_list)
                            <div class="item">
                                <?php $videoLink = @$game_list->video;
                                $rx = '~^(?:https?://)?(?:www[.])?(?:youtube[.]com/watch[?]v=|youtu[.]be/)([^&]{11})~x';
                                $has_match = preg_match($rx, $videoLink, $matches);
                                $videoId = @$matches[1]; 

                                ?>

                                <a href="javascript:void(0);" data-toggle="modal" data-target="#videopopup" onclick="getVideo('<?= @$video_list->video_embeded_link ?>', '<?= @$video_list->workout_category_id ?>', '<?= @$video_list->workout_type_id ?>')" ><img src="{{ 'https://img.youtube.com/vi/' . $videoId . '/mqdefault.jpg' }}" width="85%" height="85%" alt="videoimg" /></a>

                            </a>


                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>-->





                    <!----------------->
                    <!-- <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="dashboard_l_bottom">
                           <a href="{{ route('athlete.video-evidence') }}"><h3>Video Evidence</h3></a>
                           <div id="videoevidence" class="owl-carousel">

                            @if($video_evidence)
                            @foreach($video_evidence as $key => $video_list)
                            <div class="item">
                                <?php $videoLink = $video_list->video_link;
                                $rx = '~^(?:https?://)?(?:www[.])?(?:youtube[.]com/watch[?]v=|youtu[.]be/)([^&]{11})~x';
                                $has_match = preg_match($rx, $videoLink, $matches);
                                $videoId = $matches[1]; ?>

                                <a href="javascript:void(0);" data-toggle="modal" data-target="#videopopup" onclick="getVideo('<?= @$video_list->video_embeded_link ?>', '<?= @$video_list->workout_category_id ?>', '<?= @$video_list->workout_type_id ?>')" ><img src="{{ 'https://img.youtube.com/vi/' . $videoId . '/mqdefault.jpg' }}" width="85%" height="85%" alt="videoimg" /></a>

                            </a>


                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div> -->


            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="dashboard_l_top" style="margin-bottom:30px;">
                    <a href="{{ route('athlete.events')}}"><h3>Last event attended</h3></a>
                    <?php if(count($last_attend_event)!=1){ ?>
                    <div id="last_attend_event" class="owl-carousel">
                    <?php } ?>
                        <?php if($last_attend_event){
                            foreach($last_attend_event as $key => $last_attendevent){


                                ?>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <div class="eventsboxleft">
                                                <i>To</i>
                                                <h6>Start Date</h6><b>{{  date('m/d/Y', strtotime($last_attendevent->start_date))  }}</b>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <div class="eventsboxright">
                                                <h6>End Date</h6><b>{{  date('m/d/Y', strtotime($last_attendevent->end_date))  }}</b>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">     
                                            <div class="eventsboxleft">
                                                <h6>Location</h6><b>{{ $last_attendevent->location }}</b>
                                            </div>                             
                                        </div>

                                        <div class="eventbtngroup1">
                                            <a href="" id="event_details" data-toggle="modal"
                                            data-r="{{ @$last_attendevent->id }}" data-toggle="modal"
                                            data-r="{{ @$last_attendevent->id }}" class="postbtn event_details">DETAILS</a>

                                        </div>
                                    </div>
                                </div>
                            <?php }} ?>
                        <?php if(count($last_attend_event)!=1){ ?>
                        </div>
                    <?php } ?>

                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="dashboard_l_top">
                       <a  href="{{ route('athlete.events') }}"><h3 style="color:#4BFF00;">The next upcoming event to attend </h3></a>
                       <?php if(count($upcoming_event)!=1){?>
                       <div id="upcomingevents" class="owl-carousel">
                       <?php } ?>
                        @if($upcoming_event)
                        @foreach($upcoming_event as $key => $upcomingevents)
                        <div class="item">
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="eventsboxleft">
                                        <i>To</i>
                                        <h6>Start Date</h6><b>{{  date('m/d/Y', strtotime($upcomingevents->start_date))  }}</b>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="eventsboxright">
                                        <h6>End Date</h6><b>
                                            {{  date('m/d/Y', strtotime($upcomingevents->end_date))  }}

                                            </b>
                                    </div>
                                </div>
                                <div class="col-lg-12">     
                                    <div class="eventsboxleft">
                                        <h6>Location</h6><b>{{ $upcomingevents->location }}</b>
                                    </div>                                    
                                </div>
                                <div class="eventbtngroup1">
                                    <a href="" id="event_details" data-toggle="modal"
                                    data-r="{{ @$upcomingevents->id }}" data-toggle="modal"
                                    data-r="{{ @$upcomingevents->id }}" class="postbtn event_details">DETAILS</a>

                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        <?php if(count($upcoming_event)!=1){?>
                    </div>
                <?php } ?>
                </div>
            </div>
        </div>

        <div class="dashbottom">
            <h4>My Workouts ({{ count($workout_librarys) }})</h4>

            <div class="tab-menu03">              
                <ul>
                    <?php 
                    foreach($allWorkoutCategory as $key => $value){ 
                    // echo "<pre>";
                    // print_r($value);
                    // die;
                    ?>
                    
                   <li><a href="#" class="tab-a03 {{$key == 0 ? 'active-a03' : '' }}" data-id="tab{{$value['id']}}">{{$value['content_title']}}</a></li>
                    <?php
                    }    
                    ?>
                   {{-- <li><a href="#" class="tab-a03 active-a03" data-id="tab1">ACI™ Workout</a></li>
                   <li><a href="#" class="tab-a03" data-id="tab2">Strength</a></li> 
                   <li><a href="#" class="tab-a03" data-id="tab3">Speed</a></li>    
                   <li><a href="#" class="tab-a03" data-id="tab4">Explosiveness</a></li>    
                   <li><a href="#" class="tab-a03" data-id="tab5">Agility</a></li>    
                   <li><a href="#" class="tab-a03" data-id="tab6">Endurance</a></li>    
                   <li><a href="#" class="tab-a03" data-id="tab7">Sport Specific Workouts </a></li> 
                   <li><a href="#" class="tab-a03" data-id="tab8">Core and Flexibility </a></li>           --}}
                </ul>
             </div>
            <?php
            foreach ($allWorkoutCategory as $key => $value) { 
            
        $workout_library = UserWorkoutLibrary::where('user_id', Auth()->user()->id)->where('workout_id', $value['id'] )->where('status', 1)->get();    
        // $workout_library = UserWorkoutLibrary::where('user_id', Auth()->user()->id)->where('status', 1)->get();
        $workout_librarys = [];
        if(count($workout_library) > 0){
            foreach($workout_library as $key => $val){
                $temp = WorkoutLibrary::where('status', 1)->where('id', $val->workout_library_id)->first();
                if($temp){
                    //print_r($temp);
                    $cat = WorkoutCategory::where('status', 1)->where('id', $val->workout_id)->first();
                    $temp['category_title'] =  $cat->category_title;
                    $temp['category_id'] =  $cat->id;
                    $workout_librarys[] = $temp;
                }
            }
        }   
           
           ?>
            
            <div  class="tab03 {{$value['id'] == 8 ? 'tab-active03' : '' }}" data-id="tab{{$value['id']}}">
                <div class="row">

                    @if($workout_librarys)
                    @foreach($workout_librarys as $library)

                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="workoutboxnew">
                            <?php
                         
                            $measurement = App\Models\WorkoutLibraryMeasurement::find($library['measurement_id']);
                            $exercises = App\Models\UserWorkoutExercises::where([
                                'workout_library_id'=> $library['id'],
                                'user_id'=> Auth()->user()->id,
                                'category_id' => $library['category_id']
                            ])->first();
                                    //                                                 echo "<pre>";
                                    // print_r($exercises);
                                    // die;
                            // $userWorkoutExerciseshight =  DB::table('user_workout_exercise_logs')->where('workout_library_id', $library['id'])->where('user_id', Auth()->user()->id)->orderBy('unit_1', 'desc')->get();

                            $userWorkoutExerciseshight = DB::table('user_workout_exercise_logs')->where('workout_library_id', $library['id'])->where('category_id', $library['category_id'])->where('user_id', Auth()->user()->id)->max('unit_1');
                           

                            $recent_workout = DB::table('user_workout_exercise_logs')->where('workout_library_id', $library['id'])->where('category_id', $library['category_id'])->where('user_id', Auth()->user()->id)->
                            where('unit_1', '!=', 0)->orderBy('id', 'desc')->first();


                            $recent_video = DB::table('user_workout_exercise_logs')->where('workout_library_id', $library['id'])->where('category_id', $library['category_id'])->where('user_id', Auth()->user()->id)->
                            where('video', '!=', "")->orderBy('id', 'desc')->first();
                            

                            // dd($userWorkoutExerciseshight);
                            $workout_description_array = array(
                                'reps' => 'Enter the number of reps completed | Enter the amount of weight used',
                                'time' => 'Enter the time it took to complete the workout',
                                'distance' => 'Enter the distance they jumped',
                                'height' => 'Enter the height of the box on which they jumped',
                                'distance & weight' => 'Enter distance travelled | Enter the amount of weight used',
                                'speed' => 'Enter MPH',
                                'distance'=> 'Enter Feet',
                                'time'=> 'Enter Sec',
                                        //'yards'=> 'Enter Distance',
                                'percentage' => 'Enter Percentage'
                            );
                            // print_r($workout_description_array[strtolower($measurement->name)]); die;
                            $xx = $workout_description_array[strtolower($measurement->name)];
                            $x = explode("|", $xx);
                            ?>  
                            <h3>{{ !empty($library['sport_category_title']) ? $library['sport_category_title'] : $library['title'] }} <span>{{ $library['category_title'] }}</span></h3>
                            <h6>Last Updated 
                                <span>
                                    @if($exercises)
                                    {{ date('m/d/Y', strtotime($exercises->record_date) )}}
                                    @else
                                    {{ date('m/d/Y', strtotime($library['created_at']) )}}
                                    @endif
                                </span></h6>

                                <p>Most Recent Workout Entry <span>{{ $recent_workout ? $recent_workout->unit_1 : 0}} <b>{{strtoupper($measurement->unit)}}</b></span></p>

                                <p>Personal Record <span>{{ $userWorkoutExerciseshight ?  $userWorkoutExerciseshight : 0  }} <b>{{strtoupper($measurement->unit)}}</b></span></p>



                                <div class="vidoethumb">
                                    
                                    @if(@$recent_video->video!="")
                                    <?php
                                    $videoLink = '';
                                     $videoLink = @$recent_video->video;
                                    $rx = '~^(?:https?://)?(?:www[.])?(?:youtube[.]com/watch[?]v=|youtu[.]be/)([^&]{11})~x';
                                    $has_match = preg_match($rx, $videoLink, $matches);
                                    $videoId = $matches[1]; 
                                    ?>
                                    <a href="{{ @$exercises['video']}}"><img src="{{ 'https://img.youtube.com/vi/' . $videoId . '/mqdefault.jpg' }}" width="85%" height="100%" alt="videoimg" /></a>

                                    <a class="add_video" href="{{ url('athlete/workouts/add-video/'.$library['category_id'].'/'.$library['id']) }}"><img src="{{ asset('public/frontend/athlete/images/yellow_plus2.png') }}" alt="yellow_plus2"></a>

                                    <p class="video-date">{{ date('m/d/Y', strtotime(@$recent_video->record_date)) }}</p>
                                    @else
                                    <a href="{{ url('athlete/workouts/add-video/'.$library['category_id'].'/'.$library['id']) }}" class="addVideo">
                                    <span>Click Here to Add  Video Evidence</span>
                                </a>
                                    @endif
                                </div>
                                <div class="updated">
                                    <a href="{{ url('athlete/workouts/show/'.$library['category_id'].'/'.$library['id']) }}" class="updateddashbtn">Update</a>
                                </div>
                                <div class="clr"></div>

                                {{-- <h5>
                                    <a href="{{ url('athlete/workouts/show/'.$library['category_id'].'/'.$library['id']) }}">
                                        <img class="yellowarrow" src="{{ asset('public/frontend/athlete/images/yellowright_arrow.png') }}"
                                        alt="yellowright_arrow" />
                                    </a>
                                    <div class="clr"></div>
                                </h5> --}}
                        </div>
                    </div>
                        @endforeach
                        @endif

                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="dashbottombox_l dashbottombox_llast">
                                <a href="{{ route('workouts.index') }}">
                                    <img src="{{ asset('public/frontend/athlete/images/yellow_plus.png') }}" alt="yellow_plus" />
                                    <div class="clr"></div>
                                    <span>Add New Workout</span>
                                </a>
                            </div>
                        </div>
                </div>
            </div>
            <?php
            }
            ?>
            {{-- <div  class="tab03" data-id="tab2">
               2
            </div>
            <div  class="tab03" data-id="tab3">
                3
            </div>
            <div  class="tab03" data-id="tab4">
                4
            </div>
            <div  class="tab03" data-id="tab5">
                5
            </div>
            <div  class="tab03" data-id="tab6">
                6
            </div>
            <div  class="tab03" data-id="tab7">
                7
            </div>
            <div  class="tab03" data-id="tab8">
                8
            </div> --}}
        </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="myprofile">
                <a href="<?= url('athlete/profile'); ?>">
                    <div class="myprofile_l">
                        @if(Auth()->user()->profile_image!="")                    
                          <img src="{{ asset($user_detail->profile_image) }}" alt="user_img"/> 
                         
                      
                        @else
                        <!-- <img src="{{ asset('public/frontend/images/noimage.png') }}" alt="user_img"/> -->
                        <?php $uname = explode(" ", Auth()->user()->username);
                         $fname= $uname[0];
                         $lname= @$uname[1];

                         ?>
                         <div class="pro-avatar"><?= ucfirst(@$fname[0]).ucfirst(@$lname[0]);?></div>
                        @endif
                    </div>
                    <div class="myprofile_mid">
                        <span>Hello,</span>
                        <h5>{{ Auth()->user()->username }}!</h5>
                        <!-- <a href="<?= url('athlete/profile'); ?>" class="profilelink">View Profile</a>  -->
                        <?php if(Auth()->user()->profile_type==0){?>
                          <span class="public-profile">Public</span>
                      <?php }else{?>
                        <span class="private-profile">Private</span>
                    <?php }?>
                    </div>
                </a>
                <div class="myprofile_r">
                    <a href="<?= url('athlete/edit-profile'); ?>">
                         <img src="{{ asset('public/frontend/athlete/images/edit_img.png') }}" alt="edit_img" />
                       
                    </a>
                </div>
                <div class="clr"></div>


                <div class="followerspanel">
                   <!--  <a href="{{route('athlete.followers')}}"> -->
                        <a href="{{route('athlete.connections','tabId=4')}}">
                        <span>{{ count(@$follower)}} Followers</span></a>
                    <!-- <a href="{{route('athlete.following')}}"> -->
                        <a href="{{route('athlete.connections','tabId=3')}}">
                        <span>{{ count(@$following)}} Following</span></a>

                    <a href="{{route('athlete.coach-request')}}"><span>{{ count(@$coach_request) }} Coach Request to be follow</span></a>

                    <div class="clr"></div>
                    <!-- <a href="" class="followlink">Follow</a> -->
                    <!-- <a href="<?= url('athlete/compare'); ?>" class="addtocompare">Add to compare</a> -->
                    <a href="<?= url('athlete/profile'); ?>" class="profilelink">View Profile</a> 
                    <div class="clr"></div>
                </div>

                <div class="profiledetails">
                    <h4 class="profiledetailsdash">General Info</h4>

                    <div class="profiledetails_l">
                        <div class="clr"></div>                            
                        <span>User id</span>                            
                        <b>{{ Auth()->user()->username  }}</b>
                        <span>Birth Year</span>
                        <b>{{ Auth()->user()->year  }}</b>
                        <span>Current Education Level:</span>
                        <b>{{ @$user_education->name  }}</b>

                        <span>Competetion Level</span>
                        <?php $competetion_level= Competition::select('name')->where('id', @$user_sportposInfo->competition_id)->first();

                        ?>

                        <b>{{ @$competetion_level->name  }}</b>      

                        <span>School Playing Level</span>
                        <?php $school_playing_level= SchoolPlaying::select('name')->where('id', @$user_sportposInfo->school_level_id)->first();
                        ?>

                        <b>{{ @$school_playing_level->name  }}</b>


                    </div>
                    <div class="profiledetails_r">
                        <span>Gender</span>
                        <b>{{ ucfirst(Auth()->user()->gender)  }}</b>

                        <span>High School Graduation Year</span>
                        <b>{{ Auth()->user()->graduation_year  }}</b>
                        <span>High School GPA</span>
                        <b>{{ @$user_physicalInfo->grade  }}</b>


                    </div>
                    <div class="clr"></div>
                    <table class="dashprofiletable">
                        <tr>
                            <th>Sports</th>
                            <th>Position</th>
                        </tr>
                        <?php 

                        foreach($user_sport as $sport){
                         $user_sport=UserSportPosition::leftJoin('sport_positions', 'user_sport_positions.position_id', '=', 'sport_positions.id')->where('user_sport_positions.sport_id', $sport->sport_id)->where('user_sport_positions.user_id', Auth()->user()->id)
                         ->get();                         


                         ?>
                         <tr>
                            <td>{{ $sport->name  }}</td>
                            <td>
                                <?php for($j=0; $j<count($user_sport); $j++){ ?>
                                    <b>{{ @$user_sport[$j]->name  }}</b>
                                <?php }?>
                            </td>
                        </tr>

                    <?php } ?>
                </table>

                <div class="clr"></div>
                <h4 class="profiledetailsdash">Physical Metrics</h4>
                <div class="profiledetails_l">                        
                    <span>Height</span>
                    <b>{{ @$user_physicalInfo->height_feet  }}' {{ @$user_physicalInfo->height_inch  }}"</b>
                    <span>Dominant Hand</span>
                    <b>{{ @$user_physicalInfo->dominant_hand  }}</b>
                    <span>Wingspan</span>
                    <b>{{ @$user_physicalInfo->wingspan_feet  }}' {{ @$user_physicalInfo->wingspan_inch }}"</b>


                           <!--  <span>ACI Index</span>
                            <b>{{ round(@$aci_score->aci_index, 2) }}</b> -->

                        </div>
                        <div class="profiledetails_r">
                            <span>Weight</span>
                            <b>{{ @$user_physicalInfo->weight  }} lbs</b>
                            <span>Dominant Foot</span>
                            <b>{{ @$user_physicalInfo->dominant_foot  }}</b>
                            <span>Hand Measurement</span>
                            <b>{{ @$user_physicalInfo->head  }}"</b>
                            <!-- <span>ACI Rank</span>
                                <b>{{ round($aci_rank, 1) }} %</b> -->

                            </div>
                            <div class="clr"></div>
                        </div>

                        <div class="athletic_competencybox">
                            <h6>Athletic Competency Index ™ Score:</h6>

                            @if($aci_score)
                            <h4 id="aci-score">{{ round($aci_score->aci_index, 2) }}</h4>
                            @else
                            <h4 id="aci-score">-</h4>
                            @endif
                            <div class="clr"></div>
                            <div class="">
                                @if($aci_score)
                                <a href="javascript:void(0)" id="calculate-aci-score" class="postbtn">Recalculate</a>
                                @else
                                <a href="javascript:void(0)" id="calculate-aci-score" class="postbtn">Calculate</a>
                                @endif
                                <a href="{{ URL::to('athlete/compare') }}" id="" class="postbtn">Compare</a>
                            </div>
                            <div class="clr"></div>
                        </div>
                    <!-- <div class="athletic_competencybox">
                        <h6>ACI ™ Rank for all similar gender and birth year</h6>
                        <h4 style="color: #4BFF00;" id="aci-rank">{{ round($aci_rank, 1) }} %</h4>
                        <a href="{{ URL::to('athlete/compare') }}" id="" class="postbtn">Compare</a>
                        <div class="clr"></div>
                    </div> -->
                    <?php if(count($recommended_coach_list)>=1){?>

                        <div class="coach_recommendation">
                            <h4>Coach Recommendations (<?php echo count($recommended_coach_list) ?>)</h4>

                            <?php if(count($recommended_coach_list)<2){

                             $coach_level= CoachInformation::select('coaching_level')->where('user_id', $recommended_coach_list[0]->coach_id)->first();

                             $level= CoachLevel::select('name')->where('id', @$coach_level->coaching_level)->first();

                             $cdate = date('Y-m-d H:i:s');   
                             $d1 = strtotime($recommended_coach_list[0]->created_at);
                             $d2 = strtotime($cdate);
                             $totalSecondsDiff = abs($d1-$d2); 
                             $totalMinutesDiff = $totalSecondsDiff/60;
                             $totalHoursDiff   = $totalSecondsDiff/60/60;
                             $totalDaysDiff    = $totalSecondsDiff/60/60/24; 
                             $totalMonthsDiff  = $totalSecondsDiff/60/60/24/30;
                             $totalYearsDiff   = $totalSecondsDiff/60/60/24/365;

                             if($totalSecondsDiff > 1 && $totalSecondsDiff<= 60){
                                $duration= 'Just now';
                            }elseif($totalMinutesDiff >1 && $totalMinutesDiff <=60){
                                $duration= round($totalMinutesDiff).' min';
                            }elseif($totalHoursDiff >1 && $totalHoursDiff <=24){
                                $duration= round($totalHoursDiff).' h';
                            }elseif($totalDaysDiff >1 && $totalDaysDiff <=30){
                                $duration= round($totalDaysDiff).' d';
                            }elseif($totalMonthsDiff >1 && $totalMonthsDiff <=12){
                                $duration= round($totalMonthsDiff).' month';
                            }elseif($totalYearsDiff >1 ){
                                $duration= round($totalYearsDiff). ' y';
                            }else{
                                $duration ="";
                            }

                            ?>


                            <div class="coachsliderbox single" >
                                <div class="coachslider_img">
                                 <?php if(@$recommended_coach_list[0]->profile_image!=""){ ?>
                                    <img src="{{ asset($recommended_coach_list[0]->profile_image) }}" alt="user_img"/>
                                <?php }else{ ?>
                                 <?php $uname = explode(" ", $recommended_coach_list[0]->username);
                                            $fname= $uname[0];
                                            $lname= @$uname[1];

                                            ?>
                                            <div class="pro-team"><?= ucfirst(@$fname[0]).ucfirst(@$lname[0]);?></div>                 
                                   
                                <?php }?>
                            </div>
                            <h5>{{ @$recommended_coach_list[0]->username }} <span>{{  @$recommended_coach_list[0]->country_name}}</span> <em><?php echo @$duration; ?></em>
                                <div class="clr"></div>
                            </h5>
                            <b>{{ ucfirst(@$level->name) }} </b>
                                    <!-- <p>{!! Str::limit(@$recommended_coach_list[0]->recommendation, 160, ' ...') !!}
                                    </p> -->
                                    <p>{!! Str::limit(@$recommended_coach_list[0]->recommendation, 160, ' ...') !!}

                                        <?php if(strlen($recommended_coach_list[0]->recommendation)>160) {?>
                                            <a href="javascript:void(0);" data-toggle="modal" data-target="#invitealink" onclick="getRecommendation(<?= @$recommended_coach_list[0]->recommend_id ?>)">...Read More</a>
                                        <?php } ?>
                                    </p>
                                </div>
                                <div class="cacho_btn">
                                    <a href="javascript:void(0)" data-id="{{ $recommended_coach_list[0]->recommend_id }}" class="postbtn post-recommendation" >Post</a>
                                    <a href="javascript:void(0)" data-id="{{ $recommended_coach_list[0]->recommend_id }}" class="dontpostbtn dontpost-recommendation">Do Not Post</a>
                                    
                                    <a href="javascript:void(0);" data-toggle="modal" data-id="{{ $recommended_coach_list[0]->recommend_id }}"  data-target="#contact_coach" class="contactcaochbtn">Contact Coach</a>

                                    <a href="" class="caochquestionbtn">
                                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                                    </a>
                                </div>


                            <?php }elseif(count($recommended_coach_list)>1){?>


                             <div id="coachslider" class="owl-carousel">
                                <?php foreach($recommended_coach_list as $list) {
                                    $coach_level= CoachInformation::select('coaching_level')->where('user_id', $list->coach_id)->first();
                                    $level= CoachLevel::select('name')->where('id', @$coach_level->coaching_level)->first();


                                    $cdate = date('Y-m-d H:i:s');   
                                    $d1 = strtotime($recommended_coach_list[0]->created_at);
                                    $d2 = strtotime($cdate);
                                    $totalSecondsDiff = abs($d1-$d2); 
                                    $totalMinutesDiff = $totalSecondsDiff/60;
                                    $totalHoursDiff   = $totalSecondsDiff/60/60;
                                    $totalDaysDiff    = $totalSecondsDiff/60/60/24; 
                                    $totalMonthsDiff  = $totalSecondsDiff/60/60/24/30;
                                    $totalYearsDiff   = $totalSecondsDiff/60/60/24/365;

                                    if($totalSecondsDiff > 1 && $totalSecondsDiff<= 60){
                                        $duration= 'Just now';
                                    }elseif($totalMinutesDiff >1 && $totalMinutesDiff <=60){
                                        $duration= round($totalMinutesDiff).' min';
                                    }elseif($totalHoursDiff >1 && $totalHoursDiff <=24){
                                        $duration= round($totalHoursDiff).' h';
                                    }elseif($totalDaysDiff >1 && $totalDaysDiff <=30){
                                        $duration= round($totalDaysDiff).' d';
                                    }elseif($totalMonthsDiff >1 && $totalMonthsDiff <=12){
                                        $duration= round($totalMonthsDiff).' month';
                                    }elseif($totalYearsDiff >1 ){
                                        $duration= round($totalYearsDiff). ' y';
                                    }else{
                                        $duration ="";
                                    }

                                    ?>

                                    <div class="item">
                                        <div class="coachsliderbox">
                                            <div class="coachslider_img">
                                             <?php if(@$list->profile_image!=""){ ?>
                                                <img src="{{ asset($list->profile_image) }}" alt="user_img"/>
                                            <?php }else{ ?>

                                            <?php $uname = explode(" ", $list->username);
                                            $fname= $uname[0];
                                            $lname= @$uname[1];

                                            ?>
                                            <div class="pro-team"><?= ucfirst(@$fname[0]).ucfirst(@$lname[0]);?></div>                         
                                                <!-- <img src="{{ asset('public/frontend/coach/images/noimage.png') }}" alt="addathe_user_img"/> -->
                                            <?php }?>
                                        </div>
                                        <h5>{{ @$list->username }} <span>{{  @$list->country_name}}</span> <em><?php echo @$duration; ?></em>
                                            <div class="clr"></div>
                                        </h5>
                                        <b>{{ ucfirst(@$level->name) }} Coach</b>
                                    <!-- <p>{!! Str::limit(@$list->recommendation, 160, ' ...') !!}
                                    </p> -->
                                    <p>{!! Str::limit(@$list->recommendation, 160, ' ...') !!}
                                        <?php if(strlen($list->recommendation)>160) {?>
                                            <a href="javascript:void(0);" data-toggle="modal" data-target="#invitealink" onclick="getRecommendation(<?= @$list->recommend_id ?>)">Read More</a>
                                        <?php } ?>


                                    </p>
                                </div>
                                <div class="cacho_btn">

                                   <a href="javascript:void(0)" data-id="{{ $list->recommend_id }}" class="postbtn post-recommendation" >Post</a>

                                   <a href="javascript:void(0)" data-id="{{ $list->recommend_id }}" class="dontpostbtn dontpost-recommendation">Do Not Post</a>


                                   <a href="javascript:void(0);" data-toggle="modal" data-id="{{ $list->recommend_id }}"  data-target="#contact_coach" class="contactcaochbtn">Contact Coach</a>
                                   <a href="" class="caochquestionbtn">
                                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    <?php  }?>

                </div>
            <?php }


            ?>
        </div>

    <?php }else{?>
     <h4 class="thereareno"> There are no new coach recommendations</h4>
 <?php } ?>
 <a href="{{ route('athlete.coach-recomendation') }}" class="requestrecommendationbtn">REQUEST A RECOMMENDATION FROM A COACH</a>
</div>
</div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="contact_coach" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">      
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      <h3>Contact Coach</h3> 

      <form method="post" id="contactForm" action="{{ route('athlete.contact-coach') }}" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="recommend_id" id='recommend-id'>
          <div class="yourmsg">
            <label>Your message</label>
            <div class="yourmsg_inner">
              <textarea style="height:150px;" id="replymsg" name="reply_msg" placeholder="Type here..."></textarea>

              
          </div>
          <p id="err_msg" style="display:none; color:red">Message field cann'tbe blank</p>
      </div>                       

      <div align="center"><input type="submit" class="recommendedsendbtn" value="Send"/></div>
  </form>        

</div>      
</div>
</div>
</div>

<!-----Event Modal------>

<div class="modal fade" id="eventsmodaldetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog filterpopup" role="document">
    <div class="modal-content">
        <div class="modal-body">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>


            <h3>Events Details</h3>

            <div class="eventsdetailspage">
                <h5>Events Name</h5>
                <h6>Buttercup Events</h6>

                <h5>Location</h5>
                <h6>Action Area II, Newtown, New Town, West Bengal 700156</h6>

                <h5>Start Date</h5>
                <h6>07/01/2021</h6>

                <h5>End Date</h5>
                <h6>07/24/2021</h6>
            </div>


        </div>
    </div>
</div>
</div>

<!-----Recommendation Modal-------->
<div class="modal fade" id="invitealink" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">      
            <div class="modal-body">
                <h3>Recommendation</h3>

                <div class="invitepopupbox">
                    <p id="recmd"></p>


                    <div class="clr"></div>
                </div>


                <div align="center"><button type="button" class="invitelinkbtn" data-dismiss="modal">Cancel</button></div>
            </div>      
        </div>
    </div>
</div>
<!----Video Modal------->
<div class="modal fade" id="videopopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">      
            <div class="modal-body">
                <h3 id="video_title">Video Evidence</h3>

                <div class="invitepopupbox"  id="video_evedence">

                    <div class="clr"></div>
                </div>


                <div align="center"><button type="button" class="invitelinkbtn" data-dismiss="modal">Cancel</button></div>
            </div>      
        </div>
    </div>
</div>
<!-----Game Highlights Modal-------->
<div class="modal fade" id="gamepopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">      
            <div class="modal-body">
                <h3>Game Highlights</h3>

                <div class="invitepopupbox">
                    <p id="gamedesc"></p>


                    <div class="clr"></div>
                </div>


                <div align="center"><button type="button" class="invitelinkbtn" data-dismiss="modal">Cancel</button></div>
            </div>      
        </div>
    </div>
</div>


@endsection

@section('script')
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
<script>
    function getVideo(video_link, workout_category, workout_type){


        var video="";  
        video+='<iframe width="100%" height="315" src="'+video_link+'"></iframe>';
        $('#video_evedence').html(video);

        $.ajax({
            url:"{{url('athlete/workout-detail')}}",
            type: "POST",
            data: {
             workout_category : workout_category,
             workout_type: workout_type,          
             _token: '{{csrf_token()}}'
         },
         dataType : 'json',

         success: function(result){

            console.log(result);
            
            if(result ){
              $('#video_title').text('Video Evidence for '+result.type_detail.title+ '('+result.cat_detail.category_title+')');
          }else{ 

              alert('Ooops!! Something went wrong');

          }
      }
  });
    }

    $(document).ready(function(){
        $('#calculate-aci-score').on('click', function(){
            // alert('hr');
            //  die;
            $.ajax({
                type : "GET",
                url : "{{ url('/aci-calculate-index') }}",
                data: { },
                beforeSend: function(){
                // "_token": "{{ csrf_token() }}"
            //     //$("#overlay").fadeIn(300);
                },
            success: function(res){
                console.log(res);
                if(res.success){
                    $('#aci-score').html(res.data.aci_index.toFixed(2));
                    $('#calculate-aci-score').html('Recalculate');
                }else{
                    swal(res.message, 'Warning', 'warning');
                }
            },
            error: function(err){
                console.log(err);
            }
        }).done( () => {
        });
    });
    });

    // calculate-aci-rank

    // $(document).ready(function(){
    //     $('#calculate-aci-rank').on('click', function(){
    //         $.ajax({
    //         type : "GET",
    //         url : "{{ url('athlete/aci-rank-calculate') }}",
    //         data : {},
    //         beforeSend: function(){
    //             //$("#overlay").fadeIn(300);
    //         },
    //         success: function(res){
    //             console.log(res);
    //             if(res.success){
    //                 $('#aci-rank').html(res.data.aci_index.toFixed(2));
    //                 $('#calculate-aci-rank').html('Recalculate');
    //             }else{
    //                 swal(res.message, 'Warning', 'warning');
    //             }
    //         },
    //         error: function(err){
    //             console.log(err);
    //         }
    //         }).done( () => {
    //         });
    //     })
    // })

    /**---Chart.js */
    am4core.ready(function() {
        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("myChart", am4charts.XYChart);
        chart.paddingRight = 20;
        // Add data
        chart.data = {!! json_encode($score_dataset) !!};
        
        // Create axes
        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "month";
        categoryAxis.renderer.minGridDistance = 50;
        categoryAxis.renderer.grid.template.location = 0.5;
        categoryAxis.startLocation = 0.5;
        categoryAxis.endLocation = 0.5;

        // Create value axis
        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.baseValue = 0;

        // Create series
        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "value";
        series.dataFields.categoryX = "month";
        series.strokeWidth = 3;
        series.tensionX = 0.77;
        series.stroke = am4core.color("#4BFF00"); // red
        // bullet is added because we add tooltip to a bullet for it to change color
        var bullet = series.bullets.push(new am4charts.Bullet());
        bullet.tooltipText = "{valueY}";

        bullet.adapter.add("fill", function(fill, target){
            if(target.dataItem.valueY < 0){
                return am4core.color("#FF0000");
            }
            return fill;
        })
        var range = valueAxis.createSeriesRange(series);
        range.value = 0;
        range.endValue = -1000;
        range.contents.stroke = am4core.color("#FF0000");
        range.contents.fill = range.contents.stroke;

        // Add scrollbar
        var scrollbarX = new am4charts.XYChartScrollbar();
        scrollbarX.series.push(series);
        chart.scrollbarX = scrollbarX;

        chart.cursor = new am4charts.XYCursor();

    }); // end am4core.ready()

    

    $('.post-recommendation').on('click', function(){
        let id = $(this).data('id');        
        swal({
            //title: "Are you sure?",
            title: "Are you sure that you want to post this recommendations on your profile",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willPost) => {
            if (willPost) {
                $.ajax({

                    url: "{{ url('athlete/post-recommendation') }}"+"/"+id,
                    
                    type:'get',
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {                     
                        swal(data.message, 'success')
                        .then( () => {
                            location.reload();
                        });
                    }
                });
            }else{
                return false;
            }
        });
    });

    $('.dontpost-recommendation').on('click', function(){
        let id = $(this).data('id');        
        swal({
            //title: "Are you sure?",
            title: "Are you sure that you don't want to post this recommendations on your profile",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willPost) => {
            if (willPost) {
                $.ajax({

                    url: "{{ url('athlete/dontpost-recommendation') }}"+"/"+id,
                    
                    type:'get',
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {                       
                        swal(data.message, 'success')
                        .then( () => {
                            location.reload();
                        });
                    }
                });
            }else{
                return false;
            }
        });
    });

    

    $('.contactcaochbtn').click(function(){
       $('#recommend-id').val($(this).data('id'));

   });

    $('#contactForm').submit(function() {
      if ($.trim($("#replymsg").val()) === "") {
        $('#err_msg').show();
        return false;
    }else{
        $('#err_msg').hide();
    }
});


    //===Event Modal===
    $(document).ready(function() {
        $('.event_details').on('click', function() {
            var event_id = $(this).attr('data-r');
            console.log(event_id);
            $.ajax({
                type: "POST",
                url: "{{ route('athlete.details-events') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    event_id: event_id
                },
                dataType: "JSON",
                beforeSend: function() {
                //$("#overlay").fadeIn(300);
                $('#eventsmodaldetails').empty();
            },
            success: function(res) {
                if (res.success) {
                    $('#eventsmodaldetails').html('\
                        <div class="modal-dialog filterpopup" role="document">\
                        <div class="modal-content">      \
                        <div class="modal-body">\
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">\
                        <span aria-hidden="true">&times;</span>\
                        </button>\
                        <h3>Events Details</h3>\
                        <div class="eventsdetailspage">\
                         <div class="row">\
                         <div class="col-lg-6 col-md-12 col-sm-12">\
                        <h5>Events Category</h5>\
                        <h6>' + res.data.data.name + '</h6>\
                        </div>\
                        <div class="col-lg-6 col-md-12 col-sm-12">\
                        <h5>Events Name</h5>\
                        <h6>' + res.data.data.event_name + '</h6>\
                           </div>\
                           <div class="col-lg-6 col-md-12 col-sm-12">\
                        <h5>Location</h5>\
                        <h6>' + res.data.data.location + '</h6>\
                        </div>\
                        <div class="col-lg-6 col-md-12 col-sm-12">\
                        <h5>Start Date</h5>\
                        <h6>' + formatDate(res.data.data.start_date) + '</h6>\
                        </div>\
                        <div class="col-lg-6 col-md-12 col-sm-12">\
                        <h5>End Date</h5>\
                        <h6>' + formatDate(res.data.data.end_date) + '</h6>\
                        </div>\
                        <div class="col-lg-6 col-md-12 col-sm-12">\
            <h5>Sport</h5>\
            <p>' + res.data.sport_name.name + '</p>\
            </div>\
                        <div class="col-lg-6 col-md-12 col-sm-12">\
            <h5>State</h5>\
            <p>' + res.data.state.name + '</p>\
            </div>\
                        <div class="col-lg-6 col-md-12 col-sm-12">\
            <h5>City</h5>\
            <p>' + res.data.data.city + '</p>\
            </div>\
            <div class="col-lg-12 col-md-12 col-sm-12">\
                        <h5>Event Details</h5>\
                        <h6>' + res.data.data.even_details + '</h6>\
                        </div>\
                        <div class="col-lg-12 col-md-12 col-sm-12">\
                        <h5>End Note</h5>\
                        <p>' + res.data.data.even_note + '</p>\
                        </div>\
                        <div class="col-lg-12 col-md-12 col-sm-12">\
                        <h5>Link for the event</h5>\
            <p>' + res.data.data.url + '</p>\
            </div>\
            </div>\
                        </div>\
                        </div>      \
                        </div>\
                        </div>');

                    //                  <div class="modal-dialog" role="document">\
                    //  <div class="modal-content">\
                    //      <div class="modal-body">\
                    //          <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>\
                    //          <h5>Events Details</h5>\
                    //          <div class="tab-container">\
                    //              <div class="filtertabopoup_l">\
                    //                  <div class="tab-menu01">\
                    //                      <p>Category: ' + res.data.category + '</p>\
                    //                      <p>Event Name: ' + res.data.event_name + '</p>\
                    //                      <p>Location: ' + res.data.location + '</p>\
                    //                      <p>City: ' + res.data.event_name + '</p>\
                    //                      <p>Start Date: ' + res.data.start_date + '</p>\
                    //                      <p>End Date: ' + res.data.end_date + '</p>\
                    //                      <p>Event Note: ' + res.data.even_note + '</p>\
                    //                      <p>Event Details: ' + res.data.even_details + '</p>\
                    //                  </div>\
                    //              </div>\
                    //              <div class="clr"></div>\
                    //          </div>\
                    //      </div>\
                    //  </div>\
                    // </div>');
                    $('#eventsmodaldetails').modal('show');
                }
            }
        });
        });
    });


    function getDescription(game_id){
       $.ajax({
        type : "POST",
        url: "{{ route('athlete.get-description') }}",

                //url:"{{url('athlete/get-description')}}",
                data : {
                    game_id: game_id,
                    _token: '{{csrf_token()}}' 
                },
                dataType : 'json',
                beforeSend: function(){
                    // $("#overlay").fadeIn(300);
                },
                success: function(result){
                    console.log(result); 
                   // alert(result.res.length);                   
                   if(result.res.length>0){
                     $('#gamedesc').text(result.res[0].description);                  
                 }
             },
             error: function(err){
                console.log(err);
            }
        }).done( () => {

        });
    }


    function getRecommendation(recomend_id){
        $.ajax({
            type : "GET",

            url:"{{url('athlete/get-recommendation')}}",
            data : {
                recomend_id: recomend_id,
                _token: '{{csrf_token()}}' 
            },
            dataType : 'json',
            beforeSend: function(){
                    // $("#overlay").fadeIn(300);
                },
                success: function(res){
                    console.log(res);  
                    alert(res.reply_msg);                  
                    if(res.recommendation.length>0){
                     $('#recmd').text(res.recommendation[0].recommendation);                  
                 }
             },
             error: function(err){
                console.log(err);
            }
        }).done( () => {

        });
    }

    function formatDate(date) {
     var d = new Date(date),
         month = '' + (d.getMonth() + 1),
         day = '' + d.getDate(),
         year = d.getFullYear();

     if (month.length < 2) month = '0' + month;
     if (day.length < 2) day = '0' + day;

     return [month, day, year].join('/');
 }

    

    
</script>
@endsection