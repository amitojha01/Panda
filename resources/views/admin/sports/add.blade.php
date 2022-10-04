@extends('admin.layouts.app')
@section('title', 'Sport Add')

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
                  <form method="post" action="{{ route('sports.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                      <h4>Add Sport</h4>
                    </div>
                    <div class="card-body">
                      <div class="form-group">
                        <label>Sport Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                        name="name" placeholder="Sport name" required=""
                        value="{{ old('name') }}"
                        >
                        @if ($errors->has('name'))
                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                        @endif
                      </div>
                       <div class="form-group">
                            <label>Icon</label>
                            <input type="file" class="form-control" name="icon" required="">
                            @if ($errors->has('icon'))
                            <div class="invalid-feedback">{{ $errors->first('icon') }}</div>
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
@if ($message = Session::get('error'))  
    <script>
      swal('{{ $message }}', 'Warning', 'error');
    </script>
  @endif
@endsection
