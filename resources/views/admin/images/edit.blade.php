@extends('admin.layouts.app')
@section('title', 'Image Update')

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
                <form method="post" action="{{ route('images.update', $image->id) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="card-header">
                      <h4>Update Image</h4>
                    </div>
                    <div class="card-body">                      
                        <div class="form-group">
                            <label>Image* (.png only)</label>
                            <input type="file" class="form-control" name="file" accept="image/png">
                            <img class="preview-image mt-2" alt="image" src="{{ asset($image->image) }}" width="120px">
                            @if ($errors->has('file'))
                            <div class="invalid-feedback">{{ $errors->first('file') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Select Status</label>
                            <select class="form-control form-control-sm @error('status') is-invalid @enderror" name="status" required>
                                <option value="1" {{ $image->status == 1 ? 'selected' : ''}}>Active</option>
                                <option value="0" {{ $image->status == 0 ? 'selected' : ''}}>Inactive</option>
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
