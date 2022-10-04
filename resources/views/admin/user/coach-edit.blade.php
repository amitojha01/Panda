@extends('admin.layouts.app')
@section('title', 'User Update')

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
                        <form method="post" action="{{ route('coach.update', $user->id) }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <div class="card-header">
                              <h4>Personal Info</h4>
                          </div>
                          <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>User Name</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                    name="username" placeholder="User Name" required=""
                                    value="{{ $user->username }}"
                                    >
                                    @if ($errors->has('username'))
                                    <div class="invalid-feedback">{{ $errors->first('username') }}</div>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Mobile</label>
                                    <input type="number" class="form-control @error('mobile') is-invalid @enderror"
                                    name="mobile" placeholder="Mobile" required="" value="{{ $user->mobile }}"
                                    >
                                    @if ($errors->has('mobile'))
                                    <div class="invalid-feedback">{{ $errors->first('mobile') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Email</label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                                    name="email" placeholder="Email" required="" value="{{ $user->email }}"
                                    >
                                    @if ($errors->has('email'))
                                    <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                    @endif
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Gender</label>
                                    <select class="form-control form-control-sm @error('gender') is-invalid @enderror" name="gender" required>
                                        <option value="male" >Male</option>
                                        <option value="female" >Female</option>
                                        <option value="other" >Other</option>
                                    </select>
                                    @if ($errors->has('gender'))
                                    <div class="invalid-feedback">{{ $errors->first('gender') }}</div>
                                    @endif
                                </div> 
                            </div> 
                            

                            <div class="row"> 
                                <div class="form-group col-md-6">
                                    <label>Birth Year</label>
                                    <select class="form-control form-control-sm @error('date_of_year') is-invalid @enderror" name="date_of_year" required>
                                        <option value="1" >Select year</option>
                                        <?php
                                        for($i=2016; $i>=1940; $i--){
                                            ?>
                                            <option value="{{ $i }}" {{ $user->date_of_year == $i ? 'selected' : ''}}>{{ $i }}</option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    @if ($errors->has('date_of_year'))
                                    <div class="invalid-feedback">{{ $errors->first('date_of_year') }}</div>
                                    @endif
                                </div> 
                                
                                <div class="form-group col-md-6">
                                    <label>Profile Type</label>
                                    <select class="form-control form-control-sm @error('profile_type') is-invalid @enderror" name="profile_type" required>
                                        <option value="1" {{ $user->profile_type == 1 ? 'selected' : ''}}>Public</option>
                                        <option value="2" {{ $user->profile_type == 2 ? 'selected' : ''}}>Private</option>
                                    </select>
                                    @if ($errors->has('profile_type'))
                                    <div class="invalid-feedback">{{ $errors->first('profile_type') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Profile Image</label>
                                    <input type="file" class="form-control" name="profile_image" >
                                    @if($user->profile_image != null)   
                                    <img class="preview-image mt-2" alt="profile_image" src="{{ asset($user->profile_image) }}" width="40px">
                                    @endif
                                    @if ($errors->has('profile_image'))
                                    <div class="invalid-feedback">{{ $errors->first('profile_image') }}</div>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Select Status</label>
                                    <select class="form-control form-control-sm @error('status') is-invalid @enderror" name="status" required>
                                        <option value="1" {{ $user->status == 1 ? 'selected' : ''}}>Active</option>
                                        <option value="0" {{ $user->status == 0 ? 'selected' : ''}}>Inactive</option>
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
      <!------Address Info--------------->
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">                  
                <form method="post" action="{{ route('update.coach.address.info', $user->id) }}" enctype="multipart/form-data">
                    @csrf                    
                    <div class="card-header">
                      <h4>Address Info</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Country</label>
                            <input type="hidden" name="user_id" value={{ $user->id }}>               
                            <select class="form-control form-control-sm @error('country_id') is-invalid @enderror" name="country_id" required onchange="getCountry(this)">
                                <option value="">--Select Country--</option>
                                @if($country)
                                @foreach($country as $value)
                                <option value="{{$value->id}}" {{ @$user->address[0]->country_id == $value->id  ? 'selected': '' }}      
                                    >{{ $value->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('country_id'))
                                <div class="invalid-feedback">{{ $errors->first('country_id') }}</div>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label>State</label>                            
                                <select class="form-control" name="state_id" id="state-dropdown" required>
                                    <option value="">Select State</option>
                                    @if($states)
                                    @foreach($states as $value)
                                    <option value="{{$value->id}}" {{ @$user->address[0]->state_id == $value->id  ? 'selected': '' }}      
                                        >{{ $value->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>                     
                                </div> 
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Select City</label>
                                    <select class="form-control" name="city_id" id="city-dropdown" required>
                                        <option value="">Select City</option>
                                        @if($city)
                                        @foreach($city as $value)
                                        <option value="{{$value->id}}" {{ @$user->address[0]->city_id == $value->id  ? 'selected': '' }}      
                                            >{{ $value->name }}</option>
                                            @endforeach
                                            @endif

                                        </select>                     
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Zip</label>             
                                        <input type="number" class="form-control @error('zip') is-invalid @enderror"
                                        name="zip" placeholder="Zip" required="" value="{{ @$user->address[0]->zip }}"
                                        >
                                        @if ($errors->has('zip'))
                                        <div class="invalid-feedback">{{ $errors->first('zip') }}</div>
                                        @endif
                                    </div> 
                                </div> 
                                <div class="row">                          
                                   <div class="form-group col-md-6">
                                    <label>Select Status</label>
                                    <select class="form-control  form-control-sm @error('status') is-invalid @enderror" name="status" required>
                                        <option value="1" {{ @$user->address[0]->status == 1 ? 'selected' : ''}}>Active</option>
                                        <option value="0" {{ @$user->address[0]->status == 0 ? 'selected' : ''}}>Inactive</option>
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

      <!----------Other-Information------------->
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">                  
                <form method="post" action="{{ route('update.coach.other.info', $user->id) }}" enctype="multipart/form-data">
                    @csrf                    
                    <div class="card-header">
                      <h4>Other Info</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Level Coaching</label>
                            <input type="hidden" name="user_id" value={{ $user->id }}>               
                            <select class="form-control form-control-sm @error('coaching_level') is-invalid @enderror" name="coaching_level" required >
                                <option value="">--Select--</option>
                                <option value="college" selected>College</option>
                                <!-- <option value="school">School</option> -->
                                
                            </select>
                            @if ($errors->has('coaching_level'))
                            <div class="invalid-feedback">{{ $errors->first('coaching_level') }}</div>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label>Sport</label>                            
                            <select class="form-control" name="sport_id" id="sport-dropdown" required>
                                <option value="">Select</option>
                                @if($sports)
                                @foreach($sports as $value)
                                <option value="{{$value->id}}"     
                                 {{ @$coachInfo->sport_id == $value->id  ? 'selected': '' }}  >{{ $value->name }}</option>
                                 @endforeach
                                 @endif
                             </select>                     
                         </div> 
                     </div>
                     <div class="row">
                        <div class="form-group col-md-6">
                            <label>Current College Name</label>
                            <select class="form-control" name="college_id" id="college_id" required>
                                <option value="">Select College</option>
                                @if($college)
                                @foreach($college as $value)
                                <option value="{{$value->id}}" {{ @$coachInfo->college_id == $value->id  ? 'selected': '' }}       
                                    >{{ $value->name }}</option>
                                    @endforeach
                                    @endif

                                </select>                     
                            </div>
                                <!-- <div class="form-group col-md-6" style="display: none">
                                    <label>Current School Name</label>
                                    <select class="form-control" name="school" id="college_id" required>
                                        <option value="">Select School</option>

                                    </select>                     
                                </div> -->
                                <div class="form-group col-md-6" >
                                    <label>Gender of sport coaching</label>
                                    <select class="form-control" name="gender_of_coaching"  required>
                                        <option value="">Select </option>
                                        <option value="male" <?php if(@$coachInfo->gender_of_coaching=="male"){echo "selected" ;}?>>Male </option>
                                        <option value="female" <?php if(@$coachInfo->gender_of_coaching=="female"){echo "selected" ;}?>>Female </option>
                                        <option value="both" <?php if(@$coachInfo->gender_of_coaching=="both"){echo "selected" ;}?>>Both </option>
                                    </select>           
                                </div> 
                            </div> 
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Your Bio</label>
                                    <textarea class="form-control @error('about') is-invalid @enderror" name="about" 
                                    required=""  value="">{!! @$coachInfo->about !!}</textarea>
                                    @if ($errors->has('about'))
                                    <div class="invalid-feedback">{{ $errors->first('about') }}</div>
                                    @endif
                                </div>

                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Your Bio Link</label>             
                                    <input type="url" class="form-control @error('about_link') is-invalid @enderror"
                                    name="about_link" placeholder="http://" required="" value="{{ @$coachInfo->about_link }}"
                                    >
                                    @if ($errors->has('about_link'))
                                    <div class="invalid-feedback">{{ $errors->first('about_link') }}</div>
                                    @endif
                                </div> 
                                <div class="form-group col-md-6">
                                    <label>Contact Preference</label>
                                    <select class="form-control" name="preference_id" id="preference_id" required>
                                        <option value="">Select Preference</option>
                                        @if($preference)
                                        @foreach($preference as $value)
                                        <option value="{{$value->id}}" {{ @$coachInfo->preference_id == $value->id  ? 'selected': '' }}       
                                            >{{ $value->name }}</option>
                                            @endforeach
                                            @endif
                                        </select>           
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <input type="checkbox" id="html" name="serve_as_reference" value="1"   {{ @$coachInfo->serve_as_reference == 1  ? 'checked': '' }}                
                                        >
                                        <label for="html"> &nbsp; Are you willing to serve as a reference?</label>
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

          <!----User Sports Info------->
          <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">                  
                    <form method="post" action="{{ route('update.coach.sport.info', $user->id) }}" id="sportForm" enctype="multipart/form-data">
                        @csrf                    
                        <div class="card-header">
                          <h4>Sports Info</h4>
                          <input type="hidden" name="user_id" value={{ $user->id }}>
                          <input type="button"  class="btn btn-primary" value="Add Sports" onclick="addSport()">
                      </div>
                      <div class="card-body"> 
                        @if(@$userSports)
                        @foreach($userSports as $val)                    
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Sports</label>
                                <select class="form-control form-control-sm @error('sport_id') is-invalid @enderror" name="sport_id[]" onchange="getSportPos(this)" required>
                                    <option value="">--Select Sport--</option>
                                    <?php if(@$sports){
                                        foreach($sports as $value){
                                            ?>
                                            <option 
                                            value="{{$value->id}}"
                                            {{ $value->id == $val ? 'selected': '' }}
                                            >{{ $value->name }}  
                                        </option>
                                        <?php
                                    }
                                } ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                         <input type="button" style="margin-top:30px;" class="btn btn-danger" value="Remove" onclick="removeSport(this)">

                     </div>

                 </div>
                 @endforeach
                 @endif

                 <div class="sportlist"></div>

             </div>
             <div class="card-footer text-right">
                <button type="submit"  class="btn btn-primary">Update</button>
          </div>
      </form>
  </div>
</div>
</div>


<!-------User College------------------>
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card">                  
            <form method="post" action="{{ route('update.coach.college.info', $user->id) }}"  enctype="multipart/form-data">
                @csrf                    
                <div class="card-header">
                    <h4>College Info</h4>                  
                  <input type="button"  class="btn btn-primary" value="Add College" onclick="addCollege()">
              </div>
              <div class="card-body"> 
                @if(@$userCollege)
                @foreach($userCollege as $val)                    
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>College</label>
                        <select class="form-control form-control-sm @error('college_id') is-invalid @enderror" name="college_id[]"  required>
                            <option value="">--Select College--</option>
                            <?php if($college){
                                foreach($college as $value){
                                    ?>
                                    <option 
                                    value="{{$value->id}}"
                                    {{ $value->id == $val ? 'selected': '' }}
                                    >{{ $value->name }}  
                                </option>
                                <?php
                            }
                        } ?>
                    </select>
                </div>

                <div class="col-md-4">
                   <input type="button" style="margin-top:30px;" class="btn btn-danger" value="Remove" onclick="removeCollege(this)">

               </div>

           </div>
           @endforeach
           @endif

           <div class="collegelist"></div>

       </div>
       <div class="card-footer text-right">
        <button type="submit"  class="btn btn-primary">Update</button>
    </div>
</form>
</div>
</div>
</div>
<!---------------->


</div>
</section>
</div>
@endsection
@section('script')
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'about' );
</script>
@if ($message = Session::get('error'))  
<script>   
  swal('{{ $message }}', 'Warning', 'error');
</script>
@endif
<script>
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


function addCollege(){
        var list="";        
        $.ajax({
            url:"{{url('admin/get-college')}}",
            type: "GET",
            data: {
                _token: '{{csrf_token()}}' 
            },
            dataType : 'json',
            success: function(result){
                console.log(result);

                list+='<div class="row">';
                list+='<div class="form-group col-md-4">';
                list+='<label>College</label>';
                list+='<select class="form-control form-control-sm " name="college_id[]"  required>';
                list+='<option value="">--Select College--</option>';
                $.each(result.college,function(key,value){
                    list+='<option value="'+value.id+'">'+value.name+'</option>';
                    
                });

                list+='</select>';
                list+='</div>';            

                list+='<div class="col-md-4">';
                list+='<input type="button" style="margin-top:30px;" class="btn btn-danger" value="Remove" onclick="removeCollege(this)">';

                list+='</div>';
                list+='</div>';
                $('.collegelist').append(list);
            }
        });
    }

     function removeCollege(dis){
     $(dis).closest(".row").remove();
    }
 /*$("#sportForm").submit(function(){        
     var sport_id= $("input[name=sport_id]").val();
     alert(sport_id);
     return false;
    });*/


</script>
@endsection
