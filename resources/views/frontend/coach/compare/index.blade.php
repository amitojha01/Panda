@extends('frontend.coach.layouts.app')
@section('title', 'Compare')
@section('content')
<?php 
use App\Models\Compare;
use App\Models\Country;

use App\Models\UserWorkoutLibrary;
use App\Models\WorkoutCategoryLibrary;
use App\Models\WorkoutLibrary;
use App\Models\WorkoutCategory;
?>
<style>
    .addatheboximg{
        display: block !important;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="tab-container" id="CompareAjax">
                <div class="tab-menu">

                    <ul>
                        <li><a href="#" class="tab-a  <?php if($tabActive == "active"){}else{ echo"active-a";} ?> tab1openTag"  data-id="tab1">Saved Compare</a></li>
                        {{-- <li><a href="#" class="tab-a <?php if($tabActive == "active"){echo "active-a";}else{} ?> tab2openTag" data-id="tab2">Athletes</a></li> --}}
                        {{-- <li><a href="#" class="tab-a tab3openTag" data-id="tab3">Groups</a></li> --}}
                    </ul>
                </div>
                <?php
				$arr 	= [];
				$tmpArr	= [];
				?>
                <div class="tab <?php if($tabActive == "active"){}else{ echo"tab-active";} ?> tab1open" data-id="tab1">
                    <a href="javascript:void(0)" id="" data-toggle="modal" data-target="#myModal" onclick="$('#form-workout-library').trigger('reset');"
                        class="selectnewathletes event_details">START A NEW COMPARISON</a>
                    <div class="table-responsive">
                        <table class="tabtable" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <th>SL No.</th>
                                <th>Comparison Group Name</th>
                                <th>Action</th>
                                @if($comparison_group)
                                @foreach($comparison_group as $key => $comparison_group_details)
                            </tr>
                            <td>{{ $key+1}}</td>
                            <td>
                             <a href="{{ url('coach/comparison-details/'.@$comparison_group_details->id) }}">
                                    {{ $comparison_group_details->comparison_name }}
                            </a>
                            </td>
                            <td>
                                <span class="btn-delete-rows" onclick="deleteCompare(<?= $comparison_group_details->id ?>)"><i class="fa fa-trash-o"
                                        aria-hidden="true"></i></span>
                                     <!-- <button data-id="{{$comparison_group_details->id}}"
                                    class="btn-delete-row comparison-delete"><i class="fa fa-trash-o"
                                        aria-hidden="true"></i></button> -->
                            </td>
                            </tr>
                            @endforeach
                            @endif
                        </table>
                    </div>
                </div>

                {{-- <div class="tab <?php if($tabActive == "active"){echo "tab-active";}else{} ?> tab2open" data-id="tab2">
                    <div class="selectButton">
                        <input class="selectAll" id="ckbCheckAll" type="button" value="Select All">
                        <input class="selectAll" id="ckbCheckRemoveAll" type="button"  value="Remove All">
                    </div>
                    <div class="addathe_box_r comparesearchfilter">
                        <div class="searaddathletes">
                            <input type="text" placeholder="Search for connections" />
                            <input type="submit" class="searaddathletesbtn" value="" />
                            <div class="clr"></div>
                        </div>
                       
                        <a href="javascript:void(0)" id="compare_now" data-toggle="modal"
                        class="selectnewathletes comparenowgroup">Compare Now</a>  
                        <a class="filter custom" style="position: relative; top:7px; margin-left:20px;" href="" data-toggle="modal" data-target="#filterpopup"><img
                            src="{{ asset('public/frontend/athlete/images/filter_option.jpg') }}"
                            alt="filter_option" /></a>
                        
                    </div>
                    <div class="clr"></div>
                    <a href="javascript:void(0)" id="compare_now" data-toggle="modal"
                        class="selectnewathletes event_details">Compare Now</a>
                        
                    <div class="container-fluid">
                        <div class="row">
                            @if($athlete)
                            @foreach($athlete as $key => $athlete_list)
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="addathebox">
                                    <div class="addatheboximg">

                                        <?php if($athlete_list['profile_image']!=""){?>
                                            <img src="{{ asset($athlete_list['profile_image']) }}" alt="user_img"/> 

                                        <?php }else{ ?>
                                            <?php $uname = explode(" ", $athlete_list->username);
                                            $fname= $uname[0];
                                            $lname= @$uname[1];

                                            ?>
                                            <div class="pro-user"><?= ucfirst(@$fname[0]).ucfirst(@$lname[0]);?></div>

                                        <?php } ?>
                                        <!-- <img src="{{ isset($athlete_list['profile_image']) ? asset($athlete_list['profile_image']) : asset('public/frontend/athlete/images/defaultuser.jpg') }}"
                                            alt="addathe_user_img" /> -->
                                    </div>
                                    <?php 
												$country_name = Country::where('id', @$athlete_list->address[0]->country_id)->first();		

											?>
                                    <h5>{{ $athlete_list->username }}</h5>
                                    <span>Athlete, {{ @$country_name->name }}</span>


                                    <!-- <input type="button" class="add_athbtn" id="add_athbtn" user-id="{{ $athlete_list->id }}" value="Add"/>		 -->
                                    <label class="control" for="comparecheckbox{{ $athlete_list->id }}">
                                        <input type="checkbox" name="add_compare_user"
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
                </div> --}}

                {{-- <div class="tab tab3open" data-id="tab3">
                    <div class="addathe_box_r comparesearchfilter">
                        <div class="searaddathletes">
                            <input type="text" placeholder="Search for connections" />
                            <input type="submit" class="searaddathletesbtn" value="" />
                            <div class="clr"></div>
                        </div>
                        
                        <a href="javascript:void(0)" id="compare_now_group" data-toggle="modal"
                        class="selectnewathletes comparenowgroup" data-toggle="modal" data-target="#filterpopup">Select Group & Compare Now</a>
                    </div>
                    <div class="clr"></div>
                    <a href="javascript:void(0)" id="compare_now_group" data-toggle="modal"
                        class="selectnewathletes event_details" data-toggle="modal" data-target="#filterpopup">Compare Now</a>
                        <a class="filter custom" href="" data-toggle="modal" data-target="#filterpopup"><img
                                src="{{ asset('public/frontend/athlete/images/filter_option.jpg') }}"
                                alt="filter_option" /></a>
                    <div class="table-responsive">
                        <table class="tabtable" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <th>Group Name</th>
                                <th>No of Members</th>
                                <th>Action</th>
                            </tr>
                            @if($group)
                            @foreach($group as $key => $groupdetails)
                            <tr>
                                <td>{{ $groupdetails->group_name }}</td>
                                <?php 
                                    $count_member = App\Models\TeamingGroupUser::where('teaming_group_id', $groupdetails->id)
                                    ->get()->count();
                                ?>
                                <td>{{ $count_member }}</td>
                                <!-- <td><input type="checkbox" name="add_grp"  value="{{ $groupdetails->id }}" class="added_athbtn" ></td> -->
                                <td>
                                    <label class="control" for="comparecheckbox01{{ $groupdetails->id }}">
                                        <input type="checkbox" name="add_group_compare"
                                            data-p="{{ $groupdetails->group_name }}"
                                            id="comparecheckbox01{{ $groupdetails->id }}"
                                            value="{{ $groupdetails->id }}">
                                        <span class="control__content">
                                            Select Group
                                        </span>
                                    </label>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </table>
                    </div>
                </div> --}}
            </div>


            <!-- Group view -->
            {{-- <div class="container">
            </div> --}}
            <!-- End group view -->



        </div>
    </div>
</div>
</div>
<div class="clr"></div>
</div>


{{-- Akash --}}
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby=""
    aria-hidden="true">
    <div class="modal-dialog filterpopup" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="headTitle">Select workout you want to use for comparison ?</h5>
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
                                                            // echo "<pre>";
                                                            //     print_r($data_value);
                                                            //     die;
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

{{-- newAddCompare2nd --}}

<div class="modal fade" id="newAddCompare2nd" tabindex="-1" role="dialog" aria-labelledby=""
    aria-hidden="true">
    <div class="modal-dialog filterpopup" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="headTitle">Select Athletes from the filter or select Athletes from a TeamingUP Group for comparison</h5>
                <button type="button" class="close close_relode" id="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <p class="compare2ndpopup">
                    <input type="radio" id="test2" name="AthletesOrGroup" value="0">
                    <label for="test2">Athletes from the filter</label>
                 </p>
                 <p class="compare2ndpopup"><b>Or</b></p>
                 <p class="compare2ndpopup">
                    <input type="radio" id="test3" name="AthletesOrGroup" value="1">
                    <label for="test3">Select Athletes from a TeamingUP Group</label>
                 </p>
                
                <div class="clr"></div>
            </div>
            <div align="center" id="" style="margin-top:20px;">
                <button type="submit" id="save-workout-library-2nd-btn" class="addyourdashboard mb-3">CONTINUE</button>
            </div>
            
        </div>
    </div>
</div>

{{-- newAddCompare3nd --}}
{{-- athelatic --}}
<div class="modal fade" id="newAddCompare3nd" tabindex="-1" role="dialog" aria-labelledby=""
    aria-hidden="true" style="overflow: scroll;">
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
                        <input type="text" id="search_value" placeholder="Search for connections" />
                        <input type="submit" class="searaddathletesbtn" value="" />
                        <div class="clr"></div>
                    </div>
                   
                    {{-- <a href="javascript:void(0)" id="compare_now" data-toggle="modal"
                    class="selectnewathletes comparenowgroup">Compare Now</a>   --}}
                    <a href="javascript:void(0)" id="compare_now" data-toggle="modal"
                    class="selectnewathletes event_details" style="position: relative;
                        right: 0;
                        top: 3px;
                        margin-left: 20px;
                    ">Compare Now</a>
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
                                    <input type="checkbox" name="add_compare_user"
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

{{-- newAddCompare4nd --}}
{{-- group --}}
<div class="modal fade" id="newAddCompare4th" tabindex="-1" role="dialog" aria-labelledby=""
    aria-hidden="true">
    <div class="modal-dialog filterpopup" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="headTitle">Select Group to use comparison</h5>
                <button type="button" class="close close_relode" id="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{-- <div class="selectButton" style="padding: 0;">
                    <input class="selectAll" id="ckbCheckAll" type="button" value="Select All">
                    <input class="selectAll" id="ckbCheckRemoveAll" type="button"  value="Remove All">
                </div> --}}
                {{-- <div class="addathe_box_r comparesearchfilter"> --}}
                    {{-- <div class="searaddathletes">
                        <input type="text" placeholder="Search for connections" />
                        <input type="submit" class="searaddathletesbtn" value="" />
                        <div class="clr"></div>
                    </div> --}}
                   
                    {{-- <a href="javascript:void(0)" id="compare_now" data-toggle="modal"
                    class="selectnewathletes comparenowgroup">Compare Now</a>   --}}
                    
                {{-- </div> --}}
                
                <a href="javascript:void(0)" id="compare_now_group" data-toggle="modal"
                class="selectnewathletes" style="position: relative;top: 0;margin-bottom: 30px; right: 0;
                        float: right;
                    ">Select Group & Compare Now</a>
                    {{-- <a class="filter custom" href="" data-toggle="modal" data-target="#filterpopup"><img
                            src="{{ asset('public/frontend/athlete/images/filter_option.jpg') }}"
                            alt="filter_option" />
                    </a> --}}
                    <div class="clr"></div>
                    <div class="table-responsive">
                        <table class="tabtable" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <th>Group Name</th>
                                <th>No of Members</th>
                                <th>Action</th>
                            </tr>
                            @if($group)
                            @foreach($group as $key => $groupdetails)
                            <tr>
                                <td>{{ $groupdetails->group_name }}</td>
                                <?php 
                                    $count_member = App\Models\TeamingGroupUser::where('teaming_group_id', $groupdetails->id)
                                    ->get()->count();
                                ?>
                                <td>{{ $count_member }}</td>
                                <!-- <td><input type="checkbox" name="add_grp"  value="{{ $groupdetails->id }}" class="added_athbtn" ></td> -->
                                <td>
                                    <label class="control" for="comparecheckbox01{{ $groupdetails->id }}">
                                        <input type="checkbox" name="add_group_compare"
                                            data-p="{{ $groupdetails->group_name }}"
                                            id="comparecheckbox01{{ $groupdetails->id }}"
                                            value="{{ $groupdetails->id }}">
                                        <span class="control__content">
                                            Select Group
                                        </span>
                                    </label>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </table>
                    </div>

                
                <div class="clr"></div>
            </div>
            {{-- <div align="center" id="" style="margin-top:20px;">
                <button type="submit" id="save-workout-library-2nd-btn" class="addyourdashboard mb-3">CONTINUE</button>
            </div> --}}
            
        </div>
    </div>
