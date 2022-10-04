@extends('frontend.coach.layouts.app')
@section('title', 'Edit Profile')
@section('content')
<style>
	.hide-sec{
		display: :none;
	}
	</style>

<div class="videoevidance_panel">
	<div class="container-fluid">
		<form method="post" action="{{ route('coach.update-profile', $user->id) }}" enctype="multipart/form-data">
			@csrf
			<div class="editprofilebox">
				<h2>Personal Info </h2>
				<div class="row">

					<div class="col-md-4 col-sm-12 col-xs-12">
						<label>User Name</label>
						<input type="text" name="username" value="{{ $user->username }}" class="form-control" placeholder=""  />
						@if ($errors->has('username'))
						<div class="invalid-feedback">{{ $errors->first('username') }}</div>
						@endif
					</div>
					<div class="col-md-4 col-sm-12 col-xs-12">
						<label>Mobile</label>
						<input type="text" name="mobile"  value="{{ $user->mobile }}"  class="form-control" placeholder="" readonly/>
					</div>
					<div class="col-md-4 col-sm-12 col-xs-12">
						<label>Email</label>
						<input type="text" name="email"  value="{{ $user->email }}" class="form-control" placeholder="" readonly/>
					</div>
					<div class="col-md-4 col-sm-12 col-xs-12">
						<label>Gender</label>
						<select class="form-control" name="gender" >
							<option value="male" {{ $user->gender == 'male' ? 'selected' : ''}}>Male</option>
							<option value="female" {{ $user->gender == 'female' ? 'selected' : ''}}>Female</option>
							<option value="natural" {{ $user->gender == 'natural' ? 'selected' : ''}}>Neutral</option>
						</select>
					</div>
					
					<div class="col-md-4 col-sm-12 col-xs-12">
						<label>Profile Type</label>
						<select class="form-control" name="profile_type" >
							<option value="">Select type</option>
							<option value="0" {{ $user->profile_type == 0 ? 'selected' : ''}}>Public</option>
							<option value="1" {{ $user->profile_type == 1 ? 'selected' : ''}}>Private</option>
						</select>
					</div>

					<!----->
					
					<div class="col-md-4 col-sm-12 col-xs-12">
						<label>Allow people that follow your profile to see your email and mobile number?</label>
						<select class="form-control" name="contact_email" >
							<option value="">Select </option>
							<option value="1" {{ $user->contact_email == 1 ? 'selected' : ''}}>Yes</option>
							<option value="2" {{ $user->contact_email == 2 ? 'selected' : ''}}>No</option>
						</select>
					</div>


					<!----->
					<div class="col-md-3 col-sm-12 col-xs-12">
						<label>Profile Image</label>
						<input type="file" class="form-control" name="profile_image"/>
						
					</div>	
					<div class="col-md-1 col-sm-12 col-xs-12">
						<div class="myprofile_l">
							@if(Auth()->user()->profile_image!="") 
							<img src="{{ asset($user->profile_image) }}" alt="user_img"/>
							@else
							<img src="{{ asset('public/frontend/athlete/images/user_img.png') }}" alt="user_img"/>
							@endif
						</div>
					</div>						
					<div class="clr"></div>	 	 		
				</div>
				<input type="submit" class="addhighlightsbtn" value="Save">
			</div>
		</form>

		<!-----Address Info-------->
		<form method="post" action="{{ route('coach.update-address', $user->id) }}" enctype="multipart/form-data">
			@csrf	 	 	
			<div class="editprofilebox">
				<h2>Address Info</h2>
				<div class="row">
					<div class="col-md-4 col-sm-12 col-xs-12">
						<label>Country</label>
						<select class="form-control form-control-sm @error('country_id') is-invalid @enderror" name="country_id" required onchange="getState(this)">

							<option value="231" selected>United States</option>
							<!-- <option value="">--Select Country--</option>
							@if($country)
							@foreach($country as $value)
							<option value="{{$value->id}}" {{ @$user->address[0]->country_id == $value->id  ? 'selected': '' }}      
								>{{ $value->name }}</option>
								@endforeach
								@endif -->
							</select>
						</div>
						<div class="col-md-4 col-sm-12 col-xs-12">
							<label>State</label>
							<select class="form-control" name="state_id" id="state-dropdown" required>
								<option value="">Select State</option>
								@if($states)
								@foreach($states as $value)
								<option value="{{$value->id}}" {{ @$user->address[0]->state_id == $value->id  ? 'selected': '' }}      
									>{{ $value->name }}</option>
									@endforeach
									@endif
								</select>
							</div>
							<div class="col-md-4 col-sm-12 col-xs-12">
								<label>City</label>
								<select class="form-control" name="city_id" id="city-dropdown" required>
									<option value="">Select City</option>
									@if($city)
									@foreach($city as $value)
									<option value="{{$value->id}}" {{ @$user->address[0]->city_id == $value->id  ? 'selected': '' }}      
										>{{ $value->name }}</option>
										@endforeach
										@endif

									</select>
								</div>
								<div class="col-md-4 col-sm-12 col-xs-12">
									<label>Zip</label>
									<input type="number" onkeyup="checkZip(this)" class="form-control @error('zip') is-invalid @enderror"
									name="zip" placeholder="Zip" required="" value="{{ @$user->address[0]->zip }}"
									>
									<span id="zipErr" style="color:red; display:none">Please enter valid zip code!! </span>
								</div>								

								<div class="clr"></div>	 	 		
							</div>
							<input type="submit" id="addrsavebtn" class="addhighlightsbtn" value="Save">
						</div>
					</form>

					<!----Other Info----->
