@extends('admin.layouts.app')
@section('title', 'Product Update')

@section('style')

@endsection
@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-7 col-md-6 col-lg-6">
                    <div class="card">                  
                        <form method="post" action="{{ route('product.update', $product->id) }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <div class="card-header">
                                <h4>Update Product</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-0">
                                    <label>Product Title</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    name="title" placeholder="Product title" required="" value="{{ $product->title }}">
                                    @if ($errors->has('title'))
                                    <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                                    @endif
                                </div>
                                <div class="form-group mb-0">
                                    <label>Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" 
                                    required="" placeholder="Description ....">{{ $product->description }}</textarea>
                                    @if ($errors->has('description'))
                                    <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                                    @endif
                                </div>
                                <div class="form-group mb-0">
                                    <label>Price</label>
                                    <input type="number" step="1" class="form-control @error('price') is-invalid @enderror" name="price" 
                                    required="" placeholder="20" value="{{ number_format((float)$product->price, 2, '.', '') }}">
                                    @if ($errors->has('price'))
                                    <div class="invalid-feedback">{{ $errors->first('price') }}</div>
                                    @endif
                                </div>
                                <div class="form-group mb-0">
                                    <label>Discount Price</label>
                                    <input type="number" step="1" class="form-control @error('discount_price') is-invalid @enderror" name="discount_price" 
                                    placeholder="10" value="{{ number_format((float)$product->discount_price, 2, '.', '') }}">
                                    @if ($errors->has('discount_price'))
                                    <div class="invalid-feedback">{{ $errors->first('discount_price') }}</div>
                                    @endif
                                </div>
                                <div class="form-group mb-0">
                                    <label>Tag Line</label>
                                    <input type="text" class="form-control @error('product_tag_line') is-invalid @enderror" name="product_tag_line" 
                                    required="" placeholder="Tag line" value="{{ $product->product_tag_line }}">
                                    @if ($errors->has('discount_price'))
                                    <div class="invalid-feedback">{{ $errors->first('product_tag_line') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Image</label>
                                    <input type="file" class="form-control" name="image">
                                    @if(count($product->images) > 0)
                                    <img class="col-image" alt="image" src="{{ asset($product->images[0]->image) }}" width="120px">
                                    @endif
                                    @if ($errors->has('image'))
                                    <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Select Status</label>
                                    <select class="form-control form-control-sm @error('status') is-invalid @enderror" name="status" required>
                                        <option value="1" {{ $product->status == 1 ? 'selected' : ''}}>Active</option>
                                        <option value="0" {{ $product->status == 0 ? 'selected' : ''}}>Inactive</option>
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
                <div class="col-5 col-md-6 col-lg-6">
                    <div class="card">
                        <!--  -->
                        <form method="post" action="{{ route('product.add-attribute', $product->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <h4 class="">Manage Product Attributes</h4>
                            </div>
                            <div class="card-body">                                
                                <div class="form-group">
                                    <label>Select Frame Type</label>
                                    <select class="form-control form-control-s" name="frame_id" required>
                                        <option value="">--Select Frame--</option>
                                        @if($frame)
                                        @foreach($frame as $f)
                                        <option value="{{$f->id}}"           
                                            >{{ $f->type_name }}</option>
                                            @endforeach
                                            @endif
                                        </select>                            
                                    </div>

                                    <div class="form-group mb-0">
                                        <label>Image Height</label>
                                        <input type="number" step="0.01" class="form-control" name="image_height" 
                                        placeholder="300" value="{{ old('image_height') }}" required="">
                                       
                                    </div>
                                    <div class="form-group mb-0">
                                        <label>Image Width</label>
                                        <input type="number" step="0.01" class="form-control" name="image_width" 
                                        placeholder="300" value="{{ old('image_width') }}" required="">                                       
                                    </div>
                                    <div class="form-group mb-0">
                                        <label>Size</label>
                                        <input type="text" class="form-control @error('size') is-invalid @enderror"
                                        name="size" placeholder="Product size" required="" value="{{ old('size') }}">
                                        @if ($errors->has('size'))
                                        <div class="invalid-feedback">{{ $errors->first('size') }}</div>
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
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
                            </form>
                            <!--  -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th>Size</th>
                                                <th>Price</th>
                                                <th>Discount Price</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($product->attributes) > 0)
                                            @foreach($product->attributes as $key => $attr)
                                            @if($attr->is_deleted == 0)
                                            <tr>
                                                <td>{{ $attr->size }}</td>
                                                <td>${{ number_format((float)$attr->price, 2, '.', '') }}</td>
                                                <td>${{ !empty($attr->discount_price) ? number_format((float)$attr->discount_price, 2, '.', '') : '0.00' }}</td>
                                                <td>
                                                    <a href="{{ route('product.delete-attribute', $attr->id) }}" title="Delete" class="btn btn-danger"> <i class="fas fa-trash"></i> </a>
                                                </td>
                                            </tr>
                                            @endif
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
