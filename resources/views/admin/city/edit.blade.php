@extends('admin.layouts.app')
@section('title', 'City Update')

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
                        <form method="post" action="{{ route('cities.update', $city->id) }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <div class="card-header">
                              <h4>Update City</h4>
                          </div>
                          <div class="card-body">
                            <div class="form-group ">
                                <label>State</label>   
                                <input type="text" class="form-control"
                                placeholder="state" readonly
                                value="{{ @$states->name }}">

                            </div>

                            <div class="form-group ">
                                <label>City</label>                          
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" placeholder="name" required=""
                                value="{{ $city->name }}">                     
                            </div> 

                            <div class="form-group">
                                <label>Zip Code</label>
                                <input type="number" class="form-control @error('zip') is-invalid @enderror"
                                name="zip" placeholder="Zip Code" required=""
                                value="{{@$city->zip }}"
                                >
                                @if ($errors->has('zip'))
                                <div class="invalid-feedback">{{ $errors->first('zip') }}</div>
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