</div>

<!-- compare Modal -->
<div class="modal fade" id="comparemodaldetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog filterpopup" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <div class="eventsdetailspage">
                    <h5>Comparison Name</h5>
                    <input type="text" class="form-control" name="comparison_name" id="comparison_name">
                    <div>
                        <h3>Athletes Members</h3>
                        <div class="" id="grp_member">
                            <!-- <div class="grp_member2">SK</div> -->
                        </div>
                    </div>
                    <input type="submit" class="addhighlightsbtn" name="submit" id="comparison_save" value="submit">
                </div>
            </div>
        </div>
    </div>
</div>




<!-- modal -->
<!-- Group compare Modal -->
<div class="modal fade" id="groupcomparemodaldetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog filterpopup" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <div class="eventsdetailspage">
                    <h5>Comparison Name</h5>
                    <input type="text" class="form-control" name="group_comparison_name" id="group_comparison_name">
                    <div>
                        <h3>Group members</h3>
                        <div class="" id="grp_member1">
                            <!-- <div class="grp_member2"> </div> -->
                        </div>
                    </div>
                    <input type="submit" class="addhighlightsbtn" name="submit" id="group_comparison_save"
                        value="submit">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal -->
<!-- Modal Filter-->
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



@endsection




@section('script')
{{-- first modal script  --}}
<script>
    $(document).ready(function () {

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
                                    '<input type="checkbox" name="add_compare_user" id="comparecheckbox'+v.id+'" class="add_compare_user checkBoxClass" value="'+v.id+'" data-c="'+v.username+'">'+
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
            sessionStorage.setItem('allSelectedLibrary', multi_members);
            // $.session.set("allSelectedLibrary", multi_members);
            // var new_session_value = sessionStorage.getItem('allSelectedLibrary');
            // console.log('hiidfd');
            // console.log(new_session_value);
            if(multi_members != '' ){
              $('#myModal').modal().hide();
              $(".modal-backdrop").addClass("hide");
              $('#newAddCompare2nd').modal('show');

            }else{
                swal({
                text: "Please add minimum one workout library!",
                icon: "warning",
                dangerMode: true,
            })
            return false;
            }
        });
        
        $("#save-workout-library-2nd-btn").click(function (){
            
            var AthletesOrGroup_value = $('input[name="AthletesOrGroup"]:checked').val();
            // alert(AthletesOrGroup_value)
            if( AthletesOrGroup_value == 1){
                $('#newAddCompare2nd').modal().hide();
               $('#newAddCompare4th').modal('show');
            }
            if( AthletesOrGroup_value == 0){
                $('#newAddCompare2nd').modal().hide();
                $('#newAddCompare3nd').modal('show');
                
                
            }
            
        });
    });
