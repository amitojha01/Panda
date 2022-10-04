@extends('admin.layouts.app')
@section('title', 'Sport Add')

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
                  <form method="post" action="{{ route('admin.position.save') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                      <h4>Add Sport Position </h4>
                    </div>
                    <div class="card-body">
                      <div class="form-group">
                            <label>Select Sports<sup>*</sup></label>
                            <select class="form-control form-control-sm @error('page_slug') is-invalid @enderror" name="sport" requiredm>
                                <option value="">--Select Sports--</option>
                                @if($sports)
                                    @foreach($sports as $sport)
                                        <option value="{{$sport->id}}"                                   
                                        >{{ $sport->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @if ($errors->has('sport'))
                            <div class="invalid-feedback">{{ $errors->first('sport') }}</div>
                            @endif
                        </div>
                      <div class="form-group">
                        <label>Position Name<sup>*</sup></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                        name="name" placeholder="Position name" required=""
                        value="{{ old('name') }}"
                        >
                        @if ($errors->has('name'))
                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
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
