@extends('admin.layouts.app')
@section('title', 'Coach List')

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
                            <h4>Coach Email List</h4>

                            <form method="post" action="{{ route('admin.searchByCon') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <input class="form-controlz" name="coachName" type="text" placeholder="Search Coach" required="required">
                                    </div>
                                    <div class="col-md-3" >

                                        <button type="submit" class="btn btn-default" style="padding:4px 22px 0 9px;">
                                          <i  class="fa fa-search" aria-hidden="true" style=" font-size:18px"></i>
                                      </button>
                                  </div>
                                  <?php if(Session::has('searchcoach')){ ?>
                                  <div class="col-md-3" style="padding:0">

                                      <a href="{{ route('admin.reset-search') }}"> <input type="button" class="resetbtn" value="Reset"></a>
                                  </div>
                                 
                                  <?php } ?>


                              </div>
                          </form>

                            <a href="{{ route('admin.coach.search') }}" class="btn btn-icon icon-left btn-info btn-list-add">
                                 Search
                            </a>
                            <a href="{{ route('admin.email.create') }}" class="btn btn-icon icon-left btn-info btn-list-add" style="margin-right:110px">
                                <i class="fas fa-plus"></i> Add
                            </a>
                        </div>
                        <div id="table_data">
                           <div class="table-responsive">
                               <table class="table table-striped table-bordered">
                                  <tr>
                                     <th width="5%">ID</th>
                                     <th width="20%">School</th>
                                     <th width="20%">Name</th>
                                     <th width="20%">Title</th>
                                     <th width="20%">Email</th>
                                     <th width="20%">Action</th>
                                 </tr>
                                 @foreach($emaillist as $row)
                                 <tr>
                                     <td>{{ $row->id }}</td>             
                                     <td>{{ str_replace('"', '', $row->school) }}</td>
                                     <!-- <td>{{ $row->name }}</td> -->
                                     <td>{{ str_replace('"', '', $row->name) }}</td>
                                     <td>{{ str_replace('"', '', $row->title) }}</td>
                                     
                                     <td>{{ $row->email }}</td>
                                     <td>

                                        <a href="{{ route('admin.edit.coach', $row->id) }}" title="Update" class="btn btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="javascript:void(0)" data-id="{{ $row->id }}" title="Delete" class="btn btn-danger btn-delete-row">
                                            <i class="fas fa-trash-alt"></i>
                                        </a> 
                                    </td>
                                 </tr>
                                 @endforeach
                             </table>

                             {!! $emaillist->links() !!}

                         </div>
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
                    url: "{{ url('admin/email') }}"+"/"+id,
                    type:'delete',
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

<!-- <script>
    $(document).ready(function(){

       $(document).on('click', '.pagination a', function(event){
          event.preventDefault(); 
          var page = $(this).attr('href').split('page=')[1];
          fetch_data(page);
      });

       function fetch_data(page)
       {
          $.ajax({
             url:"/pagination/fetch_data?page="+page,
             success:function(data)
             {
                $('#table_data').html(data);
            }
        });
      }

  });
</script> -->

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
