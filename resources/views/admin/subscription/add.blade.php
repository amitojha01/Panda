@extends('admin.layouts.app')
@section('title', 'Subscription Add')

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
                  <form method="post" action="{{ route('subscription.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                      <h4>Add Subscription</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Subscription Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" placeholder="Subscription Name" required=""
                            value="{{ old('name') }}"
                            >
                            @if ($errors->has('name'))
                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Subscription Amount Monthly</label>
                            <input type="number" min="1" step=".01" class="form-control @error('monthly_amount') is-invalid @enderror"
                            name="monthly_amount" placeholder="Subscription Amount" 
                            value="{{ old('monthly_amount') }}"
                            >
                           
                        </div>
                        <div class="form-group">
                            <label>Subscription Amount Yearly</label>
                            <input type="number" min="1" step=".01" class="form-control @error('yearly_amount') is-invalid @enderror"
                            name="yearly_amount" placeholder="Subscription Amount" 
                            value="{{ old('yearly_amount') }}"
                            >
                            
                        </div>
                        <!-- <div class="form-group">
                            <label>Duration (In Month)</label>
                            <input type="number" class="form-control @error('duration') is-invalid @enderror"
                            name="duration" placeholder="Duration" required=""
                            value="{{ old('duration') }}"
                            >
                            @if ($errors->has('duration'))
                            <div class="invalid-feedback">{{ $errors->first('duration') }}</div>
                            @endif
                        </div> -->

                        <div class="form-group">
                            <label>Select Type</label>
                            <select class="form-control form-control-sm @error('type') is-invalid @enderror" name="type" required>
                                <option value="">--Select Type--</option>
                                <option value="1"             
                                        >Indivisual</option>
                                <option value="2"             
                                        >Group</option>
                                                               
                            </select>
                            @if ($errors->has('type'))
                            <div class="invalid-feedback">{{ $errors->first('type') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>User Limit</label>
                            <input type="number" class="form-control @error('user_limit') is-invalid @enderror"
                            name="user_limit" placeholder="User limit" 
                            value="{{ old('user_limit') }}"
                            >
                           
                        </div>
                        <div class="form-group mb-0">
                            <label>Content</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" name="content" 
                            required="" placeholder="Description...." value="{{ old('content') }}"></textarea>
                            @if ($errors->has('content'))
                            <div class="invalid-feedback">{{ $errors->first('content') }}</div>
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
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'content' );
</script>
@if ($message = Session::get('error'))  
    <script>
      swal('{{ $message }}', 'Warning', 'error');
    </script>
  @endif
@endsection
