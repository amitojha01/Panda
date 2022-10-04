@extends('frontend.athlete.layouts.app')
@section('title', 'Contact us')
@section('content')
<style>
  a.colorgreen{
    background:green;
  } 

</style>

<div class="container-fluid">
  <div class="addgamehighlightes">
   <div class="addgamehighlightesinner" style="width:100%;">
     <h3>Contact us</h3>
     <form method="post" id="" action="{{ route('athlete.save-report') }}" enctype="multipart/form-data">
      @csrf

     <div class="form-group addvideoevedancesmalltext">
      <label>Subject</label>
      <input type="text" name="subject" value="" class="form-control" placeholder="" required />  
      @if ($errors->has('subject'))
            <div class="invalid-feedback">{{ $errors->first('subject') }}</div>
            @endif    		
    </div>
    <div class="clr"></div>
    <div class="form-group addvideoevedancesmalltext">  
     <label>Message</label>
     <textarea class="form-control @error('message') is-invalid @enderror" name="message" 
     required="" rows="4" cols="50"  value=""></textarea>
   </div>

   <div class="clr"></div>
   <div class="form-group addvideoevedancesmalltext">
    <label>Mobile</label>
    <input type="text"  onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" name="mobile" value="{{ old('mobile') }}"  value=""  class="form-control"   maxlength="11" placeholder="" required/>
  </div>
  <div class="clr"></div>
   <input type="submit" class="addhighlightsbtn" value="Submit">
 </form>

</div>
</div>
</div>
</div>
<input type="hidden" id="base_url" value="<?php echo url('/') ?>">
<div class="clr"></div>
 

</div>



@endsection
@section('script')

<script>




</script>

@endsection