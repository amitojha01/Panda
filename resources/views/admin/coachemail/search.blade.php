@extends('admin.layouts.app')
@section('title', 'Search Email')

@section('style')

@endsection
@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <form method="post" action="{{ route('admin.searchcoach') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                      <h4>Search Coach</h4>
                    </div>
                    <div class="card-body">
                        
                        <div class="form-group">
                           <select class="form-control" name="" onchange="displaysec(this)" >
                            <option value="" selected>Search By Filter</option>
                            <option value="1">Search By Coach Name</option>
                        </select>
                        </div>

                        <div id="emailsec" style="display:none" class="form-group">
                            <label>Coach Name</label>
                            <input type="text" class="form-control @error('coachName') is-invalid @enderror"
                            name="coachName" placeholder="Enter coach name" id="coachName"
                            value="{{ old('coachName') }}"
                           >
                            @if ($errors->has('coachName'))
                            <div class="invalid-feedback">{{ $errors->first('coachName') }}</div>
                            @endif
                        </div>

                         <div id="generalsec">


                        <div class="form-group">
                            <label>Sports</label>
                           <select class="form-control" name="sport[]"  multiple="multiple" style="height:136px"  required="required" id="sportId">
                            
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
                           <select class="form-control" name="gender"  >
                            <option value="Men" selected>Men</option>
                            <option value="Women">Women</option>
                        </select>
                        </div>

                         <div class="form-group">
                            <label>School</label>
                           <select class="form-control"  name="school" id="school" >
                            
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
                    <div class="card-footer text-right">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('script')
<script>
function displaysec(dis){
    if($(dis).val()==1){
      $('#sportId').removeAttr('required');
      $('#school').removeAttr('required');
      $('#coachName').prop('required',true);
      $('#generalsec').hide();
      $('#emailsec').show();
    }else{
      $("#sportId").prop('required',true);
      $("#school").prop('required',true);
       $('#coachName').removeAttr('required');
      $('#generalsec').show();
      $('#emailsec').hide();
    }
  }
</script>

@if ($message = Session::get('error'))  
    <script>
      swal('{{ $message }}', 'Warning', 'error');
    </script>
  @endif
@endsection
