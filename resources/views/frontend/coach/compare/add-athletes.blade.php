@extends('frontend.coach.layouts.app')
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
		</div>
		<div class="col-md-6 col-sm-12 col-xs-12">
			<div class="addathe_box_r">
				<div class="searaddathletes">
					<input type="text" placeholder="Search for connections"/>
					<input type="submit" class="searaddathletesbtn" value=""/>
					<div class="clr"></div>
				</div>
				<!-- <a class="filter" href=""><img src="{{ asset('public/frontend/athlete/images/filter_option.jpg') }}" alt="filter_option"/></a> -->
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
	<div class="row">
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
				<input type="checkbox" name="add_compare_user" id="comparecheckbox{{ $athlete_list->id }}" class="add_compare_user" value="{{ $athlete_list->id }}">
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
</div>
@endsection
@section('script')
<script type="text/javascript">
	$(document).ready(function(){
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
                            url: "{{url('coach/update-comparison')}}"+"/"+id,
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
        });
</script>
@endsection