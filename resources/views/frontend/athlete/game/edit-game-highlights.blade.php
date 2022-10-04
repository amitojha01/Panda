@extends('frontend.athlete.layouts.app')
@section('title', 'Game Highlights')
@section('content')
<div class="container-fluid">
  <div class="addgamehighlightes">
   <div class="addgamehighlightesinner">
     <h3>Add New Highlights</h3>
     <div class="form-group datrrecordtext">            		
      <form  action="{{ route('athlete.update-game-highlight', $game->id) }}" method="POST" >
        @csrf
        <div class="form-group">
          <label>Date of record</label>
          <input type="text" class="form-control datepicker"  name="record_date" 
          value="{{ date('d/m/Y', strtotime(@$game->record_date)) }}" placeholder="MM-DD-YYYY" 
          required autocomplete="off"
          />
          
          <span><i class="fa fa-calendar" aria-hidden="true"></i></span>
          @if ($errors->has('record_date'))
          <span class="text-danger">{{ $errors->first('record_date') }}</span>
          @endif
        </div>
      </div>
      <div class="form-group">
        <label>Descriptions</label>
        <textarea placeholder="Type here..." name="description">{{ @$game->description }}</textarea> 
        @if ($errors->has('description'))
        <span class="text-danger">{{ $errors->first('description') }}</span>
        @endif     		
      </div>
      <div class="form-group">
        <label>If you have recorded video evidence of your workout, copy the link of the video in the box provided:</label>
        
        <input type="url" class="form-control" name="video" id="vl" value="{{ @$game->video }}" placeholder="www.youtube.com/escf1"/>
        @if ($errors->has('video'))
        <span class="text-danger">{{ $errors->first('video') }}</span>
        @endif 

        <input type="hidden" class="form-control " id="vel" name="video_embeded_link" placeholder="www.youtube.com/johndoebenchpressmax" value="{{@$game->video_embeded_link}}"/>    		
      </div>
      <input type="submit" class="addhighlightsbtn" value="Submit"/>
    </form>
  </div>
</div>
</div>

@endsection
@section('script')
<script>
 $(function(){
  $('.datepicker').datepicker({
    minDate: 0
  });
})



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