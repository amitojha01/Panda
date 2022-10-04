@extends('admin.layouts.app')
@section('title', 'Testimonial Review Update')

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
                <form method="post" action="{{ route('testimonial-review.update', $testimonial_review->id) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="card-header">
                      <h4>Update Testimonial Review</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" placeholder="name" required=""
                            value="{!! $testimonial_review->name !!}"
                            >
                            @if ($errors->has('name'))
                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="form-group mb-0">
                            <label>Comments</label>
                            <textarea class="form-control @error('comments') is-invalid @enderror" name="comments" 
                            required="" placeholder="Review comments ...." value="">{!! $testimonial_review->comments !!}</textarea>
                            @if ($errors->has('comments'))
                            <div class="invalid-feedback">{{ $errors->first('comments') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" class="form-control" name="image">
                            <img class="preview-image mt-2" alt="image" src="{{ asset($testimonial_review->image) }}" width="120px">
                            @if ($errors->has('image'))
                            <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Select Status</label>
                            <select class="form-control form-control-sm @error('status') is-invalid @enderror" name="status" required>
                                <option value="1" {{ $testimonial_review->status == 1 ? 'selected' : ''}}>Active</option>
                                <option value="0" {{ $testimonial_review->status == 0 ? 'selected' : ''}}>Inactive</option>
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
