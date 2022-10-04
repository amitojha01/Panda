@extends('frontend.coach.layouts.app')
@section('title', 'Change Password')
@section('content')

<div class="videoevidance_panel">
	<div class="container-fluid">
			
			<form method="post" action="{{ route('coach.update-password', $user->id) }}" id="changePwdForm" enctype="multipart/form-data">
				@csrf	
				<div class="editprofilebox">
					<h2>Change Password</h2>
					<div class="row">
						<div class="col-md-4 col-sm-12 col-xs-12">
							<label>Password</label>
							<input type="text" id="password" name="new_password" class="form-control" placeholder=""/>
							<span id="validerr" style="color:red;display:none">Please enter valid password!!</span>
							<span id="passwordreq" style="color:red;display:none">Password field required!!</span>
							<span id="mismatch" style="color:red;display:none">Password and confirm password does not match!!</span>						
							
						</div>
						<div class="col-md-4 col-sm-12 col-xs-12">
							<label>Confirm Password</label>
							<input type="text" name="confirm_password" class="form-control" id="confirm_password" placeholder=""/>
						</div>
						<div class="col-md-12">
							<div class="signinboxinput PasswordCheckingCheckBox">
								<div class="form-group">
									<input type="checkbox" name="password" id="mp-upper">
									<label for="password1"> &nbsp; 1 Uppercase lette</label>
								</div>
								<div class="form-group">
									<input type="checkbox" name="password" id="mp-number">
									<label for="password2"> &nbsp; 1 Number</label>
								</div>
								<div class="form-group">
									<input type="checkbox" name="password" id="mp-lower">
									<label for="password3"> &nbsp; 1 Lowercase letter </label>
								</div>
								<div class="form-group">
									<input type="checkbox" name="password" id="mp-symbol">
									<label for="password4"> &nbsp; 1 Symbol</label>
								</div>
								<div class="form-group">
									<input type="checkbox" name="password" id="mp-len">
									<label for="password5"> &nbsp; 8 Characters minimum</label>
								</div>					
							</div>	
						</div>
					</div>
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

</script>
@endsection
