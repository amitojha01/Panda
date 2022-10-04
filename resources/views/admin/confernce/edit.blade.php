@extends('admin.layouts.app')
@section('title', 'Competition Update')

@section('style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">                  
                        <form method="post" action="{{ route('admin.conference.update', $confernce->id) }}" enctype="multipart/form-data">
                            @csrf
                            <!-- <input type="hidden" name="_method" value="PUT"> -->
                            <div class="card-header">
                              <h4>Update Collegiate Confernces</h4>
                          </div>
                          <div class="card-body">
                            <div class="form-group">
                                <label>Select Category</label>
                                <select class="form-control form-control-sm @error('parent_id') is-invalid @enderror" name="parent_id" >
                                    <option value="">--Select Category--</option>
                                    @if($category)
                                    @foreach($category as $value)
                                    <option value="{{$value->id}}"
                                        {{ $value->id == $confernce->parent_id ? 'selected' : ''}}
                                        >{{ $value->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>                           
                                </div>

                                <!-- <div class="form-group">
                                    <label>Select College</label>
                                    <?php  
                                    $collegeId= array();
                                    if(count($user_college)>0){
                                        for($i=0; $i<count($user_college); $i++){
                                            array_push($collegeId, $user_college[$i]->college_id );
                                        } 
                                    }
                                    $chk= "";
                                    
                                    ?>                                   
                                      <select id="multiple" class="form-control form-control-sm selectpicker" name="college_id[]" multiple data-actions-box="true">
                                      <?php if($college){
                                        foreach($college as $value){
                                            if (in_array($value->id, $collegeId)) {
                                                $chk='selected';
                                            } ?>

                                            <option value="{{$value->id}}" {{ $chk }} 
                                                
                                                >{{ $value->name }}</option>
                                                <?php $chk= ""; }
                                            } ?>
                                        </select>
                                    </div> --> 
                                    <div class="form-group">
                                        <label>Collegiate Confernces</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" placeholder="Collegiate Confernces" required=""
                                        value="{{ $confernce->name }}"
                                        >
                                        @if ($errors->has('content'))
                                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Select Status</label>
                                        <select class="form-control form-control-sm @error('status') is-invalid @enderror" name="status" required>
                                            <option value="1" {{ $confernce->status == 1 ? 'selected' : ''}}>Active</option>
                                            <option value="0" {{ $confernce->status == 0 ? 'selected' : ''}}>Inactive</option>
                                        </select>
                                        @if ($errors->has('status'))
                                        <div class="invalid-feedback">{{ $errors->first('status') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                  <button type="submit" class="btn btn-primary">Update</button>
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
  @if ($message = Session::get('error'))  
  <script>
      swal('{{ $message }}', 'Warning', 'error');
  </script>
  @endif

  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>  

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script> -->

  
  <script>

    $("#multiple").select2({
      placeholder: "Select college",
      allowClear: true
    });
  </script>
  @endsection
