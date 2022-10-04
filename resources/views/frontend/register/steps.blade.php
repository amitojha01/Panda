@extends('frontend.layouts.app')
@section('title', 'Registration | Step-1')

@section('content')
<div class="">
    <div class="signinheader">
        <div class="signinheader_l"><a href="{{URL::to('/')}}">
          <img src="{{ asset('public/frontend/images/signin_logo.png') }}" alt="signin_logo" /></a></div>
        <div class="signinheader_r">
            <span>Don't have an account? <a href="{{ route('login') }}">Try Now</a></span>
        </div>
        <div class="clr"></div>
    </div>
    <div class="signinbox createaccount">
        <h2>Create Account</h2>
       <!--  <span>Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod</span> -->
        <h5>Who you are</h5>
        <div class="createradiobox boxed">
            <input type="radio" id="radio1" name="skills" value="Athlete">
            <label for="radio1">
                <span>I am an</span>
                <b>Athlete</b>
                <em></em>
            </label>
        </div>
        <div class="createradiobox boxed">
            <input type="radio" id="radio2" name="skills" value="Coach">
            <label for="radio2">
                <span>I am an</span>
                <b>Coach</b>
                <em></em>
            </label>
        </div>
        <div class="clr"></div>
        <input type="button" class="savecontinue" value="Save & continue" />
    </div>
    <div class="clr"></div>
    @include('frontend.layouts.footer')
</div>
@endsection
@section('script')
<script>
$('.savecontinue').on('click', function(){
  //console.log($("input[name='skills']:checked").val()); return false;
  const skill = $("input[name='skills']:checked").val();
  if(!skill){
    swal("Alert", "You must select account type", "error");
    return false;
  }

  swal({
    title: "Confirm that you selected "+skill,
    //text: "Confirm that you selected "+skill,
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      window.location.href="{{ url('registration') }}"+"/"+skill.toLowerCase();
    }
  });
})
</script>
@endsection