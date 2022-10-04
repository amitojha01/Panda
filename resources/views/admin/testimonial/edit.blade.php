@extends('admin.layouts.app')
@section('title', 'Testimonial Update')

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
                <form method="post" action="{{ route('testimonial.update', $testimonial->id) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="card-header">
                      <h4>Update Testimonial</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Testimonial Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                            name="title" placeholder="This is a about us testimonial" required=""
                            value="{!! $testimonial->title !!}"
                            >
                            @if ($errors->has('content'))
                            <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                            @endif
                        </div>
                        <div class="form-group mb-0">
                            <label>Testimonial Content</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" name="content" 
                            required="" placeholder="testimonial content ...." value="">{!! $testimonial->content !!}</textarea>
                            @if ($errors->has('content'))
                            <div class="invalid-feedback">{{ $errors->first('content') }}</div>
                            @endif
                        </div>
                        <div class="form-group mb-0">
                            <label>Ratings</label>
                             <input type="text" class="form-control @error('ratings') is-invalid @enderror"
                            name="ratings" placeholder="This is a about us testimonial" required=""
                            value="{!! $testimonial->ratings !!}"
                            >
                            @if ($errors->has('ratings'))
                            <div class="invalid-feedback">{{ $errors->first('ratings') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Select Status</label>
                            <select class="form-control form-control-sm @error('status') is-invalid @enderror" name="status" required>
                                <option value="1" {{ $testimonial->status == 1 ? 'selected' : ''}}>Active</option>
                                <option value="0" {{ $testimonial->status == 0 ? 'selected' : ''}}>Inactive</option>
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
@if ($message = Session::get('error'))  
    <script>
      swal('{{ $message }}', 'Warning', 'error');
    </script>
  @endif
@endsection
