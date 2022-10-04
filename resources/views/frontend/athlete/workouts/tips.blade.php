@extends('frontend.athlete.layouts.app')
@section('title', 'Workout Tips')
@section('style')
<style>
    .TeamingUPbox_img{
        cursor: pointer;
    }
</style>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        @if($tips)
        @foreach($tips as $key => $tip)
        @if(!empty($tip->video))
        @php($arr = explode('/', $tip->video))
        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="TeamingUPbox">
                <div class="TeamingUPbox_img">
                    <img src="https://img.youtube.com/vi/{{end($arr)}}/1.jpg"
                        alt="teamingup_img" id="video-{{$key}}"
                        data-url="{{ $tip->video }}"
                        class=""
                     />
                </div>
                <div class="TeamingUPbox_text">
                    <h3>{{ ucwords($tip->title) }}</h3>
                    <p>
                        {!! $tip->description !!}
                    </p>
                    <!-- <input type="button" class="joinedbtn" value="Joined"/> -->
                </div>
            </div>
        </div>
        @endif
        @endforeach
        @endif				
    </div>
</div>
@endsection

<!-- Modal -->
<div class="modal fade" id="video-tips" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Workout tips</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- <video src="" id="tips-video-src"></video> -->
                <iframe id="tips-video-src" width="100%" height="315"
                    src="">
                </iframe>
            </div>
        </div>
    </div>
</div>
@section('script')
<script>
    $(document).ready(function(){
        $('.TeamingUPbox_img img').on('click', function(){
            $('#tips-video-src').attr('src', $(this).data('url'));
            $('#video-tips').modal('toggle');
        })
    })
</script>
@endsection