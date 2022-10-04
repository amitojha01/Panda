@extends('frontend.layouts.app')
@section('title', 'Registration | Athlete | Subscription')

@section('content')
<div class="">
    <div class="signinheader">
        <div class="signinheader_l">
            <a href="{{URL::to('/')}}">
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
				<li>Compare your workout to other athletes using multiple datasets and variables</li>
			</ul>
			<form method="post" action="">
				@csrf
			<div class="subcriptionrdiobox">
				<h2>$4.00</h2>
				<span>Per month</span>
				<div class="radioboxsub">
					<input type="radio" id="test1" name="radio_value"  value="1.99" >
					<label for="test1"></label>
				  </div>
			</div>
			<div class="subcriptionrdiobox">
				<h2>$24.99</h2>
				<span>Per year</span>
				<div class="radioboxsub">
					<input type="radio" id="test2" name="radio_value" value="20" >
					<label for="test2"></label>
				</div>
			</div>
			<div class="clr"></div>
			<div class="tremspanel">
				<div class="form-group">
				  <input type="checkbox" id="html">
				  <label for="html"></label>
				</div>
				<p>I agree to the PARC <a href="{{ route('terms-and-conditions') }}" target="_blank">Terms and Conditions</a> and <a href="{{ route('privacy-policy') }}" target="_blank">Privacy Policy</a></p>
			</div>
			<div align="center">
				<input type="button" id="plan_submit_btn" class="subcriptionbtn" value="Connect. Compare. Compete.">
			</div>
			</form>
			@if(Session::has('user'))
				<a class="skipfornow" href="{{ route('registration.athlete.skip-membership') }}">Skip for now</a>
			@endif
		</div>
		<div class="clr"></div>		
	</div>
    <div class="clr"></div>
    @include('frontend.layouts.footer')
</div>

<!-- Modal -->
<div class="modal fade" id="activatedlicence" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">      
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <div align="center">
			<img src="{{ asset('public/frontend/images/active_licence_icon.png') }}" alt="redmail_icon"/>
		</div>
        <h4>Activate License</h4>
        <span>Enter your 10 digit license code here to activate your license</span>
        <input type="text" placeholder=""/>       
        <div class="clr"></div>
        <input type="submit" class="verifymail" value="Activate"/>
      </div>      
    </div>
  </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
		
		$("#plan_submit_btn").click(function (){
			// alert('check');
			var userEmail = '<?php echo $userEmail ; ?>';

			var plan_details = $('input[name="radio_value"]:checked').val();
			// alert (plan_details);
			

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