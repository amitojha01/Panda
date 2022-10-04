@extends('admin.layouts.app')
@section('title', 'Orders List')

@section('style')
<link rel="stylesheet" href="{{ asset('public/admin/bundles/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
@endsection
@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                        <h4>Orders List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                        <th>Order ID</th>
                                        <th>User</th>
                                        <th>Payable Amount</th>
                                        <th>Quantity</th>
                                        <th>Customize Image</th>
                                        <th>Original Image</th>
                                        <th>Order Date</th>
                                        <th>Paid By</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($orders)
                                        @foreach($orders as $key => $order)
                                            <tr>
                                                <td>{{ $order->order_no }}</td>
                                                <td>{{ ($order->user ? $order->user->name : ( $order->shippingAddress ? $order->shippingAddress[0]->name : '' )) }}</td>
                                                <td>${{ $order->total_price }}</td>
                                                <td>{{ $order->quantity }}</td>
                                                <td>
                                                    <a href="{{ asset($order->customize_image) }}" download>
                                                        <img class="col-image" alt="image" src="{{ asset($order->customize_image) }}" width="35">
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ asset($order->original_image) }}" download>
                                                        <img class="col-image" alt="image" src="{{ asset($order->original_image) }}" width="35">
                                                    </a>
                                                </td>
                                                <td>{{  date('d-m-Y', strtotime($order->created_at)) }}</td>
                                                <td>PayPal</td>
                                                <td>
                                                    @if($order->status == 1)
                                                        <label class="text-info">Order Placed</label>
                                                    @elseif($order->status == 2)
                                                        <label class="text-primary">Under Process</label>
                                                    @elseif($order->status == 3)
                                                        <label class="text-warning">Out for Delivery</label>
                                                    @else
                                                        <label class="text-success">Completed</label>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('order.edit', $order->id) }}" title="Update" class="btn btn-primary"> <i class="fas fa-edit"></i> </a>
                                                    <!-- <a href="javascript:void(0)" title="Delete" class="btn btn-danger btn-delete-row">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a> -->
                                                </td>
                                            </tr>
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
    <script>
        $(document).ready(function(){
           // $("#table-1").dataTable();
        })
    </script>

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
