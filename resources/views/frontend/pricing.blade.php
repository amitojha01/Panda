@extends('frontend.layouts.apphome')
@section('title', 'Welcome')

@section('content')



<div class="innerheadinghome">
	<div class="container">		
		<div class="pricingpanel">
	   		<h1>Choose Your Pricing Plan </h1>
		   <h4>Athlete Pricing Plan</h4>
			<div class="row">
				<div class="col-lg-6 col-md-12 col-sm-12">
					<div class="pricingbox">
						<div class="pricingboxtop">
							<h3>Monthly</h3>
							<h2>${{$athlete_subscription->monthly_amount}}</h2>
						</div>
						<ul>
							<li>{{$athlete_subscription->content}}</li>
							
						</ul>
						<div align="center"><a href="" class="getstarted">Get Started</a></div>
					</div>
				</div>
				<div class="col-lg-6 col-md-12 col-sm-12">
					<div class="pricingbox">
						<div class="pricingboxtop">
							<h3>Yearly</h3>
							<h2>${{$athlete_subscription->yearly_amount}}</h2>
						</div>
						<ul><li>{{$athlete_subscription->content}}</li>
							
						</ul>
						<div align="center"><a href="" class="getstarted">Get Started</a></div>
					</div>
				</div>

			</div>
						
			<h4>Coach Pricing Plan</h4>
			<div class="row">
				<div class="col-lg-6 col-md-12 col-sm-12">
					<div class="pricingbox">
						<div class="pricingboxtop">
							<h3>Monthly</h3>
							<h2>${{$coach_subscription->monthly_amount}}</h2>
						</div>
						<ul>
							<li>{{$coach_subscription->content}}</li>
						</ul>
						<div align="center"><a href="" class="getstarted">Get Started</a></div>
					</div>
				</div>
				
				
				<div class="col-lg-6 col-md-12 col-sm-12">
					<div class="pricingbox">
						<div class="pricingboxtop">
							<h3>Yearly</h3>
							<h2>${{$coach_subscription->yearly_amount}}</h2>
						</div>
						<ul>
							<li>{{$coach_subscription->content}}</li>
						</ul>
						<div align="center"><a href="" class="getstarted">Get Started</a></div>
					</div>
				</div>

			</div>
 		</div>
	</div>
</div>



@endsection

@section('script')

@endsection