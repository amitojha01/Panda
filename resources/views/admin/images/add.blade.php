@extends('admin.layouts.app')
@section('title', 'Image Add')

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
                  <form method="post" action="{{ route('images.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                      <h4>Add Image</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Image* (.png only)</label>
                            <input type="file" class="form-control" name="file" accept="image/png" required>
                            @if ($errors->has('file'))
                            <div class="invalid-feedback">{{ $errors->first('file') }}</div>
                            @endif
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
