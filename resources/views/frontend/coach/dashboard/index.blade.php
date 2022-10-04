@extends('frontend.coach.layouts.app')
@section('title', 'Dashboard')
@section('content')
<?php 
use App\Models\UserPhysicalInformation;
use App\Models\Education;
use App\Models\User;
use App\Models\Country;
?>

<div class="container-fluid">
	<div class="row">
		<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">		
			<div class="dashtabletab">
				<div class="tab-container">
					
					<div class="tab-menu1">
						<ul>
							<li><a href="#" class="tab-a1 active-a1" data-id="tab1">Recommendation Requests</a></li>
							<li><a href="#" class="tab-a1" data-id="tab2">Coach  Following  </a></li>
							<li><a href="#" class="tab-a1" data-id="tab3"> Requesting to Follow Coach</a></li>
						</ul>
					</div>

<!----Reverse Lookup ----->
<div  class="tab1 tab-active1" data-id="tab1">
	<div class="table-responsive">
		<table cellpadding="0" cellspacing="0" width="100%" class="coachdashtable">
			<?php 

			if(count($recommend_request) > 0){

				foreach($recommend_request as $request){ 
					$education = UserPhysicalInformation::where('user_id', @$request->athleteId)->first();
					$edu_res= Education::where('id', @$education->id)->first();

					?>
					<tr>
						<td>
							<span class="coachtableimg">
								<a href="{{ url('athlete-profile/'.$request->athleteId.'/'.'coach') }}" >
								@if($request->profile_image!="")                    
								<img src="{{ asset($request->profile_image) }}" alt="user_img"/>
								@else
								<?php $uname = explode(" ", $request->username);
								$fname= $uname[0];
								$lname= @$uname[1];

								?>
								<div class="pro-avatar"><?= ucfirst(@$fname[0]).ucfirst(@$lname[0]);?></div>

								@endif
							</a>

							</span>
						</td>
						<td>
							<h6><a href="{{ url('athlete-profile/'.$request->athleteId.'/'.'coach') }}" style="color:#fff" >{{ @$request->username}}</a></h6>

						</td>
						<td>{{@$edu_res->name}}</td>
						<td>{{ @$request->year}}</td>
						<td>{{ $request->request_purpose }}</td>
						<td><a class="writerecommendedlink" href="{{ route('coach.write-recomendation', @$request->recommend_id) }}">write recommendation</a></td>

						<td><a class="writerecommendeddeny" href="javascript:void(0)', @$request->recommend_id) }}" data-toggle="modal" data-target="#invitealink" onclick="getRecommendationId(<?= @$request->recommend_id ?>)">Decline</a></td>
					</tr>
				<?php } }else{?>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td> <h6>No Request!!</h6></td>
					</tr>

				<?php }?>

			</table>
		</div>
	</div>

	<div  class="tab1" data-id="tab2">
		<div class="table-responsive">
			<table cellpadding="0" cellspacing="0" width="100%" class="coachdashtable">
				<?php if(count($following)>0){
					foreach($following as $list){

						$user_detail = User::where('id', $list->follower_id)
						->with('address')->first();


						$country_name="";

						if(!empty(@$user_detail->address[0]->country_id)){
							$country_name = Country::where('id', $user_detail->address[0]->country_id)->first();
						}
						?>
						<tr>
							<td ><span class="coachtableimg">
								<?php if($user_detail->role_id==1){ ?>
									 <a href="{{ url('athlete-profile/'.$user_detail->id.'/'.'coach') }}" > 
								<?php }else{?>
									<a href="{{ url('coach-profile/'.$user_detail->id.'/'.'coach') }}" >

								<?php }?>
								<?php if($user_detail->profile_image!=""){?>

									<img src="{{ asset($user_detail->profile_image) }}" alt="user_img"/>

								<?php }else{ ?>

									<?php $uname = explode(" ", $user_detail->username);
									$fname= $uname[0];
									$lname= @$uname[1];

									?>
									<div class="pro-avatar"><?= ucfirst(@$fname[0]).ucfirst(@$lname[0]);?></div>

								<?php } ?>
							</a>


							</span></td>
							<td>
								<h6>
									<?php if($user_detail->role_id==1){ ?>
									 <a href="{{ url('athlete-profile/'.$user_detail->id.'/'.'coach') }}" style="color:#fff" > 
								<?php }else{?>
									<a href="{{ url('coach-profile/'.$user_detail->id.'/'.'coach') }}" style="color:#fff" >

								<?php }?>
									{{ @$user_detail->username }}
								</a>
								</h6>

							</td>

							<td style="width:30%">{{ @$user_detail->year}}</td>
							<td></td>

						</tr>
					<?php } }else{ ?>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td>No Result Found!!</td>

						</tr>


					<?php } ?>								

				</table>
			</div>
		</div>
		<div  class="tab1" data-id="tab3">
			<div class="table-responsive">
				<table cellpadding="0" cellspacing="0" width="100%" class="coachdashtable">

					<?php	
					if(count($follower) > 0){
						foreach($follower as $list){	
							$user_detail = User::where('id', $list->user_id)
							->with('address')->first();                           

							$country_name="";                           
							if(!empty(@$user_detail->address[0]->country_id)){
								$country_name = Country::where('id', $user_detail->address[0]->country_id)->first();
							}

							$education = UserPhysicalInformation::where('user_id', @$list->user_id)->first();
							$edu_res= Education::where('id', @$education->id)->first();

							?>
							<tr>


								<td><span class="coachtableimg">
									<?php if($user_detail->role_id==1){ ?>
									 <a href="{{ url('athlete-profile/'.$user_detail->id.'/'.'coach') }}"  > 
								<?php }else{?>
									<a href="{{ url('coach-profile/'.$user_detail->id.'/'.'coach') }}"  >
									<?php } ?>

									@if($user_detail->profile_image!="")                    
									<img src="{{ asset($user_detail->profile_image) }}" alt="user_img"/>
									@else
									<?php $uname = explode(" ", @$user_detail->username);
									$fname= $uname[0];
									$lname= @$uname[1];

									?>
									<div class="pro-avatar"><?= ucfirst(@$fname[0]).ucfirst(@$lname[0]);?></div>

									@endif
								</a>
								</span></td>
								<td>
									<h6>
										<?php if($user_detail->role_id==1){ ?>
									 <a href="{{ url('athlete-profile/'.$user_detail->id.'/'.'coach') }}" style="color:#fff" > 
								<?php }else{?>
									<a href="{{ url('coach-profile/'.$user_detail->id.'/'.'coach') }}" style="color:#fff" >
									<?php } ?>
										{{$user_detail->username}}
									</a>
								</h6>

								</td>
								<td>{{@$edu_res->name}}</td>
								<td>{{ @$user_detail->year}}</td>


								<td><a class="writerecommendedlink" href="javascript:void(0)" onclick="request_response(<?= $list->id ?>,'2')">Accept</a></td>
								<td><a class="writerecommendeddeny" onclick="request_response(<?= $list->id ?>, '3')" href="javascript:void(0)">Deny</a></td>
							</tr>
						<?php } }else{?>
							<tr>
								<td></td>
								<td>No Result Found!!</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>

							</tr>

						<?php } ?>

					</table> 
				</div>
			</div>
		</div>



	</div>

	<div class="dashtabletab" style="margin-top:75px;">
		<div class="tab-container">

			<div class="tab-menu2">
				<ul>
					<li><a href="#" class="tab-a2 active-a2" data-id="tab1">Reverse Alert Criteria  </a></li>
					<li class="" style="position: relative;"><a class="n-ppost" href="javascript:void(0)" data-id="tab2">Favorites 


						 
						 </a>
						 <div class="n-ppost-name">New Feature Coming in Summer 2022</div>
					</li>
					<li style="position: relative;"><a class="n-ppost" href="javascript:void(0)" data-id="tab3">New Panda Athletes</a>
						<div class="n-ppost-name">New Feature Coming in Summer 2022</div>

					</li>
				</ul>
			</div>

			<div  class="tab1z tab-active2" data-id="tab1">
				<div class="table-responsive">
					<table cellpadding="0" cellspacing="0" width="100%" class="coachdashtable ">

						<?php if(count($reverseList)>0){
							foreach($reverseList as $key => $reverseList_details){ ?>
								<tr>

									<td>{{ $key+1}}</td>
									<td>
										
											{{ $reverseList_details->name }}
									</td>

									<td>

										<a href="{{url('coach/edit-reverse-lookup/'.$reverseList_details->id)}}">
											<!-- <img src="{{ asset('public/frontend/athlete/images/edit_icon.png') }}" style="width:25px" > -->
											<i class="fa fa-pencil"
                                aria-hidden="true"></i>
										</a>
											<a href="javascript:void(0)"  class="btn-delete-row" onclick="deleteReverseLookup(<?= @$reverseList_details->id ?>)">
												<!-- <img src="{{ asset('public/frontend/athlete/images/delete_icon.png') }}" alt="delete" style="width:25px" /> -->
												<i class="fa fa-trash-o" aria-hidden="true"></i>
											</a>

											<a href="{{url('coach/view-reverse-lookup/'.$reverseList_details->id)}}"><i class="fa fa-eye"
												aria-hidden="true"></i>
											</a>

											</td>
										</tr>
									<?php }}else{ ?>
										<tr>

											<td></td>
											<td></td>
											<td>No Result Found!!</td>

										</tr>



									<?php } ?>


								</table>
							</div>
						</div>
					</div>

				</div>

			</div>
			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">

				<div class="myprofile">
					<a href="<?= url('coach/profile'); ?>">
						<div class="myprofile_l">
							@if(Auth()->user()->profile_image!="")                    
							<img src="{{ asset(Auth()->user()->profile_image ) }}" alt="user_img"/>
							@else
							<?php $uname = explode(" ", Auth()->user()->username);
							$fname= $uname[0];
							$lname= @$uname[1];

							?>
							<div class="pro-avatar"><?= ucfirst(@$fname[0]).ucfirst(@$lname[0]);?></div>

							@endif
						</div>
					</a>

					<div class="myprofile_mid">
						<span>Hello, </span>
						<h5>{{ Auth()->user()->username }}!</h5>
						<a href="<?= url('coach/profile'); ?>" class="profilelink">View Profile</a>
					</div>
					<div class="myprofile_r">
						<a href="<?= url('coach/edit-profile'); ?>">
							<img src="{{ asset('public/frontend/coach/images/edit_img.png') }}" alt="edit_img"/>
						</a>
					</div>
					<div class="clr"></div>
					<div class="profiledetails">
						<div class="profiledetails_l">
							<span>USER ID</span>
							<b>{{ Auth()->user()->username }}</b>
							<span>LEVEL COACHING</span>
							<b>{{ ucfirst(@$level_detail->name) }}</b>						
						</div>
						<?php if(!empty($level_detail)){ ?>
							<div class="profiledetails_r">
								<span>SPORT</span>
								<b>{{ $sports->sportname }}</b>					
							</div>
						<?php } ?>
						<?php if(!empty($level_detail)){ ?>
							<div class="profiledetails_r">
								<span>LEVEL PLAYED </span>
								<b>{{ @$level_detail->name }}</b>					
							</div>
						<?php } ?>


						<?php if(@$user_info->coaching_level==2){?>
							<div class="profiledetails_r">
								<span>CURRENT COLLEGE NAME</span>
								<b>{{ ucfirst(@$college->name) }}</b>					
							</div>
						<?php  }elseif($level_detail!=""){ ?>
							<div class="profiledetails_r">
								<span>{{ ucfirst($level_detail->name) }} Name</span>
								<b>{{ ucfirst(@$user_info->coach_level_name) }}</b>					
							</div>

						<?php } ?>

						<?php if(!empty($level_detail)){ ?>
							<div class="profiledetails_l">
								<span>NUMBER OF YEARS OF COACHING </span>
								<b>{{ $user_info->number_of_years }}</b>					
							</div>
						<?php } ?>
						<?php if(!empty($level_detail)){ ?>
							<div class="profiledetails_l">
								<span>Link to their School or Club bio</span>
								<b>{{ $user_info->about_link }}</b>					
							</div>
						<?php } ?>


						<?php if(!empty($level_detail)){ ?>
							<div class="profiledetails_r">
								<span>PRIMARY AGE GROUP CURRENTLY COACHING   </span>
								<b>{{ $user_info->primary_age_group }}</b>					
							</div>
						<?php } ?>

						<!-- <?php if(!empty($level_detail) && @$user_info->club_name!="" ){ ?> -->
						<div class="profiledetails_l">
							<span>SCHOOL/CLUB NAME </span>
							<b>{{ $user_info->club_name }}</b>					
						</div>
						<!-- <?php } ?> -->


						<div class="clr"></div>
					</div>

					<div class="activelicense coachdashr">
						<h4>Bio</h4>
						<p>{{ strip_tags(html_entity_decode(@$user_info->about)) }}</p>

					</div>


					<!-- <div class="activelicense coachdashr">
						<h4>Reverse Lookups</h4>
						<p>6 Athletes meets to your criteria.</p>
						<a href="javascript:void(0);" data-toggle="modal" data-target="#activatedlicence"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
					</div> -->

					<div class="coachr_rteamingupgroup">
						<h2>TeamingUP Group <a href="{{ route('coach.teamingup-group') }}">See All</a></h2>
						<div class="row">
							<div class="col-md-4 col-sm-12 col-xs-12">
								<div class="coachr_rteamingupgroup1">
									<a href="{{ route('coach.create-teamingup-group') }}"><img src="{{ asset('public/frontend/coach/images/whiteplus.png') }}" alt="whiteplus"/>
										<span>Create Group</span>
									</a>
								</div>
							</div>
							<?php if(count($teaming)> 0){
								foreach($teaming as $group){
									$name_slug= str_replace(' ', '-', $group->group_name);
									?>
									<div class="col-md-4 col-sm-12 col-xs-12">
										<div class="coachr_rteamingupgroup2">
											<a href="{{  route('coach.teamingup-group-details', ['id' => $group->id,'group-name'=>@$name_slug])}}">
												<?php if($group->image!=""){?>
													<img src="{{ asset($group->image) }}" alt="Teaming Group"/>
												<?php } ?>	

												<h5>{{$group->group_name}}</h5>
											</a>
										</div>
									</div>
								<?php } }?>

							</div>
						</div>

						<!-- <div class="coach_recommendation requesttobefollowedmain">
							<h4>Requesting to be Followed</h4>
							<div class="requesttobefollowed">
								<div class="coachsliderbox">
									<div class="coachslider_img">
										<img src="{{ asset('public/frontend/coach/images/user_img.png') }}" alt="user_img"/>
									</div>
									<span>pAnDaUsEr2021</span>
									<h5>Steve Smith <em>5w</em><div class="clr"></div></h5>
									<b>High School Junior, 2004</b>
									<p><em>ACI Score: 75.6</em><em>ACI Rank: 82%</em></p>							

									<a href="" class="accpetedbtn">Accept</a>
									<a href="" class="rejectedbtn">Reject</a>

								</div>						
							</div>
						</div> -->				
					</div>	

				</div>
			</div>
		</div>
	</div>

	<!--Modal-->

	<!-- Modal -->
	<div class="modal fade" id="invitealink" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">      
				<div class="modal-body">
