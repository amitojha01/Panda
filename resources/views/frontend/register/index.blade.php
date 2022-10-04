<!DOCTYPE html>
<html lang="en">
<!-- auth-login.html  21 Nov 2019 03:49:32 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Bluetoothphoto | Signup</title>
  <link rel='shortcut icon' type='image/x-icon' href="{{ asset('public/fav.ico') }}" />
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('public/admin/css/app.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/admin/bundles/bootstrap-social/bootstrap-social.css') }}">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('public/admin/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('public/admin/css/components.css') }}">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="{{ asset('public/admin/css/custom.css') }}">
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-1 col-md-6 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2"">
            <div class="col-md-12 text-center pb-5">
              <a href="<?= url('/'); ?>"><img src="{{ asset('public/frontend/images/logo.png') }}" alt="" srcset=""></a>
            </div>
            <div class="card card-primary">
              <div class="card-header">
                <h4 style="text-align: center; width: 100%;">Bluetoothphoto  Signup</h4>
              </div>
              <div class="card-body">
                <form method="POST" action="{{ route('frontend.signup') }}" class="needs-validation" novalidate="">
                  @csrf
<div class="row">
                  <div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" type="text" class="form-control" name="name" tabindex="1" placeholder="Please enter your name"  required autofocus> 

                    <input type="hidden" class="form-control" name="role_id" value="1">                    
                  </div>
                </div>
 <div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <label for="phone">Phone</label>
                    <input id="phone" type="text" onchange="checkPhone(this)" class="form-control" name="phone" tabindex="1" placeholder="Please enter your phone number"  required autofocus>
                    <span style="color:red; display:none" id="invalidno">Please enter valid number !!</span>                      
                  </div>
                </div>
                 <div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email"  onchange="checkEmail(this)" class="form-control" name="email" tabindex="1" required autofocus> 
                     <span style="color:red; display:none" id="existemail">Email already exist !!</span>                   
                    @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                  </div>
                </div>
 <div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <label for="phone">Address</label>
                    <input id="address" type="text" class="form-control" name="address" tabindex="1" placeholder="Please enter your address"  required autofocus>                    
                  </div>
                </div>
                 <div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <label for="phone">Country/Region</label>
                    <select class="form-control" name="country" id="country-dropdown" required>
                      <option value="">Select</option>
                      @if($countries)
                      @foreach($countries as $country)
                      <option value="{{$country->id}}">{{ $country->name }}</option>
                      @endforeach
                      @endif
                    </select>                   
                  </div>
                </div>
                 <div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <label for="phone">States</label>
                    <select class="form-control" name="state" id="state-dropdown" required>                      
                    </select>                  
                  </div>
</div>
 <div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <label for="phone">City</label>
                    <select class="form-control" name="city" id="city-dropdown"><option></option></select>                  
                  </div>
                </div>

                 <div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                      
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" placeholder="Enter password" required>
                    
                    @if ($errors->has('password'))
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                    @endif
                  </div>
                </div>

 <div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <div class="d-block">
                      <label for="confirm password" class="control-label">Confirm Password</label>                       
                      
                    </div>
                    <input id="cpwd" type="password" class="form-control" name="cpassword" tabindex="2" placeholder="Confirm password" onchange="checkpassword(this)" required>

                    <span style="color:red; display:none" id="mismatch">Password and confirm password does not match!!</span> 
                  </div>
</div>
 <div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <div class="d-block">
                      <label for="pin code" class="control-label">Pin Code</label>            
                      
                    </div>
                    <input id="pincode" type="text" class="form-control" name="pin_code" tabindex="2" placeholder="Pin Code" required>
                  </div>
</div>

</div>

                  <div class="form-group">
                   <label class="label">Already have an account?<a href="<?= url('sign-in'); ?>" ><span style="color:#0e28e8"> Sign in</span></a></label>
                   
                </div>

                                <div class="form-group">
                  <button type="submit"  id="signup-btn" class="buynow" tabindex="4">
                    Register
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- General JS Scripts -->
<script src="{{ asset('public/admin/js/app.min.js') }}"></script>
<!-- JS Libraies -->
<!-- JS Libraies -->
<script src="{{ asset('public/admin//bundles/sweetalert/sweetalert.min.js') }}"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('public/admin//js/page/sweetalert.js') }}"></script>
<!-- Page Specific JS File -->
<!-- Template JS File -->
<script src="{{ asset('public/admin/js/scripts.js') }}"></script>
<!-- Custom JS File -->
<script src="{{ asset('public/admin/js/custom.js') }}"></script>

@section('script') 
@if ($message = Session::get('success'))  
  @php(Session::forget('success'))
    <script>
      swal('{{ $message }}', 'Success', 'success');
    </script>
  @endif
<script>
    $(document).ready(function() {        
        $('#country-dropdown').on('change', function() {
            var country_id = this.value;          
            $("#state-dropdown").html('');
            $.ajax({
                url:"{{url('get-states-by-country')}}",
                type: "GET",
                data: {
                    country_id: country_id,
                    _token: '{{csrf_token()}}' 
                },
                dataType : 'json',
                success: function(result){
                    console.log(result);
                    $('#state-dropdown').html('<option value="">Select State</option>'); 
                    $.each(result.states,function(key,value){
                        $("#state-dropdown").append('<option value="'+value.id+'">'+value.name+'</option>');
                    });
                    $('#city-dropdown').html('<option value="">Select State First</option>'); 
                }
            });
        });    
        $('#state-dropdown').on('change', function() {
            var state_id = this.value;
            $("#city-dropdown").html('');
            $.ajax({
                url:"{{url('get-cities-by-state')}}",
                type: "GET",
                data: {
                    state_id: state_id,
                    _token: '{{csrf_token()}}' 
                },
                dataType : 'json',
                success: function(result){
                    $('#city-dropdown').html('<option value="">Select City</option>'); 
                    $.each(result.cities,function(key,value){
                        $("#city-dropdown").append('<option value="'+value.id+'">'+value.name+'</option>');
                    });
                }
            });
        });
    });

    //====ChekEmail=======
     function checkEmail(dis){
            var email = $(dis).val();
            $.ajax({
                url:"{{url('check-email')}}",
                type: "GET",
                data: {
                    email: email,
                    _token: '{{csrf_token()}}' 
                },
                dataType : 'json',
                success: function(result){
                    if(result==1){
                        $('#existemail').show();
                         $("#signup-btn"). attr("disabled", true); 
                    }else{
                        $('#existemail').hide(); 
                         $("#signup-btn"). attr("disabled", false);   
                    }                    
                }
            });
        }

        function checkpassword(dis){
            var cpwd = $(dis).val();
            var pwd= $('#password').val();
            if(pwd != cpwd){
              $('#mismatch').show();
              $("#signup-btn"). attr("disabled", true);

            }else{
               $('#mismatch').hide();
              $("#signup-btn"). attr("disabled", false);
            }           
        }

        function checkPhone(dis)
        {
          var phone= $(dis).val();    
          var regexPattern=new RegExp(/^[0-9-+]+$/);    // regular expression 
          if(regexPattern.test(phone) && phone.length==10)
          {
            $('#invalidno').hide();
            $("#signup-btn"). attr("disabled", false);
          }
          else
          {
            $('#invalidno').show();
            $("#signup-btn"). attr("disabled", true);
           
          }
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
</body>

<!-- auth-login.html  21 Nov 2019 03:49:32 GMT -->
</html>