</script>
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
function selectcompare() {
    var compare_grp = [];
    $.each($("input[name='add_grp']:checked"), function() {
        console.log(value);
        compare_grp.push($(this).val());
    });

}

// selectcompare();	
$(document).ready(function() {

    $('.btn-delete-row').on('click', function() {
        let id = $(this).data('id');
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "{{url('coach/delete-compare')}}" + "/" + id,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(data) {
                            console.log(data);
                            swal(data.message, 'Success', 'success')
                                .then(() => {
                                    location.reload();
                                });
                        }
                    });
                } else {
                    return false;
                }
            });
    });

    $('#add_compare').on('click', function() {
        selectcompare();

        alert(compare_grp);
        // alert("My favourite sports are: " + favorite);
        $.ajax({
            url: "{{url('coach/compare-group')}}" + "/" + compare_grp,
            type: 'POST',
            data: {
                // "compare_grp" : compare_grp,
                "_token": "{{ csrf_token() }}",
            },
            success: function(data) {

                $('.container').html(data.html);
                $('#CompareAjax').hide();
            }
        });
    });

    $('#comparison_save').on('click', function() {
        var comparison_name = $("#comparison_name").val();
        var compare_grp = [];
        var allSelectedLibrary = sessionStorage.getItem('allSelectedLibrary');
        $.each($("input[name='add_compare_user']:checked"), function() {
            compare_grp.push($(this).val());
        });
        $(".modal-backdrop").addClass("hide");
        $.ajax({
            url: "{{url('coach/create-comparison')}}",
            type: 'POST',
            data: {
                "comparison_name": comparison_name,
                "compare_grp": compare_grp,
                "allSelectedLibrary" : allSelectedLibrary,
                "_token": "{{ csrf_token() }}",
            },
            success: function(data) {
                swal(data.message, 'Success', 'success')
                    .then(() => {
                        location.reload();
                    });
            }
        });
    });

    $('#group_comparison_save').on('click', function() {
        var group_comparison_name = $("#group_comparison_name").val();
        var group_compare = [];
        var allSelectedLibrary = sessionStorage.getItem('allSelectedLibrary');
        $.each($("input[name='add_group_compare']:checked"), function() {
            group_compare.push($(this).val());
        });
        $.ajax({
            url: "{{url('coach/create-comparison-bygroup')}}",
            type: 'POST',
            data: {
                "group_comparison_name": group_comparison_name,
                "group_compare": group_compare,  
                "allSelectedLibrary" : allSelectedLibrary,
                "_token": "{{ csrf_token() }}",
            },
            success: function(data) {
                swal(data.message, 'Success', 'success')
                    .then(() => {
                        location.reload();
                    });
            }
        });
    });
})
</script>
<script type='text/javascript'>
$(document).ready(function() {
    $('#compare_now').on('click', function() {
        var compare_name = [];
        $.each($("input[name='add_compare_user']:checked"), function() {
            compare_name.push($(this).attr('data-c'));
        });
        if (compare_name == "") {
            swal({
                text: "Please add minimum one Athlete!",
                icon: "warning",
                dangerMode: true,
            })
            return false;
        }
        $('#grp_member').empty();
        $.each(compare_name, function(key, value) {
            $('#grp_member').append(`
	             	<div class="grp_member2">` + value + `
	             	</div>`);
        });
        $('#comparemodaldetails').modal('show');
    });

    $('#compare_now_group').on('click', function() {
        var compare_name = [];
        $.each($("input[name='add_group_compare']:checked"), function() {
            compare_name.push($(this).attr('data-p'));
        });
        if (compare_name == "") {
            swal({
                text: "Please add minimum one Group!",
                icon: "warning",
                dangerMode: true,
            })
            return false;
        }
        $('#grp_member1').empty();
        $.each(compare_name, function(key, value) {
            $('#grp_member1').append(`
	             	<div class="grp_member2">` + value + `
	             	</div>`);
        });
        $('#groupcomparemodaldetails').modal('show');
    });
});
</script>
<script>
    $("#a2tab").on('click',function(){
     $('.tab2open').addClass("tab-active"); 
     $('.tab2openTag').addClass("active-a"); 
      // adding active class
     $('.tab1openTag').removeClass("active-a");  // adding active class
     $('.tab1open').removeClass("tab-active");  // adding active class
   
     $('#myModal').modal('hide');
});