<form method="post" action="{{ route('coach.update-other-info', $user->id) }}" enctype="multipart/form-data">
	@csrf	 	 	
	<div class="editprofilebox">
		<h2>Other Info</h2>
		<div class="row">
			<div class="col-md-4 col-sm-12 col-xs-12">
				<label>Level Coaching</label>
				<select class="form-control form-control-sm @error('coaching_level') is-invalid @enderror" name="coaching_level" id="coach_level" required>
					<option value="">--Select--</option>
					@foreach($coach_level as $level)
					<option value="{{ $level->id }}" {{ $level->id == @$coachInfo->coaching_level ? 'selected' : ''}}>{{ @$level->name }}</option>
					@endforeach
					<!-- <option value="college" selected>College</option>
					<option value="school">School</option> -->

				</select>
			</div>
			<!-- <div class="col-md-4 col-sm-12 col-xs-12">
				<label>Sport</label>
				<select class="form-control" name="sport_id" id="sport-dropdown" >
					<option value="">Select Sport</option>
					@if($sports)
					@foreach($sports as $value)
					<option value="{{$value->id}}"     
						{{ @$coachInfo->sport_id == $value->id  ? 'selected': '' }}  >{{ $value->name }}</option>
						@endforeach
						@endif
					</select>
				</div> -->
				<input type="hidden" id="level-value" value="{{ @$coachInfo->coaching_level }}">

				<div class="col-md-4 col-sm-12 col-xs-12" id="sec-college" style="display: none">
					<label>Current College Name</label>

					<input type="text" value="{{ @$college->name }}" id="college_name" class="form-control input-lg" placeholder="Enter College Name" />
					<input type="hidden" name="college_id" id="collegeId">
					<div id="collegeList">
					</div>
					
					</div>
					<div class="col-md-4 col-sm-12 col-xs-12 " id="sec-other" style="display:none">
						<label id="level_name">{{ @$level_detail[0]->name }}  Name</label>
						<input type="text" name="coach_level_name" value="{{ @$coachInfo->coach_level_name }}" id="coach_level_name" class="form-control" placeholder=""  />
						@if ($errors->has('coach_level_name'))
						<div class="invalid-feedback">{{ $errors->first('coach_level_name') }}</div>
						@endif
					</div>
					<div class="col-md-4 col-sm-12 col-xs-12 " id="sec-club" style="display:none">
						<label id="club_name">Club Name</label>
						<input type="text" name="club_name" value="{{ @$coachInfo->club_name }}" id="club_name" class="form-control" placeholder=""  />
						@if ($errors->has('club_name'))
						<div class="invalid-feedback">{{ $errors->first('club_name') }}</div>
						@endif
					</div>


				
					<div class="col-md-4 col-sm-12 col-xs-12">
						<label>Gender of sport coaching</label>
						<select class="form-control" name="gender_of_coaching"  required>
							<option value="">Select </option>
							<option value="male" <?php if(@$coachInfo->gender_of_coaching=="male"){echo "selected" ;}?>>Male </option>
							<option value="female" <?php if(@$coachInfo->gender_of_coaching=="female"){echo "selected" ;}?>>Female </option>
							<option value="both" <?php if(@$coachInfo->gender_of_coaching=="both"){echo "selected" ;}?>>Both </option>

						</select>
					</div>

					<div class="col-md-4 col-sm-12 col-xs-12">
						<label>Your Bio Link</label>
						<input type="url" class="form-control @error('about_link') is-invalid @enderror"
						name="about_link" placeholder="http://" required="" value="{{ @$coachInfo->about_link }}"
						>
					</div>	

					<div class="col-md-4 col-sm-12 col-xs-12">
						<label>Contact Preference</label>
						<select class="form-control" name="preference_id"  required>
							<option value="">Select </option>
							@if($preference)
							@foreach($preference as $value)
							<option value="{{$value->id}}" {{ @$coachInfo->preference_id == $value->id  ? 'selected': '' }}       
								>{{ $value->name }}</option>
								@endforeach
								@endif
							</select>
						</div>
					
						<div class="col-md-4 col-sm-12 col-xs-12">
							<label>Did you play the following sport you are coaching?</label>
							<select class="form-control" id="coaching_sport" name="coaching_sport" onchange="getcoaching(this)" required>
								<option value="">--Select--</option>
								<option value="yes" <?php if(@$coachInfo->coaching_sport=="yes"){echo "selected"; }?>>Yes</option>
								<option value="no" <?php if(@$coachInfo->coaching_sport=="no"){echo "selected"; }?>>No</option>
							</select>
						</div>

						<div class="col-md-4 col-sm-12 col-xs-12" id="sport_level">
							<label>Level</label>
							<select class="form-control" id="sport_level_name" name="sport_level" onchange="getlevel(this)" >
								<option value="">--Select--</option>
								<option value="Club" {{ @$coachInfo->sport_level == "Club"  ? 'selected': '' }} >Club</option>
								<option value="High School" {{ @$coachInfo->sport_level == "High School"  ? 'selected': '' }}>High School</option>
								<option value="College – Division 1" {{ @$coachInfo->sport_level == "College – Division 1"  ? 'selected': '' }}>College – Division 1</option>
								<option value="College – Division 2" {{ @$coachInfo->sport_level == "College – Division 2"  ? 'selected': '' }}>College – Division 2</option>
								<option value="College – Division 3" {{ @$coachInfo->sport_level == "College – Division 3"  ? 'selected': '' }}>College – Division 3</option>
								<option value="Professional" {{ @$coachInfo->sport_level == "Professional"  ? 'selected': '' }}>Professional</option>

							</select>
						</div>

						<div class="col-md-4 col-sm-12 col-xs-12" id="team">
							<label>Team Name</label>
							<input type="text" class="form-control" name="team_name" value="{{@$coachInfo->team_name }}">
						</div>
						
						<div class="col-md-4 col-sm-12 col-xs-12" >
							<label>Number of Years Coaching Youth Athletes</label>
							<select class="form-control" name="number_of_years" required>
								<option value="">--Select--</option>
								<?php for ($i=0; $i <=50 ; $i++) { ?>
									<option value="{{ $i }}" <?php if(@$coachInfo->number_of_years== $i){echo 'selected' ;} ?>>{{ $i }}</option>
								<?php } ?>
							</select>
						</div>
						
						<div class="col-md-4 col-sm-12 col-xs-12" >
							<label>Primary Age Group You Currently Coach</label>
							<select class="form-control" name="primary_age_group" required>
								<option value="">--Select--</option>
								<option value="U6 to U9" <?php if(@$coachInfo->primary_age_group=='U6 to U9'){echo 'selected' ;}?>>U6 to U9</option>
								<option value="U10 to U13"<?php if(@$coachInfo->primary_age_group=='U10 to U13'){echo 'selected' ;}?>>U10 to U13</option>
								<option value="U14 to U19" <?php if(@$coachInfo->primary_age_group=='U14 to U19'){echo 'selected' ;}?>>U14 to U19</option>
								<option value="U21 and above" <?php if(@$coachInfo->primary_age_group=='U21 and above'){echo 'selected' ;}?>>U21 and above</option>

								<option value="International Competition" <?php if(@$coachInfo->primary_age_group=='International Competition'){echo 'selected' ;}?>>International Competition(non-professional) </option>
								<option value="Collegiate" <?php if(@$coachInfo->primary_age_group=='Collegiate'){echo 'selected' ;}?>>Collegiate</option>
								<option value="Professional" <?php if(@$coachInfo->primary_age_group=='Professional'){echo 'selected' ;}?>>Professional</option>
							</select>
						</div>

						<div class="col-md-12 col-sm-12 col-xs-12">
							<label>Your Bio</label>
							<textarea class="form-control @error('about') is-invalid @enderror" name="about" 
							required=""  value="">{!! @$coachInfo->about !!}</textarea>
							@if ($errors->has('about'))
							<div class="invalid-feedback">{{ $errors->first('about') }}</div>
							@endif
						</div>

						<div class="col-md-12 col-sm-12 col-xs-12">
							<input type="checkbox" id="html" name="serve_as_reference" value="1"   {{ @$coachInfo->serve_as_reference == 1  ? 'checked': '' }}                
							>
							<label style="display: inline-block;" for="html"> &nbsp; Are you willing to serve as a reference?</label>
						</div>  
						<div class="col-md-12 col-sm-12 col-xs-12" style="padding-top:15px; padding-bottom:15px; color:#fff;">
							
							<label for="html"> &nbsp; Do you want to share your contact info with players who are following you?</label>
							<input type="radio" id="html" class="btn-pos" name="share_contact" value="email"   {{ @$coachInfo->share_contact == "email"  ? 'checked': '' }}                
							> &nbsp; Email  &nbsp;&nbsp;

							<input type="radio" id="html" name="share_contact" value="mobile"  class="btn-pos" {{ @$coachInfo->share_contact == "mobile"  ? 'checked': '' }}                
							> &nbsp; Mobile &nbsp;&nbsp;

							<input type="radio" id="html" name="share_contact" value="both"  class="btn-pos" {{ @$coachInfo->share_contact == "both"  ? 'checked': '' }}                
							> &nbsp; Both
						</div>
                        

						<div class="clr"></div>	 	 		
					</div>
					<input type="submit" class="addhighlightsbtn" value="Save">
				</div>
			</form>
