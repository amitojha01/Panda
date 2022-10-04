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
                    <h4>Newsletter</h4>                    
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                <th class="text-center">
                                    #
                                </th>                                
                                <th>Email</th>
                                <th>Subscribed on</th>
                                <th>Status</th> 
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($newsletter)
                                @foreach($newsletter as $key => $n)
                                    <tr>
                                        <td>{{ ($key+1) }}</td>
                                        <td>{{ $n->email }}</td>
                                        <td>{{ date('d-m-Y', strtotime($n->created_at))  }}</td>
                                        <td>
                                        @if($n->status == 1)
                                        <div class="badge badge-success badge-shadow">
                                            Subscribed
                                        </div>
                                        @else
                                        <div class="badge badge-warning badge-shadow">                                            Unsubscribed
                                        </div>
                                        @endif
                                        </td>
                                        <td>
                                            <!-- <a href="{{ route('newsletter.delete', $n->id) }}" onclick="return deleteNewsletter()"  title="Delete" class="btn btn-danger"> <i class="fas fa-trash"></i> </a> -->
                                            <a href="javascript:void(0)" data-id="{{ $n->id }}" title="Delete" class="btn btn-danger btn-delete-row">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
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
    <!-- <script>
  function deleteNewsletter() {
      if(!confirm("Are You Sure to delete this"))
      event.preventDefault();
  }
 </script> -->
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
                            url: "{{ url('admin/delete-newsletter') }}"+"/"+id,
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
            });
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
