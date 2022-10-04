@extends('frontend.coach.layouts.app')
@section('title', 'TeamingUPTM Group')
@section('content')
<?php 
use App\Models\TeamingGroupUser;

use App\Models\UserWorkoutLibrary;
use App\Models\WorkoutCategoryLibrary;
use App\Models\WorkoutLibrary;
use App\Models\WorkoutCategory;
use App\Models\Country;

?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-4 col-sm-12 col-xs-12">
			<div class="TeamingUPbox">
				<div class="addteamingup">
					<a href
					{{-- href="{{ route('athlete.create-teamingup-group') }}" --}}
					data-toggle="modal" data-target="#myModal" onclick="$('#form-workout-library').trigger('reset');"
					>
					<img src="{{ asset('public/frontend/athlete/images/redplus.png') }}" alt=""/>
				</a>
					<a href
					{{-- href="{{ route('athlete.create-teamingup-group') }}" --}}
					data-toggle="modal" data-target="#myModal" onclick="$('#form-workout-library').trigger('reset');"
					>Create New Group</a>
				</div>
			</div>
		</div>
		<?php
		$userId= Auth()->user()->id;
		if(!empty($group)){ 			
		 foreach($group as $value){
		 	if($value->created_by== $userId|| ($value->user_id== $userId  && $value->is_joined==1)){
		 	
		 	if($value->created_by== Auth()->user()->id){
		 		$btnTxt ="Created";
		 	}else{
		 		$btnTxt ="Joined";
		 	}
		 	$name_slug= str_replace(' ', '-', $value->group_name); 
		 ?>
		<div class="col-md-4 col-sm-12 col-xs-12">
			<div class="TeamingUPbox">
				<div class="TeamingUPbox_img">
					
					<a href="{{  route('coach.teamingup-group-details', ['id' => $value->id,'group-name'=>@$name_slug])}}">
						@if($value->image!="") 
						<img src="{{ asset($value->image) }}" alt="team_img"/>
						@else
						<img src="{{ asset('public/frontend/athlete/images/teamingup_img.png') }}" alt="teamingup_img"/>
						@endif					
				</a>
				</div>
				<div class="TeamingUPbox_text">
					<a href="{{ route('coach.teamingup-group-details',['id' => $value->id,'group-name'=>@$name_slug])}}">
						<h3>{{$value->group_name}}</h3>
					</a>
					<p>{{$value->description}}</p>
					<input type="button" class="joinedbtn" value="<?= @$btnTxt ?>"/>
				</div>
			</div>
		</div>
		<?php }}} 	 ?>
       
						
	</div>
</div>

</div>
<div class="clr"></div>
</div>

