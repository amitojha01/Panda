<!-- Header section starts here -->
<div class="headertop">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="headertop_l">
                        <span><i class="fa fa-phone" aria-hidden="true"></i> &nbsp; Call: <a href="tel:9497021623">(949) 702-1623</a></span>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="headertop_r">
                        @if(session()->has('user'))
                        <span><i class="fa fa-user" aria-hidden="true"></i> &nbsp; <a href="<?= url('dashboard'); ?>">Hello {{ session()->get('user')['userName'] }}</a></span>
                        @else
                        <span><i class="fa fa-user" aria-hidden="true"></i> &nbsp; <a href="<?= url('sign-in'); ?>">Sign In / Sign UP</a></span>
                        @endif                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="header">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-12 col-xs-12">
                    <a href="<?= url('/'); ?>" class="logo"><img src="{{ asset('public/frontend/images/logo.png') }}" alt="logo"/></a>
                </div>
                <div class="col-md-9 col-sm-12 col-xs-12">
                <div class="header_right">
                    <div class="stellarnav">
                        <ul>
                            <li class="nav-item {{ (request()->segment(1) == '') ? 'active' : '' }}"><a href="<?= url('/'); ?>">Home</a></li>                      

                            <li class="nav-item {{ (request()->segment(1) == 'about-us') ? 'active' : '' }}"><a href="<?= url('about-us'); ?>">About Us </a></li>
                            <li class="nav-item {{ (request()->segment(1) == 'contact-us') ? 'active' : '' }}"><a href="<?= url('contact-us'); ?>">Contact Us</a></li>
                            <li class="nav-item {{ (request()->segment(1) == 'selfie-video') ? 'active' : '' }}"><a href="<?= url('selfie-video'); ?>">Selfie Videos</a></li>		   
                        </ul>
                    </div>
                    <a href="<?= url('buy'); ?>" class="buynow">BUY NOW</a>
                    <div class="wishcart">                    
                        <a href="<?= url('wishlist'); ?>" id="fav-count">
                            <img src="{{ asset('public/frontend/images/heart_icon.png') }}" alt="heart_icon"/>
                            <span>WishList</span>
                            
                            @if(auth()->check() )
                                @php($tmp = \App\Models\Favourite::where('user_id', Auth()->user()->id)->first())
                                <b class="wishlistno">{{!empty($tmp)?'1':'0'}}</b>
                            @else
                                <b class="wishlistno">0</b>
                            @endif
                        </a>
                        <a href="<?= url('cart'); ?>" id="card-count" disabled>
                            <img src="{{ asset('public/frontend/images/cart_icon.png') }}" alt="cart_icon"/>
                            <span>Cart</span>
                            <b class="wishlistno">0</b>
                        </a>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Header section end here -->
@section('script')
<script>
    var option = JSON.parse(localStorage.getItem('options'));
    //$('#card-count b').text(option.quantity);
</script>
@endsection