<!--
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    -->
    <h3>Reason for decline</h3>

    <form method="post" action="{{ route('coach.decline.recommendation') }}" enctype="multipart/form-data">
    	@csrf
    	<input type="hidden" name="recommendationId" id="recommendationId" value="0">

    	<ul class="popuplsiting">
    		<li><input type="radio" name="decline_reason" value="I do not have the time to write a recommendation at this time"> I do not have the time to write a recommendation at this time.</li>
    		<li><input type="radio" name="decline_reason" value="I am not taking recommendation requests at this time"> I am not taking recommendation requests at this time.</li>
    		<li><input type="radio" name="decline_reason" value="I do not know this player"> I do not know this player.</li>
    		<li><input type="radio" name="decline_reason" value="I do not have enough information on this player to write a recommendation"> I do not have enough information on this player to write a recommendation.</li>
    		<li><input type="radio" name="decline_reason" value="I am unavailable at this time"> I am unavailable at this time.</li>
    		<li><input type="radio" name="decline_reason" value="There is a conflict of interest in writing this recommendation"> There is a conflict of interest in writing this recommendation.</li>
    		<li><input type="radio" name="decline_reason" value="Please contact me again at a future time"> Please contact me again at a future time.</li>
    	</ul>
    	<div align="center"><button type="submit" class="invitelinkbtn profilelink" >Submit</button></div>
    </form>
</div>      
</div>
</div>
</div>

@endsection
@section('script')
<script>

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

	function getRecommendationId(recommendId){
		$('#recommendationId').val(recommendId);
	}

	
	function deleteReverseLookup(reverseId){
        let id = reverseId;
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "{{url('coach/delete-reverse-lookup')}}" + "/" + id,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(data) {
                            console.log(data);
                            swal(data.message, 'Success', 'success')
                                .then(() => {
                                    location.reload();
                                });
                        }
                    });
                } else {
                    return false;
                }
            });
    }

</script>
@endsection