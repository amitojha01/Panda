@extends('frontend.layouts.app')
@section('title', 'Registration | Basic Information')

@section('content')
<div>
    <div class="signinheader">
        <div class="signinheader_l"><a href="{{URL::to('/')}}">
                <img src="{{ asset('public/frontend/images/signin_logo.png') }}" alt="signin_logo" /></a></div>
        <!-- <div class="signinheader_r">
            <span>Don't have an account? <a href="">Try Now</a></span>
        </div> -->
        <div class="clr"></div>
    </div>
    <div class="signinbox createaccount2">
        <h2>Create Account</h2>
        <span>
            <a><b>01</b>/06</a>
        </span>
        <h5>Basic Information</h5>
        <form id="frmRegistrationStep-1" method="post" action="{{ route('registration.step-one', $type) }}">
            @csrf
            <div class="signinbox">
                <div class="signinboxinput">
                    <label>Username</label>
                    <input type="text" class="form-control" placeholder="Stevesmith007" name="username"  value="{{ old('username') }}"/>
                    <div class="greentick"  id="user-name" style="display: none">
                        <i class="fa fa-check" aria-hidden="true"></i>
                    </div>
                    @if ($errors->has('username'))
                        <span class="text-danger">{{ $errors->first('username') }}</span>

                    @endif
                </div>
                <div class="signinboxinput2">
                    <label>Create Password</label>
                    <input id="password-field" type="password" value="{{ old('password') }}" class="form-control" placeholder="***" onkeyup="checkPassword(this)" name="password" value="">
                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    

                     <!-- <span class="text-danger" id="pwdErr" style="padding:10px; font-size:12px; display:none; ">password must be atleast 8 character and alpha numeric</span> -->
                     <span class="text-danger" id="pwdErr" style="padding:10px; font-size:12px; display:none; ">Must be 8 characters long with 1 capital letter, and at least 1 alpha numeric and 1 special character</span>         
                     

                      
                    @if ($errors->has('password'))
                        <span class="text-danger" id="pwdReq" style="padding:10px;">{{ $errors->first('password') }}</span>
                    @endif
                </div> 

                <div class="signinboxinput">
                    <label>Email</label>
                    
                    <input type="email" name="email" id="regEmail" value="{{ old('email') }}" class="form-control reg-verify" placeholder="iamsteve@gmail.com" />
                    <div class="greentick" id="user-email" style="display: none">
                        <i class="fa fa-check" aria-hidden="true"></i>
                    </div>
                    <p><b class="verify" id="verify-email">Verify</b></p>
                    @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                    @if ($errors->has('email_verification'))
                        <span class="text-danger">{{ $errors->first('email_verification') }}</span>
                    @endif
                </div>
                <div class="signinboxinput2">
                    <label>Mobile</label>
                    <b style="position: absolute; color: #fff;  top: 38px;
                    ">+1</b>   <input type="text" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" name="mobile" value="{{ old('mobile') }}" id="mobilenum" maxlength="11" class="form-control reg-verify" placeholder="123 456 7890" style="padding-left:23px;"/>

                    <div class="greentick" id="user-mobile" style="display: none">
                        <i class="fa fa-check" aria-hidden="true"></i>
                    </div>

                     <!-- <b class="verify" id="verify-mobile" data-toggle="modal" data-target="#verifyMobile" onclick="sendOtp()" disabled>Verify</b> --> 
                     <p><b class="verify" id="verify-mobile" onclick="sendOtp()">Verify</b></p>
                    @if ($errors->has('mobile'))
                        <span class="text-danger" style="padding:0;">{{ $errors->first('mobile') }}</span>
                    @endif
                </div>
                <div class="signinboxinput genderlabel">
                    <label>Gender</label>
                    <p>
                        <input type="radio" id="test1" name="gender" {{old('gender') == 'male' ? 'checked' : ''}} value="male" checked>
                        <label for="test1">Male</label>
                    </p>
                    <p>
                        <input type="radio" id="test2" name="gender" {{old('gender') == 'female' ? 'checked' : ''}} value="female">
                        <label for="test2">Female</label>
                    </p>
                   <!--  <p>
                        <input type="radio" id="test3" name="gender" {{old('gender') == 'natural' ? 'checked' : ''}} value="natural">
                        <label for="test3">Neutral</label>
                    </p> -->
                </div>
                @if(Request::segment(2) != 'coach')                
                <div class="signinboxinput">
                    <label>Birth Month</label>
                    
                    <select class="form-control" name="month">
                        <option value="">Select Month</option>
                        @for($i=1; $i<=12; $i++)
                        <option value="{{ $i }}"
                        {{old('month') == $i ? 'selected' : ''}}
                        >{{ $i }}</option>
                        @endfor
                    </select>
                    @if ($errors->has('month'))
                        <span class="text-danger">{{ $errors->first('month') }}</span>
                    @endif
                </div>
                <div class="signinboxinput2">
                    <label>Birth Day</label>
                    <!-- <input type="number" name="date_of_year" value="{{ old('date_of_year') }}" min="1940" max="2016" step="1" class="form-control" placeholder="YYYY" /> -->
                    <select class="form-control" name="day">
                        <option value="">Select Day</option>
                        <?php
                            for($i=1; $i<=31; $i++){
                                ?>
                                <option value="{{ $i }}"
                                    {{old('day') == $i ? 'selected' : ''}}
                                >{{ $i }}</option>
                                <?php
                            }
                        ?>
                    </select>
                    @if ($errors->has('day'))
                        <span class="text-danger">{{ $errors->first('day') }}</span>
                    @endif
                </div>
                <div class="signinboxinput">
                    <label>Birth Year</label>
                    <!-- <input type="number" name="date_of_year" value="{{ old('date_of_year') }}" min="1940" max="2016" step="1" class="form-control" placeholder="YYYY" /> -->
                    <select class="form-control" name="year">                        
                        <option value="">Select Year</option>
						@for($i= Date('Y')-5; $i>=1940; $i--)
                        <option value="{{ $i }}"
                        {{old('year') == $i ? 'selected' : ''}}
                        >{{ $i }}</option>
                        @endfor					                    
                    </select>
