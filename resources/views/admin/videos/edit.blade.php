@extends('admin.layouts.app')
@section('title', 'Video Update')

@section('style')

@endsection
@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">                  
                <form method="post" action="{{ route('videos.update', $video->id) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="card-header">
                      <h4>Update Video</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Select Video Page</label>
                            <select class="form-control form-control-sm @error('page_id') is-invalid @enderror" name="page_id" required>
                                <option value="">--Select Page--</option>
                                @if($pages)
                                    @foreach($pages as $page)
                                        <option value="{{$page->id}}"
                                        {{ $video->page_id == $page->id ? 'selected' : ''}}
                                        >{{ $page->title }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @if ($errors->has('page_id'))
                            <div class="invalid-feedback">{{ $errors->first('page_id') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Video Type</label>
                            <select class="form-control form-control-sm @error('upload_type') is-invalid @enderror" name="upload_type" required>
                              <option value="">--Select Upload Type--</option>
                                <option value="0"
                                  {{ $video->upload_type == "0" ? 'selected' : ''}}
                                >Youtube Link</option>
                                <option value="1"
                                  {{ $video->upload_type == "1" ? 'selected' : ''}}
                                >File</option>
                            </select>
                        </div>
                        <div class="form-group mb-0">
                            <label>Video Content</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" name="content" 
                            placeholder="content ...." value="">{!! $video->content !!}</textarea>
                            @if ($errors->has('content'))
                            <div class="invalid-feedback">{{ $errors->first('content') }}</div>
                            @endif
                        </div>                       
                        <div class="form-group" id="u-file" style="display: {{ $video->upload_type == 1 ? '' : 'none' }}">
                            <label>Video File</label>
                            <input type="file" class="form-control" name="file">
                            <img class="preview-image mt-2" alt="image" src="{{ asset($video->image) }}" width="120px">
                            @if ($errors->has('file'))
                            <div class="invalid-feedback">{{ $errors->first('file') }}</div>
                            @endif
                        </div>
                        <div class="form-group" id="u-link" style="display: {{ $video->upload_type == 0 ? '' : 'none' }}">
                            <label>URL</label>
                            <input type="url" class="form-control mb-2" name="url" value="{{ $video->url }}"
                            {{ $video->upload_type == 0 ? 'required' : '' }}
                            >
                            <iframe width="100" height="80"
                                src="{!! $video->url !!}">
                            </iframe>
                            @if ($errors->has('url'))
                            <div class="invalid-feedback">{{ $errors->first('url') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Select Status</label>
                            <select class="form-control form-control-sm @error('status') is-invalid @enderror" name="status" required>
                                <option value="1" {{ $video->status == 1 ? 'selected' : ''}}>Active</option>
                                <option value="0" {{ $video->status == 0 ? 'selected' : ''}}>Inactive</option>
                            </select>
                            @if ($errors->has('status'))
                            <div class="invalid-feedback">{{ $errors->first('status') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer text-right">
                      <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('script')
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'content' );
</script>
<script>
  $(document).ready(function(){
    $('select[name="upload_type"]').on('change', function(){
      if($(this).val() == 1){
        $('#u-link').hide();
        $('#u-link input').prop('required', false);
        $('#u-file').show();
        $('#u-file input').prop('required', true);
      }else{
        $('#u-file').hide();
        $('#u-file input').prop('required', false);
        $('#u-link').show();
        $('#u-link input').prop('required', true);
      }
    })
  })
</script>
@if ($message = Session::get('error'))  
    <script>
      swal('{{ $message }}', 'Warning', 'error');
    </script>
  @endif
@endsection
