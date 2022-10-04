@extends('admin.layouts.app')
@section('title', 'Admin Settings')

@section('style')

@endsection
@section('content')
<!-- Main Content -->
<div class="main-content">      
    <section class="section">
       <a href="{{ route('admin.settings.create') }}" class="btn btn-icon icon-left btn-info btn-list-add" style="float:right">
        <i class="fas fa-plus"></i> Add
    </a> 
    <div class="section-body">            
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">  


                    <form method="post" action="{{ route('admin.settings.edit') }}" enctype="multipart/form-data">
                        @csrf
                        <!-- <input type="hidden" name="_method" value="PUT"> -->
                        <div class="card-header">
                          <h4>Update Admin Settings</h4>
                      </div>
                      <div class="card-body">
                       @if($setting)
                       @foreach($setting as $key => $field)
                       <div class="form-group">
                        <input type="hidden" 
                        name="field_id[]" value="{{ $field->id }}"
                        >
                        <label>{{ $field->key }}</label>
                        <input type="text" class="form-control @error('{{ $field->key }}') is-invalid @enderror"
                        name="field_value[]" placeholder="" required=""
                        value="{{ $field->value }}"
                        >
                        @if ($errors->has('{{ $field->value }}'))
                        <div class="invalid-feedback">{{ $errors->first(' $field->value ') }}</div>
                        @endif
                    </div> 

                    @endforeach
                    @endif


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