<!--                    <b class="verify cal"><i class="fa fa-calendar" aria-hidden="true"></i></b>-->
                    @if ($errors->has('year'))
                        <span class="text-danger">{{ $errors->first('year') }}</span>
                    @endif
                </div>
                <div class="signinboxinput2">
                    <label>High School Graduation Year</label>
                    <select class="form-control" name="graduation_year">                        
                        <option value="">Select Year</option>
                        @for($i= Date('Y')+10; $i>=Date('Y')-50; $i--)
                        <option value="{{ $i }}"
                        {{old('graduation_year') == $i ? 'selected' : ''}}
                        >{{ $i }}</option>
                        @endfor                                     
                    </select>

                    @if ($errors->has('graduation_year'))
                        <span class="text-danger">{{ $errors->first('graduation_year') }}</span>
                    @endif
                </div>
                @endif
                <div style="position:relative;" class="{{ Request::segment(2) == 'coach' ? 'signinboxinput' : 'signinboxinput' }}">
                    <label>Want to make your profile private 
                        <i class="fa fa-question-circle n-ppost" aria-hidden="true"></i>
                         <div class="n-ppost-msg">A public profile means that any other Panda Athlete or Coach can see your profile information.  A public profile makes you more visible to college coaches. We set the default at registration to a profile is public.  By selecting the button and moving it to the right, you will make your profile private.  A private profile can only be viewed by another Panda Athlete or Coaches if you agree to let them follow your profile.You can always change this option in your Edit Profile function on your Dashboard.</div>
                    </label>
                    
                    <div class="form-group togglepublicprivate">
                        <input type="checkbox" name="profile_type" id="toggle_1" class="chkbx-toggle" value="1" onchange="profileType(this)" >
                        <label for="toggle_1"></label>
                    </div>
                    <span id="ptype">Public</span>
                </div>

                <div class="{{ Request::segment(2) == 'coach' ? 'signinboxinput' : 'signinboxinput' }}">
                    <label>Allow people that follow your profile to see your email and mobile number? 
                        <i class="fa fa-question-circle n-ppost" aria-hidden="true"></i>
                         <div class="n-ppost-msg">If you accept a follow request from another Panda Athlete or Panda Coach, having the default button to the right, will allow them to see your mobile number and email address once you are connected.   If you do not want this information visible even after a follow request is accepted, push the toggle button to the left.  You can always change or update this option in your Edit Profile function on your Dashboard.</div>
                    </label>
                    <div class="form-group">
                        <input type="checkbox" name="contact_email" id="toggle_2" class="chkbx-toggle" value="1" checked>
                        <label for="toggle_2"></label>
                    </div>
                </div>


                <div class="clr"></div>
            </div>
            <input type="hidden" name="is_mail_verified" id="is_mail_verified" value="0">
            <input type="submit" class="savecontinue" value="Save & continue" />
            <a href="{{ URL::previous() }}" class="back">Back</a>
        </form>
    </div>
    <div class="clr"></div>
    @include('frontend.layouts.footer')
