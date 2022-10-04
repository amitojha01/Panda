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
                <form method="post" action="" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="card-header">
                      <h4>User Detail</h4>
                    </div>
                    <div class="card-body">
                      <table class="table table-hover">
                        <tr>
                          <th>Name</th>
                          <td>{{ $user->name }}</td>
                        </tr>

                        <tr>
                          <th>Email</th>
                          <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                          <th>Phone</th>
                          <td>{{ $user->phone }}</td>
                        </tr>

                        <tr>
                          <th>Address</th>
                          <td>{{ $user->address }}</td>
                        </tr>
                        <tr>
                          <th>Apartment</th>
                          <td>{{ @$user->apartment_name }}</td>
                        </tr>
                        <tr>
                          <th>Country</th>
                          <td>{{ @$country->name }}</td>
                        </tr>
                        <tr>
                          <th>State</th>
                          <td>{{ @$state->name }}</td>
                        </tr>
                        <tr>
                          <th>City</th>
                          <td>{{ @$city->name }}</td>
                        </tr>
                        <tr>
                          <th>Zip</th>
                          <td>{{ @$user->pin_code }}</td>
                        </tr>
                         
                      </table>
                    </div>
                    <div class="card-footer text-right">
                        <a href="<?= url('admin/user'); ?>" class="btn btn-info">Back</a>
                      
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
