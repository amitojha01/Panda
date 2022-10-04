@extends('frontend.layouts.coach')
@section('title', 'Registration | Coach | Step-4')
@section('style')
<style>
    .accout5_radio img{
        width: 30px;
    }
</style>
@endsection
@section('content')
<div class="">
    <div class="signinheader">
        <div class="signinheader_l">
            <a href="">
                <img src="{{ asset('public/frontend/images/signin_logo.png') }}" alt="signin_logo" />
            </a>
        </div>
        <!-- <div class="signinheader_r">
            <span>Don't have an account? <a href="">Try Now</a></span>
        </div> -->
        <div class="clr"></div>
    </div>
    <div class="signinbox selectsports">	
		<h2>Select Sports <b>You can pick max 4 sports</b></h2>        
        <form id="frmRegistrationStep-4" method="post" action="{{ route('registration.coach.step-three') }}">
                @csrf		
		    <div class="signinbox selectsports2">
                @if($sports)
                    @foreach($sports as $key => $sport)
                    <div class="{{ $loop->odd ? 'signinboxinput' : 'signinboxinput2' }}">
                        <div class="accout5_radio">
                            <img src="{{ url('/').'/'.$sport->icon }}" alt="account4_img1"/>
                            <span>{{ ucwords($sport->name)}}</span>
                            <div class="accout5_checkright">
                                <div class="form-group">
                                <input type="checkbox" id="accountcheckbox{{ $key }}" name="sports[]" value="{{ $sport->id }}">
                                <label for="accountcheckbox{{ $key }}"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif					
                <div class="clr"></div>
		    </div>		
            <div align="center">
                <input type="submit" class="selectsportsdonebtn" value="Done"/>
                <a href="{{ URL::previous() }}" class="back">Back</a>
            </div>    
        </form>		
	</div>
    <div class="clr"></div>
    @include('frontend.layouts.footer')
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('input[name="sports[]"]').on('click', function(){
            if($('input[name="sports[]"]:checked').length > 4){
                swal("Alert", "You can select max 4 sports", "warning");
                return false;
            }
        })

        $('#frmRegistrationStep-4').submit(function(e){
            if($('input[name="sports[]"]:checked').length < 1){
                swal("Alert", "You must select min 1 sport", "warning");
                return false;
            }
        })
    })
</script>
@endsection