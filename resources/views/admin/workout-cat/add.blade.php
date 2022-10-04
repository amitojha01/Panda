@extends('admin.layouts.app')
@section('title', 'Category Add')

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
                  <form method="post" action="{{ route('workoutcategory.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                      <h4>Add Category</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Category Title</label>
                            <input type="text" class="form-control @error('category_title') is-invalid @enderror"
                            name="category_title" placeholder="Category title" required=""
                            value="{{ old('category_title') }}"
                            >
                            @if ($errors->has('category_title'))
                            <div class="invalid-feedback">{{ $errors->first('category_title') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" class="form-control" name="image" multiple required="">
                            @if ($errors->has('image'))
                            <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Content Title</label>
                            <input type="text" class="form-control @error('content_title') is-invalid @enderror"
                            name="content_title" placeholder="Content title" required=""
                            value="{{ old('content_title') }}"
                            >
                            @if ($errors->has('content_title'))
                            <div class="invalid-feedback">{{ $errors->first('content_title') }}</div>
                            @endif
                        </div>

                        <div class="form-group mb-0">
                            <label>Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" 
                            required="" placeholder="Workout Description...." value="{{ old('description') }}"></textarea>
                            @if ($errors->has('description'))
                            <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Banner</label>
                            <input type="file" class="form-control" name="banner" multiple required="">
                            @if ($errors->has('banner'))
                            <div class="invalid-feedback">{{ $errors->first('banner') }}</div>
                            @endif
                        </div> 

                        <div class="form-group">
                            <label>Workout</label>
                            @foreach ($library as $key => $value)
                        
                        <input type="checkbox" name="library[]" value="{{ $value->id }}"  > {{ $value->title }}    
                                               
                        @endforeach  
                            
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
</script>
@if ($message = Session::get('error'))  
    <script>
      swal('{{ $message }}', 'Warning', 'error');
    </script>
  @endif
@endsection
