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
                        <form method="post" action="{{ route('user.update', $user->id) }}" enctype="multipart/form-data">
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
                                    <label>Birth Day</label>
                                    <select class="form-control form-control-sm @error('day') is-invalid @enderror" name="day" required>
                                        <option value="" >Select Day</option>
                                        <?php
                                        for($i=1; $i<=31; $i++){
                                            ?>
                                            <option value="{{ $i }}" {{ $user->day == $i ? 'selected' : ''}}>{{ $i }}</option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    @if ($errors->has('day'))
                                    <div class="invalid-feedback">{{ $errors->first('day') }}</div>
                                    @endif
                                </div> 

                                <div class="form-group col-md-6">
                                    <label>Birth Month</label>
                                    <select class="form-control form-control-sm @error('month') is-invalid @enderror" name="month" required>
                                        <option value="" >Select Month</option>
                                        <?php
                                        for($i=1; $i<=12; $i++){
                                            ?>
                                            <option value="{{ $i }}" {{ $user->month == $i ? 'selected' : ''}}>{{ $i }}</option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    @if ($errors->has('month'))
                                    <div class="invalid-feedback">{{ $errors->first('month') }}</div>
                                    @endif
                                </div> 
                            </div>

                            <div class="row"> 
                                <div class="form-group col-md-6">
                                    <label>Birth Year</label>
                                    <select class="form-control form-control-sm @error('year') is-invalid @enderror" name="year" required onchange="getYear(this)">
                                        <option value="{{ @$user->year }}" >{{ @$user->year }}</option>
                                        
                                    </select>
                                    @if ($errors->has('year'))
                                    <div class="invalid-feedback">{{ $errors->first('year') }}</div>
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

      <!------Guardian Info--------------->
      <?php if(@$user->guardian[0]->first_name!=""){ ?>
        <div class="row" id="guardian-sec" >
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">                  
                <form method="post" action="{{ route('update.guardian.info', $user->id) }}" enctype="multipart/form-data">
                    @csrf                    
                    <div class="card-header">
                      <h4>Guardian Info</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Relationship</label>
                            <select class="form-control" name="relationship" required="">
                                <option value="father" {{ $user->guardian[0]->relationship == "father" ? 'selected' : ''}}>Father</option>
                                <option value="mother" {{ $user->guardian[0]->relationship == "mother" ? 'selected' : ''}} >Mother</option>
                                <option value="guardian" {{ $user->guardian[0]->relationship == "guardian" ? 'selected' : ''}}>Guardian</option>
                                <option value="grand father" {{ $user->guardian[0]->relationship == "grand father" ? 'selected' : ''}}>Grand Father</option>
                                <option value="grand mother" {{ $user->guardian[0]->relationship == "grand mother" ? 'selected' : ''}}>Grand Mother</option>
                                <option value="uncle" {{ $user->guardian[0]->relationship == "uncle" ? 'selected' : ''}}>Uncle</option>
                                <option value="aunt" {{ $user->guardian[0]->relationship == "aunt" ? 'selected' : ''}}>Aunt</option>
                                <option value="other" {{ $user->guardian[0]->relationship == "other" ? 'selected' : ''}}>Other</option>
                            </select>
                            @if ($errors->has('relationship'))
                            <span class="text-danger">{{ $errors->first('relationship') }}</span>
                            @endif 
                        </div> 
                        <div class="form-group col-md-4">
                            <label>First Name</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                            name="first_name" placeholder="First Name" required=""
                            value="{{ @$user->guardian[0]->first_name }}"
                            >
                            @if ($errors->has('first_name'))
                            <div class="invalid-feedback">{{ $errors->first('first_name') }}</div>
                            @endif
                        </div>
                        <div class="form-group col-md-4">
                            <label>Last Name</label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                            name="last_name" placeholder="Last Name" required=""
                            value="{{ @$user->guardian[0]->last_name }}"
                            >
                            @if ($errors->has('username'))
                            <div class="invalid-feedback">{{ $errors->first('username') }}</div>
                            @endif
                        </div>
                    </div>
                     <div class="row">
                        <div class="form-group col-md-4">
                            <label>Primary Phone</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                            name="primary_phone" placeholder="Primary Name" required=""
                            value="{{ @$user->guardian[0]->primary_phone }}"
                            >
                            @if ($errors->has('primary_phone'))
                            <div class="invalid-feedback">{{ $errors->first('primary_phone') }}</div>
                            @endif
                        </div>
                        <div class="form-group col-md-4">
                            <label>Phone Type</label>
                            <select class="form-control" name="primary_phone_type" required="">
                                <option value="mobile" {{ @$user->guardian[0]->primary_phone_type == "mobile" ? 'selected' : ''}} >Mobile</option>
                                <option value="other" {{ @$user->guardian[0]->primary_phone_type == "other" ? 'selected' : ''}}>Other</option>
                            </select>
                            @if ($errors->has('primary_phone_type'))
                            <span class="text-danger">{{ $errors->first('primary_phone_type') }}</span>
                            @endif 
                        </div> 
                        <div class="form-group col-md-4">
                            <label>Text</label>
                            <select class="form-control" name="is_primary_text" required="">
                                <option value="1" {{ @$user->guardian[0]->is_primary_text == 1 ? 'selected' : ''}}>Yes</option>
                            <option value="0" {{ @$user->guardian[0]->is_primary_text == 0 ? 'selected' : ''}}>No</option> 
                            </select>
                            @if ($errors->has('is_primary_text'))
                            <span class="text-danger">{{ $errors->first('is_primary_text') }}</span>
                            @endif 
                        </div>                         
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Secondary Phone</label>
                            <input type="text" class="form-control @error('secondary_phone') is-invalid @enderror"
                            name="secondary_phone" placeholder="Secondary Phone" required=""
                            value="{{ @$user->guardian[0]->secondary_phone }}"
                            >
                            @if ($errors->has('secondary_phone'))
                            <div class="invalid-feedback">{{ $errors->first('secondary_phone') }}</div>
                            @endif
                        </div>
                        <div class="form-group col-md-4">
                            <label>Phone Type</label>
                            <select class="form-control" name="secondary_phone_type" required="">
                                <option value="mobile" {{ @$user->guardian[0]->secondary_phone_type == "mobile" ? 'selected' : ''}}>Mobile</option>
                                <option value="other"  {{ @$user->guardian[0]->secondary_phone_type == "other" ? 'selected' : ''}}>Other</option> 
                            </select>
                            @if ($errors->has('secondary_phone_type'))
                            <span class="text-danger">{{ $errors->first('secondary_phone_type') }}</span>
                            @endif 
                        </div> 
                        <div class="form-group col-md-4">
                            <label>Text</label>
                            <select class="form-control" name="is_secondary_text" required="">
                                <option value="1" {{ @$user->guardian[0]->is_secondary_text == 1 ? 'selected' : ''}}>Yes</option>
                                <option value="0" {{ @$user->guardian[0]->is_secondary_text == 0 ? 'selected' : ''}}>No</option>
                            </select>
                            @if ($errors->has('is_secondary_text'))
                            <span class="text-danger">{{ $errors->first('is_secondary_text') }}</span>
                            @endif 
                        </div>                         
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Primary Email</label>
                             <input type="email"  class="form-control" placeholder="" name="primary_email" value="{{ @$user->guardian[0]->primary_email }}" required="" />
                            @if ($errors->has('primary_email'))
                        <span class="text-danger">{{ $errors->first('primary_email') }}</span>
                    @endif 
                        </div> 
                        <div class="form-group col-md-4">
                            <label>Enable Text Message</label>
                            <select class="form-control" name="enable_textmessage" required="">
                                <option value="1" {{ @$user->guardian[0]->enable_textmessage == 1 ? 'selected' : ''}}>Yes</option>
                                <option value="0" {{ @$user->guardian[0]->enable_textmessage == 0 ? 'selected' : ''}}>No</option>
                            </select>
                            @if ($errors->has('enable_textmessage'))
                            <span class="text-danger">{{ $errors->first('enable_textmessage') }}</span>
                            @endif 
                        </div>
                        <div class="form-group col-md-4">
                                <label>Select Status</label>
                                <select class="form-control  form-control-sm @error('status') is-invalid @enderror" name="status" required>
                                    <option value="1" {{ @$user->guardian[0]->status == 1 ? 'selected' : ''}}>Active</option>
                                    <option value="0" {{ @$user->guardian[0]->status == 0 ? 'selected' : ''}}>Inactive</option>
                                </select>
                                @if ($errors->has('status'))
                                <div class="invalid-feedback">{{ $errors->first('status') }}</div>
                                @endif
                            </div>
                    </div>
            




                    <!---------------->
                </div>
                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary">Update</button>
              </div>
          </form>
      </div>
  </div>
</div>

     <?php  } ?>

      
<!------Address Info--------------->
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card">                  
            <form method="post" action="{{ route('update.address.info', $user->id) }}" enctype="multipart/form-data">
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
                                    <select class="form-control" name="zip" required>
                                        <!-- <option value="">--Select--</option> -->
                                        <option value="{{ @$user->address[0]->zip }}">{{ @$user->address[0]->zip }}</option>

                                    </select>
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


  <!---User Physical Information--->
  <div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card">                  
            <form method="post" action="{{ route('update.physical.info', $user->id) }}" enctype="multipart/form-data">
                @csrf                    
                <div class="card-header">
                  <h4>Physical Info</h4>
              </div>
              <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Height</label>
                        <input type="hidden" name="user_id" value={{ $user->id }}>
                        <div class="row">
                            <div class="col-md-6">
                               <input type="number" min="1"  value="{{ @$user->physicalInfo[0]->height_feet }}" class="form-control" placeholder="5 (in feet)" name="height_feet"/>

                           </div>

                           <div class="col-md-6">
                            <input type="number" min="1"  value="{{ @$user->physicalInfo[0]->height_inch }}" class="form-control" placeholder="8 (in inch)" name="height_inch"/>

                        </div>
                    </div>  
                    @if ($errors->has('height_inch'))
                    <span class="text-danger">{{ $errors->first('height_inch') }}</span>
                    @endif 
                </div>
                <div class="form-group col-md-6">
                    <label>Weight</label>
                    <input type="number" min="1" step=".01" class="form-control @error('weight') is-invalid @enderror" 
                    name="weight" placeholder="Weight" required=""
                    value="{{ @$user->physicalInfo[0]->weight }}"
                    >
                    @if ($errors->has('weight'))
                    <div class="invalid-feedback">{{ $errors->first('weight') }}</div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Wingspan</label>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="number" min="1" step=".01" value="{{ @$user->physicalInfo[0]->wingspan_feet }}" class="form-control" placeholder="2 (in feet)" name="wingspan_feet"/>
                            @if ($errors->has('wingspan_feet'))
                            <span class="text-danger">{{ $errors->first('wingspan_feet') }}</span>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <input type="number" min="1" step="" value="{{ @$user->physicalInfo[0]->wingspan_inch }}" class="form-control" placeholder="3 (in inch)" name="wingspan_inch"/>
                            @if ($errors->has('wingspan_inch'))
                            <span class="text-danger">{{ $errors->first('wingspan_inch') }}</span>
                            @endif 
                        </div>

                    </div>
                    @if ($errors->has('wingspan'))
                    <div class="invalid-feedback">{{ $errors->first('wingspan') }}</div>
                    @endif

                </div>

                <div class="form-group col-md-6">
                    <label>Head</label>
                    <input type="number" class="form-control @error('head') is-invalid @enderror" min="1" step=".01" 
                    name="head" placeholder="Head" required="" value="{{ @$user->physicalInfo[0]->head }}"
                    >
                    @if ($errors->has('head'))
                    <div class="invalid-feedback">{{ $errors->first('head') }}</div>
                    @endif
                </div>

            </div> 
            <div class="row">                          
                <div class="form-group col-md-6">
                    <label>Education</label>
                    <select class="form-control form-control-sm @error('education_id') is-invalid @enderror" name="education_id" required>
                        <option value="">--Select Education--</option>
                        @if($education)
                        @foreach($education as $value)
                        <option value="{{$value->id}}"
                            {{ $value->id == @$user->physicalInfo[0]->education_id ? 'selected' : ''}}
                            >{{ $value->name }}</option>
                            @endforeach
                            @endif
                        </select>
                        @if ($errors->has('education_id'))
                        <div class="invalid-feedback">{{ $errors->first('education_id') }}</div>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label>Grade</label>
                        <input type="text" class="form-control @error('grade') is-invalid @enderror"
                        name="grade" placeholder="Grade" required=""
                        value="{{ @$user->physicalInfo[0]->grade }}"
                        >
                        @if ($errors->has('grade'))
                        <div class="invalid-feedback">{{ $errors->first('grade') }}</div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Select Status</label>
                        <select class="form-control form-control-sm @error('status') is-invalid @enderror" name="status" required>
                            <option value="1" {{ @$user->physicalInfo[0]->status == 1 ? 'selected' : ''}}>Active</option>
                            <option value="0" {{ @$user->physicalInfo[0]->status == 0 ? 'selected' : ''}}>Inactive</option>
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
<!----User Sports Info------->
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card">                  
            <form method="post" action="{{ route('update.sport.info', $user->id) }}" enctype="multipart/form-data">
                @csrf                    
                <div class="card-header">
                  <h4>Sports Info</h4>
                  <input type="hidden" name="user_id" value={{ $user->id }}>
                  <input type="button"  class="btn btn-primary" value="Add Sports" onclick="addSport()">
              </div>
              <div class="card-body"> 
                @if($userSports)
                @foreach($userSports as $val)                    
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Sports</label>
                        <select class="form-control form-control-sm @error('sport_id') is-invalid @enderror" name="sport_id[]" onchange="getSportPos(this)" required>
                            <option value="">--Select Sport--</option>
                            <?php if($sport){
                                foreach($sport as $value){
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
                    <label>Sports Position</label>
                    <?php 
                    $position = SportPosition::where(['sport_id'=> $val])->get();
                    $pos_selected="";
                    ?>
                    <select class="form-control form-control-sm @error('sport_position_id') is-invalid @enderror sportpos-dropdown" name="sport_position_id[]" required>
                        <option value="">--Select Sport--</option>
                        <?php if($position){
                            foreach($position as $value){
                                if (in_array($value->id, $userSportpos)) {
                                    $pos_selected='selected';
                                }
                                ?>
                                <option 
                                value="{{$value->id}}"
                                {{ $pos_selected }}
                                >{{ $value->name }}  
                            </option>
                            <?php $pos_selected="";
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

       <h6>Competitive Level</h6>       
       <div class="row">
        <div class="form-group col-md-6">
            <label>School Playing Level</label>
            <select class="form-control form-control-sm @error('school_level_id') is-invalid @enderror" name="school_level_id" required>
                <option value="">--Select--</option>
                @if($school_playingList)
                @foreach($school_playingList as $value)
                <option value="{{$value->id}}"
                    {{ $value->id == @$user_school_level_id ? 'selected' : ''}}
                    >{{ $value->name }}</option>
                    @endforeach
                    @endif
                </select>
                @if ($errors->has('school_level_id'))
                <div class="invalid-feedback">{{ $errors->first('school_level_id') }}</div>
                @endif
            </div>
            <div class="form-group col-md-6">
                <label>Rec/Club/Travel Level</label>
                <select class="form-control form-control-sm @error('other_level_id') is-invalid @enderror" name="other_level_id" required>
                    <option value="">--Select--</option>
                    @if($travelList)
                    @foreach($travelList as $value)
                    <option value="{{$value->id}}"
                        {{ $value->id == @$user_other_level_id ? 'selected' : ''}}
                        >{{ $value->name }}</option>
                        @endforeach
                        @endif
                    </select>
                    @if ($errors->has('other_level_id'))
                    <div class="invalid-feedback">{{ $errors->first('other_level_id') }}</div>
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
