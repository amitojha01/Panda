@extends('frontend.athlete.layouts.app')
@section('title', 'Edit Profile')
@section('content')
<?php 
use App\Models\SportPosition;
use App\Models\UserSportPosition;

?>
<div class="videoevidance_panel">
	<div class="container-fluid">
		<form method="post" action="{{ route('athlete.update-profile', $user->id) }}" enctype="multipart/form-data">
			@csrf
			<div class="editprofilebox">
				<h2>Personal Info</h2>
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
							<!-- <option value="natural" {{ $user->gender == 'natural' ? 'selected' : ''}}>Neutral</option> -->
						</select>
					</div>

					<div class="col-md-4 col-sm-12 col-xs-12">
						<label>Birth Day</label>
						<select class="form-control" name="day" >
							<option value="" >Select Day</option>
							<?php
							for($i=1; $i<=31; $i++){
								?>
								<option value="{{ $i }}" {{ $user->day == $i ? 'selected' : ''}}>{{ $i }}</option>
								<?php
							}
							?>
						</select>
					</div>
					<div class="col-md-4 col-sm-12 col-xs-12">
						<label>Birth Month</label>
						<select class="form-control" name="month" >
							<option value="" >Select Month</option>
							<?php
							for($i=1; $i<=12; $i++){
								?>
								<option value="{{ $i }}" {{ $user->month == $i ? 'selected' : ''}}>{{ $i }}</option>
								<?php
							}
							?>
						</select>
					</div>

					<div class="col-md-4 col-sm-12 col-xs-12">
						<label>Birth Year</label>
						<select class="form-control" name="year" >
							<option value="{{ @$user->year }}" >{{ @$user->year }}</option>
							<!-- <?php
							for($i=2016; $i>=1940; $i--){
								?>
								<option value="{{ $i }}" {{ $user->year == $i ? 'selected' : ''}}>{{ $i }}</option>
								<?php
							}
							?> -->
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

					<div class="col-md-4 col-sm-12 col-xs-12">
						<label>Allow people that follow your profile to see your email and mobile number?</label>
						<select class="form-control" name="contact_email" >
							<option value="">Select </option>
							<option value="1" {{ $user->contact_email == 1 ? 'selected' : ''}}>Yes</option>
							<option value="2" {{ $user->contact_email == 2 ? 'selected' : ''}}>No</option>
						</select>
					</div>
					<div class="col-md-3 col-sm-12 col-xs-12">
						<label>Profile Image</label>
						<input type="file" class="form-control" name="profile_image"/>
						
					</div>	
					<div class="col-md-1 col-sm-12 col-xs-12">
						<div class="myprofile_l">
							@if(Auth()->user()->profile_image!="") 
							<img src="{{ asset($user->profile_image) }}" alt="user_img"/>
							@else

							<?php $uname = explode(" ", Auth()->user()->username);
							$fname= $uname[0];
							$lname= @$uname[1];

							?>
							<div class="pro-avatar"><?= ucfirst(@$fname[0]).ucfirst(@$lname[0]);?></div>
							@endif
						</div>
					</div>	
					<div class="col-md-4 col-sm-12 col-xs-12">
						<label>High School Graduation Year</label>
						<select class="form-control" name="graduation_year" >
							
							<?php							
							for($i= Date('Y')+10; $i>=Date('Y')-50; $i--){
								?>
								<option value="{{ $i }}" {{ $user->graduation_year == $i ? 'selected' : ''}}>{{ $i }}</option>
								<?php
							}
							?> 
						</select>
					</div>
					
					<!-- <div class="col-md-4 col-sm-12 col-xs-12">
						<label>Publish the email and mobile phone</label>
						<select class="form-control" name="publish_contact" >
						 <option value="" >Select</option>
						 <option value="yes" <?php if($user->publish_contact=="yes"){echo 'selected'; }?>>Yes</option>
						 <option value="no" <?php if($user->publish_contact=="no"){echo 'selected'; }?> >No</option>
							 
						</select>
					</div> -->

					
					<div class="clr"></div>	 	 		
				</div>
				<input type="submit" class="addhighlightsbtn" value="Save">
			</div>
		</form>

		<!-----Guardian Info------>
		<?php if(@$user->guardian[0]->first_name!=""){ ?>
			<form method="post" action="{{ route('athlete.update-guardian', $user->id) }}" enctype="multipart/form-data">
				@csrf	 	 	
				<div class="editprofilebox">
					<h2>Guardian Info</h2>
					<div class="row">
						<div class="col-md-4 col-sm-12 col-xs-12">
							<label>Relationship</label>
							<select class="form-control" name="relationship" required="">
								<option value="father" {{ @$user->guardian[0]->relationship == "father" ? 'selected' : ''}}>Father</option>
								<option value="mother" {{ @$user->guardian[0]->relationship == "mother" ? 'selected' : ''}} >Mother</option>
								<option value="guardian" {{ @$user->guardian[0]->relationship == "guardian" ? 'selected' : ''}}>Guardian</option>
								<option value="grand father" {{ @$user->guardian[0]->relationship == "grand father" ? 'selected' : ''}}>Grand Father</option>
								<option value="grand mother" {{ @$user->guardian[0]->relationship == "grand mother" ? 'selected' : ''}}>Grand Mother</option>
								<option value="uncle" {{ @$user->guardian[0]->relationship == "uncle" ? 'selected' : ''}}>Uncle</option>
								<option value="aunt" {{ @$user->guardian[0]->relationship == "aunt" ? 'selected' : ''}}>Aunt</option>
								<option value="other" {{ @$user->guardian[0]->relationship == "other" ? 'selected' : ''}}>Other</option>
							</select>
						</div>			

						<div class="col-md-4 col-sm-12 col-xs-12">
							<label>First Name</label>
							<input type="text" class="form-control @error('first_name') is-invalid @enderror"
							name="first_name" placeholder="First Name" required=""
							value="{{ @$user->guardian[0]->first_name }}"
							>
						</div>
						<div class="col-md-4 col-sm-12 col-xs-12">
							<label>Last Name</label>
							<input type="text" class="form-control @error('last_name') is-invalid @enderror"
							name="last_name" placeholder="Last Name" required=""
							value="{{ @$user->guardian[0]->last_name }}"
							>                            
						</div>
						<div class="col-md-4 col-sm-12 col-xs-12">
							<label>Primary Phone</label>
							<input type="text" class="form-control @error('first_name') is-invalid @enderror"
							name="primary_phone" placeholder="Primary Name" required=""
							value="{{ @$user->guardian[0]->primary_phone }}"
							>                            
						</div>
						<div class="col-md-4 col-sm-12 col-xs-12">
							<label>Phone Type</label>
							<select class="form-control" name="primary_phone_type" required="">
								<option value="mobile" {{ @$user->guardian[0]->primary_phone_type == "mobile" ? 'selected' : ''}} >Mobile</option>
								<option value="other" {{ @$user->guardian[0]->primary_phone_type == "other" ? 'selected' : ''}}>Other</option>
							</select>

						</div> 
						<div class="col-md-4 col-sm-12 col-xs-12">
							<label>Text</label>
							<select class="form-control" name="is_primary_text" required="">
								<option value="1" {{ @$user->guardian[0]->is_primary_text == 1 ? 'selected' : ''}}>Yes</option>
								<option value="0" {{ @$user->guardian[0]->is_primary_text == 0 ? 'selected' : ''}}>No</option> 
							</select>                    
						</div>
						<div class="col-md-4 col-sm-12 col-xs-12">
							<label>Secondary Phone</label>
							<input type="text" class="form-control @error('secondary_phone') is-invalid @enderror"
							name="secondary_phone" placeholder="Secondary Phone" required=""
							value="{{ @$user->guardian[0]->secondary_phone }}"
							>

						</div>
						<div class="col-md-4 col-sm-12 col-xs-12">
							<label>Phone Type</label>
							<select class="form-control" name="secondary_phone_type" required="">
								<option value="mobile" {{ @$user->guardian[0]->secondary_phone_type == "mobile" ? 'selected' : ''}}>Mobile</option>
								<option value="other"  {{ @$user->guardian[0]->secondary_phone_type == "other" ? 'selected' : ''}}>Other</option> 
							</select>                            
						</div> 
						<div class="col-md-4 col-sm-12 col-xs-12">
							<label>Text</label>
							<select class="form-control" name="is_secondary_text" required="">
								<option value="1" {{ @$user->guardian[0]->is_secondary_text == 1 ? 'selected' : ''}}>Yes</option>
								<option value="0" {{ @$user->guardian[0]->is_secondary_text == 0 ? 'selected' : ''}}>No</option>
							</select>                  
						</div> 	
						<div class="col-md-4 col-sm-12 col-xs-12">
							<label>Primary Email</label>
							<input type="email"  class="form-control" placeholder="" name="primary_email" value="{{ @$user->guardian[0]->primary_email }}" required="" />                           
						</div>	

						<div class="col-md-4 col-sm-12 col-xs-12">
							<label>Enable Text Message</label>
							<select class="form-control" name="enable_textmessage" required="">
								<option value="1" {{ @$user->guardian[0]->enable_textmessage == 1 ? 'selected' : ''}}>Yes</option>
								<option value="0" {{ @$user->guardian[0]->enable_textmessage == 0 ? 'selected' : ''}}>No</option>
							</select>

						</div>						

						<div class="clr"></div>	 	 		
					</div>
					<input type="submit" class="addhighlightsbtn" value="Save">
				</div>
			</form>
		<?php } ?>

		<form method="post" action="{{ route('athlete.update-address', $user->id) }}" enctype="multipart/form-data">
			@csrf	 	 	
			<div class="editprofilebox">
				<h2>Address Info</h2>
				<div class="row">
					<div class="col-md-4 col-sm-12 col-xs-12">
						<label>Country</label>
						<select class="form-control form-control-sm @error('country_id') is-invalid @enderror" name="country_id" required onchange="getState(this)">
							<option value="">--Select Country--</option>
							@if($country)
							@foreach($country as $value)
							<option value="{{$value->id}}" {{ @$user->address[0]->country_id == $value->id  ? 'selected': '' }}      
								>{{ $value->name }}</option>
								@endforeach
								@endif
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
									<!-- <select class="form-control" name="zip" required>            
                                        <option value="{{ @$user->address[0]->zip }}">{{ @$user->address[0]->zip }}</option>

                                    </select> -->
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
                    <!----Physical Info----->
                    <form method="post" action="{{ route('athlete.update-physical-info', $user->id) }}" enctype="multipart/form-data">
                    	@csrf	 	 	
                    	<div class="editprofilebox">
                    		<h2>Physical  Info</h2>
                    		<div class="row">
                    			<div class="col-md-4 col-sm-12 col-xs-12">
                    				<label>Height</label>
                    				<div class="row">
                    					<div class="col-md-6">
                    						<input type="float" min="1"  value="{{ @$user->physicalInfo[0]->height_feet }}" class="form-control" placeholder="5 (in feet)" name="height_feet"/>
                    					</div>
                    					<div class="col-md-6">
                    						<input type="float" min="1"  value="{{ @$user->physicalInfo[0]->height_inch }}" class="form-control" placeholder="5 (in feet)" name="height_inch"/>
                    					</div>
                    				</div>

                    			</div>
                    			<div class="col-md-4 col-sm-12 col-xs-12">
                    				<label>Weight</label>
                    				<input type="float" min="1" step=".01" class="form-control @error('weight') is-invalid @enderror" 
                    				name="weight" placeholder="Weight" required=""
                    				value="{{ @$user->physicalInfo[0]->weight }}"
                    				>
                    			</div>
                    			<div class="col-md-4 col-sm-12 col-xs-12">
                    				<label>Wingspan</label>
                    				<div class="row">
                    					<div class="col-md-6">
                    						<input type="float" min="1"  value="{{ @$user->physicalInfo[0]->wingspan_feet }}" class="form-control" placeholder="2 (in feet)" name="wingspan_feet"/>
                    					</div>
                    					<div class="col-md-6">
                    						<input type="float" min="1"  value="{{ @$user->physicalInfo[0]->wingspan_inch }}" class="form-control" placeholder="5 (in feet)" name="wingspan_inch"/>
                    					</div>
                    				</div>
									<!-- <input type="number" class="form-control @error('wingspan') is-invalid @enderror"
									name="wingspan" min="1" step=".01"  placeholder="Wingspan" required="" value="{{ @$user->physicalInfo[0]->wingspan }}"
									> -->
								</div>
								<div class="col-md-4 col-sm-12 col-xs-12">
									<label>Hand Measurement</label>
									<input type="float" class="form-control @error('head') is-invalid @enderror" min="1" step=".01" 
									name="head" placeholder="Head" required="" value="{{ @$user->physicalInfo[0]->head }}"
									>
								</div>	
								<div class="col-md-4 col-sm-12 col-xs-12">
									<label>Education</label>
									<select class="form-control form-control-sm @error('education_id') is-invalid @enderror" name="education_id" onchange="getEducationLevel(this)" required>
										<option value="">--Select Education--</option>
										@if($education)
										@foreach($education as $value)
										<option value="{{$value->id}}"
											{{ $value->id == @$user->physicalInfo[0]->education_id ? 'selected' : ''}}
											>{{ $value->name }}</option>
											@endforeach
											@endif
										</select>
									</div>	
									<?php if(@$user->physicalInfo[0]->education_id==18){
										$req="";					

									}else{
										$req="required";

									} ?>
									<div class="col-md-4 col-sm-12 col-xs-12">
										<label>Grade Point Average</label>
										<input type="number" min="1" step=".01" class="form-control @error('grade') is-invalid @enderror"
										name="grade" placeholder="Grade" <?= @$req ?>
										value="{{ @$user->physicalInfo[0]->grade }}"
										>
									</div>

									<div class="col-md-4 col-sm-12 col-xs-12">
										<label>Dominant Hand </label>
										<select class="form-control" name="dominant_hand">
											<option value="">Select </option>
											<option value="Right" {{ @$user->physicalInfo[0]->dominant_hand == "Right" ? 'selected': '' }} >Right </option>
											<option value="Left" {{ @$user->physicalInfo[0]->dominant_hand == "Left" ? 'selected': '' }} >Left </option>
											<option value="Ambidextrous" {{ @$user->physicalInfo[0]->dominant_hand == "Ambidextrous" ? 'selected': '' }} >Ambidextrous </option>


										</select>
										@if ($errors->has('dominant_hand'))
										<span class="text-danger">{{ $errors->first('dominant_hand') }}</span>
										@endif
									</div>
									<div class="col-md-4 col-sm-12 col-xs-12">
										<label>Dominant Foot</label>
										<select class="form-control" name="dominant_foot">
											<option value="">Select </option>
											<option value="Right" {{ @$user->physicalInfo[0]->dominant_foot == "Right" ? 'selected': '' }} >Right </option>
											<option value="Left" {{ @$user->physicalInfo[0]->dominant_foot == "Left" ? 'selected': '' }} >Left </option>
											<option value="Ambidextrous" {{ @$user->physicalInfo[0]->dominant_foot == "Ambidextrous" ? 'selected': '' }} >Ambidextrous </option>
										</select>
										@if ($errors->has('dominant_foot'))
										<span class="text-danger">{{ $errors->first('dominant_foot') }}</span>
										@endif
									</div>
									<div class="clr"></div>	 	 		
								</div>
								<input type="submit" class="addhighlightsbtn" value="Save">
							</div>
						</form>
						<!---------Sport Info----------------->
						<form method="post" action="{{ route('athlete.update-sports', $user->id) }}" id="sportForm" enctype="multipart/form-data">
							@csrf	 	 	
							<div class="editprofilebox">
								<div class="row">
									<div class="col-md-10 col-sm-12 col-xs-12">
										<h2>Sport Info</h2>
									</div>
									<div class="col-md-2 col-sm-12 col-xs-12 ">
										<input type="button"  class="btn btn-primary" value="Add Sports" onclick="addSport()">
									</div>
								</div>
								<?php if($userSports){
									foreach($userSports as $val){ 
										$user_sport_position= UserSportPosition::where('user_id', Auth()->user()->id)->where('sport_id', @$val)
										->get();

										?>
										<div class="row">
											<div class="col-md-3 col-sm-12 col-xs-12 ">
												<label>Sports</label>
												<input type="hidden" name="sprtId[]" class="sprtId" value="<?= @$val ?>">					
												<select class="form-control form-control-sm @error('sport_id') is-invalid @enderror  sportOption" name="sport_id[]" onchange="getSportPos(this)" required>
													<option value="">--Select Sport--</option>
													<?php if($sport){
														foreach($sport as $value){
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
										<div class="col-md-3 col-sm-12 col-xs-12">
											<label>Sports Position</label>
											<?php 
											$position = SportPosition::where(['sport_id'=> $val])->where('status',1)->get();
											$pos_selected="";

											?>
											<select class="form-control pvalone form-control-sm @error('sport_position_id') is-invalid @enderror sportpos-dropdown" name="sport_position_id[]" onchange="checkPosition2(this)" requiredz>
												<option value="">--Select Sport--</option>
												<?php if($position){
													foreach($position as $value){
												/*if (in_array($value->id, $userSportpos)) {
													$pos_selected='selected';
												}*/
												if($value->id==@$user_sport_position[0]->position_id){
													$pos_selected='selected';

												}
												?>
												<option 
												value="{{$value->id}}"
												{{ $pos_selected }}
												>{{ $value->name }}  
											</option>
											<?php $pos_selected="";
										}
									} ?>
								</select>
							</div>
							<?php if($val==12 || $val==14 || $val==21 || $val==22){?>
								<div class="col-md-3 col-sm-12 col-xs-12 secondSport" style="display:none" >

								<?php }else{?>

							<div class="col-md-3 col-sm-12 col-xs-12 secondSport" >
							<?php } ?>
								<label>Sports Position</label>
								<?php 
								$position = SportPosition::where(['sport_id'=> $val])->get();
								$pos_selected="";

								?>
								<select class="form-control pvaltwo form-control-sm @error('sport_position_id') is-invalid @enderror sportpos-dropdown" name="sport_position_id[]" onchange="checkPosition1(this)" requiredz>
									<option value="">--Select Sport--</option>
									<?php if($position){
										foreach($position as $value){
												/*if (in_array($value->id, $userSportpos)) {
													$pos_selected='selected';
												}*/
												if($value->id== @$user_sport_position[1]->position_id){
													$pos_selected='selected';

												}
												
												?>
												<option 
												value="{{$value->id}}"
												{{ $pos_selected }}
												>{{ $value->name }}  
											</option>
											<?php $pos_selected="";
										}
									} ?>
								</select>
							</div>
						

							<div class="col-md-2 col-sm-12 col-xs-12 ">
								<input type="button" style="margin-top:30px;" class="btn btn-danger" value="Remove" onclick="removeSport(this)">

							</div>
							<div class="clr"></div>	 
						</div>
					<?php } }?>
					<div class="sportlist"></div>

					<!--<h2>Competitive Level</h2>-->
					<div class="row">							
						<div class="col-md-4 col-sm-12 col-xs-12">
							<label>Competition Level</label>
							<select class="form-control  form-control-sm @error('competition_id') is-invalid @enderror " name="competition_id"  >
								<option value="">--Select--</option>
								@if($competition)
								@foreach($competition as $value)
								<option value="{{$value->id}}"
									{{ $value->id == @$competition_id ? 'selected' : ''}}
									>{{ $value->name }}</option>
									@endforeach
									@endif
								</select>
							</div>

							<div class="col-md-4 col-sm-12 col-xs-12">
								<label>School Playing Level</label>
								<select class="form-control  form-control-sm @error('school_level_id') is-invalid @enderror" name="school_level_id" >
									<option value="">--Select--</option>
									@if($school_playingList)
									@foreach($school_playingList as $value)
									<option value="{{$value->id}}"
										{{ $value->id == @$user_school_level_id ? 'selected' : ''}}
										>{{ $value->name }}</option>
										@endforeach
										@endif
									</select>
								</div>
								<div class="col-md-4 col-sm-12 col-xs-12">
									<label>Rec/Club/Travel Level</label>
									<select class="form-control form-control-sm @error('other_level_id') is-invalid @enderror" name="other_level_id" >
										<option value="">--Select--</option>
										@if($travelList)
										@foreach($travelList as $value)
										<option value="{{$value->id}}"
											{{ $value->id == @$user_other_level_id ? 'selected' : ''}}
											>{{ $value->name }}</option>
											@endforeach
											@endif
										</select>
									</div>
								</div>


								<input type="submit" class="addhighlightsbtn" value="Save">
							</div>
						</form>
						<!---College Info --->
						<form method="post" action="{{ route('update.athlete.college', $user->id) }}" enctype="multipart/form-data">
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
								@if(@$userCollege)
								@foreach(@$userCollege as $val) 
								<div class="row">
									<div class="col-md-5 col-sm-12 col-xs-12">
										<label>College</label>
										<select class="form-control form-control-sm @error('college_id') is-invalid @enderror" name="college_id[]" required>
											<option value="">--Select College--</option>
											<?php if($college_list){
												foreach($college_list as $value){
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
					</form>

				</div>                                                                       
			</div>     

			<div class="clr"></div>
		</div>
		@endsection
		@section('script')
		@if ($message = Session::get('error'))  
		<script>   
			swal('{{ $message }}', 'Warning', 'error');
		</script>
		@endif
		<script src="{{ asset('public/frontend/js/password.js') }}"></script>

		<script>
			function getState(dis){

				var country_id = $(dis).val();          
				$("#state-dropdown").html('');
				$.ajax({
					url:"{{url('athlete/get-states')}}",
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
					url:"{{url('athlete/get-city')}}",
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

			function getSportPos(dis){      
				var sport_id = dis.value;
								
				if(sport_id==12 || sport_id==14 || sport_id==21 || sport_id==22)
				{					
					$(dis).closest('.row').find('.secondSport').hide();
				}else{
					$(dis).closest('.row').find('.secondSport').show();

				}

				$(dis).closest('.row').find('.sprtId').val(sport_id);
				$.ajax({
					url:"{{url('athlete/get-sport-position')}}",
					type: "GET",
					data: {
						sport_id: sport_id,
						_token: '{{csrf_token()}}' 
					},
					dataType : 'json',
					success: function(result){
						console.log(result);
						$(dis).closest('.row').find('.sportpos-dropdown').html('<option value="">Select Sport Position</option>'); 
						$.each(result.position,function(key,value){
							$(dis).closest('.row').find('.sportpos-dropdown').append('<option value="'+value.id+'">'+value.name+'</option>');
						});

					}
				});

			}

			$('#changePwdForm').submit(function() {
				var password= $('#password').val();
				var confirm_password = $('#confirm_password').val();
				if(password==""){
					$('#passwordreq').show();
					$('#mismatch').hide();
					$('#validerr').hide();
					return false;
				}
				if(password!=confirm_password){				
					$('#passwordreq').hide();
					$('#validerr').hide();
					$('#mismatch').show();
					return false;
				}

				if($("#mp-upper").prop('checked') == false || $("#mp-number").prop('checked') == false ||  $("#mp-lower").prop('checked') == false ||  $("#mp-symbol").prop('checked') == false ||  $("#mp-len").prop('checked') == false){				
					$('#validerr').show();
					$('#passwordreq').hide();
					$('#mismatch').hide();
					return false;    
				}    
			});


			function addSport(){	 	
				var list="";        
				$.ajax({
					url:"{{url('athlete/get-sportslist')}}",
					type: "GET",
					data: {
						_token: '{{csrf_token()}}' 
					},
					dataType : 'json',
					success: function(result){
						console.log(result);

						list+='<div class="row">';
						list+='<div class="form-group col-md-3">';
						list+='<label>Sports</label>';

						list+='<input type="hidden" name="sprtId[]" class="sprtId" value="">';	
						list+='<select class="form-control form-control-sm  sportOption " name="sport_id[]" onchange="getSportPos(this)" required>';
						list+='<option value="">--Select Sport--</option>';
						$.each(result.sport,function(key,value){
							list+='<option value="'+value.id+'">'+value.name+'</option>';

						});

						list+='</select>';
						list+='</div>';
						list+='<div class="col-md-3">';
						list+='<label>Sports Position</label>';
						list+='<select class="form-control pvalone form-control-sm   sportpos-dropdown" name="sport_position_id[]" onchange="checkPosition2(this)" required>';
						list+='<option value="">--Select Sport--</option>';

						list+='</select>';
						list+='</div>';


						list+='<div class="col-md-3 secondSport">';
						list+='<label>Sports Position</label>';
						list+='<select class="form-control pvaltwo form-control-sm   sportpos-dropdown" name="sport_position_id[]" onchange="checkPosition1(this)">';
						list+='<option value="">--Select Sport--</option>';

						list+='</select>';
						list+='</div>';

						list+='<div class="col-md-2">';
						list+='<input type="button" style="margin-top:30px;" class="btn btn-danger" value="Remove" onclick="removeSport(this)">';

						list+='</div>';
						list+='</div>';
						$('.sportlist').append(list);
					}
				});
			}

			function removeSport(dis){
				$(dis).closest(".row").remove();
			}

			$('select[name="city_id"]').on('change', function(){
				let id = $(this).val();           
				$.ajax({
					type : "GET",
					url : "{{ url('api/get-zip-codes') }}?city_id="+id,
					data : {},
					beforeSend: function(){
                    // $("#overlay").fadeIn(300);
                },
                success: function(res){
                	console.log(res);
                	if(res.success){
                		$('select[name="zip"]').html('<option value="">--Select--</option>');
                		res.data.forEach((v) => {
                			$('select[name="zip"]')
                			.append('<option value="'+v.zip+'">'+v.zip+'</option>');
                		})                    
                	}
                },
                error: function(err){
                	console.log(err);
                }
            }).done( () => {

            });
        })


			$('#sportForm').submit(function() {    	
				var sport_count= $('.sportOption option').size();
				if(sport_count==0){
					swal('Alert', 'Please add sport', 'error');
					return false;
				} 
			})

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


			function addCollege(){
				var list="";        
				$.ajax({
					url:"{{url('athlete/get-collegelist')}}",
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

			function getEducationLevel(dis){
				if($(dis).val()==18){
					$("input[name=grade]").removeAttr('required');
				}else{            
					$("input[name=grade]").prop('required',true);
				}
			}

			function checkPosition1(dis){
				var p2= $(dis).val();
				var p1= $(dis).parents('.row').find('.pvalone').val();
				if(p1!="" && p1==p2){           
					swal('Alert', 'Position 1 and Position 2 can not be same', 'error');
					$(dis).val('');

				}

			}
			function checkPosition2(dis){
				var p2= $(dis).parents('.row').find('.pvaltwo').val();
				var p1= $(dis).val();

				if(p2!="" && p1==p2){            
					swal('Alert', 'Position 1 and Position 2 can not be same', 'error');
					$(dis).val('');

				}
			}

		</script>
		@endsection
