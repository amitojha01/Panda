@extends('frontend.layouts.app')
@section('title', 'Registration | Athlete | Subscription Payment')

@section('content')

<link href="https://js.recurly.com/v4/recurly.css" rel="stylesheet" type="text/css">
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
			<h3>Subscription Plan</h3>
			{{-- <span>Benefits Includes:</span>			
			<ul>
				<li>Build your dashboard/billboard to promote yourself to college coaches</li>
				<li>Connect with coaches</li>
				<li>Create unlimited TeamingUP groups</li>
				<li>Compare your workout to other athletes using multiple datasets and variables</li>
			</ul> --}}

			{{-- <h4 style="color:white;">Price : ${{ $plan_price }}</h4> --}}
			<h4 style="color:white;">Price : 20</h4>
			<form id="my-form">
				<input type="text" data-recurly="first_name">
				<input type="text" data-recurly="last_name">
			  
				<div id="recurly-elements">
				  <!-- Recurly Elements will be attached here -->
				</div>
			  
				<!-- Recurly.js will update this field automatically -->
				<input type="hidden" name="recurly-token" data-recurly="token">
			  
				<button>submit</button>
			</form>
			
			<div class="clr"></div>
			<div class="tremspanel">
				<div class="form-group">
				  <input type="checkbox" id="html">
				  <label for="html"></label>
				</div>
				<p>I agree to the PARC <a href="{{ route('terms-and-conditions') }}" target="_blank">Terms and Conditions</a> and <a href="{{ route('code-of-conduct') }}" target="_blank">Code of Conduct</a></p>
			</div>
			{{-- <div align="center">
				<input type="button" id="plan_submit_btn" class="subcriptionbtn" value="Payment">
			</div> --}}
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
<script src="https://js.recurly.com/v4/recurly.js"></script>
<script>
    $(document).ready(function(){
		//
		$("#plan_submit_btn").click(function (){
			alert('check');
			var plan_details = $('input[name="radio_value"]:checked').val();
			alert(plan_details);
		})
    })
</script>
<script>
	const elements = recurly.Elements();
	// const cardElement = elements.CardElement();
	

	const cardElement = elements.CardElement({
  inputType: 'mobileSelect',
  style: {
    fontSize: '1em',
    placeholder: {
      color: 'gray !important',
      fontWeight: 'bold',
      content: {
        number: 'Card number',
        cvv: 'CVC'
      }
    },
    invalid: {
      fontColor: 'red'
    }
  }
});
cardElement.attach('#recurly-elements');
</script>
@endsection