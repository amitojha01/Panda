@extends('admin.layouts.app')
@section('title', 'Banner Update')

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
                <form method="post" action="{{ route('banners.update', $banner->id) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="card-header">
                      <h4>Update Banner</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Select Banner Page</label>
                            <select class="form-control form-control-sm @error('page_id') is-invalid @enderror" name="page_id" required>
                                <option value="">--Select Page--</option>
                                @if($pages)
                                    @foreach($pages as $page)
                                        <option value="{{$page->id}}"
                                        {{ $banner->page_id == $page->id ? 'selected' : ''}}
                                        >{{ $page->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @if ($errors->has('page_id'))
                            <div class="invalid-feedback">{{ $errors->first('page_id') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Banner Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                            name="title" placeholder="This is a about us banner" required=""
                            value="{!! $banner->title !!}"
                            >
                            @if ($errors->has('content'))
                            <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                            @endif
                        </div>
                        <div class="form-group mb-0">
                            <label>Banner Content</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" name="content" 
                            required="" placeholder="Banner content ...." value="">{!! $banner->content !!}</textarea>
                            @if ($errors->has('content'))
                            <div class="invalid-feedback">{{ $errors->first('content') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>File</label>
                            <input type="file" class="form-control" name="image">
                            <img class="preview-image mt-2" alt="image" src="{{ asset($banner->image) }}" width="120px">
                            @if ($errors->has('image'))
                            <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Select Status</label>
                            <select class="form-control form-control-sm @error('status') is-invalid @enderror" name="status" required>
                                <option value="1" {{ $banner->status == 1 ? 'selected' : ''}}>Active</option>
                                <option value="0" {{ $banner->status == 0 ? 'selected' : ''}}>Inactive</option>
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
