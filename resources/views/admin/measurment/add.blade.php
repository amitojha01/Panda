@extends('admin.layouts.app')
@section('title', 'Measurement Add')

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
                  <form method="post" action="{{ route('libraryMesurement.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                      <h4>Add Measurement</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Measurement Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" placeholder="Measurement Name" required=""
                            value="{{ old('name') }}"
                            >
                            @if ($errors->has('name'))
                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Measurement Unit</label>
                            <input type="text" class="form-control @error('unit') is-invalid @enderror"
                            name="unit" placeholder="Measurement Unit" required=""
                            value="{{ old('unit') }}"
                            >
                            @if ($errors->has('unit'))
                            <div class="invalid-feedback">{{ $errors->first('unit') }}</div>
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
    CKEDITOR.replace( 'description' );
    CKEDITOR.replace( 'tips_content' );    
</script>
@if ($message = Session::get('error'))  
    <script>
      swal('{{ $message }}', 'Warning', 'error');
    </script>
  @endif
@endsection
