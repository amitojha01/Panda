@extends('admin.layouts.app')
@section('title', 'Competition Add')

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
                  <form method="post" action="{{ route('admin.conference.save') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                      <h4>Add Collegiate Confernces</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Select Category</label>
                            <select class="form-control form-control-sm @error('page_slug') is-invalid @enderror" name="parent_id" >
                                <option value="0">--Select Category--</option>
                                @if($category)
                                    @foreach($category as $value)
                                        <option value="{{$value->id}}"
                                        
                                        >{{ $value->name }}</option>
                                    @endforeach
                                @endif
                            </select>                            
                        </div>
                        <!--  <div class="form-group">
                            <label>Select College</label>
                            <select id="multiple" class="form-control form-control-sm selectpicker" name="college_id[]" multiple data-actions-box="true">
                              @if($college)
                                    @foreach($college as $value)
                                        <option value="{{$value->id}}"
                                        
                                        >{{ $value->name }}</option>
                                    @endforeach
                                @endif
                          </select>
                        </div> --> 
                        <div class="form-group">
                            <label>Collegiate Confernces</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" placeholder="Collegiate Confernces" required=""
                            value="{{ old('name') }}"
                            >
                            @if ($errors->has('name'))
                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                            @endif
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
@if ($message = Session::get('error'))  
    <script>
      swal('{{ $message }}', 'Warning', 'error');
    </script>
  @endif
    
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>  -->

  
  <script>

    $("#multiple").select2({
      placeholder: "Select college",
      allowClear: true
    });
  </script>
@endsection
