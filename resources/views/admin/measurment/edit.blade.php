@extends('admin.layouts.app')
@section('title', 'Measurement Update')

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
                <form method="post" action="{{ route('libraryMesurement.update', $mesurement_data->id) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="card-header">
                      <h4>Update Measurement</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Measurement Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ $mesurement_data->name }}" placeholder="Name" required=""
                            value="{{ old('name') }}"
                            >
                            @if ($errors->has('name'))
                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Measurement Unit</label>
                            <input type="text" class="form-control @error('unit') is-invalid @enderror"
                            name="unit" value="{{ $mesurement_data->unit }}" placeholder="Unit" required=""
                            value="{{ old('unit') }}"
                            >
                            @if ($errors->has('unit'))
                            <div class="invalid-feedback">{{ $errors->first('unit') }}</div>
                            @endif
                        </div>
                        
                        
                        <div class="form-group">
                            <label>Select Status</label>
                            <select class="form-control form-control-sm @error('status') is-invalid @enderror" name="status" required>
                                <option value="1" {{ $mesurement_data->status == 1 ? 'selected' : ''}}>Active</option>
                                <option value="0" {{ $mesurement_data->status == 0 ? 'selected' : ''}}>Inactive</option>
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
    CKEDITOR.replace( 'description' );
    CKEDITOR.replace( 'tips_content' );
    
</script>
@if ($message = Session::get('error'))  
    <script>
      swal('{{ $message }}', 'Warning', 'error');
    </script>
  @endif
@endsection
