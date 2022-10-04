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
                  <form method="post" action="{{ route('cms.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                      <h4>Add CMS</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Select CMS Page</label>
                            <select class="form-control form-control-sm @error('page_slug') is-invalid @enderror" name="page_slug" required>
                                <option value="">--Select Page--</option>
                                @if($pages)
                                    @foreach($pages as $page)
                                        <option value="{{$page->slug}}"
                                        {{ old('page_slug') == $page->slug ? 'selected' : ''}}
                                        >{{ $page->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @if ($errors->has('page_slug'))
                            <div class="invalid-feedback">{{ $errors->first('page_slug') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Select Section</label>
                            <select class="form-control form-control-sm @error('section') is-invalid @enderror" name="section" required>
                                <option value="">--Select Section--</option>
                                <option value="left">Left</option>
                                <option value="right">Right</option>
                                <option value="top">Top</option>
                                <option value="bottom">Bottom</option>
                               
                            </select>
                            @if ($errors->has('section'))
                            <div class="invalid-feedback">{{ $errors->first('section') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Cms Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                            name="title" placeholder="Cms title" required=""
                            value="{{ old('title') }}"
                            >
                            @if ($errors->has('title'))
                            <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                            @endif
                        </div>

                        <div class="form-group mb-0">
                            <label>CMS Content</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" name="content" 
                            required="" placeholder="Cms content ...." value="{{ old('content') }}"></textarea>
                            @if ($errors->has('content'))
                            <div class="invalid-feedback">{{ $errors->first('content') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>File</label>
                            <input type="file" class="form-control" name="image">
                            @if ($errors->has('image'))
                            <div class="invalid-feedback">{{ $errors->first('image') }}</div>
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
