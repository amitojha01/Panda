@extends('frontend.athlete.layouts.app')
@section('title', 'Athlete Profile')
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
use App\Models\Competition;
use App\Models\SchoolPlaying;
use App\Models\UserWorkoutExerciseLog;

?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-sm-12 col-xs-12">
			<!---Graph---->
            <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="dashboard_r_top">
                        @if(empty($score_dataset))
                        <img src="{{ asset('public/frontend/images/no-grap.png') }}" alt="graph_img" />
                        @else
                        <div id="myChart" width="400" height="170"></div>
                        @endif
                    </div>
                </div>
            </div>
			<div class="dashbottom">
				<h4>Workouts ({{ count($workout_librarys) }})</h4>
				<div id="athletesliderworkout" class="owl-carousel">
					@if($workout_librarys)
					@foreach($workout_librarys as $key => $library)
					<!--{{-- <div class="item">
						<div class="dashbottombox_l">
							 <?php
                                $measurement = App\Models\WorkoutLibraryMeasurement::find($workout_librarys['measurement_id']);

                                $exercises = App\Models\UserWorkoutExercises::where([
                                            'workout_library_id'=> $workout_librarys['id'],
                                            'user_id'=> $workout_librarys['user_id']
                                            ])->first();
                                $workout_description_array = array(
                                    'reps' => 'Enter the number of reps completed | Enter the amount of weight used',
                                    'time' => 'Enter the time it took to complete the workout',
                                    'distance' => 'Enter the distance they jumped',
                                    'height' => 'Enter the height of the box on which they jumped',
                                    'distance_weight' => 'Enter distance travelled | Enter the amount of weight used',
                                    'speed' => 'Enter MPH',
                                    'distance'=> 'Enter Feet',
                                    'time'=> 'Enter Sec',
                                    //'yards'=> 'Enter Distance',
                                    'percentage' => 'Enter Percentage'
                                );
                                $xx = $workout_description_array[strtolower($measurement->name)];
                                $x = explode("|", $xx);
                            ?>
							<h4>{{ $workout_librarys['category_title'] }}</h4>
							<span>{{ !empty($workout_librarys['sport_category_title']) ? $workout_librarys['sport_category_title'] : $workout_librarys['title'] }}</span>
							<h5> {{ucwords($measurement->unit)}}, 
                                    {{ !empty($x[0]) ? $x[0] : '0' }}</h5>
							<span>For 15 Reps, Max Weight Lifted</span>
							<h5> {{ $exercises ? $exercises->unit_1 : 0}} <b>{{strtoupper($measurement->unit)}}</b></h5>
							<span>Date</span>
							<h5>@if($exercises)
                                        {{ date('m/d/Y', strtotime($exercises->record_date) )}}
                                    @else
                                        {{ date('m/d/Y', strtotime($workout_librarys['created_at']) )}}
                                    @endif <a href="#"><img class="yellowarrow" src="{{ asset('public/frontend/athlete/images/yellowright_arrow.png') }}" alt="yellowright_arrow"/></a> <div class="clr"></div></h5>
						</div> 
					</div> --}}-->

					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="workoutboxnew">
						<?php
						$measurement = App\Models\WorkoutLibraryMeasurement::find($library['measurement_id']);
						$exercises = App\Models\UserWorkoutExercises::where([
							'workout_library_id'=> $library['id'],
							'user_id'=> @$user_detail->id
						])->first();

						//==21 dec==
						$exercises_video = App\Models\UserWorkoutExerciseLog::where([
							'workout_library_id'=> $library['id'],
							'user_id'=> @$user_detail->id
						])->where('video', '!=', " ")->orderBy('id', "desc")->first();

						
						$recent_workout = App\Models\UserWorkoutExerciseLog::where([
							'workout_library_id'=> $library['id'],
							'user_id'=> @$user_detail->id
						])->where('unit_1', '!=', 0)->orderBy('id', "desc")->first();

						//==
							/*echo "<pre>";
							 print_r($exercises);
							 die;*/
						/*$userWorkoutExerciseshight = App\Models\UserWorkoutExercises::where('workout_library_id', $library['id'])->orderBy('unit_1', 'desc')->first();*/

						$userWorkoutExerciseshight = DB::table('user_workout_exercise_logs')->where('workout_library_id', $library['id'])->where('user_id', @$user_detail->id)->max('unit_1');

						$workout_description_array = array(
							'reps' => 'Enter the number of reps completed | Enter the amount of weight used',
							'time' => 'Enter the time it took to complete the workout',
							'distance' => 'Enter the distance they jumped',
							'height' => 'Enter the height of the box on which they jumped',
							'distance_weight' => 'Enter distance travelled | Enter the amount of weight used',
							'speed' => 'Enter MPH',
							'distance'=> 'Enter Feet',
							'time'=> 'Enter Sec',
								//'yards'=> 'Enter Distance',
							'percentage' => 'Enter Percentage'
						);
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
								@if(@$exercises_video['video'] != '')
								<?php
							   $videoLink = '';
								$videoLink = @$exercises_video['video'];
								$rx = '~^(?:https?://)?(?:www[.])?(?:youtube[.]com/watch[?]v=|youtu[.]be/)([^&]{11})~x';
								 $has_match = preg_match($rx, $videoLink, $matches);
								 $videoId = $matches[1]; 
								 ?>
								 <a href="{{ @$exercises_video['video']}}"><img src="{{ 'https://img.youtube.com/vi/' . $videoId . '/mqdefault.jpg' }}" width="85%" height="100%" alt="videoimg" /></a>
								 @else
								 <span>No Video</span>
								 @endif
								</div>
							{{-- <div class="updated">
								<a href="{{ url('athlete/workouts/show/'.$library['category_id'].'/'.$library['id']) }}" class="updateddashbtn">Update</a>
							</div> --}}
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
					
				</div>				

			</div>

			<!----Game Highlight---->

			 <div class="col-md-12">
                <div class="newgamehighlight">
                	<div id="gamehighlightnew2" class="owl-carouselz">
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





			<!------->

			<!-- <div class="row">
				<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
					<div class="athlete_l">
						<h3>Game Highlights</h3>
						<div id="gamehighlightscthleteslider" class="owl-carousel">
							@if(!$game_highlight->isEmpty())
							@foreach($game_highlight as $key => $game_high_light)
							<div class="item">
								<div class="gamehighlight_box">
									<span><img src="{{ asset('public/frontend/athlete/images/blackcalender.png') }}" alt="blackcalender"></span>
									<h4>{{ date('Y-m-d', strtotime($game_high_light->record_date)) }}</h4>
									<p>{{ substr(($game_high_light->description),0,100) }}</p>
								</div>
							</div>
							@endforeach
							@else
							<div class="item">
								<div class="gamehighlight_box">
									<span><img src="{{ asset('public/frontend/athlete/images/blackcalender.png') }}" alt="blackcalender"></span>
									<p>There are no game highlight founds</p>
								</div>
							</div>
							<div class="item">
								<div class="gamehighlight_box">
									<span><img src="{{ asset('public/frontend/athlete/images/blackcalender.png') }}" alt="blackcalender"></span>
									<p>There are no game highlight founds</p>
								</div>
							</div>
							<div class="item">
								<div class="gamehighlight_box">
									<span><img src="{{ asset('public/frontend/athlete/images/blackcalender.png') }}" alt="blackcalender"></span>
									<p>There are no game highlight founds</p>
								</div>
							</div>
							@endif
						</div>
					</div>
				</div>
				<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
					<div class="athlete_r">
						<h3>Video Evidence</h3>
						<div class="athlete_r_inner">
							<div id="athlete_rvideoevidenceslider" class="owl-carousel">
								 @if(!$video_evidence->isEmpty())
                                @foreach($video_evidence as $key => $video_list)
								<div class="item">
									<?php $videoLink = $video_list->video_link;
               $rx = '~^(?:https?://)?(?:www[.])?(?:youtube[.]com/watch[?]v=|youtu[.]be/)([^&]{11})~x';
                $has_match = preg_match($rx, $videoLink, $matches);
                $videoId = $matches[1]; ?>
									 <a href="{{ $video_list->video_embeded_link }}" target="_blank"><img src="{{ 'https://img.youtube.com/vi/' . $videoId . '/mqdefault.jpg' }}" width="110%" height="110%" alt="videoimg" /></a>
								</div>
								 @endforeach
								 @else
								<div class="item">
									 <p>There are no any video_evidence founds</p>
								</div>
                                @endif
							</div>
						</div>
					</div>
				</div>
			</div> -->

			<div class="dashbottom">
				<h4>TeamingUP Group </h4>
				<div id="teamingupgroupslider" class="owl-carousel">
					@if(!$teamingup_group->isEmpty())
					@foreach($teamingup_group as $key => $teamingup_group_list)
					<div class="item">
						<div class="TeamingUPbox">
							<div class="TeamingUPbox_img">
								<img src="{{ asset($teamingup_group_list->image) }}" alt="teamingup_img">
							</div>
							<div class="TeamingUPbox_text">
								<h3>{{ $teamingup_group_list->group_name }}</h3>								
								<p>{{ substr(($teamingup_group_list->description),0,90) }}....</p>						
							</div>
						</div> 
					</div>
					@endforeach
					@else
					<div class="item">
						<div class="TeamingUPbox">
							<!-- <div class="TeamingUPbox_img">
								<img src="{{ asset('public/frontend/athlete/images/teamingup_img.png') }}" alt="teamingup_img">
							</div> -->
							<div class="TeamingUPbox_text">
								<p>There is no teamup group member </p>					
							</div>
						</div> 
					</div>
					@endif
				</div>				

			</div>

		</div>
		<div class="col-md-4 col-sm-12 col-xs-12">

			<div class="myprofile">
				<div class="myprofile_l">
					@if($user->profile_image!="")					
					<img src="{{ asset($user->profile_image) }}" alt="user_img"/>
					@else					
					<?php $uname = explode(" ", $user->username);
					$fname= $uname[0];
					$lname= @$uname[1];

					?>
					<div class="pro-avatar"><?= ucfirst(@$fname[0]).ucfirst(@$lname[0]);?></div>

					@endif
				</div>
					<div class="myprofile_mid">
						<!-- <span>Hello,</span> -->
						<h5 style="padding-top:20px;">{{ $user->username }}</h5>
					</div>
					<div class="myprofile_r">
						
					</div>
					<div class="clr"></div>
					
					<div class="followerspanel">
						<a href="{{route('user.followers', $user->id)}}"><span>{{ count(@$follower)}} Followers</span></a>
						<a href="{{route('user.following', $user->id)}}"><span>{{ count(@$following)}} Following</span></a>
						<div class="clr"></div>
						<?php 
				$exit_follower_user = App\Models\Follower::where('status', 1)->where('user_id', Auth()->user()->id)->where('follower_id',$user->id)->first(); ?>

				@if($exit_follower_user)
						<a href="javascript:void(0)" id="followers" data-athleteid="{{$user->id}}" class="followlink followers">Followed</a>
						@else
						<a href="javascript:void(0)" id="followers" data-athleteid="{{$user->id}}" class="followlink followers">Follow</a>

						@endif
						<a href="javascript:void(0)" id="add_athbtn" user-id="{{ $user->id }}" class="addtocompare">Add to compare</a>
						<div class="clr"></div>
					</div>
					
					<div class="profiledetails">
						 <h4 class="profiledetailsdash">General Infos</h4>
						<div class="profiledetails_l">
							<div class="clr"></div>

							<span>User id</span>
							<b>{{ $user_detail->username  }}</b>

							<span>Birth Year</span>
							<b>{{ $user_detail->year  }}</b>
							

							<span>Current Education Level:</span>
							<b>{{ @$user_education->name  }}</b>

							

                            <span>Competetion Level</span>
                            <?php $competetion_level= Competition::select('name')->where('id', @$user_sportposInfo->competition_id)->first();

                            ?>

                            <b>{{ @$competetion_level->name  }}</b>      

                            

                            <?php if($user_detail->contact_email==1  && count($is_follow) >0){?>

							<span>Email</span>
                            <b>{{ ucfirst($user_detail->email)  }}</b>
                        <?php } ?> 					

							
						</div>
						<div class="profiledetails_r">
							

                            <span>Gender</span>
                            <b>{{ ucfirst($user_detail->gender)  }}</b>

                            <span>High School Graduation Year</span>
                            <b>{{ $user_detail->graduation_year  }}</b>

                            <span>High School GPA</span>
                            <b>{{ @$user_physicalInfo->grade  }}</b>

                            <span>School Playing Level</span>
                            <?php $school_playing_level= SchoolPlaying::select('name')->where('id', @$user_sportposInfo->school_level_id)->first();
                            ?>

                            <b>{{ @$school_playing_level->name  }}</b>

                            
                             <?php if($user_detail->contact_email==1  && count($is_follow) >0){?>

                              <span>Mobile</span>
                              <b>{{ @$user_detail->mobile  }}</b>

                          <?php }?>
							
							
						</div>
						<div class="clr"></div>
						
						<div class="clr"></div>
                      <table class="dashprofiletable">
                        <tr>
                            <th>Sports</th>
                            <th>Position</th>
                        </tr>
                        <?php 
                        foreach($user_sport as $sport){
                           $user_sport=UserSportPosition::leftJoin('sport_positions', 'user_sport_positions.position_id', '=', 'sport_positions.id')->where('user_sport_positions.sport_id', $sport->sport_id)->where('user_sport_positions.user_id', @$user_detail->id)
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





						<!--------->
						 <h4 class="profiledetailsdash">Physical Metrics</h4>
						  <div class="profiledetails_l"> 

                        <span>Height</span>
                            <b>{{ @$user_physicalInfo->height_feet  }}' {{ @$user_physicalInfo->height_inch  }}"</b> 

                             <span>Dominant Hand</span>
                            <b>{{ @$user_physicalInfo->dominant_hand  }}</b>

                             <span>Wingspan</span>
                            <b>{{ @$user_physicalInfo->wingspan_feet  }}' {{ @$user_physicalInfo->wingspan_inch }}"</b>

                             <span>ACI Index</span>
                            <b>{{ round(@$aci_score->aci_index, 2) }}</b>
                           </div>
                        <div class="profiledetails_r">

                            <span>Weight</span>
                            <b>{{ @$user_physicalInfo->weight  }} lbs</b>

                            <span>Dominant Foot</span>
                            <b>{{ @$user_physicalInfo->dominant_foot  }}</b>

                            <span>Hand Measurement</span>
                            <b>{{ @$user_physicalInfo->head  }}"</b>

                             <span>ACI Rank</span>
                            <b>{{ round(@$aci_rank, 1) }} %</b>                           
                            
						</div>
						<div class="clr"></div>
					</div>	

					<!-- <div class="coach_recommendation Recentboxbottom">
						<h4>Recent Recommendations</h4>
						<div id="coachslider" class="owl-carousel">
							<div class="item">
								<div class="coachsliderbox">
									<div class="coachslider_img">
										<img src="{{ asset('public/frontend/athlete/images/user_img.png') }}" alt="user_img"/>
									</div>
									<h5>Steve Smith <span>Harrisburg, PA</span> <em>5w</em><div class="clr"></div></h5>
									<b>Club Coach</b>
									<p>Wayne Smith is a terrific athlete and and is a gym rat working out 5 days a work.</p>
								</div>								
							</div>
							<div class="item">
								<div class="coachsliderbox">
									<div class="coachslider_img">
										<img src="{{ asset('public/frontend/athlete/images/user_img.png') }}" alt="user_img"/>
									</div>
									<h5>Steve Smith <span>Harrisburg, PA</span> <em>5w</em><div class="clr"></div></h5>
									<b>Club Coach</b>
									<p>Wayne Smith is a terrific athlete and and is a gym rat working out 5 days a work.</p>
								</div>
							</div>
						</div>
						
						
					</div> -->		
					<?php if(count($recommended_coach_list)>=1){?>

							<div class="coach_recommendation">
								<h4>Recent Recommendations </h4>

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
										<p>{!! Str::limit(@$recommended_coach_list[0]->recommendation, 160, ' ...') !!}
											<a href="javascript:void(0);" data-toggle="modal" data-target="#invitealink" onclick="getRecommendation(<?= @$recommended_coach_list[0]->recommend_id ?>)">Read More</a>
										</p>
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
														<?php }?>
													</div>
													<h5>{{ @$list->username }} <span>{{  @$list->country_name}}</span> <em><?php echo @$duration; ?></em>
														<div class="clr"></div>
													</h5>
													<b>{{ ucfirst(@$level->name) }} </b>
													<p>{!! Str::limit(@$list->recommendation, 160, ' ...') !!}
														<a href="javascript:void(0);" data-toggle="modal" data-target="#invitealink" onclick="getRecommendation(<?= @$list->recommend_id ?>)">Read More</a>
													</p>
												</div>

											</div>
										<?php  }?>

									</div>
								<?php }
								?>
							</div>
						
						<?php } ?>	
				</div>
				
			</div>
		</div>
	</div>
