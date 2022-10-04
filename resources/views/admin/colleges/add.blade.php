@extends('admin.layouts.app')
@section('title', 'College Add')

@section('style')

@endsection
@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <form method="post" action="{{ route('colleges.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                      <h4>Add College</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                        <div class="form-group col-md-6">
                            <label>Select Type</label>
                            <select class="form-control form-control-sm @error('college_type') is-invalid @enderror" name="college_type" required>
                                <option value="">--Select Type--</option>
                                <option value="1"             
                                        >College</option>
                                <option value="2"             
                                        >School</option>
                                <option value="3"             
                                        >Club</option>
                               
                            </select>
                            @if ($errors->has('college_type'))
                            <div class="invalid-feedback">{{ $errors->first('college_type') }}</div>
                            @endif
                        </div>

                        <div class="form-group col-md-6">
                            <label>Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" placeholder="Name" required=""
                            value="{{ old('name') }}"
                            >
                            @if ($errors->has('name'))
                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                    </div>
                         
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Competitive Level/Division</label>
                            <select class="form-control form-control-sm @error('competitive_level_id') is-invalid @enderror" name="competitive_level_id" onchange="getConfrence(this)">
                                <option value="0">--Select--</option>
                                 @if($competitive_level)
                                    @foreach($competitive_level as $value)
                                        <option value="{{$value->id}}"
                                        
                                        >{{ $value->name }}</option>
                                    @endforeach
                                @endif 
                            </select>
                        </div>
                    

                        <div class="form-group col-md-6">
                            <label>Collegiate Confernce</label>
                            <select class="form-control form-control-sm @error('collegiate_confernce_id') is-invalid @enderror" name="collegiate_confernce_id[]" id="confrence-dropdown" multiple>
                                <option value="0">--Select--</option>
                            </select>
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                                <label>State</label>                            
                                <select class="form-control" name="state_id" id="state-dropdown" required>
                                    <option value="">Select State</option>
                                    @if($states)
                                    @foreach($states as $value)
                                    <option value="{{$value->id}}"      
                                        >{{ $value->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>                     
                                </div> 

                                <div class="form-group col-md-6">
                                    <label>Select City</label>
                                    <select class="form-control" name="city_id" id="city-dropdown" required>
                                        <option value="">Select City</option>
                                        

                                        </select>                     
                                    </div>
                            </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Founded</label>
                            <input type="text" class="form-control @error('founded') is-invalid @enderror"
                            name="founded" placeholder="Founded" required=""
                            value="{{ old('founded') }}"
                            >
                            @if ($errors->has('founded'))
                            <div class="invalid-feedback">{{ $errors->first('founded') }}</div>
                            @endif
                        </div>

                        <div class="form-group col-md-6">
                            <label>Enrollment</label>
                            <input type="text" class="form-control @error('enrollment') is-invalid @enderror"
                            name="enrollment" placeholder="Enrollment" required=""
                            value="{{ old('enrollment') }}"
                            >
                            @if ($errors->has('enrollment'))
                            <div class="invalid-feedback">{{ $errors->first('enrollment') }}</div>
                            @endif
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Endowment</label>
                            <input type="text" class="form-control @error('endowment') is-invalid @enderror"
                            name="endowment" placeholder="Endowment" 
                            value="{{ old('endowment') }}"
                            >
                            @if ($errors->has('endowment'))
                            <div class="invalid-feedback">{{ $errors->first('endowment') }}</div>
                            @endif
                        </div>

                        <div class="form-group col-md-6">
                            <label>Nickname</label>
                            <input type="text" class="form-control @error('nickname') is-invalid @enderror"
                            name="nickname" placeholder="Nickname" required=""
                            value="{{ old('nickname') }}"
                            >
                            @if ($errors->has('nickname'))
                            <div class="invalid-feedback">{{ $errors->first('nickname') }}</div>
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

 <script>
function getConfrence(dis){

        var competitive_level_id = $(dis).val();          
        $("#confrence-dropdown").html('');
        $.ajax({
            url:"{{url('admin/get-confrence')}}",
            type: "GET",
            data: {
                competitive_level_id: competitive_level_id,
                _token: '{{csrf_token()}}' 
            },
            dataType : 'json',
            success: function(result){
                console.log(result);
                $('#confrence-dropdown').html('<option value="">Select Confrence</option>'); 
                $.each(result.confrence,function(key,value){
                    $("#confrence-dropdown").append('<option value="'+value.id+'">'+value.name+'</option>');
                }); 
            }
        });

    }

    $('#state-dropdown').on('change', function() {
        var state_id = this.value;
        $("#city-dropdown").html('');
        $.ajax({
            url:"{{url('admin/get-cities-by-state')}}",
            type: "GET",
            data: {
                state_id: state_id,
                _token: '{{csrf_token()}}' 
            },
            dataType : 'json',
            success: function(result){
                $('#city-dropdown').html('<option value="">Select City</option>'); 
                $.each(result.cities,function(key,value){
                    $("#city-dropdown").append('<option value="'+value.id+'">'+value.name+'</option>');
                });
            }
        });
    });
 </script>
@endsection
