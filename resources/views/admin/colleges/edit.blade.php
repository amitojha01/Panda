@extends('admin.layouts.app')
@section('title', 'College Update')

@section('style')

@endsection
@section('content')
<?php 
use App\Models\Confernce;
use App\Models\City;

?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">                  
                        <form method="post" action="{{ route('colleges.update', $college->id) }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <div class="card-header">
                              <h4>Update College</h4>
                          </div>
                          <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Select Type</label>
                                    <select class="form-control form-control-sm @error('college_type') is-invalid @enderror" name="college_type" required>
                                        <option value="1" {{ $college->college_type == 1 ? 'selected' : ''}}>College</option>
                                        <option value="2" {{ $college->college_type == 2 ? 'selected' : ''}}>School</option>
                                        <option value="3" {{ $college->college_type == 3 ? 'selected' : ''}}>Club</option>
                                    </select>
                                    @if ($errors->has('college_type'))
                                    <div class="invalid-feedback">{{ $errors->first('college_type') }}</div>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" placeholder="Name" required=""
                                    value="{{ $college->name }}"
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
                                        <option value="{{$value->id}}"{{ @$collegiate_confernce[0]->division_id == $value->id  ? 'selected': '' }} 

                                            >{{ $value->name }}</option>
                                            @endforeach
                                            @endif 
                                        </select>
                                    </div>
                                    <?php                       

                                    $confrence = Confernce::where(['parent_id'=> @$collegiate_confernce[0]->division_id])->get();
                                    $cnf_selected="";

                                    ?>


                                    <div class="form-group col-md-6">
                                        <label>Collegiate Confernce</label>
                                        <select class="form-control form-control-sm @error('collegiate_confernce_id') is-invalid @enderror" name="collegiate_confernce_id[]" id="confrence-dropdown" multiple>
                                            <option value="">--Select--</option>

                                            <?php if($confrence){
                                                foreach($confrence as $value){
                                                    if (in_array($value->id, $confrences)) {
                                                        $cnf_selected='selected';
                                                    }
                                                    ?>
                                                    <option 
                                                    value="{{$value->id}}"
                                                    {{ $cnf_selected }}
                                                    >{{ $value->name }}  
                                                </option>
                                                <?php $cnf_selected="";
                                            }
                                        } ?>
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
                                        <option value="{{$value->id}}" {{ @$college->state_id == $value->id  ? 'selected': '' }}      
                                            >{{ $value->name }}</option>
                                            @endforeach
                                            @endif
                                        </select>                     
                                    </div> 
                                    <?php                        

                                    $city_list = City::where(['state_id'=> $college->state_id])->get();
                                    

                                    ?>
                                    <div class="form-group col-md-6">
                                        <label>Select City</label>
                                        <select class="form-control" name="city_id" id="city-dropdown" required>
                                            <option value="">Select City</option> 

                                            @if($city_list)
                                            @foreach($city_list as $value)
                                            <option value="{{$value->id}}" {{ @$college->city_id == $value->id  ? 'selected': '' }}      
                                                >{{ $value->name }}</option>
                                                @endforeach
                                                @endif                                       

                                            </select>                     
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Founded</label>
                                            <input type="text" class="form-control @error('founded') is-invalid @enderror"
                                            name="founded" placeholder="Founded" required=""
                                            value="{{ @$college->founded }}"
                                            >
                                            @if ($errors->has('founded'))
                                            <div class="invalid-feedback">{{ $errors->first('founded') }}</div>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Enrollment</label>
                                            <input type="text" class="form-control @error('enrollment') is-invalid @enderror"
                                            name="enrollment" placeholder="Enrollment" required=""
                                            value="{{ @$college->enrollment }}"
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
                                            value="{{ @$college->endowment }}"
                                            >
                                            @if ($errors->has('endowment'))
                                            <div class="invalid-feedback">{{ $errors->first('endowment') }}</div>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Nickname</label>
                                            <input type="text" class="form-control @error('nickname') is-invalid @enderror"
                                            name="nickname" placeholder="Nickname" required=""
                                            value="{{ @$college->nickname }}"
                                            >
                                            @if ($errors->has('nickname'))
                                            <div class="invalid-feedback">{{ $errors->first('nickname') }}</div>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="row">
                                     <div class="form-group col-md-6">
                                        <label>Select Status</label>
                                        <select class="form-control form-control-sm @error('status') is-invalid @enderror" name="status" required>
                                            <option value="1" {{ $college->status == 1 ? 'selected' : ''}}>Active</option>
                                            <option value="0" {{ $college->status == 0 ? 'selected' : ''}}>Inactive</option>
                                        </select>
                                        @if ($errors->has('status'))
                                        <div class="invalid-feedback">{{ $errors->first('status') }}</div>
                                        @endif
                                    </div>
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
                console.log(result);
                $('#city-dropdown').html('<option value="">Select City</option>'); 
                $.each(result.cities,function(key,value){
                    $("#city-dropdown").append('<option value="'+value.id+'">'+value.name+'</option>');
                });
            }
        });
    });



</script>
@endsection
