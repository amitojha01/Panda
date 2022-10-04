@extends('admin.layouts.app')
@section('title', 'Fitness List')

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
                    <h4>Fitness List</h4>
                 
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                            <th class="text-center">
                            <th>#</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Status</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($fitness)
                                  @foreach($fitness as $key => $fitness)
                                <tr>
                                    <td>1</td>
                                    <td>{{ $fitness->title }}</td>
                                    <td>{{ $fitness->content }}</td>
                                    <td>
                                        @if($fitness->status == 1)
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
                                        <a href="{{ route('fitness.edit', $fitness->id) }}" title="Update" class="btn btn-primary"> <i class="fas fa-edit"></i> </a>
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
