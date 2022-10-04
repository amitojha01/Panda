@extends('admin.layouts.app')
@section('title', 'CMS Update')

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
                <form method="post" action="{{ route('cms.update', $cms->id) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="card-header">
                      <h4>Update CMS</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Select CMS Page</label>
                            <select class="form-control form-control-sm @error('page_slug') is-invalid @enderror" name="page_slug" required>
                                <option value="">--Select Page--</option>
                                @if($pages)
                                    @foreach($pages as $page)
                                        <option value="{{$page->slug}}"
                                        {{ $cms->page_slug == $page->slug ? 'selected' : ''}}
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
                                <option value="left" {{ $cms->section == 'left' ? 'selected' : ''}}>Left</option>
                                <option value="right" {{ $cms->section == 'right' ? 'selected' : ''}}>Right</option>
                                <option value="top" {{ $cms->section == 'top' ? 'selected' : ''}}>Top</option>
                                <option value="bottom" {{ $cms->section == 'bottom' ? 'selected' : ''}}>Bottom</option>
                               
                            </select>
                            @if ($errors->has('section'))
                            <div class="invalid-feedback">{{ $errors->first('section') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Cms Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                            name="title" value="{{ $cms->title }}" placeholder="Cms title" required=""
                            value="{{ old('title') }}"
                            >
                            @if ($errors->has('title'))
                            <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                            @endif
                        </div>
                        
                        <div class="form-group mb-0">
                            <label>Cms Content</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" name="content" 
                            required="" placeholder="Banner content ...." value="">{!! $cms->content !!}</textarea>
                            @if ($errors->has('content'))
                            <div class="invalid-feedback">{{ $errors->first('content') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>File</label>
                            <input type="file" class="form-control" name="image">
                            @if($cms->image != null)   
                                <img class="preview-image mt-2" alt="image" src="{{ asset($cms->image) }}" width="120px">
                            @endif
                            @if ($errors->has('image'))
                            <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Select Status</label>
                            <select class="form-control form-control-sm @error('status') is-invalid @enderror" name="status" required>
                                <option value="0" {{ $cms->status == 0 ? 'selected' : ''}}>Active</option>
                                <option value="1" {{ $cms->status == 1 ? 'selected' : ''}}>Inactive</option>
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
    CKEDITOR.replace( 'content' );
</script>
@if ($message = Session::get('error'))  
    <script>
      swal('{{ $message }}', 'Warning', 'error');
    </script>
  @endif
@endsection
