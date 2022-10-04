@extends('frontend.coach.layouts.app')
@section('title', 'PROFILE')
@section('content')
<?php 
use App\Models\Country;
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="coachprofilebox">

				<div class="coachprofilebox_top">
					<div class="row">
						<div class="col-md-2 col-sm-12 col-xs-12">
							<div class="coachprofilebox_top_l">
								
								<?php if(Auth()->user()->profile_image!=""){?>

									<img src="{{ asset(Auth()->user()->profile_image) }}" alt="user_img"/>

								<?php }else{ ?>

									<?php $uname = explode(" ", Auth()->user()->username);
									$fname= $uname[0];
									$lname= @$uname[1];

									?>
									<div class="pro-user"><?= ucfirst(@$fname[0]).ucfirst(@$lname[0]);?></div>

								<?php } ?>

							</div>
						</div>
						
						<div class="col-md-10 col-sm-12 col-xs-12">
							<div class="coachprofilebox_top_r">
								<h3>{{ $user->username }}</h3>
								
								<p>{{ strip_tags(html_entity_decode($user_info->about)) }}</p>
							</div>
						</div>
					</div>
				</div>

				<div class="coachprofilebox_mid">
					<div class="row">
						<div class="col-sm">
							<span>User id</span>
							<h6>{{ $user->username }}</h6>
						</div>
						<?php if(@$level_detail->name!=""){?>
						<div class="col-sm">
							<span>Level Coaching</span>
							<h6>{{ ucfirst(@$level_detail->name) }}</h6>
						</div>
					<?php } ?>
						<?php if(@$sports->sportname!=""){?>
						<div class="col-sm">
							<span>Sport</span>
							<h6>{{ $sports->sportname }}</h6>
						</div>
					<?php } ?>
						<?php if(@$user_info->club_name!=""){?>
						<div class="col-sm">
							<span>Current Club or School Name</span>
							<h6>{{ $user_info->club_name }}</h6>
						</div>
					<?php } ?>
					<?php if(@$user_info->gender_of_coaching!=""){?>
						<div class="col-sm">
							<span>Gender of Sport Coaching</span>
							<h6>{{ $user_info->gender_of_coaching }}</h6>
						</div>
					<?php } ?>
						<?php if(!empty($level_detail)){ ?>
							<div class="col-sm">
								<span>PRIMARY AGE GROUP CURRENTLY COACHING </span>
								<h6>{{ $user_info->primary_age_group }}</h6>
							</div>
						<?php } ?>
					</div>
				</div>

				<div class="coachprofilebox_bottom">
					<h3>TeamingUP Group </h3>
					
					<div id="coachprofilebox_bottomslider" class="owl-carousel">
						<?php if(!empty($teamingup_group)) { 
							foreach ($teamingup_group as $key => $value) { 
								?>
								<div class="item">
									<div class="TeamingUPbox">
										<div class="TeamingUPbox_img">
											<img src="{{ asset($value->image) }}" alt="teamingup_img">
										</div>
										<div class="TeamingUPbox_text">
											<h3>{{ $value->group_name }}</h3>
											<span>{{ $value->description }}</p>
												<input type="button" class="joinedbtn" value="Created">
											</div>
										</div>
									</div>
								<?php } } ?>
							</div> 
						</div>

						<div class="coachprofilebox_bottom">
							<h3>Events </h3>
							<div class="row">
								<div class="col-md-6 col-sm-12 col-xs-12">
									<div class="dashboard_l_top" style="margin-bottom:30px;">
										<a href="javascript:void(0)"><h3>Last event attended</h3></a>
										<div id="last_attend_event" class="owl-carousel">
											@if($last_attend_event)
											@foreach($last_attend_event as $key => $last_attendevent)
											<div class="item">
												<div class="row">
													<div class="col-lg-6 col-md-12 col-sm-12">
														<div class="eventsboxleft teamingprifile">
															<i>To</i>
															<h6>Start Date</h6><b>{{ $last_attendevent->start_date }}</b>
														</div>
													</div>
													<div class="col-lg-6 col-md-12 col-sm-12">
														<div class="eventsboxright">
															<h6>End Date</h6><b>{{ $last_attendevent->end_date }}</b>
														</div>
													</div>
													<div class="col-lg-12">     
														<div class="eventsboxleft">
															<h6>Location</h6><b>{{ $last_attendevent->location }}</b>
														</div>                                    
													</div>
												</div>
											</div>
											@endforeach
											@endif


										</div>

									</div>
								</div>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<div class="dashboard_l_top" style="margin-bottom:30px;">
										<a  href="javascript:void(0)"><h3 style="color:#4BFF00;">Upcoming event</h3></a>
										<div id="last_attend_event2" class="owl-carousel">
											@if($upcoming_event)
											@foreach($upcoming_event as $key => $upcomingevents)
											<div class="item">
												<div class="row">
													<div class="col-lg-6 col-md-12 col-sm-12">
														<div class="eventsboxleft teamingprifile">
															<i>To</i>
															<h6>Start Date</h6><b>{{ $upcomingevents->start_date }}</b>
														</div>
													</div>
													<div class="col-lg-6 col-md-12 col-sm-12">
														<div class="eventsboxright">
															<h6>End Date</h6><b>{{ $upcomingevents->end_date }}</b>
														</div>
													</div>
													<div class="col-lg-12">     
														<div class="eventsboxleft">
															<h6>Location</h6><b>{{ $upcomingevents->location }}</b>
														</div>                                    
													</div>
												</div>
											</div>
											@endforeach
											@endif


										</div>

									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="clr"></div>
	</div>
	@endsection