{{-- workout category library --}}
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby=""
    aria-hidden="true">
    <div class="modal-dialog filterpopup" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="headTitle" style="color: white;">Select workout you want to use for comparison ?</h5>
                <button type="button" class="close close_relode" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-5 col-sm-12 col-xs-12">

                            <div id="workout_l_box12" class="popupcompareleftbox tab-menu02">
                            <?php foreach($allWorkoutCategory as $key => $category_value){ 

                            ?> 
                                <div class="workout_l_box workout-category tab-a02 active-a02" data-id="tab{{$key+1}}">
                                    <img src="{{  asset($category_value->image) }}" alt="workout_img" />
                                    <span>{{ $category_value->category_title }}</span>
                                </div>
                            <?php } ?>

                            </div>
                        </div>
                        <div class="col-md-7 col-sm-12 col-xs-12">
                            <div class="workout_right">
                                <div class="workout_right_r comparepopupdesign" id="workout-librarys">
                                   
                                     <form action="" id="form-workout-library">
                                        @csrf
                                    
                                        <div id="workout_library_scroll" class="popupcomparerightbox">
            
                                   
                                            <div class="signinbox" id="workouts-category-library123">
                                                <?php 
                                                 foreach($allWorkoutCategory as $key => $workOutValue){    
                                                    $workout_library = WorkoutCategoryLibrary::where('workout_category_id', $workOutValue['id'])->get()->pluck('workout_library_id');
     
                                                    $data = [];
                                                        if(count($workout_library) > 0){
                                                            if($workOutValue['id'] != 8){
                                                                $data = WorkoutLibrary::where('status', 1)->where('is_aci_index', 0)->whereIn('id', $workout_library)->orderBy('title', 'asc')->get();
                                                            }else{
                                                                $data = WorkoutLibrary::where('status', 1)->whereIn('id', $workout_library)->orderBy('title', 'asc')->get();
                                                            
                                                            } 
                                                        }else{
                                                            $data = WorkoutLibrary::where('status', 1)->get();
                                                        }
                                                ?>
                                                <div class="tab02 {{$key== 0 ? 'tab-active02' : '' }}" data-id="tab{{$key+1}}">
                                               

                                                        @foreach($data as $key_val => $data_value)
                                                            <?php 
                                                            $workout_library_id_only = WorkoutCategoryLibrary::where('workout_category_id', $workOutValue['id'])->where('workout_library_id', $data_value->id)->get()->pluck('id');
                                                          
                                                            ?>
                                                            <div class="signinboxinput">
                                                                <div class="accout5_radio">
                                                                    <span>{{ $data_value->title }}</span>
                                                                    <div class="accout5_checkright">
                                                                        <div class="form-group" style="display: <?=$data_value->is_aci_index == 1 &&  $workOutValue['id'] !=8  ? 'none' : '' ;?>">
                                                                            <input type="checkbox" name="workout_cat_library_array[]" id="accountcheckbox{{$key+1}}{{$key_val}}" value="{{$workout_library_id_only[0]}}">
                                                                            <label for="accountcheckbox{{$key+1}}{{$key_val}}"></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                </div>
                                                <?php 
                                                }
                                                ?>
                                                
                                            </div>  
                                        </div>
                                    </form>
                                </div>
                                <div class="clr"></div>
                            </div>
                            
                        </div>
                    </div>
                    <div align="center" id="" style="margin-top:20px;">
                        <button type="submit" id="save-workout-library" class="addyourdashboard mb-3">CONTINUE</button>
                    </div>
                </div>
                <div class="clr"></div>
            </div>
        </div>
    </div>
</div>

{{-- newAddCompare3nd --}}
{{-- athelatic --}}
<div class="modal fade" id="newAddCompare3nd" tabindex="-1" role="dialog" aria-labelledby=""
    aria-hidden="true" style="overflow: scroll;" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
               <header>
                <h5 class="headTitle">Select Athletes with whom you want to compare</h5>
                <button type="button" class="close close_relode" id="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="selectButton" style="padding: 0;">
                    <input class="selectAll" id="ckbCheckAll" type="button" value="Select All">
                    <input class="selectAll" id="ckbCheckRemoveAll" type="button"  value="Remove All">
                </div>
                <div class="addathe_box_r comparesearchfilter popupmodalno3rd">
                    <div class="searaddathletes">
                        <input type="text" id="search_value" placeholder="Search Athletes" />
                        <input type="submit" class="searaddathletesbtn" value="" />
                        <div class="clr"></div>
                    </div>
                   
                    {{-- <a href="javascript:void(0)" id="compare_now" data-toggle="modal"
                    class="selectnewathletes comparenowgroup">Compare Now</a>   --}}
                    <a href="javascript:void(0)" id="athelatic_save_button" data-toggle="modal"
					{{-- data-toggle="modal" data-target="#createGroupDetails" --}}
                    class="selectnewathletes event_details" style="position: relative;
                        right: 0;
                        top: 3px;
                        margin-left: 20px;
                    ">Continue</a>
                    <a class="filter custom" style="position: relative; top:7px; margin-left:20px;" href="" data-toggle="modal" data-target="#filterpopup"><img
                        src="{{ asset('public/frontend/athlete/images/filter_option.jpg') }}"
                        alt="filter_option" /></a>
                </div>
                </header>
                
                    {{-- <a class="filter custom" href="" data-toggle="modal" data-target="#filterpopup"><img
                            src="{{ asset('public/frontend/athlete/images/filter_option.jpg') }}"
                            alt="filter_option" />
                    </a> --}}
                    <div class="clr"></div>
                <div class="container-fluid">
                    <div class="row" id="all_ath">
                        @if($athlete)
                        @foreach($athlete as $key => $athlete_list)
                        <div class="col-lg-3 col-md-6 col-sm-12" id="all_div">
                            <div class="addathebox">
                                <div class="addatheboximg">
                                    <img src="{{ isset($athlete_list['profile_image']) ? asset($athlete_list['profile_image']) : asset('public/frontend/athlete/images/defaultuser.jpg') }}"
                                        alt="addathe_user_img" />
                                </div>
                                <?php 
                                            $country_name = Country::where('id', @$athlete_list->address[0]->country_id)->first();		

                                        ?>
                                <h5>{{ $athlete_list->username }}</h5>
                                <span>Athlete, {{ @$country_name->name }}</span>


                                <!-- <input type="button" class="add_athbtn" id="add_athbtn" user-id="{{ $athlete_list->id }}" value="Add"/>		 -->
                                <label class="control" for="comparecheckbox{{ $athlete_list->id }}">
                                    <input type="checkbox" name="add_compare_user_array[]"
                                        id="comparecheckbox{{ $athlete_list->id }}" class="add_compare_user checkBoxClass"
                                        value="{{ $athlete_list->id }}" data-c="{{ $athlete_list->username }}">
                                    <span class="control__content">
                                        Select
                                    </span>
                                </label>
                            </div>
                        </div>
                        @endforeach
                        @endif

                    </div>
                </div>    
                
                <div class="clr"></div>
            </div>
            {{-- <div align="center" id="" style="margin-top:20px;">
                <button type="submit" id="save-workout-library-2nd-btn" class="addyourdashboard mb-3">CONTINUE</button>
            </div> --}}
            
        </div>
    </div>
