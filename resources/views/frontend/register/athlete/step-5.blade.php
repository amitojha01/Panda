@extends('frontend.layouts.app')
@section('title', 'Registration | Athlete | Position')

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
            <a><b>05</b>/06</a>
        </span>
		<h5>What position do you play? </h5>
        <form id="frmRegistrationStep-4" method="post" action="{{ route('registration.athlete.step-four') }}">
            @csrf
            @if($sports)
            @php($c = 1);
            @foreach($sports as $key => $sport)
               
            <div class="positiononepanel">
                <div class="signinboxinput">
                    <label>Position 1 for {{ $sport->name }}</label>
                    <input type="hidden" name="sports[]" value="{{ $sport->id }}" >
                    <select class="form-control pvalone" name="sport_positions[]" requiredz onchange="checkPosition2(this)">
                        <option  value="">Select </option>
                    @if($sport->positions)
                        @foreach($sport->positions as $key => $position)
                        <option value="{{ $position->id }}">{{ ucwords($position->name) }}</option>
                    @endforeach
                    @endif
                    </select>
                </div>
                
                <?php if( $sport->name!="Golf" && $sport->name!= 'Cross Country' && $sport->name!= 'Beach Volleyball' && $sport->name!= 'Powerlifting'){?>
                 <div class="signinboxinput2">
                    <label>Position 2 for {{ $sport->name }}</label>
                    <input type="hidden" name="sports[]" value="{{ $sport->id }}" >
                    <select class="form-control pvaltwo" name="sport_positions[]" requiredz onchange="checkPosition1(this)">
                        <option  value="">Select </option>
                    @if($sport->positions)
                        @foreach($sport->positions as $key => $position)
                        <option value="{{ $position->id }}">{{ ucwords($position->name) }}</option>
                    @endforeach
                    @endif
                    </select>
                </div>
            <?php } ?>
                <div class="clr"></div>
            </div>
            @php($c++)
            @endforeach
            <div class="clr"></div>
            @endif
            <h5>What is your current competitive level?</h5>
            <div class="signinboxinput">
                <label>Competition Level :</label>
                <select class="form-control" name="competition_level_id">
                    <option value="">-- Select --</option>
                </select>
            </div>		
            <div class="signinboxinput2">
                <label>School Playing Level</label>
                <select class="form-control" name="school_level_id" required>
                    <option value="">-- Select --</option>
                    @if($playingLevels)
                        @foreach($playingLevels as $key => $level)
                        <option value="{{ $level->id }}">{{ ucwords($level->name) }}</option>
                    @endforeach
                    @endif
                </select>
                @if ($errors->has('school_level_id'))
                    <span class="text-danger">{{ $errors->first('school_level_id') }}</span>
                @endif
            </div>
            <div class="signinboxinput">
                <label>Rec/Club/Travel Level:</label>
                <select class="form-control" name="other_level_id">
                    <option value="">-- Select --</option>
                </select>
            </div>	
            
            <div class="clr"></div>
            <input type="submit" class="savecontinue" value="Save & continue"/>
            <!-- <a href="{{ URL::previous() }}" class="back">Back</a> -->
        </form>
	</div>
    <div class="clr"></div>
    @include('frontend.layouts.footer')
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        //Club
		$.ajax({
            type : "GET",
            url : "{{ url('api/get-clubs') }}",
            data : {},
            beforeSend: function(){
                //$("#overlay").fadeIn(300);
            },
            success: function(res){
                console.log(res);
                if(res.success){
                    res.data.forEach((v) => {
                        $('select[name="other_level_id"]')
                        .append('<option value="'+v.id+'">'+v.name+'</option>');
                    })                    
                }
            },
            error: function(err){
                console.log(err);
            }
        }).done( () => {
        })   

        //Competetion
        $.ajax({
            type : "GET",
            url : "{{ url('api/get-competition-level') }}",
            data : {},
            beforeSend: function(){
                //$("#overlay").fadeIn(300);
            },
            success: function(res){
                console.log(res);
                if(res.success){
                    res.data.forEach((v) => {
                        $('select[name="competition_level_id"]')
                        .append('<option value="'+v.id+'">'+v.name+'</option>');
                    })                    
                }
            },
            error: function(err){
                console.log(err);
            }
        }).done( () => {
        })           
    })

    function checkPosition1(dis){
        var p2= $(dis).val();
        var p1= $(dis).parents('.positiononepanel').find('.pvalone').val();
        if(p1!="" && p1==p2){           
            swal('Alert', 'Position 1 and Position 2 can not be same', 'error');
            $(dis).val('');

        }
     
    }
    function checkPosition2(dis){
        var p2= $(dis).parents('.positiononepanel').find('.pvaltwo').val();
        var p1= $(dis).val();
         if(p2!="" && p1==p2){            
            swal('Alert', 'Position 1 and Position 2 can not be same', 'error');
            $(dis).val('');

        }
    }
</script>
@endsection