</div>
<div class="clr"></div>
</div>

<!-----Modal-------->
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
@endsection

@section('script')
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
<script>
    $(document).ready(function(){
    	$('.followers').on('click',function(){
    		var follower_id=$(this).data('athleteid');
			$.ajax({
	            type 	: "POST",
	            url 	: "{{ route('athlete.add-follow') }}",
	            data 	: {
	            		'_token' : "{{ csrf_token() }}",
	            		follower_id : follower_id
	            },
	            dataType : "JSON",
	            beforeSend: function(){
	                //$("#overlay").fadeIn(300);
	                // $('#eventsmodaldetails').empty();
	            },
	            success: function(res){
	                if(res.success){
	                	 swal(res.message,'Success', 'success')
                                .then( () => {
                                    location.reload();
                                });
                            }
	            }
	        }); 
	    });
    });


    //==Chart js=====   
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
    //==

	$(document).on('click','#add_athbtn', function() {
			let compare_user_id = $(this).attr('user-id');
			if(compare_user_id !=""){
				$.ajax({
				    type: "POST",
				    url: "{{ route('athlete.add-compare') }}",
				    data: {
				    	'_token' : "{{ csrf_token() }}",
				    	compare_user_id: compare_user_id,
				    },
				    dataType: "JSON",
				    success: function(res) {
				    	if(res.success){

				    		 swal(res.message,'Success', 'success')
                                .then( () => {
                                    window.location.href = "{{ route('athlete.compare')}}";
                                });
				    	}
				    	else{
				    		window.location.href = "{{ route('athlete.compare')}}";
				    	}
				    }
				});
			}
	});

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
</script>
@endsection
