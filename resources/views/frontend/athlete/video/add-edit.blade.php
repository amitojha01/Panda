@extends('frontend.athlete.layouts.app')
@section('title', 'Video Evidence')
@section('content')
<?php 
use App\Models\Events;
?>

 <div class="createteamingup">
      <div class="container-fluid">
        <div class="addgamehighlightes">
         <div class="addgamehighlightesinner">
        	<h3>Add/Edit New Video Evidence</h3>
        	<form method="post" action="{{ route('athlete.save-video-evidence')}}" enctype="multipart/form-data">
                <input type="hidden" name="videoEvidenceId" value="{{isset($data)?($data->id):''}}">
                @csrf
        	<div class="form-group datrrecordtext">
        		<label>Date</label>
        		<input type="text" class="form-control datepicker" name="date_of_video" placeholder="MM-DD-YYYY" value="{{isset($data)?($data->date_of_video):''}}" required/>
        		<span><i class="fa fa-calendar" aria-hidden="true"></i></span>
        	</div>
        	
        	<div class="form-group addvideoevedancesmalltext">
        		<label>Workout Category</label>
        		<select class="form-control" name="workout_category_id" required>
                    <option>Select</option>
                </select>      		
        	</div>  
        	
        	<div class="form-group addvideoevedancesmalltext">
        		<label>Workout Type</label>
        		<select class="form-control" name="workout_type_id" required>
                    <option>Select</option>
                </select>         		
        	</div>

        	<div class="clr"></div>
        	<div class="form-group">
        		<label>If you have recorded video evidence of your workout, copy the link of the video in the box provided:</label>
                <input type="text" class="form-control " id="vl" name="video_link" placeholder="www.youtube.com/johndoebenchpressmax" value="{{isset($data)?($data->video_link):''}}" required />              
        		<input type="hidden" class="form-control " id="vel" name="video_embeded_link" placeholder="www.youtube.com/johndoebenchpressmax" value="{{isset($data)?($data->video_embeded_link):''}}"/>      		
        	</div>

             <div class="form-group addvideoevedancesmalltext">
                <label>Status</label>
                <select class="form-control" name="status" required>
                    <option disabled>Select</option>
                   <option value="1" {{ ((isset($data) && $data->status)=="1")? "selected" : "" }}>Active</option>
                        <option value="0" {{ ((isset($data) && $data->status)=="0")? "selected" : "" }}>Inactive</option>
                </select>           
            </div>
            <div class="clr"></div>
        	<input type="submit" class="addhighlightsbtn" value="Submit"/>
        </form>
        </div>
		  </div>
      </div>
    </div>
    <div class="clr"></div>
  </div>
</div>

@endsection
@section('script')
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
	CKEDITOR.replace('even_details');
</script>

<script>
 $(function(){
  $('.datepicker').datepicker({
    maxDate: 0
  });
})
</script>

@if ($message = Session::get('error'))  
	<script>   
		swal('{{ $message }}', 'Warning', 'error');
	</script>
	@endif
	<script src="{{ asset('public/frontend/js/password.js') }}"></script>
<script>
	const workout_category = "{{isset($data)?($data->workout_category_id):'0'}}";
    $(document).ready(function(){
        //Get Workout list
		$.ajax({
            type : "GET",
            url : "{{ url('api/get-workouts') }}",
            data : {},
            beforeSend: function(){
                //$("#overlay").fadeIn(300);
            },
            success: function(res){
                console.log(res);
                if(res.success){
                    res.data.forEach((v) => {
                    	let selected = workout_category!=0 ? (workout_category == v.id ? 'selected': '') : '';
                        $('select[name="workout_category_id"]')
                        .append('<option value="'+v.id+'" '+selected+'>'+v.category_title+'</option>');
                    })

                }
            },
            error: function(err){
                console.log(err);
            }
        }).done( () => {
        })  

        //Get Workout Type/Library

   
        $('select[name="workout_category_id"]').on('change', function(){
            let id = $(this).val();
        $.ajax({
            type : "GET",
            url : "{{ url('api/get-workouts/library') }}?workout_category_id="+id,
            data : {},
            beforeSend: function(){
                //$("#overlay").fadeIn(300);
            },
            success: function(res){
            if(res.success){
            $('select[name="workout_type_id"]').html('');
            $('select[name="workout_type_id"]').html('<option value="">--Select Category--</option>');
            res.data.forEach((v) => {
                $('select[name="workout_type_id"]')
                .append('<option value="'+v.id+'">'+v.title+'</option>');
            })
            }

            },
            error: function(err){
                console.log(err);
            }
        }).done( () => {
        }) ; 
        });  



    const workout_type = "{{isset($data)?($data->workout_type_id):'0'}}";
    const catId = "{{isset($data)?($data->workout_category_id):'0'}}";
        //Get Workout list
        $.ajax({
            type : "GET",
            url : "{{ url('api/get-workouts/library') }}?workout_category_id="+catId,
            data : {},
            beforeSend: function(){
                //$("#overlay").fadeIn(300);
            },
            success: function(res){
                console.log(res.data);
                if(res.success){
                    res.data.forEach((v) => {
                         let selected = workout_type!=0 ? (workout_type == v.id ? 'selected': '') : '';
                         console.log(selected);
                        $('select[name="workout_type_id"]')
                        .append('<option  value="'+v.id+'" '+selected+'>'+v.title+'</option>');
                    })

                }
            },
            error: function(err){
                console.log(err);
            }
        }).done( () => {
        })
   
    })
</script>
<script type="text/javascript">
        $(document).on('blur','#vl',function() {
            let url =  $('#vl').val();
            let videoId = youtubeUrlCheck(url);
            if(videoId!=false){
               $('#vel').val('https://www.youtube.com/embed/' + videoId + '?autoplay=0');
            }else{
                //alert('Enter Valid Youtube URL');
                swal({
                    title: "Enter Valid Youtube URL",
                    icon: "warning",
                    //buttons: true,
                    dangerMode: true,
                    showConfirmButton: false,
                    showCancelButton: true,
                })
                $('#vl').val('');
                $('#vel').val('');
            }
      });

      function youtubeUrlCheck(url) {
          if (url != undefined || url != '') {
            var regExp = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
            var match = url.match(regExp);
            if (match) {
                return match[1];
            }
            else {
                return false;
            }
        }return false;
      }
</script>
@endsection