</div>


{{-- -- save group -- --}}
<div class="modal fade" id="createGroupDetails" tabindex="-1" role="dialog" aria-labelledby=""
    aria-hidden="true">
    <div class="modal-dialog filterpopup" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="headTitle" style="color: white;">Select workout you want to use for comparison ?</h5>
                <button type="button" class="close close_relode" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <form method="post" action="{{ url('coach/add-group-teamingup') }}" id="createGroupForm_new" name="JobForm"  enctype="multipart/form-data">
                    @csrf     
                    <div class="container-fluid">
                            {{-- id="createGroupForm" --}}
                       
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="createteamingup_l">
                                    <div class="form-group">
                                        <label>Group Name</label>
                                        <input type="text" class="form-control" name="group_name" id="group_name" placeholder="Name your group" onkeyup="checkGroup(this)" required="" />
                                        <span style="color:red; font-size:13px; display:none;" id="existErr" >Group Name already exist!!</span>
                                        <input type="hidden" value="0" id="exist_group">
                                    </div>
                                    <div class="form-group">
                                        <label>About Group</label>
                                        <input type="text" class="form-control" name="description"  placeholder="Describe your group" required/>
                                        
                                        <input type="hidden" class="form-control" id="allSelectedLibrary_group" name="workout_id" value=""/>
                                        <input type="hidden" class="form-control" id="all_multi_athelatic" name="group_user_id"  value=""/>
                            
                                    </div>
                            
                                    <div class="upload-btn-wrapper">
                                        
                                        <button class="btn" id=""><i class="fa fa-file-image-o" aria-hidden="true"></i> &nbsp; Upload Cover Photo</button>
                                        <input type="file" name="image" id="iamge_file" required="" onchange="showMyImage(this)" />
                                        <img id="thumbnil" style="width:100%; border-radius:15px; margin-top:10px;" src="{{ asset('public/frontend/images/noimg.png') }}" alt="image"/> 
                                    </div>
                                    <input type="submit" class="creategroupbtn disable-create-group" id="group_submit_button_new" value="Create Group"/> 
                                    {{-- id="group_submit_button"  --}}
                                    </div>
                                </div>
                            {{-- <div class="col-md-9 col-sm-12 col-xs-12">    
                                <div class="row">
                                <div class="col-md-6 col-md-4 col-sm-12 col-xs-12-12 col-xs-12">
                                    <div class="addathe_box_l">
                                    <!--  <h4>Invite Connections</h4> -->
                                    </div>
                                </div>
                                <div class="col-md-6 col-md-4 col-sm-12 col-xs-12-12 col-xs-12"> --}}
                                    {{-- <div class="addathe_box_r">
                                    <div class="searaddathletes">
                                        <input type="text" placeholder="Search for connections" onkeyup="searchConnection(this)"/>
                                        <input type="submit" class="searaddathletesbtn" value=""/>
                                        <div class="clr"></div>
                                    </div>            
                                    <div class="clr"></div>
                                    </div> --}}
                                {{-- </div>
                                </div>
                                
                            </div> --}}
                            </div>
                        
                    </div>
                </form>

                <div class="clr"></div>
            </div>
        </div>
    </div>
