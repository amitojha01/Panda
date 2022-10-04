@extends('frontend.layouts.app')
@section('title', 'Registration | Athlete | Physical Information')

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
		<span>
            <a><b>03</b>/06</a>
        </span>
		<h5>Physical Information</h5>        
        <form id="frmRegistrationStep-1" method="post" action="{{ route('registration.athlete.step-two') }}">
            @csrf
            <div class="signinbox">		
                <div class="signinboxinput">
                    <label>Height</label>
                    <div class="row">
                        <div class="col-md-6">
                            <span class="heightinchlabel">Feet</span>
                             <input type="text" onkeypress="return validateFloatKeyPress(this,event);" class="form-control" placeholder="" name="height_feet"/>
                        <!-- @if ($errors->has('height_feet'))
                            <span class="text-danger">{{ $errors->first('height_feet') }}</span>
                        @endif -->    
                        </div>
                          
                        <div class="col-md-6">
                             <span class="heightinchlabel">Inch.</span>
                            <input type="text" onkeypress="return validateFloatKeyPress(this,event);" min="0"  value="{{ old('height_inch') }}" class="form-control" placeholder="" name="height_inch"/>
                        <!-- @if ($errors->has('height_inch'))
                        <span class="text-danger">{{ $errors->first('height_inch') }}</span>
                        @endif -->
                        </div>
                    </div>	
                    @if ($errors->has('height_inch'))
                            <span class="text-danger">{{ $errors->first('height_inch') }}</span>
                        @endif 	
                </div>
                <div class="signinboxinput2">
                    <label>Weight</label>
                    <input  type="text" onkeypress="return validateFloatKeyPress(this,event);" min="1" step=".01" value="{{ old('weight') }}" class="form-control" name="weight"> 
                    <select class="weightselectdropdown">
                        <option>LBS</option>
                    </select>
                    @if ($errors->has('weight'))
                        <span class="text-danger">{{ $errors->first('weight') }}</span>
                    @endif
                </div>
                <div class="signinboxinput">
                    <label>Wingspan <i class="fa fa-info-circle n-ppost" aria-hidden="true"></i>
                     <div class="n-ppost-msg">With your hands fully extended to your sides and stretched as far as possible, wingspan is the measure of distance from middle fingertip to middle fingertip.  The measure is in feet and inches.  In general, your wingspan should be pretty close to the same as your height, plus or minus.You can always change or update this detail in your Edit Profile function on your Dashboard.</div>
                 </label>
                   
                <div class="row">
                    <div class="col-md-6">                        
                        <span class="heightinchlabel">Feet</span>
                        <input type="text" onkeypress="return validateFloatKeyPress(this,event);" min="1" step=".01" value="{{ old('wingspan_feet') }}" class="form-control" placeholder="" name="wingspan_feet"/>
                        @if ($errors->has('wingspan_feet'))
                            <span class="text-danger">{{ $errors->first('wingspan_feet') }}</span>
                        @endif
                    </div>
                    
                    <div class="col-md-6">
                        <span class="heightinchlabel">Inch.</span>
                        <input type="text" onkeypress="return validateFloatKeyPress(this,event);" value="{{ old('wingspan_inch') }}" class="form-control" placeholder="" name="wingspan_inch"/>
                        @if ($errors->has('wingspan_inch'))
                            <span class="text-danger">{{ $errors->first('wingspan_inch') }}</span>
                        @endif 
                        </div>                    
                </div>
                </div>
                <div class="signinboxinput2">
                    <label>Hand Measurement <i class="fa fa-info-circle n-ppost" aria-hidden="true"> 

                    </i>
                    <div class="n-ppost-msg">For this measurement, you are presenting the width of your hand.  To measure, expand your fingers as wide as they can go.  With your fingers fully extended, measure from the tip of our thumb to the tip of your pinky.  The measure is in inches.  You can always change or update this detail in your Edit Profile function on your Dashboard.</div>

                    </label>
                    
                    <span class="heightinchlabel">Inch.</span>
                    <input type="text" onkeypress="return validateFloatKeyPress(this,event);" min="1" step=".01" value="{{ old('head') }}" class="form-control" placeholder="" name="head"/>
                    @if ($errors->has('head'))
                        <span class="text-danger">{{ $errors->first('head') }}</span>
                    @endif
                </div>
                <div class="signinboxinput">
                    <label>Dominant Hand </label>
                    
                    <select class="form-control" name="dominant_hand">
                        <option value="">Select </option>
                    </select>
                    @if ($errors->has('dominant_hand'))
                        <span class="text-danger">{{ $errors->first('dominant_hand') }}</span>
                    @endif
                </div>

                <div class="signinboxinput2">
                    <label>Dominant Foot </label>
                    
                    <select class="form-control" name="dominant_foot">
                        <option value="">Select </option>
                    </select>
                    @if ($errors->has('dominant_foot'))
                        <span class="text-danger">{{ $errors->first('dominant_foot') }}</span>
                    @endif
                </div>
                <div class="clr"></div>


               
                <h5>Other Information</h5>
                <div class="signinboxinput otheringobottoml">
                    <label>Current Education Level</label>
                    <select class="form-control" name="education_id" >
                        <option value="">Select Education</option>
                    </select>
                    @if ($errors->has('education_id'))
                        <span class="text-danger">{{ $errors->first('education_id') }}</span>
                    @endif
                </div>
                <div class="signinboxinput2 otheringobottomr">
                    <label>Grade Point Average (GPA)  
                         &nbsp; &nbsp;<input type="checkbox" onchange="gradecheck(this)"/> Check if not applicable
                    </label>
                  
                    <input type="text" onkeypress="return validateFloatKeyPress(this,event);" max="100" min="1" step=".01" value="{{ old('grade') }}" class="form-control" placeholder="" name="grade" required/>
                    @if ($errors->has('grade'))
                        <span class="text-danger">{{ $errors->first('grade') }}</span>
                    @endif
                </div>	
                <div class="clr"></div>
            </div>		
            <input type="submit" class="savecontinue" value="Save & continue"/>
           <!--  <a href="{{ URL::previous() }}" class="back">Back</a> -->
        </form>
	</div>
    <div class="clr"></div>
    @include('frontend.layouts.footer')
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){ 
        $.ajax({
            type : "GET",
            url : "{{ url('api/get-education-level') }}",
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

        //Dominant List
        $.ajax({
            type : "GET",
            url : "{{ url('api/registration/athlete/dominant') }}",
            data : {},
            beforeSend: function(){
                //$("#overlay").fadeIn(300);
            },
            success: function(res){
                console.log(res);
                if(res.success){
                    res.data.forEach((v) => {
                        $('select[name="dominant_hand"]')
                        .append('<option value="'+v.name+'">'+v.name+'</option>');

                        $('select[name="dominant_foot"]')
                        .append('<option value="'+v.name+'">'+v.name+'</option>');

                        
                    })                    
                }
            },
            error: function(err){
                console.log(err);
            }
        }).done( () => {
            
        });


    })

    function gradecheck(dis){
        if($(dis).is(':checked')){
            $("input[name=grade]").removeAttr('required');

        }else{
           $("input[name=grade]").prop('required',true);

        }
    }

    function validateFloatKeyPress(el, evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        var number = el.value.split('.');
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
    //just one dot (thanks ddlab)
    if(number.length>1 && charCode == 46){
       return false;
   }
    //get the carat position
    var caratPos = getSelectionStart(el);
    var dotPos = el.value.indexOf(".");
    if( caratPos > dotPos && dotPos>-1 && (number[1].length > 1)){
        return false;
    }
    return true;
}

function getSelectionStart(o) {
    if (o.createTextRange) {
        var r = document.selection.createRange().duplicate()
        r.moveEnd('character', o.value.length)
        if (r.text == '') return o.value.length
            return o.value.lastIndexOf(r.text)
    } else return o.selectionStart
}

</script>
@endsection