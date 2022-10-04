@extends('admin.layouts.app')
@section('title', 'CMS Add')

@section('style')

@endsection
@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
            <div class="col-12 col-md-8 col-lg-8">
                <div class="card">
                  <form method="post" action="{{ route('admin.settings.store') }}">
                    @csrf
                    <div class="card-header">
                      <h4>Add Field</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Field Title</label>
                            <input type="text" class="form-control @error('field_title') is-invalid @enderror"
                            name="field_title" placeholder="Field title" required=""
                            value="{{ old('field_title') }}"
                            >
                            @if ($errors->has('field_title'))
                            <div class="invalid-feedback">{{ $errors->first('field_title') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Field value</label>
                            <input type="text" class="form-control @error('field_value') is-invalid @enderror"
                            name="field_value" placeholder="Field value" 
                            value="{{ old('field_value') }}"
                            >
                            @if ($errors->has('field_value'))
                            <div class="invalid-feedback">{{ $errors->first('field_value') }}</div>
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
@if ($message = Session::get('error'))  
    <script>
      swal('{{ $message }}', 'Warning', 'error');
    </script>
  @endif
@endsection