<!----User Sports Info------->
<form method="post" action="{{ route('update.coach.sport', $user->id) }}" enctype="multipart/form-data">
	@csrf	 	 	
	<div class="editprofilebox">
		<div class="row">
			<div class="col-md-10 col-sm-12 col-xs-12">
		<h2>Sport Info</h2>
	</div>
	<div class="col-md-2 col-sm-12 col-xs-12">
		<input type="button"  class="btn btn-primary" value="Add Sports" onclick="addSport()">
	</div>
	</div>
	<input type="hidden" id="sportCount" value="{{ count($userSports)}}">
		@if($userSports)
		@foreach($userSports as $val) 
		<div class="row">
			<div class="col-md-5 col-sm-12 col-xs-12">
				<label>Sports</label>				
				<select class="form-control form-control-sm @error('sport_id') is-invalid @enderror" name="sport_id[]" required>
					<option value="">--Select Sport--</option>
					<?php if($sports){
						foreach($sports as $value){
							?>
							<option 
							value="{{$value->id}}"
							{{ $value->id == $val ? 'selected': '' }}
							>{{ $value->name }}  
						</option>
						<?php
					}
				} ?>
			</select>
		</div>

		<div class="col-md-2 col-sm-12 col-xs-12 ">
			<input type="button" style="margin-top:30px;" class="btn btn-danger" value="Remove" onclick="removeSport(this)">

		</div>
		<div class="clr"></div>	 
	</div>
	@endforeach
	@endif
	<div class="sportlist"></div>

	<input type="submit" class="addhighlightsbtn" value="Save">