</div>

{{-- Filter Modal --}}
<div class="modal fade" id="filterpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close1" data-dismiss="modal" aria-label="Close"> <span
                        aria-hidden="true">&times;</span> </button>
                <h5>Apply Filter</h5>
                <div class="tab-container">
                    <div class="filtertabopoup_l">
                        <div class="tab-menu01">
                            <ul>
                                 <li><a href="#" class="tab-a01 active-a01" data-id="tab1">Age</a></li>
                                <li><a href="#" class="tab-a01" data-id="tab2">Gender</a></li>
                                <li><a href="#" class="tab-a01" data-id="tab3">Sport</a></li>
                                <li><a href="#" class="tab-a01" data-id="tab4">Position</a></li>
                                <li><a href="#" class="tab-a01" data-id="tab5">City</a></li>
                                <li><a href="#" class="tab-a01" data-id="tab6">State</a></li>
                                <li><a href="#" class="tab-a01" data-id="tab7">Current competition level</a></li>
                                <li><a href="#" class="tab-a01" data-id="tab8">Zip Code</a></li>
                                <li><a href="#" class="tab-a01" data-id="tab9">Graduation Year</a></li>
                                
                            </ul>
                        </div>
                    </div>
                    <form action="" method="post">
                        <div class="filtertabopoup_r">

                            @csrf
                            <input type="hidden" name="modalOpen" value="3" >
                            <div class="tab01 tab-active01" data-id="tab1">
                                <input type="number" class="form-control" name="start_year" value=""
                                    placeholder="Year" autocomplete="off" />To
                                <input type="number" class="form-control" name="end_year" value=""
                                    placeholder="Year" autocomplete="off" />
                            </div>
                            <div class="tab01" data-id="tab2">
                                    <select class="form-control" name="gender" id="gender"
                                        style="width: 100% !important;">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="both">Both</option>
                                    </select>
                            </div>
                            <div class="tab01" data-id="tab3">
                                <ul>
                                    @foreach($sport as $sport_value)
                                    <li>
                                        {{$sport_value->name}}
                                        <div class="radioboxsub">
                                            <input type="checkbox" id="sport{{$sport_value->id}}" name="sports"
                                                value="{{$sport_value->id}}">
                                            <label for="sport{{$sport_value->id}}"></label>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="tab01" data-id="tab4">
                                <ul>
                                    @foreach($sport_position as $position_value)
                                    <li>
                                        {{$position_value->name}}
                                        <div class="radioboxsub">
                                            <input type="checkbox" id="position{{$position_value->id}}" name="position"
                                                value="{{$position_value->id}}">
                                            <label for="position{{$position_value->id}}"></label>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="tab01" data-id="tab5">
                                <ul>
                                    <select class="form-control" name="cities" id="cities"
                                        style="width: 100% !important;">
                                        <option value=''>Select </option>
                                        @foreach($cities as $cities_value)
                                        <option value="{{$cities_value->id}}"> {{$cities_value->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </ul>
                            </div>
                            <div class="tab01" data-id="tab6">
                                {{-- <ul>
                                    <select class="form-control" name="states" id="state"
                                        style="width: 100% !important;">
                                        <option value=''>Select </option>
                                        @foreach($states as $states_value)
                                        <option value="{{$states_value['id']}}"> {{$states_value['name']}}
                                        </option>
                                        @endforeach
                                    </select>
                                </ul> --}}

                                <ul>
                                    @foreach($states as $states_value)
                                    <li>
                                        {{$states_value['name']}}
                                        <div class="radioboxsub">
                                            <input type="checkbox" id="states{{$states_value['id']}}" name="states"
                                                value="{{$states_value['id']}}">
                                            <label for="states{{$states_value['id']}}"></label>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="tab01" data-id="tab7">
                                <ul>
                                    <select class="form-control" name="competition" id="competition"
                                        style="width: 100% !important;">
                                        <option value=''>Select </option>
                                        @foreach($competition_level as $competition_value)
                                        <option value="{{$competition_value['id']}}"> {{$competition_value['name']}}
                                        </option>
                                        @endforeach
                                    </select>
                                </ul>
                            </div>
                            <div class="tab01" data-id="tab8">
                                <input type="number" class="form-control" name="zip_code" value=""
                                    placeholder="Enter zip code" autocomplete="off" />
                            </div>
                            <div class="tab01" data-id="tab9">
                                <input type="number" class="form-control" name="graduation_year" value=""
                                    placeholder="Enter graduation year" autocomplete="off" />
                            </div>
                            
                        </div>
                        <div class="clr"></div>

                        <input type="button" class="applybtn filterbtnSubmit" value="Apply" />
                        <from>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- save group --}}
{{-- <div class="modal fade" id="createGroupDetails" tabindex="-1" role="dialog" aria-labelledby=""
    aria-hidden="true">
    <div class="modal-dialog filterpopup" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="headTitle" style="color: white;">Select workout you want to use for comparison ?</h5>
                <button type="button" class="close close_relode" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
				<div class="container-fluid">
					<form method="POST" action="{{ route('coach.create.teaming_group') }}" id="createGroupForm" enctype="multipart/form-data">
					   @csrf 
					 <div class="row">
					   <div class="col-md-12 col-sm-12 col-xs-12">
						 <div class="createteamingup_l">
						   <div class="form-group">
							 <label>Group Name</label>
							 <input type="text" class="form-control" name="group_name" id="group_name" placeholder="Name your group" onkeyup="checkGroup(this)" required="" />
							  <span style="color:red; font-size:13px; display:none;" id="existErr" >Group Name already exist!!</span>
							   <input type="hidden" value="0" id="exist_group">
						   </div>
						   <div class="form-group">
							 <label>About Group</label>
							 <input type="text" class="form-control" name="description"  placeholder="Describe your group" required/>
				   
						   </div>
				   
						   <div class="upload-btn-wrapper">
							 
							 <button class="btn" id=""><i class="fa fa-file-image-o" aria-hidden="true"></i> &nbsp; Upload Cover Photo</button>
							 <input type="file" name="image" id="iamge_file" required="" onchange="showMyImage(this)" />
							  <img id="thumbnil" style="width:100%; border-radius:15px; margin-top:10px;" src="{{ asset('public/frontend/images/noimg.png') }}" alt="image"/> 
						   </div>
						   <input type="button" class="creategroupbtn disable-create-group" id="group_submit_button" value="Create Group"/> 
				   
						 </div>
					   </div>
					   <div class="col-md-9 col-sm-12 col-xs-12">    
						 <div class="row">
						   <div class="col-md-6 col-md-4 col-sm-12 col-xs-12-12 col-xs-12">
							 <div class="addathe_box_l">
							 </div>
						   </div>
						   <div class="col-md-6 col-md-4 col-sm-12 col-xs-12-12 col-xs-12">

						   </div>
						 </div>
						 
					   </div>
					 </div>
				   	</form>
				</div>

                <div class="clr"></div>
            </div>
        </div>
    </div>
</div> --}}




