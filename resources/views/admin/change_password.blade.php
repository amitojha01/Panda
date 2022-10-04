@extends('admin.layouts.app')
@section('title', 'Admin Settings')

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

            <form method="post" action="{{ route('admin.profile.update', $detail[0]->id) }}" enctype="multipart/form-data">
              @csrf
              <div class="card-header">
                <h4>Update Profile Image</h4>
              </div>

              <div class="form-group">

                <input type="file" class="form-control" name="image" required>
                <img class="preview-image mt-2" alt="image"  src="{{ asset(@$detail[0]->profile_image) }}" width="120px" style="margin: 10px">
                @if ($errors->has('image'))
                <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                @endif
              </div>
              <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Update</button>
              </div>
            </form>

            <form method="post" action="{{ route('admin.profile.change-password', $detail[0]->id) }}" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="_method" value="PUT">


              <div class="card-header">
                <h4>Change Password</h4>
              </div>
              <div class="card-body">
                <div class="form-group mb-0">
                  <label>Current Password</label>
                  <input type="password" name="old_password"  class="form-control" required autofocus>
                </div>

                <div class="form-group">
                  <label>New Password</label>
                  <input type="password" name="new_password"  class="form-control" required autofocus>
                </div>
                <div class="form-group">
                  <label>Confirm Password</label>
                  <input type="password" name="confirm_password"  class="form-control" required autofocus>
                </div>

                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
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
@if ($message = Session::get('success'))  
<script>
  swal('{{ $message }}', 'Success', 'success');
</script>
@endif
@endsection
