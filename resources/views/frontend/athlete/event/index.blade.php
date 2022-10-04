@extends('frontend.athlete.layouts.app')
@section('title', 'Events')
@section('content')
<?php 
use App\Models\Events;
?>

<div class="createteamingup">
	<div class="container-fluid">
		<div class="addgamehighlightes">
			<form method="post" action="{{ route('athlete.save-events') }}" enctype="multipart/form-data">
				@csrf
				<div class="addgamehighlightesinner">
					<h3>Add/Edit Event</h3>
					<div class="row">
						<input type="hidden" name="eventId" value="{{isset($data)?($data->id):''}}">
						<div class="col-md-6">
							<div class="form-group ">
								<label>Category</label>
								<select class="form-control" name="category" required>
									<option>Select Category</option>
									<option value="1" {{ ((@$data->category)=="1")? "selected" : "" }}>Camp</option>
									<option value="2" {{ ((@$data->category)== 2)? "selected" : "" }}>Combine</option>
									<option value="3" {{ ((@$data->category)=="3")? "selected" : "" }}>Tournament</option>
								</select>      		
								@if ($errors->has('category'))
								<div class="invalid-feedback">{{ $errors->first('category') }}</div>
								@endif 
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Event Name</label>
								<input type="text" class="form-control" name="event_name" placeholder="event name" value="{{isset($data)?($data->event_name):''}}"  required/> 
								@if ($errors->has('event_name'))
								<div class="invalid-feedback">{{ $errors->first('event_name') }}</div>
								@endif     		
							</div>
						</div>
						<div class="col-md-12">	
							<div class="form-group">
								<label>Field, Stadium, or Main Area of Activity </label>
								<input type="text" class="form-control " name="location" placeholder="e.g. – Univ of Maryland campus, or Penn State University main campus" value="{{isset($data)?($data->location):''}}" required/> 
								@if ($errors->has('location'))
								<div class="invalid-feedback">{{ $errors->first('location') }}</div>
								@endif      		
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Sport</label>
								<select class="form-control"  name="sport" required>
									<option value=""  >Select</option>
								</select>  
								@if ($errors->has('sport'))
								<div class="invalid-feedback">{{ $errors->first('sport') }}</div>
								@endif     		
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>State</label>
								
								<select class="form-control" id="state" name="state" required>
									<option value=""  >Select</option>
								</select>  
								
								@if ($errors->has('state'))
								<div class="invalid-feedback">{{ $errors->first('state') }}</div>
								@endif   		
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>City</label>
								<select class="form-control" id="city"  name="city" required>
									<option value=""  >Select</option>
									@if(@$city)
									@foreach(@$city as $value)
									<option value="{{@$value->id}}" {{ @$data->city == @$value->id  ? 'selected': '' }}      
										>{{ @$value->name }}</option>
										@endforeach
										@endif
									</select>  
									
									@if ($errors->has('city'))
									<div class="invalid-feedback">{{ $errors->first('city') }}</div>
									@endif     		
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>URL of EVENT</label>
									<input type="text" class="form-control" name="url" placeholder="URL of EVENT" value="{{isset($data)?($data->url):''}}"  required/> 
									@if ($errors->has('url'))
									<div class="invalid-feedback">{{ $errors->first('url') }}</div>
									@endif     		
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group ">
									<label>Start Date</label>
									<input type="text" class="form-control" id="txtFromDate" value="{{isset($data)?(   date('m/d/Y', strtotime($data->start_date))):''}}" placeholder="MM-DD-YYYY"  name="start_date"/>
									
									<span><i class="fa fa-calendar" aria-hidden="true"></i></span>
									@if ($errors->has('start_date'))
									<div class="invalid-feedback">{{ $errors->first('start_date') }}</div>
									@endif
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group ">
									<label>End Date</label>
									<input type="text" class="form-control" value="{{isset($data)?(date('m/d/Y', strtotime($data->end_date))):''}}" name="end_date" placeholder="MM-DD-YYYY"  id="txtToDate" />
									
									<span><i class="fa fa-calendar" aria-hidden="true"></i></span>
									@if ($errors->has('end_date'))
									<div class="invalid-feedback">{{ $errors->first('end_date') }}</div>
									@endif
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Event Details</label>
									
									<textarea id="editor" name="even_details">{{isset($data)?($data->even_details):''}}</textarea>
									@if ($errors->has('even_details'))
									<div class="invalid-feedback">{{ $errors->first('even_details') }}</div>
									@endif   		
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Event Note</label>
									<textarea placeholder="Type here..." name="even_note" >{{isset($data)?($data->even_note):''}}</textarea>   	
									@if ($errors->has('even_note'))
									<div class="invalid-feedback">{{ $errors->first('even_note') }}</div>
									@endif
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="form-group ">
									<label>Status</label>
									<select class="form-control" name="status" required>
										<option>--Select--</option>
										<option value="1" {{ ((isset($data) && $data->status)=="1")? "selected" : "" }}>Active</option>
										<option value="0" {{ ((isset($data) && $data->status)=="0")? "selected" : "" }}>Inactive</option>
									</select>      		
									@if ($errors->has('status'))
									<div class="invalid-feedback">{{ $errors->first('status') }}</div>
									@endif 
								</div>
							</div>
						</div>
						<input type="submit" class="addhighlightsbtn" value="Submit"/>
						<!-- <input type="submit" class="addhighlightsbtn" value="Back"/> -->
						<a href="{{url('athlete/events')}}" class="addhighlightsbtn eventsbackbtn">Back</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="clr"></div>

	@endsection
	@section('script')
	<script src="https://cdn.ckeditor.com/ckeditor5/31.0.0/classic/ckeditor.js"></script>
	<script>
		ClassicEditor
		.create( document.querySelector( '#editor' ) )
		.then( editor => {
			console.log( editor );
		} )
		.catch( error => {
			console.error( error );
		} );
	</script>

	<script>
		$(function(){
			$('.datepicker').datepicker({
   // minDate: 0
   
});
		})



		$(document).ready(function(){
			$("#txtFromDate").datepicker({
				numberOfMonths: 1,
				onSelect: function(selected) {
					$("#txtToDate").datepicker("option","minDate", selected)
				}
			});
			$("#txtToDate").datepicker({ 
				numberOfMonths: 1,     
				onSelect: function(selected) {
					$("#txtFromDate").datepicker("option","maxDate", selected)
				}
			});  
		});


	</script>

	@if ($message = Session::get('error'))  
	<script>   
		swal('{{ $message }}', 'Warning', 'error');
	</script>
	@endif
	<script src="{{ asset('public/frontend/js/password.js') }}"></script>
	<script>
		const state_id = "{{isset($data)?($data->state):'0'}}";
		console.log(state_id);	
		$(document).ready(function(){
        //Club
        $.ajax({
        	type : "GET",
        	url : "{{ url('api/get-state?country_id=231') }}",
        	data : {},
        	beforeSend: function(){
                //$("#overlay").fadeIn(300);
            },
            success: function(res){
            	console.log(res);
            	if(res.success){
            		res.data.forEach((v) => {
            			let selected = state_id!=0 ? (state_id == v.id ? 'selected': '') : '';
            			$('select[name="state"]')
            			.append('<option value="'+v.id+'" '+selected+'>'+v.name+'</option>');
            		})

            	}
            },
            error: function(err){
            	console.log(err);
            }
        }).done( () => {
        })   
        
    })

	// sport

	//const sport_id = "{{isset($sport)?($data->sport):'0'}}";
	const sport_id = "{{isset($data)?($data->sport):'0'}}";
	console.log(sport_id);
	$(document).ready(function(){
        //Club
        $.ajax({
        	type : "GET",
        	url : "{{ url('api/get-sports') }}",
        	data : {},
        	beforeSend: function(){
                //$("#overlay").fadeIn(300);
            },
            success: function(res){
            	console.log(res);
            	if(res.success){
            		res.data.forEach((v) => {
            			console.log(v);
            			let selected = sport_id!=0 ? (sport_id == v.id ? 'selected': '') : '';
            			$('select[name="sport"]')
            			.append('<option value="'+v.id+'" '+selected+'>'+v.name+'</option>');
            		})

            	}
            },
            error: function(err){
            	console.log(err);
            }
        }).done( () => {
        })   
        
    })


	// state_id
	$('#state').on('change',function(){
		var state_id = $('#state option:selected').val();
		if(state_id == ''){
			$('#city').empty();
			$('#city').append('<option>Select</option>');
			return false;
		}
		
		const city_id = "{{isset($city)?($data->city):'0'}}";
		//const city_id = "{{isset($data)?($data->city):'0'}}";
		//alert(city_id);
		// if(){
		// 	const city_id =	state_value;
		// }
		$('#city').empty();
		console.log(city_id);
		$(document).ready(function(){

        //Club
        $.ajax({
        	type : "GET",
        	url : "{{ url('api/get-city?state_id=') }}"+state_id,
        	data : {},
        	beforeSend: function(){
                //$("#overlay").fadeIn(300);
            },
            success: function(res){
            	console.log(res);
            	if(res.success){
					// var v = '';
					
					
					res.data.forEach((v) => {
						console.log(v);
						let selected = city_id!=0 ? (city_id == v.id ? 'selected': '') : '';
						$('select[name="city"]')
						.append('<option value="'+v.id+'" '+selected+'>'+v.name+'</option>');
					})

				}
			},
			error: function(err){
				console.log(err);
			}
		}).done( () => {
		})   
		
	});
	});
	
</script>
@endsection