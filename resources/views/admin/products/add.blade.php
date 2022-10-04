@extends('admin.layouts.app')
@section('title', 'Product Add')

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
                  <form method="post" action="{{ route('product.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                      <h4>Add Product</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Product Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                            name="title" placeholder="Product title" required=""
                            value="{{ old('title') }}"
                            >
                            @if ($errors->has('title'))
                            <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                            @endif
                        </div>
                        <div class="form-group mb-0">
                            <label>Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" 
                            required="" placeholder="Description ...." value="{{ old('description') }}"></textarea>
                            @if ($errors->has('description'))
                            <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                            @endif
                        </div>
                        <div class="form-group mb-0">
                            <label>Price</label>
                            <input type="number" step="1" class="form-control @error('price') is-invalid @enderror" name="price" 
                            required="" placeholder="20" value="{{ old('price') }}">
                            @if ($errors->has('price'))
                            <div class="invalid-feedback">{{ $errors->first('price') }}</div>
                            @endif
                        </div>
                        <div class="form-group mb-0">
                            <label>Discount Price</label>
                            <input type="number" step="1" class="form-control @error('discount_price') is-invalid @enderror" name="discount_price" 
                            placeholder="10" value="{{ old('discount_price') }}">
                            @if ($errors->has('discount_price'))
                            <div class="invalid-feedback">{{ $errors->first('discount_price') }}</div>
                            @endif
                        </div>
                        <div class="form-group mb-0">
                            <label>Tag Line</label>
                            <input type="text" class="form-control @error('product_tag_line') is-invalid @enderror" name="product_tag_line" 
                            required="" placeholder="Tag line" value="{{ old('product_tag_line') }}">
                            @if ($errors->has('discount_price'))
                            <div class="invalid-feedback">{{ $errors->first('product_tag_line') }}</div>
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
