<!-- Header section starts here -->
<div class="header">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-12 col-sm-12">
                <a href="{{URL::to('/')}}" class="logohome"><img src="{{ asset('public/frontend/images/logo.png') }}" alt="logo"/></a>
            </div>
            <div class="col-lg-8 col-md-12 col-sm-12">
                <div class="header_right">
                <div class="stellarnav">
                    <ul>
                        <li><a href="{{URL::to('/')}}">Home </a></li>
                        <li><a href="{{ route('about-us') }}">About</a></li>
                        <li><a href="{{ route('features') }}">Features</a></li>
                        <li><a href="{{ route('blogs') }}">Blog</a></li>
                        <li><a href="{{ route('contact-us')}}">Contact</a></li>
                        <li><a href="{{ route('login') }}">Login</a></li>
                    </ul>
                </div>
                <a href="{{ route('registration') }}" class="registerbtn">Register now</a>
                </div>  
                
            </div>
        </div>
    </div>
</div>

<!-- Header section end here -->
<!-- @section('script')
<script>
    var option = JSON.parse(localStorage.getItem('options'));
    //$('#card-count b').text(option.quantity);
</script>
@endsection -->