$("#a3tab").on('click',function(){
    $('.tab3open').addClass("tab-active"); 
     $('.tab3openTag').addClass("active-a"); 
      // adding active class
     $('.tab1openTag').removeClass("active-a");  // adding active class
     $('.tab1open').removeClass("tab-active");  // adding active class
     $('#myModal').modal('hide');
});

//==


function deleteCompare(compareId){

    let id = compareId;  
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {                    
                    $.ajax({
                        //url: "{{url('coach/delete-compare')}}" + "/" + id,
                        url: "{{ url('coach/delete-compare') }}"+"/"+id,                      
                        type: 'POST',
                        data: {
                            id:id,
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(data) {
                            console.log(data);
                            swal(data.message, 'Success', 'success')
                                .then(() => {
                                    location.reload();
                                });
                        }
                    });
                } else {
                    return false;
                }
            });

}
</script>
{{-- NEW --}}
<script>
    var workoutCategory="";
    var workoutId = "";
    const savedWorkoutLibrary = [];
    $(document).ready(function(){ 
        $.ajax({
            type : "GET",
            url : "{{ url('api/get-workouts') }}",
            data : {},
            beforeSend: function(){
                //$("#overlay").fadeIn(300);
            },
            success: function(res){
                if(res.success){
                    if(res.data.length > 0){
                        workoutCategory = res.data;
                        res.data.forEach((v) => {
                            let image = base_url+"/"+v.image;
                            $('#workouts-category #workout_l_box')
                            .append('<div class="workout_l_box workout-category" id="'+v.id+'">\
                                <img src="'+image+'" alt="workout_img" />\
                                <span>'+v.category_title+'</span>\
                            </div>');
                        })
                        $('.workout-category#'+res.data[0].id).click();
                    }               
                }
            },
            error: function(err){
                console.log(err);
            }
        }).done( () => {            
        });

        $(document).on('click', '.workout-category', function(){
            $('.workout-category').removeClass('active');
            $(this).addClass('active');
            workoutId = $(this).attr('id');
            //get users updated workout librarys            
            $.ajax({
            type : "GET",
            url : "{{ url('api/get-user-workouts') }}?user_id={{ Auth()->user()->id }}",
            data : {},
            beforeSend: function(){
                //$("#overlay").fadeIn(300);
            },
            success: function(res){
                if(res.success){
                    if(res.data.length > 0){
                        savedWorkoutLibrary.splice(0, savedWorkoutLibrary.length);
                        for(data of res.data){
                            savedWorkoutLibrary.push(data.id);
                        }
                    }
                }
            },
            error: function(err){
                console.log(err);
            }
            }).done( () => {                
                getCategoryLibrary(workoutId);
            });
            //add workoput Id to save data
            $('input[name="workout_id"]').val(workoutId);
            //populate category info
            workoutCategory.forEach((v) => {
                if(v.id == workoutId){
                    if(v.banner != null){
                        $('#category-info img').attr('src', base_url+"/"+v.banner);
                    }
                    $('#category-info #title').html(v.content_title);
                    $('#category-info #description').html(v.description);
                    $('#workout-librarys #workout-title').html('Select '+v.category_title+' workouts list');
                }
            })
        });

        $('#form-workout-library').submit(function(e){
            e.preventDefault();
            if($('input[name="workout_library[]"]:checked').length < 1){
                swal('Please select library from list', 'Warning', 'warning');
                return false;
            }

            swal({
                title: "Are you sure?",
                text: "Want to add selected categories on dashboard",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    let fd = new FormData(this);
                    let workout_ids = [];
                    $('input[name="workout_library[]"]:checked').each(function(v){
                        workout_ids.push($(this).val());
                    })
                    fd.append('workout_library', workout_ids);
                    $.ajax({
                        type : "POST",
                        url : "{{ route('workouts.store') }}",
                        data : fd,
                        cache : false,
                        processData: false,
                        contentType: false,
                        beforeSend: function(){
                            //$("#overlay").fadeIn(300);
                        },
                        success: function(res){
                            if(res.success){
                                swal(res.message, 'Success', 'success');
                            }else{
                                swal(res.message, 'Warning', 'warning');
                            }
                        },
                        error: function(err){
                            console.log(err);
                            swal('Sorry!! Something went wrong', 'Warning', 'warning');
                        }
                    }).done( () => {
                        
                    });
                }
                });
                
        })

        $('#workout-tips').on('click', function(){
            window.location.href = "{{ url('/coach/workouts') }}/"+workoutId+"/tips";
        })
    })

    async function getCategoryLibrary(id){
        $.ajax({
            type : "GET",
            url : "{{ url('api/get-workouts/library') }}?workout_category_id="+id,
            data : {},
            beforeSend: function(){
                //$("#overlay").fadeIn(300);
            },
            success: function(res){
                if(res.success){
                    $('#workouts-category-library').html('');
                    if(res.data.length > 0){
                        var checked = "";
                        res.data.forEach((v, k) => {
                            let disabled = '';
                            if(v.is_aci_index == 1){
                                checked = 'checked';
                                disabled = 'disabled';
                            }else{
                                checked = savedWorkoutLibrary.indexOf(v.id) >=0 ? 'checked' : '';
                            }
                            let title = v.sport_category_title ?  v.sport_category_title : v.title;
                            $('#workouts-category-library').append('<div class="signinboxinput">\
                                    <div class="accout5_radio">\
                                        <span>'+title+'</span>\
                                        <div class="accout5_checkright">\
                                            <div class="form-group">\
                                                <input type="checkbox" name="workout_library[]" id="accountcheckbox'+k+'" value="'+v.id+'" '+checked+' '+disabled+'>\
                                                <label for="accountcheckbox'+k+'"></label>\
                                            </div>\
                                        </div>\
                                    </div>\
                                </div>'
                            );
                        });
                        $('#workout-add').show();
                        $('#workouts-category-library').append('<div class="clr"></div>');
                    }else{
                        $('#workout-add').hide();
                        swal('Sorry!! No data dound', 'Alert', 'warning');
                    }
                }
            },
            error: function(err){
                console.log(err);
                swal('Sorry!! Something went wrong', 'Warning', 'warning');
            }
        }).done( () => {
            
        });
    }
