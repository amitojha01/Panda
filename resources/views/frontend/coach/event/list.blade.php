@extends('frontend.coach.layouts.app')
@section('title', 'Events List')
@section('content')
<?php 
use App\Models\Events;
?>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="tab-container" id="CompareAjax">
                <div class="tab-menu">

                    <ul>
                        <li><a href="#" class="tab-a active-a" data-id="tab1">Promote Events</a></li>
                        <li><a href="#" class="tab-a " data-id="tab2"> <i class="fa fa-calendar" aria-hidden="true"></i> &nbsp; Event Opportunities</a></li>
                    </ul>
                </div>
                <div class="tab tab-active" data-id="tab1">
                    <div class="table-responsive">
                        <div class="clr"></div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="addathe_box_l">
                                    <!-- <h4>List of Events – Attended or Planning to Attend</h4> -->
                                    <!-- <h4>Search Posted Events</h4> -->
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="addathe_box_r">
                                    <!-- <div class="searaddathletes"> -->
                                        <!-- <input type="text" placeholder="Search for connections"/>
											<input type="submit" class="searaddathletesbtn" value=""/> -->
                                    <!-- </div> -->
                                    <a style="float:left;margin-top:10px;margin-bottom:10px" class="addevents_btn"
                                        href="{{route('coach.add-events')}}">Add
                                        Events</a>

                                    <div class="clr"></div>
                                </div>
                            </div>
                        </div>
                        <table class="tabtable" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <th>SL No.</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Sport</th>
                                <th>Event Name</th>
                                <th>Type of event</th>
                                <th>Location</th>
                                <th>Link to Event</th>
                                <th>Action</th>
                            </tr>
                            @if($user_event)
                            @foreach($user_event as $key => $user_event_details)
                            <tr>

                                <td>{{ $key+1}}</td>
                                <td>{{  date('m/d/Y', strtotime($user_event_details->start_date))  }}</td>
                                <td>{{  date('m/d/Y', strtotime($user_event_details->end_date))  }}</td>
                                <td>{{ $user_event_details->sp_name }}</td>
                                <td>{{ $user_event_details->event_name }}</td>
                                <td>{{ $user_event_details->ev_name }}</td>
                                <td>{{ $user_event_details->location }}</td>
                                <td>{{ $user_event_details->url }}</td>
                                <td>
                                    <!-- <button data-id="" class="btn-delete-row comparison-delete"><i class="fa fa-trash-o"
                                            aria-hidden="true"></i></button> -->
                                    <a href="{{url('coach/edit-events/'.$user_event_details->id)}}"><i
                                            class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <a href="javascript:void(0)" ><i class="fa fa-trash-o" aria-hidden="true" onclick="deleteEvent(<?= $user_event_details->id ?>)" ></i></a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </table>
                    </div>
                </div>

                <div class="tab " data-id="tab2">
                    <div class="container-fluid" style="margin-top: 30px;">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="addathe_box_l">
                                    <!-- <h4>List of Events – Attended or Planning to Attend</h4> -->
                                    <h4>Search Event Opportunities</h4>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="addathe_box_r">
                                    <!-- <div class="searaddathletes">
											<input type="text" placeholder="Search for connections"/>
											<input type="submit" class="searaddathletesbtn" value=""/>
											<div class="clr"></div>
										</div> -->
                                    <!-- <a style="float:left;" class="addevents_btn"
                                        href="{{route('coach.add-events')}}">Add
                                        Events</a> -->
                                    <a class="filter" href="" data-toggle="modal" data-target="#filterpopup"><img
                                            src="https://dev.fitser.com/dev2/Panda/dev/public/frontend/athlete/images/filter_option.jpg"
                                            alt="filter_option"></a>
                                    <div class="clr"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <?php 
									if (!empty(count($even_list))) {
									for($i=0; $i<count($even_list); $i++) {
										// $country_name = Events::where('id', @$athlete[$i]->address[0]->id)->first();
									?>
                            <div class="col-lg-4 col-md-12 col-sm-12">
                                <div class="gamebox coachrecommendationsbox">
                                    <div class="coachslider_img eventnewlisticon">
                                            <!-- <i class="fa fa-calendar-o" aria-hidden="true"></i> -->
                                            <img src="{{ asset('public/frontend/coach/images/Icon awesome-calendar-check.png') }}"
                                                alt="Icon awesome-calendar-check"
                                                style="height: 19px; width: 17px;  border-radius: 0;">
                                        </div>
                                    <div class="coachsliderbox">
                                        
                                        <div class="eventsbocnew">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-12 col-sm-12">
                                                    <div class="eventsboxleft">
                                                        <i>To</i>
                                                        <h6>Start Date</h6><b>{{ date('m/d/Y', strtotime($even_list[$i]->start_date))  }}</b>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-sm-12">
                                                    <div class="eventsboxright">
                                                        <h6>End Date</h6><b>{{ date('m/d/Y', strtotime($even_list[$i]->end_date))  }}</b>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="eventsboxleft">
                                                        <h6>Location</h6><b>{{ @$even_list[$i]->location }}</b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="eventbtngroup">
                                        <a href="" id="event_details" data-toggle="modal"
                                            data-r="{{ @$even_list[$i]->id }}" class="postbtn event_details">DETAILS</a>
                                        <?php if (($user_id= Auth()->user()->id)== $even_list[$i]->user_id ) { ?>
                                        <a href="{{url('coach/edit-events/'.@$even_list[$i]->id)}}"
                                            class="dontpostbtn">EDIT</a>
                                        <a href="javascript:void(0)" data-id="{{@$even_list[$i]->id}}"
                                            class="contactcaochbtn btn-delete-row">DELETE</a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <?php }  ?>
                        </div>
                        <?php }else{?>
                        <!-- end events list -->
                        <div class="row">

                            <div class="col-sm">
                                <div class="addathebox eventdetailsbox">
                                    <div class="addatheboximg">
                                        <h5>No Events Found</h5>
                                    </div>
                                    <h5>No Events Found</h5>
                                </div>
                            </div>

                        </div>
                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="clr"></div>
</div>

<!-- Modal -->
<div class="modal fade" id="filterpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
                        aria-hidden="true">&times;</span> </button>
                <h5>Events Details</h5>
                <div class="tab-container">
                    <div class="filtertabopoup_l">
                        <div class="tab-menu01">
                            <h3>Event Name:</h3>
                        </div>
                    </div>

                    <div class="clr"></div>

                    <input type="submit" class="applybtn" value="Apply" />
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


<!-- Modal -->
<div class="modal fade" id="eventsmodaldetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog filterpopup" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>


                <h3>Events Details</h3>

                <div class="eventsdetailspage">
                    <h5>Events Name</h5>
                    <h6>Buttercup Events</h6>

                    <h5>Location</h5>
                    <h6>Action Area II, Newtown, New Town, West Bengal 700156</h6>

                    <h5>Start Date</h5>
                    <h6>07/01/2021</h6>

                    <h5>End Date</h5>
                    <h6>07/24/2021</h6>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="filterpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
                        aria-hidden="true">&times;</span> </button>
                <h5>Apply Filter</h5>
                <div class="tab-container">
                    <div class="filtertabopoup_l">
                        <div class="tab-menu01">
                            <ul>
                                <li><a href="#" class="tab-a01 active-a01" data-id="tab1">Event Type</a></li>
                                <li><a href="#" class="tab-a01" data-id="tab2">Sport</a></li>
                                <li><a href="#" class="tab-a01" data-id="tab3">State</a></li>
                                <!-- <li><a href="#" class="tab-a01" data-id="tab4">City</a></li> -->
                                <li><a href="#" class="tab-a01" data-id="tab5">Date</a></li>
                            </ul>
                        </div>
                    </div>
                    <form action="" method="post">
                        <div class="filtertabopoup_r">

                            @csrf
                            <div class="tab01 tab-active01" data-id="tab1">
                                <!-- <div class="searaddathletes">
                            <input type="text" placeholder="Search for connections">
                            <input type="submit" class="searaddathletesbtn" value="">
                            <div class="clr"></div>
                            </div> -->
                                <ul>
                                    @foreach($cat_event as $cat_value)
                                    <li>
                                        {{$cat_value->name}}
                                        <div class="radioboxsub">
                                            <input type="checkbox" id="cat{{$cat_value->id}}" name="category[]"
                                                value="{{$cat_value->id}}">
                                            <label for="cat{{$cat_value->id}}"></label>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>


                            </div>
                            <div class="tab01" data-id="tab2">
                                <ul>
                                    @foreach($sport as $sport_value)
                                    <li>
                                        {{$sport_value->name}}
                                        <div class="radioboxsub">
                                            <input type="checkbox" id="sport{{$sport_value->id}}" name="sports[]"
                                                value="{{$sport_value->id}}">
                                            <label for="sport{{$sport_value->id}}"></label>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="tab01" data-id="tab3">
                                <ul>
                                    <select class="form-control" name="states" id="state"
                                        style="width: 100% !important;">
                                        <option value=''>Select </option>
                                        @foreach($states as $states_value)
                                        <option value="{{$states_value['id']}}"> {{$states_value['name']}}
                                        </option>
                                        @endforeach
                                    </select>
                                </ul>
                            </div>
                            <!-- <div class="tab01" data-id="tab4">
                                <h2>tab4</h2>
                            </div> -->
                            <div class="tab01" data-id="tab5">
                                <input type="text" class="form-control datepicker" name="start_date" value=""
                                    placeholder="MM-DD-YYYY" autocomplete="off" />
                                <input type="text" class="form-control datepicker" name="end_date" value=""
                                    placeholder="MM-DD-YYYY" autocomplete="off" />
                            </div>
                        </div>
                        <div class="clr"></div>

                        <input type="submit" class="applybtn" value="Apply" />
                        <from>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
@if ($message = Session::get('error'))
<script>
swal('{{ $message }}', 'Warning', 'error');
</script>
@endif
<script src="{{ asset('public/frontend/js/password.js') }}"></script>
<script>

 function deleteEvent(eventId){
        let id = eventId;
        
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
                        url: "{{url('coach/delete-events')}}" + "/" + id,
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
    }

function formatDate(date) {
     var d = new Date(date),
         month = '' + (d.getMonth() + 1),
         day = '' + d.getDate(),
         year = d.getFullYear();

     if (month.length < 2) month = '0' + month;
     if (day.length < 2) day = '0' + day;

     return [month, day, year].join('/');
 }

$(document).ready(function() {
    $('.event_details').on('click', function() {
        var event_id = $(this).attr('data-r');
        console.log(event_id);
        $.ajax({
            type: "POST",
            url: "{{ route('coach.details-events') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                event_id: event_id
            },
            dataType: "JSON",
            beforeSend: function() {
                //$("#overlay").fadeIn(300);
                $('#eventsmodaldetails').empty();
            },
            success: function(res) {
                if (res.success) {
                    $('#eventsmodaldetails').html('\
	                		<div class="modal-dialog filterpopup" role="document">\
    <div class="modal-content">      \
      <div class="modal-body">\
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">\
          <span aria-hidden="true">&times;</span>\
        </button>\
       	<h3>Events Details</h3>\
       	 <div class="eventsdetailspage">       	 	\
         <div class="row">\
         <div class="col-lg-6 col-md-12 col-sm-12">\
       	 <h5>Events Category</h5>\
       	 	<h6>' + res.data.data.name + '</h6>\
            </div>\
            <div class="col-lg-6 col-md-12 col-sm-12">\
       	 	<h5>Events Name</h5>\
       	 	<h6>' + res.data.data.event_name + '</h6>\
            </div>\
            <div class="col-lg-6 col-md-12 col-sm-12">\
       	 	<h5>Location</h5>\
       	 	<h6>' + res.data.data.location + '</h6>\
            </div>\
            <div class="col-lg-6 col-md-12 col-sm-12">\
       	 	<h5>Start Date</h5>\
       	 	<h6>' + formatDate(res.data.data.start_date) + '</h6>\
            </div>\
            <div class="col-lg-6 col-md-12 col-sm-12">\
       	 	<h5>End Date</h5>\
       	 	<h6>' + formatDate(res.data.data.end_date) + '</h6>\
            </div>\
            <div class="col-lg-6 col-md-12 col-sm-12">\
            <h5>Sport</h5>\
            <p>' + res.data.sport_name.name + '</p>\
            </div>\
            <div class="col-lg-6 col-md-12 col-sm-12">\
            <h5>State</h5>\
            <p>' + res.data.state.name + '</p>\
            </div>\
            <div class="col-lg-6 col-md-12 col-sm-12">\
            <h5>City</h5>\
            <p>' + res.data.data.city + '</p>\
            </div>\
            <div class="col-lg-12 col-md-12 col-sm-12">\
                        <h5>Event Details</h5>\
                        <h6>' + res.data.data.even_details + '</h6>\
                        </div>\
                        <div class="col-lg-12 col-md-12 col-sm-12">\
                        <h5>End Note</h5>\
                        <p>' + res.data.data.even_note + '</p>\
                        </div>\
                        <div class="col-lg-12 col-md-12 col-sm-12">\
                        <h5>Link for the event</h5>\
            <p><a href="'+ res.data.data.url +'" target="_blank">' + res.data.data.url + '</a></p>\
            </div>\
            </div>\
       	 </div>\
      </div>      \
    </div>\
  </div>');

                    //           		<div class="modal-dialog" role="document">\
                    // 	<div class="modal-content">\
                    // 		<div class="modal-body">\
                    // 			<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>\
                    // 			<h5>Events Details</h5>\
                    // 			<div class="tab-container">\
                    // 				<div class="filtertabopoup_l">\
                    // 					<div class="tab-menu01">\
                    // 						<p>Category: ' + res.data.category + '</p>\
                    // 						<p>Event Name: ' + res.data.event_name + '</p>\
                    // 						<p>Location: ' + res.data.location + '</p>\
                    // 						<p>City: ' + res.data.event_name + '</p>\
                    // 						<p>Start Date: ' + res.data.start_date + '</p>\
                    // 						<p>End Date: ' + res.data.end_date + '</p>\
                    // 						<p>Event Note: ' + res.data.even_note + '</p>\
                    // 						<p>Event Details: ' + res.data.even_details + '</p>\
                    // 					</div>\
                    // 				</div>\
                    // 				<div class="clr"></div>\
                    // 			</div>\
                    // 		</div>\
                    // 	</div>\
                    // </div>');
                    $('#eventsmodaldetails').modal('show');
                }
            }
        });
    });
});
</script>
<script>
$(document).ready(function() {

    $('.btn-delete-row').on('click', function() {
        let id = $(this).data('id');
        alert(id);
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
                        url: "{{url('coach/delete-events')}}" + "/" + id,
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
})

//==
$(function() {
            $('.datepicker').datepicker({
                maxDate: 0
            });



            
</script>

@if ($message = Session::get('error'))
<script>
swal('{{ $message }}', 'Warning', 'error');
</script>
@endif
@if ($message = Session::get('success'))
<script>
swal('{{ $message }}', 'Success', 'success');
</script>
@endif
@endsection