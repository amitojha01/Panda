@extends('frontend.athlete.layouts.app')
@section('title', 'Email a Coach')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<div class="container-fluid">


  <div class="row">
    <div class="col-md-6 col-md-4 col-sm-12 col-xs-12-12 col-xs-12">
      <div class="addathe_box_l">

      </div>
    </div>
    <div class="col-md-6 col-md-4 col-sm-12 col-xs-12-12 col-xs-12">
      <div class="addathe_box_r">
       <a href="{{ route('athlete.sent-list') }}" class="addhighlightsbtn" style="padding: 6px 15px 6px 15px;">View Sent List</a> 

     </div>
   </div>

 </div>

 <div class="addgamehighlightes emailcoach">
   <div class="addgamehighlightesinner">

     <div class="form-group datrrecordtext">

      <form  action="{{ route('athlete.searchcoach') }}" method="POST" >
        @csrf
        <div class="form-group">
          <label>Search</label>
          <select class="form-control" name="" onchange="displaysec(this)" >
            <option value="" selected>Search By Filter</option>
            <option value="1">Search By Coach Name</option>
          </select>
        </div>

        <div id="emailsec" style="display:none">
         <label>Coach Name</label>
         <input type="text" name="coachName" value="" class="form-control" placeholder="">

       </div>

       <div id="generalsec">

        <div class="form-group">
          <label style="padding: 0px 0px 20px;">Sports</label><br>
          
          <select class=" multipleSelect2 form-control-sm multiplesport" multiple="multiple" id="sportId" name="sport[]"   required>
            <option value="">--Select Sport--</option>
            <?php if($sport){
              foreach($sport as $value){
                ?>
                <option 
                value="{{$value->sport}}"
                >{{ $value->sport }}  
              </option>
              <?php
            }
          } ?>
        </select>


      </div>
      <div class="form-group">
        <label>Gender</label>
        <select class="form-control" name="gender" >
          <option value="Men" >Men</option>
          <option value="Women">Women</option>

        </select>
      </div>

      <div class="form-group">
        <label>School</label>

        <select class="form-control form-control-sm @error('school') is-invalid @enderror " name="school" id="school" required>
          <option value="">--Select --</option>
          <?php if($college_list){
            foreach($college_list as $value){
              ?>
              <option 
              value="{{$value->school}}"
              >{{ $value->school }}  
            </option>
            <?php
          }
        } ?>
      </select>
    </div>
  </div>
</div>
<input type="submit" class="addhighlightsbtn" value="Search"/>

</form>
</div>
</div>
</div>

@endsection
@section('script')
<script>
  $( document ).ready(function() {
    $(".multiplesport").select2({
      placeholder: "Select Sport",
      allowClear: true
    });
  });

  function displaysec(dis){
    if($(dis).val()==1){
      $('#sportId').removeAttr('required');
      $('#school').removeAttr('required');
      $('#generalsec').hide();
      $('#emailsec').show();
    }else{
      $("#sportId").prop('required',true);
      $("#school").prop('required',true);
      $('#generalsec').show();
      $('#emailsec').hide();
    }
  }

</script>
@endsection