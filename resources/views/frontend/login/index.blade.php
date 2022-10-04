<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panda | Sign In</title>
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('public/fav.ico') }}"/>
    <link href="{{ asset('public/frontend/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('public/frontend/css/bootstrap-submenu.min.css') }}" rel="stylesheet" >
    <link href="{{ asset('public/frontend/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/css/theme.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/css/responsive.css') }}" rel="stylesheet">
  </head>
<body class="signin">
<div >
	<div class="signinheader">
		<div class="signinheader_l">
      <a href="{{URL::to('/')}}">
        <img src="{{ asset('public/frontend/images/signin_logo.png') }}" alt="signin_logo"/>
      </a>
    </div>
		<div class="signinheader_r">
			<span>Don't have an account? <a href="{{ route('registration') }}">Try Now</a></span>
		</div>
		<div class="clr"></div>
	</div>
	<div class="signinbox">
		<h2>Sign In</h2>
		<!-- <span>Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod</span> -->
    <form action="{{ route('login') }}" method="POST">
      @csrf
      <label>Username or Email</label>
      <input type="text" name="email" class="form-control" value="{{ old('email') }}" placeholder="iamsteve@gmail.com" required/>
      @if ($errors->has('email'))
          <span class="text-danger">{{ $errors->first('email') }}</span>
      @endif
      <label>Password</label>
      <input type="password" name="password" id="password-field" class="form-control" placeholder="**************" required/>
      <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password login_eye"></span>
      @if ($errors->has('password'))
          <span class="text-danger">{{ $errors->first('password') }}</span>
      @endif
      <a href="<?= url('forgot-password'); ?>">Forgot password?</a>
      <input type="submit" class="submitbtn" value="Login"/>
    </form>
	</div>
	<div class="clr"></div>
	<div class="signinfooter">
		<div class="signinfooter_l"><p>Copyright © 2021 PARC Sports LLC All Rights Reserved.</p></div>
		<div class="signinfooter_r">
			<ul>
				<li><a href="{{ route('terms-of-use') }}">Terms of Use</a></li>
				<li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
			</ul>
		</div>
	</div>
</div>

<script src="{{ asset('public/frontend/js/jquery.js') }}"></script>
<script src="{{ asset('public/frontend/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/frontend/js/theme1.js') }}"></script>

<!-- swal -->
<script src="{{ asset('public/admin/bundles/sweetalert/sweetalert.min.js') }}"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('public/admin/js/page/sweetalert.js') }}"></script>
<script>
  $(".toggle-password").click(function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
});
</script>
@if ($message = Session::get('error'))  
    <script>
    swal('{{ $message }}', 'Warning', 'error');
    </script>
@endif
@if ($message = Session::get('success'))  
    <script>
    swal('{{ $message }}', 'Success', 'success');
    </script>
@endif
</body>
</html>
