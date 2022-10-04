@extends('admin.layouts.app')
@section('title', 'Subscription Update')

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
                <form method="post" action="{{ route('subscription.update', $subscription->id) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="card-header">
                      <h4>Update Subscription</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Subscription Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" placeholder="Subscription Name" required=""
                            value="{{ $subscription->name }}"
                            >
                            @if ($errors->has('name'))
                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Subscription Amount Monthly</label>
                            <input type="number" min="1" step=".01" class="form-control @error('monthly_amount') is-invalid @enderror"
                            name="monthly_amount" placeholder="Subscription Amount" value="{{ $subscription->monthly_amount }}"
                            >
                            
                        </div>
                        <div class="form-group">
                            <label>Subscription Amount Yearly</label>
                            <input type="number" min="1" step=".01" class="form-control @error('yearly_amount') is-invalid @enderror"
                            name="yearly_amount" placeholder="Subscription Amount" value="{{ $subscription->yearly_amount }}"
                            >
                            
                        </div>                        
                        <div class="form-group">
                            <label>Type</label>
                            <select class="form-control form-control-sm @error('type') is-invalid @enderror" name="type" required>
                                <option value="1" {{ $subscription->type == 1 ? 'selected' : ''}}>Individual</option>
                                <option value="0" {{ $subscription->type == 2 ? 'selected' : ''}}>Group</option>
                            </select>
                            @if ($errors->has('type'))
                            <div class="invalid-feedback">{{ $errors->first('type') }}</div>
                            @endif
                        </div>                        
                        <div class="form-group">
                            <label>User Limit</label>
                            <input type="number" class="form-control @error('user_limit') is-invalid @enderror"
                            name="user_limit" placeholder="User limit" 
                            value="{{ $subscription->user_limit }}"
                            >
                           
                        </div>
                        <div class="form-group mb-0">
                            <label>Content</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" name="content" 
                            required="" placeholder="content ...." value="">{!! $subscription->content !!}</textarea>
                           
                        </div>
                        <div class="form-group">
                            <label>Subscription Code</label>
                            <input type="text" class="form-control @error('subscription_code') is-invalid @enderror"
                            name="subscription_code" placeholder="Subscription Code" required=""
                            value="{{ $subscription->subscription_code }}"
                            >
                            @if ($errors->has('subscription_code'))
                            <div class="invalid-feedback">{{ $errors->first('subscription_code') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Select Status</label>
                            <select class="form-control form-control-sm @error('status') is-invalid @enderror" name="status" required>
                                <option value="1" {{ $subscription->status == 1 ? 'selected' : ''}}>Active</option>
                                <option value="0" {{ $subscription->status == 0 ? 'selected' : ''}}>Inactive</option>
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
    CKEDITOR.replace( 'content' );
</script>
@if ($message = Session::get('error'))  
    <script>
      swal('{{ $message }}', 'Warning', 'error');
    </script>
  @endif
@endsection
