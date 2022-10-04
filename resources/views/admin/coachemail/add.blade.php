@extends('admin.layouts.app')
@section('title', 'Add Coach Email')

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
                  <form method="post" action="{{ route('admin.email.save') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                      <h4>Add Coach Email</h4>
                    </div>
                    <div class="card-body">
                        
                        <div class="form-group">
                            <label>Sport</label>
                            <input type="text" class="form-control @error('sport') is-invalid @enderror"
                            name="sport" placeholder="Enter sport name" required=""
                            value="{{ old('sport') }}"
                            >
                            @if ($errors->has('sport'))
                            <div class="invalid-feedback">{{ $errors->first('sport') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Gender</label>
                            <select class="form-control form-control-sm @error('gender') is-invalid @enderror" name="gender" required>
                                <option value="Men" >Men</option>
                                <option value="Women">Women</option>
                            </select>
                           
                        </div>

                        <div class="form-group">
                            <label>School</label>
                            <input type="text" class="form-control @error('school') is-invalid @enderror"
                            name="school" placeholder="Enter school name" required=""
                            value="{{ old('school') }}"
                            >
                            @if ($errors->has('school'))
                            <div class="invalid-feedback">{{ $errors->first('school') }}</div>
                            @endif
                        </div>


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
                            <label>Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                            name="title" placeholder="Enter title" required=""
                            value="{{ old('title') }}"
                            >
                            @if ($errors->has('title'))
                            <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" placeholder="Enter email" required=""
                            value="{{ old('email') }}"
                            >
                            @if ($errors->has('email'))
                            <div class="invalid-feedback">{{ $errors->first('email') }}</div>
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
