@extends('admin.layouts.app')
@section('title', 'Exercises Add')

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
                  <form method="post" action="{{ route('exercises.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                      <h4>Add Exercises</h4>
                    </div>
                    <div class="card-body">
                      <div class="form-group">
                        <label>Exercises Name<sup>*</sup></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                        name="name" placeholder="Exercises name" required=""
                        value="{{ old('name') }}"
                        >
                        @if ($errors->has('name'))
                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                        @endif
                      </div>
                      <div class="form-group">
                        <label>Description <sup>*</sup></label>
                        <textarea rows=5 class="form-control @error('description') is-invalid @enderror"
                        name="description" placeholder="Description" required=""
                        >{{ old('description') }}</textarea>
                        @if ($errors->has('description'))
                        <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                        @endif
                      </div>
                      <div class="form-group">
                        <label>Tips video url<sup>*</sup></label>
                        <input type="url" class="form-control @error('tips_video') is-invalid @enderror"
                        name="tips_video" placeholder="Tips url" required=""
                        value="{{ old('tips_video') }}"
                        >
                        @if ($errors->has('tips_video'))
                        <div class="invalid-feedback">{{ $errors->first('tips_video') }}</div>
                        @endif
                      </div>
                      <div class="form-group">
                        <label>Min Count<sup>*</sup></label>
                        <input type="number" min="0" step="1" class="form-control @error('min_count') is-invalid @enderror"
                        name="min_count" placeholder="0" required=""
                        value="{{ old('min_count') }}"
                        >
                        @if ($errors->has('min_count'))
                        <div class="invalid-feedback">{{ $errors->first('min_count') }}</div>
                        @endif
                      </div>
                      <div class="form-group">
                        <label>Max Count<sup>*</sup></label>
                        <input type="number" min="0" step="1" class="form-control @error('max_count') is-invalid @enderror"
                        name="max_count" placeholder="255" required=""
                        value="{{ old('max_count') }}"
                        >
                        @if ($errors->has('max_count'))
                        <div class="invalid-feedback">{{ $errors->first('max_count') }}</div>
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
