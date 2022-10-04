@extends('frontend.athlete.layouts.app')
@section('title', 'Video Evidence List')
@section('content')
<?php 
use App\Models\Events;
?>

<div class="videoevidance_panel">
	 	 <div class="container-fluid">
	 	 	<h2>List of videos</h2>
	 	 	<div class="row" id="likevideo">
         <div class="col-md-4 col-sm-12 col-xs-12">
			<div class="gameboxheighlightsbox addvoiceedidancebox">
				<a href="{{ route('athlete.add-video-evidence')}}"><img src="{{ asset('public/frontend/images/yellow_plus2.png') }}" alt="yellow_plus2"> Add New Evidence</a>
			</div>
         </div>
         @if($video_evidence_list)
         @foreach($video_evidence_list as $key=> $video_evidence_list)
         <div class="col-md-4 col-sm-12 col-xs-12" >
			<div class="gamebox videoevidance_box" >
				<div class="gamebox_l">
					<!-- <img src="{{ asset('public/frontend/images/video_img.jpg') }}" alt="video_img"/> -->
					<?php $videoLink = $video_evidence_list->video_link;
	           $rx = '~^(?:https?://)?(?:www[.])?(?:youtube[.]com/watch[?]v=|youtu[.]be/)([^&]{11})~x';
	            $has_match = preg_match($rx, $videoLink, $matches);
	            $videoId = $matches[1]; ?>
	            <a href="{{ $video_evidence_list->video_embeded_link }}" target="_blank"><img src="{{ 'https://img.youtube.com/vi/' . $videoId . '/mqdefault.jpg' }}" width="100%" height="90" alt="video_img"/></a>
					<!-- <iframe type="text/html" width="100%" height="90" src="{{$video_evidence_list->video_embeded_link}}" frameborder="0" allowfullscreen ></iframe> -->
				</div>
				<div class="gamebox_r">
					<h6>{{$video_evidence_list->category_title}}</h6>
					<a href="{{ $video_evidence_list->video_embeded_link }}" target="_blank"><h4>{{$video_evidence_list->title}}</h4></a>
					<em>{{$video_evidence_list->date_of_video}}</em>
					<b><a href="javascript:void(0)" class="" user-id="{{ Auth()->user()->id }}" video-evidence-id="{{$video_evidence_list->id}}"  id="addToLike"  ><i class="{{ (likeMarkCheck(Auth()->user()->id, $video_evidence_list->id))?'fa fa-thumbs-up likewhite':'fa fa-thumbs-up' }}" aria-hidden="true"></i></a> {{$video_evidence_list->like_count}} Likes</b>

				<div class="eventbtngroup">
		            <?php if (($user_id= Auth()->user()->id)== $video_evidence_list->user_id ) { ?>
		            <a href="{{url('athlete/edit-video-evidence/'.@$video_evidence_list->id)}}" class="dontpostbtn">EDIT</a>
		            <a href="javascript:void(0)" data-id="{{@$video_evidence_list->id}}" class="contactcaochbtn btn-delete-row">DELETE</a>
		            <?php } ?> 
		    	</div>	

				</div>
				<div class="clr"></div>
			</div>
         </div>
         @endforeach
         @endif
        </div>
	 	 </div>                                                                       
	 </div>
    
    
    
    <div class="clr"></div>
  </div>
</div>

@endsection





@section('script')

<script>
        $(document).ready(function(){
            
            $('.btn-delete-row').on('click', function(){
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
                            url: "{{url('athlete/delete-video-evidence')}}"+"/"+id,
                            type:'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function(data) {
                            	console.log(data);
                                swal(data.message,'Success', 'success')
                                .then( () => {
                                    location.reload();
                                });
                            }
                        });
                    }else{
                        return false;
                    }
                    });
            });
        })
    </script>
    
<script type="text/javascript">
	$(document).on('click','#addToLike', function() {
			let videoEvidenceId = $(this).attr('video-evidence-id');
			let userId = $(this).attr('user-id');
			console.log(userId);
			if(userId !=""){
				$.ajax({
				    type: "POST",
				    url: "{{ route('athlete.like-video-evidence') }}",
				    data: {
				    	'_token' : "{{ csrf_token() }}",
				    	video_evidence_id: videoEvidenceId,
				    },
				    dataType: "JSON",
				    success: function(res) {
				    	if(res.success){

				    		// location.reload();
				    		  $("#likevideo").load(location.href+" #likevideo>*","");
				    	}
				    }
				});
			}else{
				$("#bookmarkmodal").modal('show');
				// alert("You need to login first!");
			}
	});
</script>

@endsection
