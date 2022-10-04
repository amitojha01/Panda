@extends('admin.layouts.app')
@section('title', 'Sports List')

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
                    <h4>Sports Position List</h4>
                    <a href="{{ route('admin.position.create') }}" class="btn btn-icon icon-left btn-info btn-list-add">
                        <i class="fas fa-plus"></i> Add
                    </a>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($position)
                            @foreach($position as $key => $position)
                                <tr>
                                    <td>{{ ($key+1) }}</td>
                                    <td>{{ ucwords($position->name) }}</td>
                                    <td>
                                        @if($position->status == 1)
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
                                        <a href="{{ route('admin.position.edit', $position->id) }}" title="Update" class="btn btn-primary"> <i class="fas fa-edit"></i> </a>
                                        <a href="javascript:void(0)" data-id="{{ $position->id }}" title="Delete" class="btn btn-danger btn-delete-row">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-info text-center">
                                        Sorry!! No record found.
                                    </td>
                                </tr>
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
    
    <script>
        $(document).ready(function(){
            $('#table-1').dataTable();
            
            $('.btn-delete-row').on('click', function(){
               let id = $(this).data('id');
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    })
                    .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "{{ url('admin/delete-position') }}"+"/"+id,
                            type:'get',
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function(data) {
                                swal(data.message, 'success')
                                .then( () => {
                                    location.reload();
                                });
                            }
                        });
                    }else{
                        return false;
                    }
                    });
            })
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
