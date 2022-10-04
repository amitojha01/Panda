@extends('admin.layouts.app')
@section('title', 'Email A Coach Update Update')

@section('style')

@endsection
@section('content')
<?php 
use App\Models\SportPosition;
?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">                  
                        <form method="post" action="{{ route('admin.coach.update', $result->id) }}" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="card-header">
                              <h4>Personal Info</h4>
                          </div>
                          <div class="card-body">
                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label>Sport</label>
                                    <input type="text" class="form-control @error('sport') is-invalid @enderror"
                                    name="sport" placeholder="Enter sport name" required=""
                                    value="{{ $result->sport }}"
                                    >
                                    @if ($errors->has('sport'))
                                    <div class="invalid-feedback">{{ $errors->first('sport') }}</div>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Gender</label>
                                    <select class="form-control form-control-sm @error('gender') is-invalid @enderror" name="gender" required>
                                        <option value="Men" {{ $result->gender == 'Men' ? 'selected' : ''}} >Men</option>
                                        <option value="Women" {{ $result->gender == 'Women' ? 'selected' : ''}}>Women</option>
                                    </select>

                                </div>
                                
                            </div>


                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label>School</label>
                                    <input type="text" class="form-control @error('school') is-invalid @enderror"
                                    name="school" placeholder="Enter school name" required=""
                                    value="{{ $result->school }}"
                                    >
                                    @if ($errors->has('school'))
                                    <div class="invalid-feedback">{{ $errors->first('school') }}</div>
                                    @endif
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" placeholder="Enter name" required=""
                                    value="{{ $result->name }}"
                                    >
                                    @if ($errors->has('name'))
                                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>

                                
                            </div>

                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label>Title</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    name="title" placeholder="Enter title" required=""
                                    value="{{ $result->title }}"
                                    >
                                    @if ($errors->has('title'))
                                    <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                                    @endif
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" placeholder="Enter Email" 
                                    value="{{ $result->email }}"
                                    >
                                    @if ($errors->has('email'))
                                    <div class="invalid-feedback">{{ $errors->first('email') }}</div>
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
    function getSportPos(dis){      
        var sport_id = dis.value;
        $.ajax({
            url:"{{url('admin/get-position-by-sport')}}",
            type: "GET",
            data: {
                sport_id: sport_id,
                _token: '{{csrf_token()}}' 
            },
            dataType : 'json',
            success: function(result){
                console.log(result);
                $(dis).closest('.row').find('.sportpos-dropdown').html('<option value="">Select Sport Position</option>'); 
                $.each(result.position,function(key,value){
                    $(dis).closest('.row').find('.sportpos-dropdown').append('<option value="'+value.id+'">'+value.name+'</option>');
                });

            }
        });
        
    }

    function getCountry(dis){

        var country_id = $(dis).val();          
        $("#state-dropdown").html('');
        $.ajax({
            url:"{{url('admin/get-states-by-country')}}",
            type: "GET",
            data: {
                country_id: country_id,
                _token: '{{csrf_token()}}' 
            },
            dataType : 'json',
            success: function(result){
                console.log(result);
                $('#state-dropdown').html('<option value="">Select State</option>'); 
                $.each(result.states,function(key,value){
                    $("#state-dropdown").append('<option value="'+value.id+'">'+value.name+'</option>');
                });
                $('#city-dropdown').html('<option value="">Select State First</option>'); 
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

    function addSport(){
        var list="";        
        $.ajax({
            url:"{{url('admin/get-sports')}}",
            type: "GET",
            data: {
                _token: '{{csrf_token()}}' 
            },
            dataType : 'json',
            success: function(result){
                console.log(result);

                list+='<div class="row">';
                list+='<div class="form-group col-md-4">';
                list+='<label>Sports</label>';
                list+='<select class="form-control form-control-sm   " name="sport_id[]" onchange="getSportPos(this)" required>';
                list+='<option value="">--Select Sport--</option>';
                $.each(result.sport,function(key,value){
                    list+='<option value="'+value.id+'">'+value.name+'</option>';
                    
                });

                list+='</select>';
                list+='</div>';
                list+='<div class="col-md-4">';
                list+='<label>Sports Position</label>';
                list+='<select class="form-control form-control-sm   sportpos-dropdown" name="sport_position_id[]" required>';
                list+='<option value="">--Select Sport--</option>';

                list+='</select>';
                list+='</div>';

                list+='<div class="col-md-4">';
                list+='<input type="button" style="margin-top:30px;" class="btn btn-danger" value="Remove" onclick="removeSport(this)">';

                list+='</div>';
                list+='</div>';
                $('.sportlist').append(list);
            }
        });
    }

    function removeSport(dis){
       $(dis).closest(".row").remove();
   }

    //get Zip code for a city
    $('select[name="city_id"]').on('change', function(){
        let id = $(this).val();
            // console.log(id);
            $.ajax({
                type : "GET",
                url : "{{ url('api/get-zip-codes') }}?city_id="+id,
                data : {},
                beforeSend: function(){
                    // $("#overlay").fadeIn(300);
                },
                success: function(res){
                    console.log(res);
                    if(res.success){
                        $('select[name="zip"]').html('<option value="">--Select--</option>');
                        res.data.forEach((v) => {
                         $('select[name="zip"]')
                         .append('<option value="'+v.zip+'">'+v.zip+'</option>');
                     })                    
                    }
                },
                error: function(err){
                    console.log(err);
                }
            }).done( () => {

            });
        })

    function getYear(dis){
        var year= $(dis).val();
        var currentYear = (new Date).getFullYear();
        var get_year = currentYear-12;
        if(year > get_year){
            $('#guardian-sec').show();
        }else{
            $('#guardian-sec').hide();
        }
    }
    
</script>
@endsection
