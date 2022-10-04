@extends('frontend.athlete.layouts.app')
@section('title', 'Game Highlights')
@section('content')
<div class="container-fluid">
 <div class="row">
   <div class="col-md-4 col-sm-12 col-xs-12">
     <div class="gameboxheighlightsbox gamehighlightedboxadd gamehighlightednewbox">
       <a href="{{ route('athlete.add-game-highlights') }}">
        <img src="{{ asset('public/frontend/athlete/images/yellow_plus2.png') }}" alt="yellow_plus2"/> Add New Highlights</a>
    </div>
  </div>
  @foreach($game as $value)
  <div class="col-md-4 col-sm-12 col-xs-12">
   <div class="gamebox gamehighlightedbox gamehighlightednewbox">
    <span><i class="fa fa-calendar-o" aria-hidden="true"></i></span>
    <h5>{{ date("d/m/Y", strtotime(@$value->record_date)) }}</h5>
    <p>{!! Str::limit(@$value->description, 50, ' ...') !!}</p>

    <!-- <a href="{{ @$value->video }}" target="_blank"><p>{{ @$value->video }}</p></a> -->

    <div class="vidoethumb">

      @if(@$value->video!="")
      <?php
      $videoLink = '';
      $videoLink = @$value->video;
      $rx = '~^(?:https?://)?(?:www[.])?(?:youtube[.]com/watch[?]v=|youtu[.]be/)([^&]{11})~x';
      $has_match = preg_match($rx, $videoLink, $matches);
      $videoId = $matches[1]; 
      ?>
      <a href="{{ @$value->video }}" target="_blank"><img src="{{ 'https://img.youtube.com/vi/' . $videoId . '/mqdefault.jpg' }}" width="85%" height="100%" alt="videoimg" /></a>

      
      @endif
    </div>

    <div align="center" style="padding-top:15px;">
    <a href="{{ route('athlete.edit-game-highlight', $value->id) }}"class="editbtngame" href="">Edit</a>
    <a href="javascript:void(0)" data-id="{{ $value->id }}"  class="deletebtngame" href="">Delete</a>

  </div>
    
     
  </div>
</div>
@endforeach

</div>
</div>
</div>
<div class="clr"></div>
</div>
</div>
@endsection

@section('script')
<script>

$('.deletebtngame').on('click', function(){
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
          
          url: "{{ url('athlete/delete-game') }}"+"/"+id,
          
          type:'get',
          data: {
            "_token": "{{ csrf_token() }}",
          },
          success: function(data) {
            swal(data.message, 'success')
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
</script>

@endsection
