@extends('frontend.layouts.apphome')
@section('title', 'Welcome')

@section('content')


<div class="innerheadinghome">
	<div class="container">
		<h2>Blog</h2>
		<div class="row">
 		<div class="col-md-12 col-sm-12 col-xs-12"> 
			<div class="blog_details">
				<div class="blog_img blogdetailsimg">
					<img src="{{ asset($blogs->image) }}" alt="blogimg2">
				</div>
				<h3>{{isset($blogs)?($blogs->title):''}}</h3>
				<p>
					{!! $blogs->content !!}</p>
				<span>{{date("d M Y", strtotime(isset($blogs)?($blogs->created_at):''))}} posted by <b>Admin</b></span>
			</div>
 		
 		</div>
 		
 		<div class="clr"></div>
 		</div>
	</div>
</div>




@endsection

@section('script')

@endsection