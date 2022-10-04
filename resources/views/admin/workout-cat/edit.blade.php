@extends('admin.layouts.app')
@section('title', 'Category Update')

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
                        <form method="post" action="{{ route('workoutcategory.update', $cat_data->id) }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <div class="card-header">
                              <h4>Update Library</h4>
                          </div>
                          <div class="card-body">
                            <div class="form-group">
                                <label>Category Title</label>
                                <input type="text" class="form-control @error('category_title') is-invalid @enderror"
                                name="category_title" value="{{ $cat_data->category_title }}" placeholder="Category title" required=""
                                value="{{ old('category_title') }}"
                                >
                                @if ($errors->has('category_title'))
                                <div class="invalid-feedback">{{ $errors->first('category_title') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" class="form-control" name="image">
                                @if($cat_data->image != null)   
                                <img class="preview-image mt-2" alt="image" src="{{ asset($cat_data->image) }}" width="120px">
                                @endif
                                @if ($errors->has('image'))
                                <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Content Title</label>
                                <input type="text" class="form-control @error('content_title') is-invalid @enderror"
                                name="content_title" value="{{ $cat_data->content_title }}" placeholder="Category title" required=""
                                value="{{ old('content_title') }}"
                                >
                                @if ($errors->has('content_title'))
                                <div class="invalid-feedback">{{ $errors->first('content_title') }}</div>
                                @endif
                            </div>

                            <div class="form-group mb-0">
                                <label>Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" 
                                required="" placeholder="Workout Description...." value="">{!! $cat_data->description !!}</textarea>
                                @if ($errors->has('description'))
                                <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Banner</label>
                                <input type="file" class="form-control" name="banner">
                                @if($cat_data->banner != null)   
                                <img class="preview-image mt-2" alt="banner" src="{{ asset($cat_data->banner) }}" width="120px">
                                @endif
                                @if ($errors->has('banner'))
                                <div class="invalid-feedback">{{ $errors->first('banner') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Workout</label>
                                <?php  
                                $libId= array(); 
                                if(count($workout_library)>0){
                                    for($i=0; $i<count($workout_library); $i++){
                                        array_push($libId, $workout_library[$i]->workout_library_id );
                                    } 
                                }

                                ?>
                                <?php 
                                $chk= "";

                                ?>
                                <?php foreach ($library as $key => $value){
                                    if (in_array($value->id, $libId)) {
                                        $chk='checked';
                                    }
                                    ?>

                                    <input type="checkbox" name="library[]" value="{{ $value->id }}"  {{ $chk }} > {{ $value->title }}
                                    <?php $chk= ""; } ?>
                                </div> 

                                <div class="form-group">
                                    <label>Select Status</label>
                                    <select class="form-control form-control-sm @error('status') is-invalid @enderror" name="status" required>
                                        <option value="1" {{ $cat_data->status == 1 ? 'selected' : ''}}>Active</option>
                                        <option value="0" {{ $cat_data->status == 0 ? 'selected' : ''}}>Inactive</option>
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
    CKEDITOR.replace( 'description' );
</script>
@if ($message = Session::get('error'))  
<script>
  swal('{{ $message }}', 'Warning', 'error');
</script>
@endif
@endsection
