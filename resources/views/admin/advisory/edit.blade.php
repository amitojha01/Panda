@extends('admin.layouts.app')
@section('title', 'Team Update')

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
                <form method="post" action="{{ route('advisory.update', $advisory->id) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="card-header">
                      <h4>Update Advisory</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" placeholder="Enter name" required=""
                            value="{!! $advisory->name !!}"
                            >
                            @if ($errors->has('name'))
                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Position</label>
                            <input type="text" class="form-control @error('position') is-invalid @enderror"
                            name="position" placeholder="Enter position" required=""
                            value="{!! $advisory->position !!}"
                            >
                            @if ($errors->has('position'))
                            <div class="invalid-feedback">{{ $errors->first('position') }}</div>
                            @endif
                        </div>

                        <div class="form-group mb-0">
                            <label>Bio</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror" name="bio" 
                            required="" maxlength="1500" placeholder="Please enter at most 1500 characters...." value="">{!! $advisory->bio !!}</textarea>
                            @if ($errors->has('bio'))
                            <div class="invalid-feedback">{{ $errors->first('bio') }}</div>
                            @endif
                        </div>

                         <div class="form-group">
                            <label>Facebook Link</label>
                            <input type="url" class="form-control @error('fb_link') is-invalid @enderror"
                            name="fb_link" placeholder="Enter Facebook Link" required=""
                            value="{!! $advisory->fb_link !!}"
                            >
                            @if ($errors->has('fb_link'))
                            <div class="invalid-feedback">{{ $errors->first('fb_link') }}</div>
                            @endif
                        </div>

                         <div class="form-group">
                            <label>Twitter Link</label>
                            <input type="url" class="form-control @error('twitter_link') is-invalid @enderror"
                            name="twitter_link" placeholder="Enter Twitter Link" required=""
                            value="{!! $advisory->twitter_link !!}"
                            >
                            @if ($errors->has('twitter_link'))
                            <div class="invalid-feedback">{{ $errors->first('twitter_link') }}</div>
                            @endif
                        </div>

                         <div class="form-group">
                            <label>Instagram Link</label>
                            <input type="url" class="form-control @error('insta_link') is-invalid @enderror"
                            name="insta_link" placeholder="Enter Instagram Link" required=""
                            value="{!! $advisory->insta_link !!}"
                            >
                            @if ($errors->has('insta_link'))
                            <div class="invalid-feedback">{{ $errors->first('insta_link') }}</div>
                            @endif
                        </div>
                   
                        <div class="form-group">
                            <label>File</label>
                            <input type="file" class="form-control" name="image">
                            <img class="preview-image mt-2" alt="image" src="{{ asset($advisory->image) }}" width="120px">
                            @if ($errors->has('image'))
                            <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Select Status</label>
                            <select class="form-control form-control-sm @error('status') is-invalid @enderror" name="status" required>
                                <option value="1" {{ $advisory->status == 1 ? 'selected' : ''}}>Active</option>
                                <option value="0" {{ $advisory->status == 0 ? 'selected' : ''}}>Inactive</option>
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
