@extends('admin.layouts.app')
@section('title', 'City List')

@section('style')
<link rel="stylesheet" href="{{ asset('public/admin/bundles/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
@endsection
@section('content')
<?php 
use App\Models\State;
?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    <h4>City List</h4>
                    
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>City</th>
                                <th>State</th> 
                                <th>Zip</th>     
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($city) {
                            foreach($city as $key => $value){
                                 $states = State::where('id', $value->state_id)
                            ->first();

                                ?>
                                <tr>
                                    <td>{{ ($key+1) }}</td>
                                    <td>{{ ucwords($value->name) }}</td> 
                                    <td>{{ $states->name }}</td>
                                    <td>{{$value->zip}}</td>      
                                    
                                    <td>
                                        <a href="{{ route('cities.edit', $value->id) }}" title="Update" class="btn btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                       
                                    </td>
                                </tr>
                            <?php } }
                            else{?>
                                <tr>
                                    <td colspan="4" class="text-info text-center">
                                        Sorry!! No record found.
                                    </td>
                                </tr>
                            <?php }  ?>
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
