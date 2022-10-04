
@extends('frontend.layouts.apphome')
@section('title', 'About Us')

@section('content')

<!-- <div class="innerheadinghome">
	<div class="container">
		<h2>{{ $title }}</h2>
		<div class="aboutuspanel">
			<img src="{{ asset($cms_data->image) }}" alt="blogimg2"/>
			<p> {!! $cms_data? $cms_data->content: '' !!}</p>
		</div>
	</div>
</div> -->

<div class="innerheadinghome">
  <div class="container">
    <h2>About Us</h2>
    <a id="button"></a>
<div class="row">
 	<div class="col-md-3 col-sm-12 col-xs-12">
 	<div class="featured_left adsss">
 	<nav id="desktop-nav">  
    <ul>
      <li class="active"><a href="#home" class="page-scroll">About Us</a></li>
      <li><a href="#about" class="page-scroll">Our Team</a></li>  
      <li><a href="#advisory" class="page-scroll">Advisory Board </a></li>    
    </ul>
  </nav>
   </div>
    </div>
    <div class="col-md-9 col-sm-12 col-xs-12">
   		<div class="featured_right">
    		<section id="home">
    			 <h3>{{ $title }}</h3>
    			
    			 <img src="{{ asset($cms_data->image) }}" alt="blogimg2" style="width:300px;"/>

    			 <!-- 
             <img src="images/blogimg2.png" alt="blogimg2" style="width:300px;"/>  -->
             <p> {!! $cms_data? $cms_data->content: '' !!}</p>
            
    		</section>
    		
			<section id="about">
			<br><br>
			<h3>Our Team</h3>
				<div class="row">
					<?php foreach($teams as $team){?>
					<div class="col-md-4 col-sm-12 col-xs-12">
						<div class="ourteambox">
							<div class="ourteamimg"><img src="{{ asset($team->image) }}" alt="testimonials_img"/></div>
							<h4>{{ $team->name }}</h4>
							<span>{{ $team->position }}</span>
							<div class="ourteam">
							<span>{{ $team->bio }}</span>
						</div>
							<div class="socialshare">
								<a href="{{ $team->fb_link }}" target="_blank"><i class="fa fa-facebook" aria-hidden="true" ></i></a>
								<a href="{{ $team->twitter_link }}"  target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
								<a href="{{ $team->insta_link }}"  target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
							</div>
						</div>
					</div>
					<?php } ?>
					
					
				</div> 
			</section>

			<!----Advisory Board--->
			<section id="advisory">
			<br><br>
			<h3>Advisory Board</h3>
				<div class="row">
					<?php foreach($advisory as $advisory){?>
					<div class="col-md-4 col-sm-12 col-xs-12">
						<div class="ourteambox">
							<div class="ourteamimg"><img src="{{ asset($advisory->image) }}" alt="testimonials_img"/></div>
							<h4>{{ $advisory->name }}</h4>
							<span>{{ $advisory->position }}</span>
							<div class="ourteam">
							<span>{{ $advisory->bio }}</span>
						</div>
							<div class="socialshare">
								<a href="{{ $advisory->fb_link }}" target="_blank"><i class="fa fa-facebook" aria-hidden="true" ></i></a>
								<a href="{{ $advisory->twitter_link }}"  target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
								<a href="{{ $advisory->insta_link }}"  target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
							</div>
						</div>
					</div>
					<?php } ?>
					
					
				</div> 
			</section>
			

			<!-----End Advisory Board Section------->
		</div>
		</div>
    </div>
</div>
</div>




@endsection

@section('script')
<script>var btn = $('#button');

$(window).scroll(function() {
  if ($(window).scrollTop() > 300) {
    btn.addClass('show');
  } else {
    btn.removeClass('show');
  }
});

btn.on('click', function(e) {
  e.preventDefault();
  $('html, body').animate({scrollTop:0}, '300');
});

</script>

@endsection