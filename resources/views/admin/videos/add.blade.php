@extends('admin.layouts.app')
@section('title', 'Video Add')

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
                  <form method="post" action="{{ route('videos.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                      <h4>Add Video</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Select Video Page</label>
                            <select class="form-control form-control-sm @error('page_id') is-invalid @enderror" name="page_id" required>
                                <option value="">--Select Page--</option>
                                @if($pages)
                                    @foreach($pages as $page)
                                        <option value="{{$page->id}}"
                                        {{ old('page_id') == $page->id ? 'selected' : ''}}
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
                                  {{ old('upload_type') == "0" ? 'selected' : ''}}
                                >Youtube Link</option>
                                <option value="1"
                                  {{ old('upload_type') == "1" ? 'selected' : ''}}
                                >File</option>
                            </select>
                        </div>
                        <div class="form-group mb-0">
                            <label>Video Content</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" name="content" 
                            placeholder="content ...." value="{{ old('content') }}"></textarea>
                            @if ($errors->has('content'))
                            <div class="invalid-feedback">{{ $errors->first('content') }}</div>
                            @endif
                        </div>
                        <div class="form-group" id="u-file" style="display: none">
                            <label>Video File</label>
                            <input type="file" class="form-control" name="file">
                            @if ($errors->has('file'))
                            <div class="invalid-feedback">{{ $errors->first('file') }}</div>
                            @endif
                        </div>
                        <div class="form-group" id="u-link" style="display: none">
                            <label>URL</label>
                            <input type="url" class="form-control" name="url">
                            @if ($errors->has('url'))
                            <div class="invalid-feedback">{{ $errors->first('url') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer text-right">
                      <button type="submit" class="btn btn-primary">Submit</button>
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
