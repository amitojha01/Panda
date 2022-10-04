@extends('frontend.layouts.coach')
@section('title', 'Registration | Coach | Subscription')

@section('content')
<div class="">
    <div class="signinheader">
        <div class="signinheader_l">
            <a href="">
                <img src="{{ asset('public/frontend/images/signin_logo.png') }}" alt="signin_logo" />
            </a>
        </div>
        <!-- <div class="signinheader_r">
            <span>Don't have an account? <a href="">Try Now</a></span>
        </div> -->
        <div class="clr"></div>
    </div>
    <div class="subcriptionbox">
		<div class="subcriptionbox_l">
			<div align="center">
                <img src="{{ asset('public/frontend/images/greentick.png') }}" alt="greentick"/>
            </div>
			<h3>Congratulations!</h3>
			<h6>Your basic profile has been successfully created</h6>
			<!-- <div class="activelicense">
				<h4>Activate License</h4>
				<p>If your Club or School purchased a license for you, enter your code here to activate your license.</p>
				<a href="javascript:void(0);" data-toggle="modal" data-target="#activatedlicence"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
			</div> -->
		</div>
		<div class="subcriptionbox_r">
			<h3>Subscription</h3>
			<span>Benefits Includes:</span>			
			<ul>
				<li>Build your dashboard/billboard to promote yourself to college coaches</li>
				<li>Connect with coaches</li>
				<li>Create unlimited TeamingUP groups</li>
				<li>Compare your workout to other coaches using multiple datasets and variables</li>
			</ul>
			
			<div class="subcriptionrdiobox">
				<h2>$4.00</h2>
				<span>Per month</span>
				<div class="radioboxsub">
					<input type="radio" id="test1" name="radio_value" value="1.99">
					<label for="test1"></label>
				  </div>
			</div>
			<div class="subcriptionrdiobox">
				<h2>$24.99</h2>
				<span>Per year</span>
				<div class="radioboxsub">
					<input type="radio" id="test2" name="radio_value" value="20" checked>
					<label for="test2"></label>
				  </div>
			</div>
			<div class="clr"></div>
			<div class="tremspanel">
				<div class="form-group">
				  <input type="checkbox" id="html">
				  <label for="html"></label>
				</div>
				<p>I agree to the PARC <a href="{{ route('terms-of-use') }}" target="_blank">Terms and Conditions</a> and <a href="{{ route('privacy-policy') }}" target="_blank">Privacy Policy</a></p>
			</div>
			<div align="center"><input type="submit" id="plan_submit_btn" class="subcriptionbtn" value="Connect. Compare. Compete."></div>
			@if(Session::has('user'))
				<a class="skipfornow" href="{{ route('registration.coach.skip-membership') }}">Skip for now</a>
			@endif
		</div>
		<div class="clr"></div>		
	</div>
    <div class="clr"></div>
    <div class="signinfooter">
        <div class="signinfooter_l">
            <p>Copyright © {{date('Y')}} PARC Sports LLC All Rights Reserved.</p>
        </div>
        <div class="signinfooter_r">
            <ul>
                <li><a href="">Terms of Use</a></li>
                <li><a href="">Privacy Policy</a></li>
            </ul>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
		//
    })
</script>
<script>
    $(document).ready(function(){
		
		$("#plan_submit_btn").click(function (){
			// alert('check');
			var userEmail = '<?php echo $userEmail ; ?>';

			var plan_details = $('input[name="radio_value"]:checked').val();
			//alert (plan_details);
			

			if(plan_details == "1.99"){
				var planName = "12monthbilling";
			}
			else if(plan_details == "20"){
				var planName = "1yearsubscription";
			}
			else{
				swal({
				text: "Please Select Subcription Plan !",
				icon: "warning",
				dangerMode: true,
				});

				return true;
			}
			

			if( plan_details == ''){
				swal({
                text: "Please Select Subcription Plan !",
                icon: "warning",
                dangerMode: true,
				})
				
			}
			if($("#html").prop('checked') == false){
				swal({
                text: "please check terms and conditions!",
                icon: "warning",
                dangerMode: true,
				})
				return false;
				
			}
			else{

				window.location.href = "https://pandastronger.recurly.com/subscribe/"+ planName +"?first_name=&last_name=&email="+userEmail;
			}
		});
    });
</script>
@endsection