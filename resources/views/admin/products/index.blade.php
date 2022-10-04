@extends('admin.layouts.app')
@section('title', 'Product')

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
                    <h4>Product</h4>
                    <a href="{{ route('product.create') }}" class="btn btn-icon icon-left btn-info btn-list-add">
                        <i class="fas fa-plus"></i> Add
                    </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                <th class="text-center">
                                    #
                                </th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Tag Line</th>
                                <th>Image</th>
                                <th>Basic Price</th>
                                <th>Discount Price</th>
                                <th>Status</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($product)
                                @foreach($product as $key => $p)
                                    <tr>
                                        <td>{{ ($key+1) }}</td>
                                        <td>{{ $p->title }}</td>
                                        <td>{{ $p->description }}</td>
                                        <td>{{ $p->product_tag_line }}</td>
                                        <td>
                                        @if(count($p->images) > 0)
                                            <img class="col-image" alt="image" src="{{ asset($p->images[0]->image) }}" width="35">
                                        @endif
                                        </td>
                                        <td>${{ number_format((float)$p->price, 2, '.', '') }}</td>
                                        <td>${{ !empty($p->discount_price) ? number_format((float)$p->discount_price, 2, '.', '') : '0.00' }}</td>
                                        <td>
                                        @if($p->status == 1)
                                        <div class="badge badge-success badge-shadow">
                                            Active
                                        </div>
                                        @else
                                        <div class="badge badge-warning badge-shadow">
                                            Inctive
                                        </div>
                                        @endif
                                    </td>
                                        <td>
                                            <a href="{{ route('product.edit', $p->id) }}" title="Update" class="btn btn-primary"> <i class="fas fa-edit"></i> </a>
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
    <script src="{{ asset('public/admin/bundles/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('public/admin/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('public/admin/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('public/admin/js/page/datatables.js') }}"></script>

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
