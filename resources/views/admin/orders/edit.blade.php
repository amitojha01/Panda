@extends('admin.layouts.app')
@section('title', 'Order Update')

@section('style')

@endsection
@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">                  
                <form method="post" action="{{ route('order.update', $order->id) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="card-header">
                      <h4>Update Order</h4>
                    </div>
                    <div class="card-body">
                      <table class="table table-hover">
                        <tr>
                          <th>Order No</th>
                          <td>{{ $order->order_no }}</td>
                        </tr>
                        <tr>
                          <th>Order By</th>
                          <td>{{ ($order->user ? $order->user->name : ( $order->shippingAddress ? $order->shippingAddress[0]->name : '' )) }}</td>
                        </tr>

                         @if($order->shippingAddress[0]->type=="guest")
                        <tr>
                          <th>User Email</th>
                          <td>
                            {{ ucfirst(@$order->shippingAddress[0]->email) }}
                          </td>
                        </tr>
                         @endif

                        <tr>
                          <th>Order Amount</th>
                          <td>${{ $order->total_price }}</td>
                        </tr>
                        <tr>
                          <th>Order Quantity</th>
                          <td>{{ $order->quantity }}</td>
                        </tr>
                        <tr>
                          <th>Image Size</th>
                          <td>{{ $order->size }}</td>
                        </tr>
                        <tr>
                          <th>Frame Type</th>
                          <td>{{ $order->frame_type }}</td>
                        </tr>
                        <tr>
                          <th>Customize Image</th>
                          <td>
                            <a href="{{ asset($order->customize_image) }}" download>
                              <img class="col-image" alt="image" src="{{ asset($order->customize_image) }}" width="35">
                            </a>
                          </td>
                        </tr>
                        <tr>
                          <th>Original Image</th>
                          <td>
                            <a href="{{ asset($order->original_image) }}" download>
                              <img class="col-image" alt="image" src="{{ asset($order->original_image) }}" width="35">
                            </a>
                          </td>
                        </tr>
                        <tr>
                          <th>
                            Shipping Address
                          </th>
                          <td>
                            @if(!empty($order->shippingAddress))
                              <label>Order Person : <strong>{{ $order->shippingAddress[0]->name }}</strong>, </label>
                              <label>Phone : <strong>{{ $order->shippingAddress[0]->phone }}</strong>, </label>
                              <label>Address : <strong>{{ $order->shippingAddress[0]->address }}</strong>,</label>
                              <label>Apartment Name : <strong>{{ $order->shippingAddress[0]->apartment_name }}</strong></label>
                            @else
                              <label>N/A</label>
                            @endif
                          </td>
                        </tr>
                        @if($order->shippingAddress[0]->hear_about!="")
                        <tr>
                          <th>Hear From</th>
                          <td>
                            {{ ucfirst(@$order->shippingAddress[0]->hear_about) }}
                          </td>
                        </tr>
                         @endif
                         
                        <tr>
                          <th>Order Status</th>
                          <td>
                          <div class="form-group">
                            <select class="form-control form-control-sm @error('status') is-invalid @enderror" name="status" required>
                                <option value="1" {{ $order->status == 1 ? 'selected' : ''}}>Order Placed</option>
                                <option value="2" {{ $order->status == 2 ? 'selected' : ''}}>Under Process</option>
                                <option value="3" {{ $order->status == 3 ? 'selected' : ''}}>Out for Delivery</option>
                                <option value="4" {{ $order->status == 4 ? 'selected' : ''}}>Completed</option>
                            </select>
                            @if ($errors->has('status'))
                            <div class="invalid-feedback">{{ $errors->first('status') }}</div>
                            @endif
                        </div>
                          </td>
                        </tr>
                      </table>
                    </div>
                    <div class="card-footer text-right">
                      <a href="{{ route('order.index') }}" class="btn btn-info">Back</a>
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
@if ($message = Session::get('success'))  
    <script>
      swal('{{ $message }}', 'Success', 'success');
    </script>
  @endif
@endsection