</div>
</form>
<!---College Info --->
<!-- <form method="post" action="{{ route('update.coach.college', $user->id) }}" enctype="multipart/form-data">
	@csrf	 	 	
	<div class="editprofilebox">
		<div class="row">
			<div class="col-md-10 col-sm-12 col-xs-12">
				<h2>College Info</h2>
			</div>			
			<div class="col-md-2 col-sm-12 col-xs-12">
				<input type="button"  class="btn btn-primary" value="Add College" onclick="addCollege()">
			</div>
		</div>
		@if($userCollege)
		@foreach($userCollege as $val) 
		<div class="row">
			<div class="col-md-5 col-sm-12 col-xs-12">
				<label>College</label>
				<select class="form-control form-control-sm @error('college_id') is-invalid @enderror" name="college_id[]" required>
					<option value="">--Select College--</option>
					<?php if($college){
						foreach($college as $value){
							?>
							<option 
							value="{{@$value->id}}"
							{{ @$value->id == $val ? 'selected': '' }}
							>{{ @$value->name }}  
						</option>
						<?php
					}
				} ?>
			</select>
		</div>

		<div class="col-md-2 col-sm-12 col-xs-12 ">
			<input type="button" style="margin-top:30px;" class="btn btn-danger" value="Remove" onclick="removeCollege(this)">

		</div>
		<div class="clr"></div>	 
	</div>
	@endforeach
	@endif
	<div class="collegelist"></div>

	<input type="submit" class="addhighlightsbtn" value="Save">
