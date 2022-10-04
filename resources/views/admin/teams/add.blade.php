@extends('admin.layouts.app')
@section('title', 'Team Add')

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
                  <form method="post" action="{{ route('team.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                      <h4>Add Team</h4>
                    </div>
                    <div class="card-body">
                        
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" placeholder="Enter name" required=""
                            value="{{ old('name') }}"
                            >
                            @if ($errors->has('name'))
                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Position</label>
                            <input type="text" class="form-control @error('position') is-invalid @enderror"
                            name="position" placeholder="Enter Position" required=""
                            value="{{ old('position') }}"
                            >
                            @if ($errors->has('position'))
                            <div class="invalid-feedback">{{ $errors->first('position') }}</div>
                            @endif
                        </div>

                          <div class="form-group mb-0">
                            <label>Bio</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror" name="bio" 
                            required="" maxlength="1500" placeholder="Please enter at most 1500 characters...." value="{{ old('bio') }}"></textarea>
                            @if ($errors->has('bio'))
                            <div class="invalid-feedback">{{ $errors->first('bio') }}</div>
                            @endif
                        </div>


                        <div class="form-group">
                            <label>Facebook Link</label>
                            <input type="url" class="form-control @error('fb_link') is-invalid @enderror"
                            name="fb_link" placeholder="Enter Facebook Link" required=""
                            value="{{ old('fb_link') }}"
                            >
                            @if ($errors->has('fb_link'))
                            <div class="invalid-feedback">{{ $errors->first('fb_link') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Twitter Link</label>
                            <input type="url" class="form-control @error('twitter_link') is-invalid @enderror"
                            name="twitter_link" placeholder="Enter Twitter Link" required=""
                            value="{{ old('twitter_link') }}"
                            >
                            @if ($errors->has('twitter_link'))
                            <div class="invalid-feedback">{{ $errors->first('twitter_link') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Instagram Link</label>
                            <input type="url" class="form-control @error('insta_link') is-invalid @enderror"
                            name="insta_link" placeholder="Enter Instagram Link" required=""
                            value="{{ old('insta_link') }}"
                            >
                            @if ($errors->has('insta_link'))
                            <div class="invalid-feedback">{{ $errors->first('insta_link') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" class="form-control" name="image" required>
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
@if ($message = Session::get('error'))  
    <script>
      swal('{{ $message }}', 'Warning', 'error');
    </script>
  @endif
@endsection
