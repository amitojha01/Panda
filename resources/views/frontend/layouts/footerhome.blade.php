<div class="footer">
<div class="container">
	<div class="row">
		<div class="col-lg-3 col-md-12 col-sm-12">
			<div class="footerlogo">
				<a href="{{URL::to('/')}}"><img src="{{ asset('public/frontend/images/logo.png') }}" alt="logo"/></a>
			</div>
		</div>
		<div class="col-lg-3 col-md-12 col-sm-12">
			<div class="footerbox">
				<h3>Menu</h3>
				<ul>
					<li><a href="{{ route('about-us') }}">About</a></li>					
					<li><a href="{{ route('features') }}">Features</a></li>
					<li><a href="{{ route('blogs') }}">Blog</a></li>
					<li><a href="{{ route('pricing') }}">Pricing</a></li>
					<li><a href="{{ route('contact-us')}}">Contact</a></li>					
				</ul>
			</div>
		</div>
		<div class="col-lg-3 col-md-12 col-sm-12">
			<div class="footerbox">
				<h3>Features</h3>
				<ul>
					<li><a href="">My Workouts</a></li>					
					<li><a href="">My TeamingUp Groups</a></li>
					<li><a href="">My Connections</a></li>
					<li><a href="">Recommendations</a></li>
					<li><a href="">Compare</a></li>					
				</ul>
			</div>
		</div>
		<div class="col-lg-3 col-md-12 col-sm-12">
			<div class="footerbox">
				<h3>Social</h3>
				<div class="sociallink">
					<a href="{{getSettings('Facebook Link')}}"><i class="fa fa-facebook" aria-hidden="true"></i></a>
					<a href="{{getSettings('Twitter Link')}}"><i class="fa fa-twitter" aria-hidden="true"></i></a>
					<a href="{{getSettings('Instagram Link')}}"><i class="fa fa-instagram" aria-hidden="true"></i></a>
				</div>
			</div>
		</div>		
		</div>
		<div class="copyright">
			<div class="copyrightl">
				<p>Copyright © 2021 PARC Sports LLC All Rights Reserved.</p>
			</div>
			<div class="copyrightr">
				<ul>
					<li><a href="{{ route('terms-of-use') }}">Terms of Use</a></li>
					<li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
				</ul>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
