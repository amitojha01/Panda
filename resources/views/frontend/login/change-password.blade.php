@extends('frontend.layouts.app')
@section('title', 'Reset Password')
@section('style')
<style>
  #validate-otp h2{
    font-size: 28px;
  }
  #validate-otp p{
    color: #4BFF00;
    font-size: 14px;
  }
</style>
@endsection
@section('content')
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
        <div class="signinbox" id="validate-otp">
            <h2>Validate Forgot Password OTP</h2>
            <p>Please don't press back button before complete the step.</p>
            <p class="text-info">Please enter your 4 digit OTP.</p>
            <form action="" id="frm-otp-validation" method="POST">
                @csrf
              <input type="text" id="otp" name="otp" minlength="4" maxlength="4" class="form-control" placeholder="1111" required />        
              <input type="submit" class="submitbtn" id="sub-btn" value="Submit"/>
          </form>
        </div>
        <div class="signinbox" id="reset-password" style="display: none">
            <h2>Reset Password</h2>            
            <form action="" id="update-password" method="POST">
                @csrf
              <input type="password" name="password" id="password" minlength="8" class="form-control" placeholder="****" required />       
              <input type="password" name="confirm_password" minlength="8" id="confirm_password" class="form-control" placeholder="*****" required />
              <input type="submit" class="submitbtn" id="sub-btn" value="Submit"/>
          </form>
        </div>
        <div class="clr"></div>
        <div class="signinfooter">
            <div class="signinfooter_l"><p>Copyright © {{date('Y')}} PARC Sports LLC All Rights Reserved.</p></div>
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
    $('#frm-otp-validation').submit(function(e){
      e.preventDefault();
      let otp = $('#otp').val();
      let email = localStorage.getItem('email');
      $.ajax({
          type : "POST",
          url : "{{ url('api/validate-otp') }}",
          data : {
            email: email,
            otp: otp,
          },
          beforeSend: function(){
              //$("#overlay").fadeIn(300);
          },
          success: function(res){
            if(res.success){
              swal(res.message, 'Success', 'success')
              .then((value) => {
                $('#validate-otp').hide();
                $('#reset-password').show();
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

    $('#update-password').submit(function(e){
      e.preventDefault();
      let email = localStorage.getItem('email');
      let password = $('#password').val();
      let confirm_password = $('#confirm_password').val();

      if(password != confirm_password){
        swal('Password & Confirm Password not matched', 'Warning', 'error');
        return false;
      }
      $.ajax({
          type : "POST",
          url : "{{ url('api/update-password') }}",
          data : {
            email: email,
            password: password,
          },
          beforeSend: function(){
              //$("#overlay").fadeIn(300);
          },
          success: function(res){
            if(res.success){
              swal(res.message, 'Success', 'success')
              .then((value) => {
                localStorage.clear();
                window.location.href = "{{ url('/login') }}"
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
  $('#resetpwdForm').submit(function() {
        var pwd= $('#pwd').val();
        var cpwd= $('#cpwd').val();
        if(pwd=="" || cpwd==""){
          $('#req').show();
          $('#mismatch').hide();
          $('#lengtherror').hide();
           return false;
        }
        if(pwd!=cpwd){
          $('#mismatch').show();
          $('#req').hide();
          $('#lengtherror').hide();
          return false;
        }
        if(pwd.length<8){
          $('#req').hide();
           $('#mismatch').hide();
           $('#lengtherror').show();
           return false;
        }
        
      });

</script>
@endsection