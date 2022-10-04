<!-- Footer section start here -->
<?php 
use App\Models\Setting;
$setting = Setting::all();

?>
<div class="footer">
	<div class="container">
    	<div class="row">
        	<div class="col-md-3 col-sm-12 col-xs-12">
            	<a href="<?= url('/'); ?>" class="footerlogo"><img src="{{ asset('public/frontend/images/footer_logo.png') }}" alt="footer_logo"/></a>
            </div>
            <form action="{{ route('subscribers.store') }}" method="post">
            @csrf
            <div class="col-md-6 col-sm-12 col-xs-12">
            	<div class="footertop_mid">
                    <h4>Subscribe Newsletter</h4>                   
                   <input type="email"  name="email" placeholder="Your Email" required/>
                   <input type="submit" value="" class="newsletterbtn"/>
               </div>
           </div>
            </form>
            <div class="col-md-3 col-sm-12 col-xs-12">
            	<div class="footertop_r">
                	<ul>
                    	<li><a href="{{ $setting[0]->fb_link }}" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="{{ $setting[0]->twitter_link }}" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="{{ $setting[0]->instagram_link }}" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        <li><a href="{{ $setting[0]->youtube_link }}" target="_blank"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="footerbottom">
        	<div class="container">
            	<div class="row">
                	<div class="col-md-4 col-sm-12 col-xs-12">
                    	<div class="footer_box">
                        	<h3>BlueTooth Photos</h3>
                            <p>a product of:</p>
                            <p><b>Address: </b> {{ $setting[0]->address }}</p>

                            <p><b>Phone:</b> <a href="javascript:void(0)">{{ $setting[0]->phone }}</a></p>
                            <p><b>Email:</b> <a href="mailto:{{ $setting[0]->email }}">{{ $setting[0]->email }}</a></p>

                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                    	<div class="footer_box">
                        	<h3>Quick links</h3>
                            <ul>
                            	<li><a href="<?= url('about-us'); ?>">About Us</a></li>
                                <li><a href="<?= url('contact-us'); ?>">Contact Us</a></li>
                                <li><a href="<?= url('privacy-policy'); ?>">Privacy Policy</a></li>
                                <li><a href="<?= url('shipping-policy'); ?>">Shipping</a></li>
                                <li><a href="<?= url('search'); ?>">Search</a></li>
                            </ul>
                        </div>
                    </div>                    
                    <div class="col-md-4 col-sm-12 col-xs-12">
                    	<div class="footer_box">
                        	<h3>Payment methods</h3>
                            <img src="{{ asset('public/frontend/images/card_img.png') }}" alt="card_img"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="fottercopyright">
   <div class="container">
   		<div class="row">
        	<div class="col-md-12 col-sm-12 col-xs-12">
            	<div class="footercopyright_l">
                	<p align="center">&copy; Copyright {{ date('Y') }} by Savi Ranch Studio</p>
                </div>
            </div>
        </div>
   </div>     	
</div>