</div>

<!-- Modal -->
<div class="modal fade" id="verifyemail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div align="center">
                    <img src="{{ asset('public/frontend/images/redmail_icon.png') }}" alt="redmail_icon" />
                </div>
                <input type="hidden" id="emailAdd" value="">
                <span>Enter the 4 digit code that has been sent to your email address</span>
                <input type="text" id="txt-1" tabindex="0" class="otp" placeholder="" />
                <input type="text" id="txt-2" tabindex="1" class="otp" placeholder="" />
                <input type="text" id="txt-3" tabindex="2" class="otp" placeholder="" />
                <input type="text" id="txt-4" tabindex="3" class="otp" placeholder="" />
                <div class="clr"></div>
                <input type="button" class="verifymail" value="Verify Email" />
                <input type="button" class="resendmail" onclick="resendMailOtp()" value="Resend otp" />
                <span id="resendotp" style="color:red; display:none" >Otp sent to you email address!!</span>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="verifyMobile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">      
      <div class="modal-body">
        <button type="button" class="close" id="closemodal" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <div align="center">
            <img src="{{ asset('public/frontend/images/redphone_icon.png') }}" alt="redmail_icon"/>
        </div>
        <input type="hidden" id="mobileNumber" value="">
        
        <span>Enter the 4 digit code that has been sent to your mobile number</span>
        <input type="text" placeholder="" id="first_digit" class="mobile-otp" tabindex="0" />
        <input type="text" placeholder="" id="sec_digit" class="mobile-otp" tabindex="1"/>
        <input type="text" placeholder="" id="third_digit" class="mobile-otp" tabindex="2"/>
        <input type="text" placeholder="" id="fourth_digit" class="mobile-otp" tabindex="3"/>
        
        <div class="clr"></div>
        <input type="submit" class="verifMobile" value="Verify Mobile" onclick="verify_mobile()"/>
      </div>      
    </div>
  </div>
</div>
@endsection
@section('script')
<script>
    var email_otp = '';
$(".toggle-password").click(function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
});

$('#verify-mobilezz').on('click', function(){
    var phoneno = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
    let mobile = $('input[name="mobile"]').val();
    if(mobile == "")
    {
        swal("Alert", "Mobile number is required to verify", "error");
        return false;
    }
    
    console.log('mobile');
})
$('#verify-email').on('click', function(){
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    let email = $('input[name="email"]').val();
    $('#emailAdd').val(email);
    if(email == "")
    {
        swal("Alert", "Email is required to verify", "error");
        return false;
    }
    if(!email.match(mailformat))
    {
        swal("Alert", "Email format is not matched", "error");
        return false;
    }
    $.ajax({
        type : "POST",
        url : "{{ url('api/registration/verify-email') }}",
        data : {
            "email": email,
            "_token": "{{ csrf_token() }}",
            "verify_user": "user"
        },
        beforeSend: function(){
            //$("#overlay").fadeIn(300);
        },
        success: function(res){
            if(res.success== false){
                swal("Alert", "Sorry!! Email is already registered", "error");
                return false;
            }
            if(res.success){
                email_otp = atob(res.data.otp);
                $('#verifyemail').modal('show');
            }
        },
        error: function(err){
            console.log(err);
        }
    }).done( () => {
        
    });
})

$('input[class="otp"]').on('keyup', function(){
    let v = $(this).val();
    if(isNaN(v)){
        $(this).val('');
    }
    if(v > 9){
        $(this).val($(this).val().substr($(this).val().length-1, 1));
    }
    if(!isNaN(v)){
        let t = $(this).prop('tabindex');
        $('input[tabindex="'+(t+1)+'"]').focus();
    }
})