@endsection

@section('script')
<script>
    $(document).ready(function () {
       $(".checkBoxClass").prop('checked', false);
       $("#ckbCheckAll").click(function () {
           // $(".checkBoxClass").attr('checked', this.checked);
           $(".checkBoxClass").prop('checked', true);
       });

       $("#ckbCheckRemoveAll").click(function () {
           // $(".checkBoxClass").attr('checked', this.checked);
           $(".checkBoxClass").prop('checked', false);
       });
   });
</script>
<script>
	
    $(".filterbtnSubmit").click(function (){
        var start_year = $("input[name='start_year']").val();
        var end_year = $("input[name='end_year']").val();
        var gender =  $("select[name='gender']").val();
        var sportsarray = Array();
        var positionarray = Array();
        var statesarray = Array();
        $("input:checkbox[name=sports]:checked").each(function(){
            sportsarray.push($(this).val());
        });
        $("input:checkbox[name=position]:checked").each(function(){
            positionarray.push($(this).val());
        });
        var cities = $("select[name='cities']").val();

        // var states = $("select[name='states']").val();
        $("input:checkbox[name=states]:checked").each(function(){
            statesarray.push($(this).val());
        });

        var competition = $("select[name='competition']").val();
        var zip_code = $("input[name='zip_code']").val();
        var graduation_year = $("input[name='graduation_year']").val();
        
        
        
        $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: "{{url('filter-athlete-compare')}}",
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    start_year: start_year,
                      gender : gender,
                    sports : sportsarray,
                    position : positionarray,  
                    cities : cities,
                    states : statesarray,
                    competition : competition,
                    zip_code : zip_code,
                    graduation_year: graduation_year
                },
                success: function(data) {
                    console.log(data);
                    var fieldHTML = '';       
                    var new_list = jQuery.parseJSON(data); 
                    console.log(new_list);
                    
                    $.each(new_list, function(k, v) {
                        console.log(v);
                    fieldHTML = fieldHTML +
                    '<div class="col-lg-3 col-md-6 col-sm-12" id="all_div">'+
                            '<div class="addathebox">'+
                                '<div class="addatheboximg">'+
                                    '<img src="'+v.profile_image+'" alt="addathe_user_img" />'+
                                '</div>'+
                                
                                '<h5>'+v.username+'</h5>'+
                                '<span>Athlete, '+v.country_name+'</span>'+
                                '<label class="control" for="comparecheckbox'+v.id+'">'+
                                    '<input type="checkbox" name="add_compare_user_array[]" id="comparecheckbox'+v.id+'" class="add_compare_user checkBoxClass" value="'+v.id+'" data-c="'+v.username+'">'+
                                    '<span class="control__content"> Select </span>'+
                                '</label>'+
                            '</div>'+
                        '</div>';
                    });
                    $('#all_ath').html(fieldHTML);
                                // swal(data.message, 'Success', 'success')
                        // .then(() => {
                        //     location.reload();
                        // });
                }
        });
        // console.log(sportsarray);
    })

	$("#save-workout-library").click(function () {
		// $.session.set("userName", $("#uname").val());
		// $.session.get('userName');
		// alert('hii');
		var multi_members="";
		$("input[name='workout_cat_library_array[]']:checked:enabled").each(function() {
		multi_members=$(this).val()+","+multi_members;
		});
		// console.log(multi_members);
		sessionStorage.setItem('allSelectedLibrary_group', multi_members);
		// $.session.set("allSelectedLibrary", multi_members);
		var new_session_value = sessionStorage.getItem('allSelectedLibrary_group');
		console.log('workout_cat_library_array');
		console.log(new_session_value);
		if(multi_members != '' ){
		  $('#myModal').modal().hide();
		  $(".modal-backdrop").addClass("hide");
		  $('#newAddCompare3nd').modal('show');

		}else{
			swal({
			text: "Please add minimum one workout library!",
			icon: "warning",
			dangerMode: true,
		})
		return false;
		}
	});

	$("#group_submit_button").click(function (){
		// alert('gg'); die;
		$("#createGroupForm").submit();
		// var formData = new FormData();

		var group_name = $("input[name='group_name']").val();
		var description = $("input[name='description']").val();
		var image = $('#image').val();
		// var image = $('input[name="image"]').get(0).files[0] ;
		// var image = $('#iamge_file')[0].files[0] ;
		var workout_id = sessionStorage.getItem('allSelectedLibrary_group');
		var group_user_id = sessionStorage.getItem('all_multi_athelatic');
		
        // var graduation_year = $("input[name='graduation_year']").val();
		// formData.append('group_name', $("input[name='group_name']").val());
        // formData.append('image', $('#iamge_file')[0].files[0]);
        // formData.append('description', $("input[name='description']").val());
        // formData.append('workout_id', workout_id);
        // formData.append('group_user_id', group_user_id);
        
        // console.log(formData);
		// die;
        
        $.ajax({
			
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: "{{url('/create-teamingup-group')}}",
                type: 'POST',
				
				// type: "PATCH",
                data: {
                    "_token": "{{ csrf_token() }}",
                    group_name: group_name,
					description : description,
                    image : image,
					group_user_id: group_user_id,
					workout_id: workout_id
                },
				     
				// data: formData,
				
				// cache : false,
    			// processData: false,
				// contentType: false,
				
                success: function(data) {
					// if(data == 1){
					// swal({
					// 	text: "Successfully added",
					// 	icon: "success",
					// 	dangerMode: true,
					// });
					location.reload();
				// }
				// else{
				// 	swal({
				// 		text: "failed",
				// 		icon: "error",
				// 		dangerMode: true,
				// 	});
				// 	location.reload();
				// }
			}
		});
	});

	// athelatic button
	$("#athelatic_save_button").click(function () {
		// $.session.set("userName", $("#uname").val());
		// $.session.get('userName');
		// alert('hii');
		var multi_athelatic="";
		$("input[name='add_compare_user_array[]']:checked:enabled").each(function() {
			multi_athelatic=$(this).val()+","+multi_athelatic;
		});
		// console.log(multi_members);
		sessionStorage.setItem('all_multi_athelatic', multi_athelatic);
		// $.session.set("allSelectedLibrary", multi_members);
		var new_session_value_athe = sessionStorage.getItem('all_multi_athelatic');
		console.log('all_multi_athelatic');
		console.log(new_session_value_athe);
		if(multi_athelatic != '' ){
		//   $('#myModal').modal().hide();
        $('#allSelectedLibrary_group').val(sessionStorage.getItem('allSelectedLibrary_group'));
        $('#all_multi_athelatic').val(sessionStorage.getItem('all_multi_athelatic'));
		  $(".modal-backdrop").addClass("hide");
		  $('#createGroupDetails').modal('show');

		}else{
			swal({
			text: "Please add minimum one member ",
			icon: "warning",
			dangerMode: true,
		})
		return false;
		}
	});

	$("#search_value").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#all_ath div").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

	function checkGroup(dis){
		var group_name= $(dis).val();
			$.ajax({
				url:"{{url('coach/check-group')}}",
				type: "GET",
				data: {
					group_name: group_name,
					_token: '{{csrf_token()}}'
				},
				dataType : 'json',
				success: function(result){         
				console.log(result);          
					if(result==0 ){
					$('#existErr').hide();
					$('#exist_group').val('0');

					/*if($('.colorgreen').length >0 && $('#exist_group').val()==0 ){
					$('.creategroupbtn').prop("disabled", false);
					$('.creategroupbtn').removeClass('disable-create-group');
					
					}*/
					$('.creategroupbtn').prop("disabled", false);
					$('.creategroupbtn').removeClass('disable-create-group');
				}else{ 
					$('#exist_group').val('1');

					$('#existErr').show();
					$('.creategroupbtn').prop("disabled", true);
					$('.creategroupbtn').addClass('disable-create-group');
					
					}
				}
			});
 	}

	function showMyImage(fileInput) {
		var files = fileInput.files;
		for (var i = 0; i < files.length; i++) { 
		var file = files[i];
		var imageType = /image.*/; 
		if (!file.type.match(imageType)) {
			continue;
		} 
		var img=document.getElementById("thumbnil"); 
		img.file = file; 
		var reader = new FileReader();
		reader.onload = (function(aImg) { 
			return function(e) { 
			aImg.src = e.target.result; 
			}; 
		})(img);
		reader.readAsDataURL(file);
		} 
	}
</script>


@endsection