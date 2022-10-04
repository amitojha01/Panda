@extends('frontend.layouts.apphome')
@section('title', 'Welcome')

@section('content')


<div class="innerheadinghome">
	<div class="container">
		<h2>Blog</h2>
		<div class="row">
 		<div class="col-md-8 col-sm-12 col-xs-12">
 		<div class="row">
 			<?php 
					if (!empty(count($bloglist))) {
					for($i=0; $i<count($bloglist); $i++) {
					?>
 			<div class="col-md-6 col-sm-12 col-xs-12">
 				<div class="blog_details">
 					<a href="{{ url('blogs-details/'.$bloglist[$i]->id) }}">
			<div class="blog_img">
				<img src="{{ asset($bloglist[$i]->image) }}" alt="blogimg2">
			</div></a>
			<a href="{{ url('blogs-details/'.$bloglist[$i]->id) }}">
			<h3>{{ $bloglist[$i]->title }}.</h3>
			</a>

			<!------>
			 <p>{!! substr(($bloglist[$i]->content),0,170)  !!}<?php if(strlen($bloglist[$i]->content)>170) {?><a href="{{ url('blogs-details/'.$bloglist[$i]->id) }}">...Read More </a><?php } ?></p>
			

			<!------>
			
			<span>{{ date("d M Y", strtotime(($bloglist[$i]->created_at))) }} posted by <b>Admin</b></span>
		</div>
 			</div>
 			
 		<?php } } ?>
 			</div>
 		</div>
 		<div class="col-md-4 col-sm-12 col-xs-12 blog_right">
 			
			<div class="blog_right_1">
				<h2>Latest Posts</h2>
				<?php 
					if (!empty(count($latestbloglist))) {
					for($i=0; $i<count($latestbloglist); $i++) {
					?>
					<a href="{{ url('blogs-details/'.$latestbloglist[$i]->id) }}">
				<div class="blog_r_papular">
					<div class="blog_r_popu_l"><img src="{{ asset($latestbloglist[$i]->image) }}" alt="b2" /></div>
					<div class="blog_r_popu_r">
						<h3>{{ $latestbloglist[$i]->title }}</h3>
						<span>{{ date("d M Y", strtotime(($latestbloglist[$i]->created_at))) }}/ Urban</span>
					</div>
					<div class="clearfix"></div>
				</div>
				</a>
				<?php } } ?>
			</div>
			
			<!-- <div class="blog_right_r">
				<h2>Categories</h2>
				<ul>
					<li><a href=""><i class="fa fa-arrow-right" aria-hidden="true"></i>hotography (19)</a></li>
					<li><a href=""><i class="fa fa-arrow-right" aria-hidden="true"></i>Lifestyle (21)</a></li>
					<li><a href=""><i class="fa fa-arrow-right" aria-hidden="true"></i>Journal (16)</a></li>
					<li><a href=""><i class="fa fa-arrow-right" aria-hidden="true"></i>Works (7)</a></li>
					<li><a href=""><i class="fa fa-arrow-right" aria-hidden="true"></i>Conceptual (12)</a></li>
					<li><a href=""><i class="fa fa-arrow-right" aria-hidden="true"></i>Videography</a></li>					
				</ul>
			</div> -->

 		</div>
 		<div class="clr"></div>
 		</div>
	</div>
</div>




@endsection

@section('script')

@endsection