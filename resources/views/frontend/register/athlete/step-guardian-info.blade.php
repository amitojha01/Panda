@extends('frontend.layouts.app')
@section('title', 'Registration | Athlete | Guardian Information')
@section('style')
<style>
.text-danger{
    top: 72px;
}
.pr-60{
    padding-right: 60px !important;
}
</style>
@endsection
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
    <div class="signinbox createaccount2">
		<h2>Create Account</h2>
		<span>The guardian page if the user is 12 or under 12.
            <a><b>03</b>/06</a>
        </span>
		<h5>Guardian Info</h5>        
        <form id="frmRegistrationStep-1" method="post" action="{{ route('athlete.step-guardian', 'athlete') }}">
            @csrf
            <div class="signinbox">		
                <div class="signinboxinput3">
                    <label>Relationship</label>
                    <select class="form-control" name="relationship">
                        <option value="father">Father</option>
                        <option value="mother">Mother</option>
                        <option value="guardian">Guardian</option>
                        <option value="grand father">Grand Father</option>
                        <option value="grand mother">Grand Mother</option>
                        <option value="uncle">Uncle</option>
                        <option value="aunt">Aunt</option>
                        <option value="other">Other</option>
                    </select>
                    @if ($errors->has('relationship'))
                        <span class="text-danger">{{ $errors->first('relationship') }}</span>
                    @endif				
                </div>
                <div class="signinboxinput3">
                    <label>First Name</label>
                    <input  type="text"  value="{{ old('first_name') }}" class="form-control" name="first_name" value="{{ old('first_name') }}"> 
                    @if ($errors->has('first_name'))
                        <span class="text-danger">{{ $errors->first('first_name') }}</span>
                    @endif
                </div>
                <div class="signinboxinput3">
                    <label>Last Name</label>
                    <input  type="text"  value="{{ old('last_name') }}" class="form-control" name="last_name" value="{{ old('last_name') }}"> 
                    @if ($errors->has('last_name'))
                        <span class="text-danger">{{ $errors->first('last_name') }}</span>
                    @endif
                </div>
                <div class="row col-md-12">
                    <div class="">
                        <label style="padding-bottom:0;"><b>Please send me text messages</b>
                            <i class="fa fa-question-circle n-ppost" aria-hidden="true"></i>
                             <div class="n-ppost-msg">As the parent or guardian, we have enabled the system to give the parent the option to receive text messages when your child has activity on the account like “Follow” requests or “Chat” notifications.  At Panda Stronger, we take the security of children very seriously.  Panda Stronger will do our very best to protect children.  There is, however, no better control than a parent or guardian keeping abreast of the activity going on with their child’s account.  To receive text updates, please keep the button in the “on” position.</div>
                        </label>
                        <div class="form-group">
                            <input type="checkbox" name="enable_textmessage" id="toggle_1" class="chkbx-toggle" value="1" checked="">
                            <label for="toggle_1"></label>
                        </div>
                    </div>
                </div>
                <div class="signinboxinput3">
                    <label>Primary Phone </label>
                    <input  type="text"  value="{{ old('primary_phone') }}" class="form-control pr-60" name="primary_phone" value="{{ old('primary_phone') }}"> 
                    <div class="greentick" id="user-mobile" style="display: none">
                        <i class="fa fa-check" aria-hidden="true"></i>
                    </div>
                    <b class="verify" id="verify-mobile" data-toggle="modal" data-target="#verifyMobile">Verify</b>
                    @if ($errors->has('primary_phone'))
                        <span class="text-danger">{{ $errors->first('primary_phone') }}</span>
                    @endif
                </div> 
                <div class="signinboxinput3">
                    <label>Phone Type </label>
                    <select class="form-control" name="primary_phone_type">
                        <option value="mobile">Mobile</option>
                        <option value="other">Other</option>
                    </select>
                    @if ($errors->has('primary_phone_type'))
                        <span class="text-danger">{{ $errors->first('primary_phone_type') }}</span>
                    @endif
                </div> 
                <div class="signinboxinput3">
                    <label>Text </label>
                    <select class="form-control" name="is_primary_text">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                    @if ($errors->has('is_primary_text'))
                        <span class="text-danger">{{ $errors->first('is_primary_text') }}</span>
                    @endif
                </div>
                <div class="signinboxinput3">
                    <label>Secondary Phone </label>
                    <input  type="text"  value="{{ old('secondary_phone') }}" class="form-control" name="secondary_phone" value="{{ old('secondary_phone') }}"> 
                    @if ($errors->has('secondary_phone'))
                        <span class="text-danger">{{ $errors->first('secondary_phone') }}</span>
                    @endif
                </div> 
                <div class="signinboxinput3">
                    <label>Phone Type </label>
                    <select class="form-control" name="secondary_phone_type">
                        <option value="">Select</option>
                        <option value="mobile">Mobile</option>
                        <option value="other">Other</option>
                    </select>
                    @if ($errors->has('secondary_phone_type'))
                        <span class="text-danger">{{ $errors->first('secondary_phone_type') }}</span>
                    @endif
                </div> 
                <div class="signinboxinput3">
                    <label>Text </label>
                    <select class="form-control" name="is_secondary_text">
                        <option value="">Select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                    @if ($errors->has('is_secondary_text'))
                        <span class="text-danger">{{ $errors->first('is_secondary_text') }}</span>
                    @endif
                </div> 
                <div class="clr"></div>
                <div class="signinboxinput3">
                    <label>Primary Email </label>
                    <input type="email" value="{{ old('primary_email') }}" class="form-control pr-60" placeholder="" name="primary_email" value="{{ old('primary_email') }}"/>
                    <div class="greentick" id="user-email" style="display: none">
                        <i class="fa fa-check" aria-hidden="true"></i>
                    </div>
                    <p><b class="verify" id="verify-email">Verify</b></p>
                    @if ($errors->has('primary_email'))
                        <span class="text-danger">{{ $errors->first('primary_email') }}</span>
                    @endif
                </div>	
                

                <div class="{{ Request::segment(2) == 'coach' ? 'signinboxinput' : 'signinboxinput' }}">
                    <label><b>Do you want to make your athlete’s profile private</b>
                        <i class="fa fa-question-circle n-ppost" aria-hidden="true"></i>
                        <div class="private-msg">As the parent, you have the option to make your child’s profile public or private.  Private profiles are only viewable by people that you have allowed to “Follow” your child’s profile.  Public profiles are viewable by all Panda users.  The button below allows you to override your child’s choice to make the profile either public or private.  Additionally, in the Edit feature of the profile on the Dashboard, each user has the ability to display their email and phone number to people that are allowed to Follow their profile.  Please review with your child and make sure that you are comfortable with the decision to provide, or not provide, email and phone number when Follow requests are accepted.</div>
                    </label>
                    <div class="form-group togglepublicprivate">
                        <input type="checkbox" name="profile_type" id="toggle_2" class="chkbx-toggle" value="1" onchange="profileType(this)" >
                        <label for="toggle_2"></label>
                    </div>
                    <span id="ptype">Public</span>
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
                <span>Enter the 4 digit code that has been sent to your email address</span>
                <input type="text" id="txt-1" tabindex="0" class="otp" placeholder="" />
                <input type="text" id="txt-2" tabindex="1" class="otp" placeholder="" />
                <input type="text" id="txt-3" tabindex="2" class="otp" placeholder="" />
                <input type="text" id="txt-4" tabindex="3" class="otp" placeholder="" />
                <div class="clr"></div>
                <input type="button" class="verifymail" value="Verify Email" />
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="verifyMobile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">      
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <div align="center">
            <img src="{{ asset('public/frontend/images/redphone_icon.png') }}" alt="redmail_icon"/>
        </div>
        <span>Enter the 4 digit code that has been sent to your mobile number</span>
        <input type="text" placeholder=""/>
        <input type="text" placeholder=""/>
        <input type="text" placeholder=""/>
        <input type="text" placeholder=""/>
        <div class="clr"></div>
        <input type="submit" class="verifMobile" value="Verify Mobile"/>
      </div>      
    </div>
  </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){ 
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
                        $('select[name="education_id"]')
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

</script>

<script>
    var email_otp = '';

    $('#verify-mobile').on('click', function(){
        var phoneno = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
        let primary_phone = $('input[name="primary_phone"]').val();
        if(primary_phone.match(phoneno))
        {
            return true;
        }
        else{

        }
        console.log('mobile');
    })
    $('#verify-email').on('click', function(){
        var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        let email = $('input[name="primary_email"]').val();
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
                "verify_user": "other"
            },
            beforeSend: function(){
                //$("#overlay").fadeIn(300);
            },
            success: function(res){
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
            swal("Success", "Email verified successfully done.", "success");
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

</script>
@endsection