</div>
</form> -->

		</div>                                                                      
	</div>     

	<div class="clr"></div>
</div>
@endsection
@section('script')
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
	CKEDITOR.replace( 'about' );
</script>
@if ($message = Session::get('error'))  
<script>   
	swal('{{ $message }}', 'Warning', 'error');
</script>
@endif
<script src="{{ asset('public/frontend/js/password.js') }}"></script>

<script>

	$(document).ready(function(){
		var level= $('#level-value').val();
		if(level==2){
			$('#sec-college').show();
			$('#sec-other').hide();
		}else if(level==7 || level==8){
			$('#sec-other').show();
			$('#sec-club').show();
			$('#sec-college').hide();
		}
		else{
			$('#sec-other').show();
			$('#sec-college').hide();

		}

    	$('select[name="coaching_level"]').on('change', function(){
			let option = $(this).val();			
			if(option==7){				
			var coach_level= 'High School Name';
			$('#level_name').text(coach_level);
			$('#sec-club').show();

			}else if(option==8){
				var coach_level= 'Middle School Name';
			$('#level_name').text(coach_level);
			$('#sec-club').show();

			}else{
				$('#club_name').val('');
				$('#sec-club').hide();
				var coach_level= $("#coach_level option:selected").text()+' Name';
			$('#level_name').text(coach_level);

			}
			
			//var coach_level= $("#coach_level option:selected").text()+' Name';
			//$('#level_name').text(coach_level);
						
			console.log(option);			
			if(option == '2'){
				
				$('#college_name').val('');				
				$('#sec-other').hide();
				$('#sec-other .form-control').prop('required', false);
				$('#sec-college').show();
				$('#sec-college .form-control').prop('required', true);
			}else{
				$('#coach_level_name').val('');

				$('#sec-other').show();
				$('#sec-other .form-control').prop('required', true);
				$('#sec-college').hide();
				$('#sec-college .form-control').prop('required', false);
			}

		})

		//=College Auto suggest==
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

    	 

    });

	function getState(dis){

		var country_id = $(dis).val();          
		$("#state-dropdown").html('');
		$.ajax({
			url:"{{url('coach/coach-states')}}",
			type: "GET",
			data: {
				country_id: country_id,
				_token: '{{csrf_token()}}' 
			},
			dataType : 'json',
			success: function(result){
				console.log(result);
				$('#state-dropdown').html('<option value="">Select State</option>'); 
				$.each(result.states,function(key,value){
					$("#state-dropdown").append('<option value="'+value.id+'">'+value.name+'</option>');
				});
				$('#city-dropdown').html('<option value="">Select State First</option>'); 
			}
		});

	}

	$('#state-dropdown').on('change', function() {
		var state_id = this.value;
		$("#city-dropdown").html('');
		$.ajax({
			url:"{{url('coach/coach-city')}}",
			type: "GET",
			data: {
				state_id: state_id,
				_token: '{{csrf_token()}}' 
			},
			dataType : 'json',
			success: function(result){
				$('#city-dropdown').html('<option value="">Select City</option>'); 
				$.each(result.cities,function(key,value){
					$("#city-dropdown").append('<option value="'+value.id+'">'+value.name+'</option>');
				});
			}
		});
	});


	function addSport(){
		var sportCount=$('#sportCount').val();
        var list=""; 
        if(sportCount < 4){       
        $.ajax({
            url:"{{url('coach/get-sportlist')}}",
            type: "GET",
            data: {
                _token: '{{csrf_token()}}' 
            },
            dataType : 'json',
            success: function(result){
                console.log(result);

                list+='<div class="row">';
                list+='<div class="form-group col-md-5">';
                list+='<label>Sports</label>';
                list+='<select class="form-control form-control-sm   " name="sport_id[]"  required>';
                list+='<option value="">--Select Sport--</option>';
                $.each(result.sport,function(key,value){
                    list+='<option value="'+value.id+'">'+value.name+'</option>';
                    
                });

                list+='</select>';
                list+='</div>';            

                list+='<div class="col-md-4">';
                list+='<input type="button" style="margin-top:30px;" class="btn btn-danger" value="Remove" onclick="removeSport(this)">';

                list+='</div>';
                list+='</div>';
                $('.sportlist').append(list);
                var newCount= ++sportCount;
                $('#sportCount').val(newCount);
                
            }
        });
    }else{
    	swal({
			title: "You can add max 4 sport",
			//text: "You can add max 4 sport",
			icon: "warning",
			//buttons: true,
			//dangerMode: true,
		})
    }
    }

    function removeSport(dis){
    	var sportCount=$('#sportCount').val();
    	$(dis).closest(".row").remove();
    	var newCount= --sportCount;
    	$('#sportCount').val(newCount);
    }

 function addCollege(){
        var list="";        
        $.ajax({
            url:"{{url('coach/get-collegelist')}}",
            type: "GET",
            data: {
                _token: '{{csrf_token()}}' 
            },
            dataType : 'json',
            success: function(result){
                console.log(result);

                list+='<div class="row">';
                list+='<div class="form-group col-md-5">';
                list+='<label>College</label>';
                list+='<select class="form-control form-control-sm " name="college_id[]"  required>';
                list+='<option value="">--Select College--</option>';
                $.each(result.college,function(key,value){
                    list+='<option value="'+value.id+'">'+value.name+'</option>';
                    
                });

                list+='</select>';
                list+='</div>';            

                list+='<div class="col-md-4">';
                list+='<input type="button" style="margin-top:30px;" class="btn btn-danger" value="Remove" onclick="removeCollege(this)">';

                list+='</div>';
                list+='</div>';
                $('.collegelist').append(list);
            }
        });
    }

     function removeCollege(dis){
     $(dis).closest(".row").remove();
    }

    function getcoaching(dis){
    	var coaching_value= $(dis).val();
    	if(coaching_value=="yes"){
    		$('#sport_level').show();
    		$('#sport_level .form-control').prop('required', true);
    	}else{
    		$('#sport_level').hide();
    		$('#team').hide();
    		$('#sport_level_name').val('');
    		$('#sport_level .form-control').prop('required', false);
    	}
    }

     function getlevel(dis){
    	var level= $(dis).val();
    	if(level=="Professional"){
    		$('#team').show();
    	}else{
    		$('#team').hide();
    	}    	
    }

    $( document ).ready(function() {
    	var coaching_sport = $('#coaching_sport').val();
    	var sport_level_name= $('#sport_level_name').val();
    	if(coaching_sport=="no" || coaching_sport==""){
    		$('#sport_level').hide();
   			$('#team').hide();
    	}
    	if(sport_level_name=="Professional"){    		
   			$('#team').show();
    	}else{
    		$('#team').hide();
    	}
    	
    	
    });

    function checkZip(dis){
 		var zip_length= $(dis).val().length; 		
 		if(zip_length!=5){
 			$('#zipErr').show();
 			$('#addrsavebtn').attr("disabled", true);
 		}else{
 			$('#zipErr').hide();
 			$('#addrsavebtn').attr("disabled", false);
 			
 		}
 	}

</script>
@endsection
