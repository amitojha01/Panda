@extends('frontend.athlete.layouts.app')
@section('title', 'Add Athletes to Compare')
@section('content')
<?php 
use App\Models\Compare;
use App\Models\Country;
 $segment1 =  Request::segment(3); 
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-6 col-sm-12 col-xs-12">
			<div class="addathe_box_l">
				<h4>List of Athletes</h4>
			</div>
            <!------>
         <div class="selectButton" style="padding: 0;">
                    <input class="selectAll" id="ckbCheckAll" type="button" value="Select All">
                    <input class="selectAll" id="ckbCheckRemoveAll" type="button"  value="Remove All">
                </div>

        <!----------->
		</div>

		<div class="col-md-6 col-sm-12 col-xs-12">
			<div class="addathe_box_r">
				<div class="searaddathletes">
					<input type="text" id="search_value" placeholder="Search for connections"/>
					<input type="submit" class="searaddathletesbtn" value=""/>
					{{-- <a class="filter custom" style="position: relative; top:7px; margin-left:20px;" href="" data-toggle="modal" data-target="#filterpopup"><img
                        src="{{ asset('public/frontend/athlete/images/filter_option.jpg') }}"
                        alt="filter_option" /></a> --}}
					<div class="clr"></div>
				</div>
				<!-- <a class="filter" href=""><img src="{{ asset('public/frontend/athlete/images/filter_option.jpg') }}" alt="filter_option"/></a> -->
				
				 <a class="filter custom" style="position: relative; top:7px; margin-left:20px;" href="" data-toggle="modal" data-target="#filterpopup"><img
                        src="{{ asset('public/frontend/athlete/images/filter_option.jpg') }}"
                        alt="filter_option" /></a>


				<div class="clr"></div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="addathe_box_r">
					<button id="comparison_save" value="{{ $segment1 }}"  class="add_compare_user addtocomparebtn">Add to this comparison</button>
					<div class="clr"></div>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid">
	<div class="row" id="all_ath">
		@if($athlete)
		@foreach($athlete as $key => $athlete_list)
		<div class="col-sm">
			<div class="addathebox">
				<div class="addatheboximg">
					<img src="{{ isset($athlete_list['profile_image']) ? asset($athlete_list['profile_image']) : asset('public/frontend/athlete/images/defaultuser.jpg') }}" alt="addathe_user_img"/>
				</div>
				<?php 
							$country_name = Country::where('id', @$athlete_list->address[0]->country_id)->first();		

						?>
				<h5>{{ $athlete_list->username }}</h5>
				<span>Athlete, {{ @$country_name->name }}</span>

				<!-- <input type="button" class="add_athbtn" id="add_athbtn" user-id="{{ $athlete_list->id }}" value="Add"/>	 -->
				<label class="control" for="comparecheckbox{{ $athlete_list->id }}">
				<input type="checkbox" name="add_compare_user" id="comparecheckbox{{ $athlete_list->id }}" class="add_compare_user checkBoxClass" value="{{ $athlete_list->id }}">
				<span class="control__content">Select</span>
				</label>
					
			</div>
		</div>
		@endforeach
		@endif
			
	</div>
</div>


</div>
<div class="clr"></div>

<!--Filter Modal--->
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

</div>


@endsection
@section('script')
<script type="text/javascript">
	$(document).ready(function(){
      $("#search_value").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#all_ath div").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
	$('#comparison_save').on('click', function(){
            	// var segment1 =  Request::segment(3);;
            	var id = $("#comparison_save").val();
                var compare_grp = [];
            $.each($("input[name='add_compare_user']:checked"), function(){
                compare_grp.push($(this).val());
            });
	            if(compare_grp == ""){
		             	swal({
	                    text: "Please add minimum one Athlete!",
	                    icon: "warning",
	                    dangerMode: true,
	                    })
		             	return false;
		         	}
            
                        $.ajax({
                            url: "{{url('athlete/update-comparison')}}"+"/"+id,
                            type:'POST',
                            data: {
                                "compare_grp" : compare_grp,
                                "_token" : "{{ csrf_token() }}",
                            },
                            success: function(data) {
                                swal(data.message,'Success', 'success')
                                .then( () => {
                                	 window.location=document.referrer;
                                });

                        	}
                        });
            });

	/***Filter Athlete ****/
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
    
        });

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
@endsection