</script>
<script>
    $(document).ready(function(){
      $("#search_value").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#all_ath div").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
		
		$('#newAddCompare3nd').on("scroll", function() {      
		  	if ($(this).scrollTop() > 1){  
				$('header').addClass("sticky");                
			}
			else{
				$('header').removeClass("sticky");
			}
		});

        // $('#filterpopup').on("scroll", function() {      
		//   	if ($(this).scrollTop() > 1){  
		// 		$('header').addClass("sticky");
        //         console.log('ok filter');
		// 	}
		// 	else{
		// 		$('header').removeClass("sticky");
		// 	}
		// });

        


    });
    </script>
<!--
<script>
		$(window).scroll(function() {
			alert('SANJAY');
			if ($(this).scrollTop() > 1){  
				$('header').addClass("sticky");
			}
			else{
				$('header').removeClass("sticky");
			}
		});
	
	
</script>
-->


<script> 
   $('.close').click(function () {
       $('.modal-backdrop, .modal-dialog, .modal').hide();
       event.stopPropagation();
    // location.reload();
   })
   $('.close_relode').click(function () {
       $('.modal-backdrop, .modal-dialog, .modal').hide();
       event.stopPropagation();
    location.reload();
   })
   $('.close1').click(function () {
        $("#filterpopup").modal("hide");
        // if($("#newAddCompare3nd").data('bs.modal')?._isShown){
        //     //console.log('open');
        //     $("#newAddCompare3nd").css("overflow","scroll");
        // } else {
        //     //console.log('close');
        // }
   });
</script>
@endsection