@extends('frontend.athlete.layouts.app')
@section('title', 'Email a Coach')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<div class="container-fluid">
  <div class="addgamehighlightes emailcoach">
   <div class="addgamehighlightesinner">

    <div class="form-group datrrecordtextz">

      <form  action="{{ route('athlete.sendMail') }}" method="POST" >
        @csrf 
        <div class="row">     

          <div class="col-md-9 form-group">
            <label>To</label>
            <input type="text" name="email[]" value="{{ @$coachEmailone }}, {{ @$coachEmailtwo}}" class="form-control" placeholder="" disabled="">
            <input type="hidden" name="email[]" value="{{  @$coachEmailone }}">
            <input type="hidden" name="email[]" value="{{  @$coachEmailtwo }}"> 

            <!-- <input type="hidden" name="email[]" value="ameetojha01@gmail.com">
            <input type="hidden" name="email[]" value="ameetojha02@gmail.com">  -->

          </div>

          <div class="col-md-2 form-group">
            <input type="button" class="profilelink n-ppost" onclick="addEmail()" value="Add Email">

            <div class="n-ppost-msg">Click here to manually add an email address not found in our coach email address list</div>

          </div>
        </div>

        <div class="row" id="manualEmail" style="display:none">
          <div class="col-md-9 form-group"  >
            <label>To</label>
            <input type="text" name="email[]" value="" class="form-control" placeholder="">
          </div>
          <div class="col-md-2 form-group">
            <input type="button" class="profilelink" onclick="remove()" value="Remove">

          </div>

        </div>
        <div class="row">

          <div class="col-md-9 form-group">
            <label>From</label>
            <input type="text" name="from_email" value="<?= Auth()->user()->email ?>" class="form-control" placeholder="">
          </div>

           <input type="hidden" name="athlete_name" value="<?= Auth()->user()->username ?>" class="form-control" placeholder="">
        </div>
        <div class="row">
          <div class="col-md-9 form-group">
            <label>Subject</label>
            <input type="text" name="subject" value=" Please Review my Profile" class="form-control" placeholder="" required="">
          </div> 
        </div>

      </div>
      <div class="row">
        <div class="col-md-9 form-group">
          <label>Message</label>
          <textarea placeholder="Type here..." name="message" required=""></textarea> 
          @if ($errors->has('message'))
          <span class="text-danger">{{ $errors->first('message') }}</span>
          @endif     		
        </div>
      </div>
      <div class="row"> 
        <div class="col-md-9 form-group">
          <label>URL link for public view of the Athlete Profile</label>

          <input type="url" class="form-control" name="profile_link"  value="{{ url('athleteprofile/'.Auth()->user()->id) }}" placeholder="" readonly/>

          @if ($errors->has('profile_link'))
          <span class="text-danger">{{ $errors->first('profile_link') }}</span>
          @endif     		
        </div>
      </div>
      <input type="submit" class="addhighlightsbtn" value="Submit"/> 
      <!-- <a href="{{url('/athlete/searchcoach') }} " class="addhighlightsbtn">Back</a> -->
    </form>
  </div>
</div>
</div>

@endsection
@section('script')
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
 // CKEDITOR.replace( 'message' );
</script>
<script>
  function addEmail(){
   $('#manualEmail').show();
 }

 function remove(){
   $('#manualEmail').hide();

 }


</script>
@endsection