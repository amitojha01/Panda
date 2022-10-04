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
                    <h4>Enquiry</h4>                    
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                <th class="text-center">
                                    #
                                </th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Contact on</th>                               
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($enquiry)
                                @foreach($enquiry as $key => $e)
                                    <tr>
                                        <td>{{ ($key+1) }}</td>
                                        <td>{{ $e->first_name }}</td>
                                        <td>{{ $e->email }}</td>
                                        <td>{{ $e->phone }}</td>
                                        <td>{{ $e->subject }}</td>
                                        <td>{{ $e->message }}</td>
                                        <td>{{ date('d-m-Y', strtotime($e->created_at))  }}</td>
                                        <td>
                                            <a href="{{ route('enquiry.delete', $e->id) }}" onclick="return deleteEnquiry()" title="Delete" class="btn btn-danger"> <i class="fas fa-trash"></i> </a>
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
    <script>
  function deleteEnquiry() {
      if(!confirm("Are You Sure to delete this"))
      event.preventDefault();
  }
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
