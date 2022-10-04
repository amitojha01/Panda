@extends('frontend.layouts.coach')
@section('title', 'Registration | Coach | Other Informations')
@section('style')
<style>
    .accout5_radio img{
        width: 30px;
    }
</style>
@endsection
@section('content')
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<div class="">
<div class="signinheader">
        <div class="signinheader_l"><a href="">
                <img src="{{ asset('public/frontend/images/signin_logo.png') }}" alt="signin_logo" /></a></div>
        <!-- <div class="signinheader_r">
            <span>Don't have an account? <a href="">Try Now</a></span>
        </div> -->
        <div class="clr"></div>
    </div>
	<div class="signinbox createaccount2">
		<h2>Create Account</h2>
		<span>Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod 
			<a><b>03</b>/03</a>
		</span>
		<h5>Other information</h5>
		<form action="{{ route('registration.coach.other-information')}}" method="POST" id="sinupForm">
			@csrf
			<div class="signinbox">		
				<div class="signinboxinput">
					<label>Level Coaching</label>
					<select class="form-control" name="coaching_level" id="coach_level" required>
						<option value="">--Select--</option>
						
						@foreach($coach_level as $level)
						<option value="{{ $level->id }}" {{ $level->id == 2 ? 'selected' : ''}}>{{ $level->name }}</option>
						@endforeach

				
					</select>
				</div>
				<div class="signinboxinput2 multi-sport">
					<label>Sport</label>
					
					<select class=" multipleSelect2 form-control " multiple="multiple" id="sportId" name="sport_id[]"   required>
						<option value="">--Select--</option>
					</select>
				</div>
				<div class="clr"></div>
				<div class="signinboxinput" id="sec-college">
					<label>Current College Name</label>
					<input type="text"  id="college_name" class="form-control input-lg" placeholder="Enter College Name" />
					<input type="hidden" name="college_id" id="collegeId">
					<div id="collegeList">
					</div>
					<!-- select class="form-control" name="college_id" required>
						<option value="">--Select--</option>
					</select> -->
				</div>
				<div class="signinboxinput" id="sec-school" style="display: none">
					<label id="level_name"></label>
					<input type="text" class="form-control" name="coach_level_name">
				</div>
				
				<div class="signinboxinput2">
					<div class="genderlabel genderradiobox">
					<label>Gender of Sport Coaching</label>
					<div class="clr"></div>
					<p>
					<input type="radio" id="test2" name="gender_of_coaching" value="male" {{ old('gender_of_coaching') == 'male'? 'checked': ''}}>
					<label for="test2">Male</label>
					</p>
					<p>
					<input type="radio" id="test3" name="gender_of_coaching" value="female" {{ old('gender_of_coaching') == 'female'? 'checked': ''}} >
					<label for="test3">Female</label>
					</p>
					<p>
					<input type="radio" id="test4" name="gender_of_coaching" value="both" {{ old('gender_of_coaching') == 'both'? 'checked': ''}}  checked="">
					<label for="test4">Both</label>
					</p>
					</div>
					@if ($errors->has('gender_of_coaching'))
                        <span class="text-danger">{{ $errors->first('gender_of_coaching') }}</span>
                    @endif
				</div>
				<div class="clr"></div>
				 <div class="signinboxinput" id="sec-club" style="display: none">
					<label id="club_name">Club Name</label>
					<input type="text" class="form-control" name="club_name">
				</div> 
				<div class="clr"></div>
				<div class="signinboxinput2 genderlabel">
					<div class="">
					<label>Your Bio</label>
					<div class="clr"></div>
						<textarea class="yourbiotextarea" name="about" placeholder="Type here or copy and paste" required>{{old('about')}}</textarea>
					</div>
					@if ($errors->has('about'))
                        <span class="text-danger">{{ $errors->first('about') }}</span>
                    @endif
				</div>
				<div class="signinboxinput2 genderlabel">
					<div class="">
					<label>Your Bio Link</label>
					<div class="clr"></div>
						<input type="url" class="form-control" name="about_link" value="{{ old('about_link') }}" placeholder="http://">
					</div>
					@if ($errors->has('about_link'))
                        <span class="text-danger">{{ $errors->first('about_link') }}</span>
                    @endif
				</div>
				<div class="signinboxinput">
					<label>Contact Preference</label>
					<select class="form-control" name="preference_id" required>
						<option value="">--Select--</option>
					</select>
				</div>
				<div class="signinboxinput2">
					<div class="reference_checkright">
					<div class="form-group">
					<input type="checkbox" id="html" name="serve_as_reference" value="1"
							{{ old('serve_as_reference') == 1 ? 'checked' : '' }}
					>
					<label for="html"> &nbsp; Are you willing to serve as a reference?</label>
					</div>
					</div>
				</div>
				<div class="clr"></div>
				<!-------->
				<div class="signinboxinput">
					<label>Did you play the following sport you are coaching?</label>
					<select class="form-control" name="coaching_sport" onchange="getcoaching(this)" required>
						<option value="">--Select--</option>
						<option value="yes">Yes</option>
						<option value="no">No</option>
					</select>
				</div>
				
				<div class="signinboxinput2" id="level" style="display:none">
					<label>Level</label>
					<select class="form-control" name="sport_level" onchange="getlevel(this)" >
						<option value="">--Select--</option>
						<option value="Club">Club</option>
						<option value="High School">High School</option>
						<option value="College – Division 1">College – Division 1</option>
						<option value="College – Division 2">College – Division 2</option>
						<option value="College – Division 3">College – Division 3</option>
						<option value="Professional">Professional</option>


					</select>
				</div>
				<div class="signinboxinput" id="team" style="display: none">
					<label>Team Name</label>
					<input type="text" class="form-control" name="team_name">
				</div>
				<div class="clr"></div>
				<div class="signinboxinput">
					<label>Number of Years Coaching Youth Athletes</label>
					<select class="form-control" name="number_of_years" required>
						<option value="">--Select--</option>
						<?php for ($i=0; $i <=50 ; $i++) { ?>
						<option value="{{ $i }}">{{ $i }}</option>
						<?php } ?>
					</select>
				</div>
				<div class="signinboxinput2">
					<label>Primary Age Group You Currently Coach</label>
					<select class="form-control" name="primary_age_group" required>
						<option value="">--Select--</option>
						<option value="U6 to U9">U6 to U9</option>
						<option value="U10 to U13">U10 to U13</option>
						<option value="U14 to U19">U14 to U19</option>
						<option value="U21 and above">U21 and above</option>

						<option value="International Competition">International Competition(non-professional) </option>
						<option value="Collegiate">Collegiate</option>
						<option value="Professional">Professional</option>
					</select>
				</div>
				<div class="clr"></div>
			</div>
			<input type="submit" class="savecontinue" value="Save & continue"/>
			<a href="{{ URL::previous() }}" class="back">Back</a>
		</form>
	</div>
	<div class="clr"></div>
	@include('frontend.layouts.footer')
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
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

			}
			else{
				$('#sec-club').hide();
				var coach_level= $("#coach_level option:selected").text()+' Name';
			$('#level_name').text(coach_level);

			}
									
			console.log(option);
			if(option == '2'){
				$('#sec-school').hide();
				$('#sec-school .form-control').prop('required', false);
				$('#sec-college').show();
				$('#sec-college .form-control').prop('required', true);
			}else{
				$('#sec-school').show();
				$('#sec-school .form-control').prop('required', true);
				$('#sec-college').hide();
				$('#sec-college .form-control').prop('required', false);
			}

		})
		$.ajax({
            type : "GET",
            url : "{{ url('api/get-preference') }}",
            data : {},
            beforeSend: function(){
                //$("#overlay").fadeIn(300);
            },
            success: function(res){
                console.log(res);
                if(res.success){
                    res.data.forEach((v) => {
                        $('select[name="preference_id"]')
                        .append('<option value="'+v.id+'">'+v.name+'</option>');
                    })                    
                }
            },
            error: function(err){
                console.log(err);
            }
        }).done( () => {
            
        });

		//Club
		$.ajax({
            type : "GET",
            url : "{{ url('api/get-colleges') }}",
            data : {},
            beforeSend: function(){
                //$("#overlay").fadeIn(300);
            },
            success: function(res){
                console.log(res);
                if(res.success){
                    res.data.forEach((v) => {
                        $('select[name="college_id"]')
                        .append('<option value="'+v.id+'">'+v.name+'</option>');
                    })                    
                }
            },
            error: function(err){
                console.log(err);
            }
        }).done( () => {
            
        });
		//Sports
		$.ajax({
            type : "GET",
            url : "{{ url('api/get-sports') }}",
            data : {},
            beforeSend: function(){
                //$("#overlay").fadeIn(300);
            },
            success: function(res){
                console.log(res);
                if(res.success){
                	/*$("#sportId").select2({
                		maximumSelectionLength: 4
                	});*/
                    res.data.forEach((v) => {
                        $('select[name="sport_id[]"]')
                        .append('<option value="'+v.id+'">'+v.name+'</option>');
                    })                    
                }
            },
            error: function(err){
                console.log(err);
            }
        }).done( () => {
            
        });
    })

    $(document).ready(function(){

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
    					$('#collegeList').fadeIn();  
    					$('#collegeList').html(data);

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


    $(function () {
    $("#sportId").select2({
        maximumSelectionLength: 4,
        language: {
            maximumSelected: function (e) {
            var t = "You can select max " + e.maximum + " sport";
            e.maximum != 1 && (t += "s");
            return t ;
        }
    }
        
    });
});

    function getcoaching(dis){
    	var coaching_value= $(dis).val();
    	if(coaching_value=="yes"){
    		$('#level').show();
    		$('#level .form-control').prop('required', true);
    	}else{
    		$('#level').hide();
    		$('#level .form-control').prop('required', false);
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

    

</script>
@endsection