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
                <form method="post" action="{{ route('sport.position.update', $position->id) }}" enctype="multipart/form-data">
                    @csrf
                    <!-- <input type="hidden" name="_method" value="PUT"> -->
                    <div class="card-header">
                      <h4>Update Position</h4>
                    </div>
                    <div class="card-body">
                    <div class="form-group">
                            <label>Select Sport<sup>*</sup></label>
                            <select class="form-control form-control-sm @error('sport') is-invalid @enderror" name="sport" required>
                                <option value="">--Select Sport--</option>
                                @if($sports)
                                    @foreach($sports as $sport)
                                        <option value="{{$sport->id}}"
                                        {{ $sport->id == $position->sport_id ? 'selected' : ''}}
                                        >{{ $sport->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @if ($errors->has('sport'))
                            <div class="invalid-feedback">{{ $errors->first('sport') }}</div>
                            @endif
                        </div>                        
                        <div class="form-group">
                            <label>Position name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" placeholder="College name" required=""
                            value="{{ $position->name }}"
                            >
                            @if ($errors->has('content'))
                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Select Status</label>
                            <select class="form-control form-control-sm @error('status') is-invalid @enderror" name="status" required>
                                <option value="1" {{ $position->status == 1 ? 'selected' : ''}}>Active</option>
                                <option value="0" {{ $position->status == 0 ? 'selected' : ''}}>Inactive</option>
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