$('.verifymail').on('click', function(){
    let input_otp = '';
    //var otp
    $('input[class="otp"]').each(function(){
        if( $(this).val() != ""){
        input_otp = input_otp + $(this).val();
        }
    })
    if(input_otp.length < 4){        
        swal("Alert", "Please enter a valid 4 digits OTP", "error");
        return false;
    }
    if(input_otp == email_otp){
        console.log(input_otp.length);
        $('#verifyemail').modal('hide');
        $('input[name="is_mail_verified"]').val(1);

        swal("Success", "Email verification successfully done.", "success");
    
        $('#verify-email').hide();
        $('#user-email').show();
    }else{
        swal("Alert", "OTP not matched", "error");
        return false;
    }
})


function profileType(dis){    
    var ptype= $('#ptype').text();
    
    if(ptype=="Private")
    {
        $('#ptype').text('Public');
    }else{
      $('#ptype').text('Private');
  }

}
//==Send otp===
function sendOtp(){
    var mobile= $('#mobilenum').val(); 
    //var phoneno = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
    if(mobile==""){
        
     swal("Alert", "Mobile number is required to verify", "error");
     $('#closemodal').trigger('click');
     $("#verifyMobile").modal('hide');
  
     return false;
    }
        if(mobile.length<10)
     {
       swal("Alert", "Please enter valid mobile number", "error");
        return false;
    }

    else{
        $("#verifyMobile").modal('show');
        var num_with_code= '1'+mobile;
        $('#mobileNumber').val(num_with_code);
        $.ajax({
            url:"{{url('sendSMS')}}",
            type: "GET",
            data: {
                mobile:num_with_code,
                _token: '{{csrf_token()}}' 
            },
            dataType : 'json',
            success: function(result){
                $('#verifyMobile').show();
                console.log(result);
            }
        });
    }

}

    $('input[class="mobile-otp"]').on('keyup', function(){
    let v = $(this).val();
    if(isNaN(v)){
        $(this).val('');
    }
    if(v > 9){
        $(this).val($(this).val().substr($(this).val().length-1, 1));
    }
    if(!isNaN(v)){
        let t = $(this).prop('tabindex');
        $('input[tabindex="'+(t+1)+'"]').focus();
    }
})

    function verify_mobile(){

        var mobileNumber= $('#mobileNumber').val();
        var first_digit = $('#first_digit').val();
        var sec_digit = $('#sec_digit').val();
        var third_digit = $('#third_digit').val();
        var fourth_digit = $('#fourth_digit').val();
        var mobile_otp= first_digit+sec_digit+third_digit+fourth_digit;

         $.ajax({
            url:"{{url('verify-mobile-otp')}}",
            type: "GET",
            data: {
                mobileNumber: mobileNumber,
                mobile_otp: mobile_otp,
                _token: '{{csrf_token()}}' 
            },
            dataType : 'json',
            success: function(result){
                console.log(result);
                if(result==1){                    
                    $('#mobilegreentick').show();
                    $('#closemodal').trigger('click');
                    swal("Success", "Mobile verification successfully done.", "success");
                    $('#verify-mobile').hide();
                    $('#user-mobile').show();
                }else{
                     swal("Alert", "OTP not matched", "error");
                     return false;                     

                }

            
            }
        });
    }

    /* $('#frmRegistrationStep-1').on('submit', function() {
        if($('#is_mail_verified').val()==0 && $('#regEmail').val()!=""){
        
         swal("Please verify your email address", '', "warning");
         return false;
     }
     });*/

     function resendMailOtp(){
        var email= $('#emailAdd').val();       
        $.ajax({
        type : "POST",
        url : "{{ url('api/registration/verify-email') }}",
        data : {
            "email": email,
            "_token": "{{ csrf_token() }}",
            "verify_user": "user"
        },
        beforeSend: function(){
            //$("#overlay").fadeIn(300);
        },
        success: function(res){            
            if(res.success){
                email_otp = atob(res.data.otp);
                $('#resendotp').show();
               // $('#verifyemail').modal('show');
            }
        },
        error: function(err){
            console.log(err);
        }
    }).done( () => {
        
    });

     }

     function checkPassword(dis){
        var special = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
        var upr = /[A-Z]/;
        var lwr = /[a-z]/;
        var number = /[0-9]/;

        var inputs = $(dis).val();

        if(special.test(inputs) && upr.test(inputs) && lwr.test(inputs) && number.test(inputs) && inputs.length >= 8){                       
            $('#pwdErr').hide();
            $(".savecontinue").removeAttr("disabled");
        }else{
         $('#pwdErr').show();
         $('#pwdReq').hide();
         $('.savecontinue').attr("disabled", "disabled")
     }
     

        
     }

</script>
@endsection