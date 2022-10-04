<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panda | Forgot Password</title>
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('public/fav.ico') }}"/>
    <link href="{{ asset('public/frontend/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('public/frontend/css/bootstrap-submenu.min.css') }}" rel="stylesheet" >
    <link href="{{ asset('public/frontend/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/css/theme.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/css/responsive.css') }}" rel="stylesheet">
    <style>
      .signinbox label{
        color: #fff;
      }
      .signinbox p{
        color: #4BFF00;
        font-size: 14px;
      }
    </style>
  </head>
<body>
<div class="signin forgetpwd">
  <div class="signinheader">
    <div class="signinheader_l">
      <a href="{{ url('/') }}">
        <img src="{{ asset('public/frontend/images/signin_logo.png') }}" alt="signin_logo"/>
      </a>
    </div>
    <div class="signinheader_r">
      <span>Don't have an account? <a href="{{ route('registration') }}">Try Now</a></span>
    </div>
    <div class="clr"></div>
  </div>
  <div class="signinbox">
    <h2>Forgot Password</h2>
    <div class="form-group">
        <label>Please select an option to receive your One Time Password(OTP) to reset your password : </label>
        <label style="display:inline-block;"><input type="radio" name="otp-option" value="email" checked> Email &nbsp; &nbsp;</label> 
        <label style="display:inline-block;"><input type="radio" name="otp-option" value="mobile" > Phone </label>
    </div>
    <form action="" id="frm-forgot-password" method="">
      @csrf
      <div class="form-group" id="c-email">
        <label>Email</label>
        <p>
          Enter the email address for your account. A verification code will be sent to you. Once you have received the verification code, you will be able to choose a new password for your account.
        </p>
        <!-- <input type="email" name="email" onkeyup="checkEmail(this)" id="email" class="form-control" value="{{ old('email') }}" placeholder="iamsteve@gmail.com" required/> -->
        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="iamsteve@gmail.com" required/>
        <span id="existemail" style="color:red; display:none ">Email Id not Exist!!</span>
      </div>
      <div class="form-group" id="c-mobile" style="display: none">
        <label>Mobile</label>
        <p>
        Enter the Mobile Number for your account. A verification code will be sent to you. Once you have received the verification code, you will be able to choose a new password for your account.
        </p>
        <!-- <input type="email" name="email" onkeyup="checkEmail(this)" id="email" class="form-control" value="{{ old('email') }}" placeholder="iamsteve@gmail.com" required/> -->
        <input type="tel" name="mobile" id="mobile" class="form-control" value="{{ old('mobile') }}" placeholder="965874512"/>
      </div>      
      <button type="submit" class="submitbtn"  id="sub-btn">Submit</button>
    </form>
  </div>
  <div class="clr"></div>
  <div class="signinfooter">
    <div class="signinfooter_l"><p>Copyright © 2021 PARC Sports LLC All Rights Reserved.</p></div>
    <div class="signinfooter_r">
      <ul>
        <li><a href="">Terms of Use</a></li>
        <li><a href="">Privacy Policy</a></li>
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

$(document).ready(function(){
  //select opt option phone or email
  $('input[name="otp-option"]').on('click', function(){
      $('#frm-forgot-password .form-group').hide();
      $('#frm-forgot-password input').val('');
      $('#frm-forgot-password input').prop('required', false);
      $('#frm-forgot-password #c-'+$(this).val()).show();
      $('#frm-forgot-password #'+$(this).val()).prop('required', true);
  })
  $('#frm-forgot-password').submit(function(e){
    e.preventDefault();
    let option = $('input[name="otp-option"]:checked').val();
    if(option == "mobile"){
      swal('Please Try with email only', 'Warning', 'error');
      return false;
    }
    var email = $('#email').val();
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    if(!emailReg.test( email )){
      swal('Please provide a valid email', 'Warning', 'error');
      return false;
    }
    $.ajax({
        type : "POST",
        url : "{{ url('api/forgot-password') }}",
        data : {
          email: email
        },
        beforeSend: function(){
            //$("#overlay").fadeIn(300);
        },
        success: function(res){
          if(res.success){
            swal(res.message, 'Success', 'success')
            .then((value) => {
              console.log('location');
              localStorage.setItem('email', email);
              window.location.href = "{{ url('/reset-password') }}"
            });
          }else{
            swal(res.message, 'Warning', 'error');
          }
        },
        error: function(err){
            console.log(err);
        }
    }).done( () => {
          
    });
  })
})


  function checkEmail(dis){
    var email = $(dis).val();
    //alert(email);
    if(email==""){
        $('#req').show();
        $('#existemail').hide();
        $("#sub-btn"). attr("disabled", true);
    }
    if( !validateEmail(email)){
      $('#existemail').hide();
      $('#invalidemail').show();
      $("#sub-btn"). attr("disabled", true);
    }else{
      $('#invalidemail').hide();
      $("#sub-btn"). attr("disabled", false);
    $.ajax({
        url:"{{url('check-email')}}",
        type: "GET",
        data: {
            email: email,
            _token: '{{csrf_token()}}'
        },
        dataType : 'json',
        success: function(result){
            if(result==1){
                $('#existemail').hide();
                $('#req').hide();
                  $("#sub-btn"). attr("disabled", false);
            }else{
                $('#existemail').show();
                $('#req').hide();
                  $("#sub-btn"). attr("disabled", true);
                  return false;
            }
        }
    });
  }
}

function validateEmail($email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  return emailReg.test( $email );
}
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
