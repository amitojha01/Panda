
@extends('frontend.layouts.apphome')
@section('title', 'Welcome')

@section('content')



<div class="innerheadinghome">
	<div class="container">
		<h2>Contact Us</h2>
		<div class="aboutuspanel">
		<div class="row">
			<div class="col-md-6 col-sm-12 col-xs-12 contact-left">
      <div> <span><i class="fa fa-globe" aria-hidden="true"></i> ADDRESS :</span>
        <p> {{ getSettings('Address')}}</p>
        <div class="clr"></div>
      </div>
      
      <div> <span><i class="fa fa-phone-square" aria-hidden="true"></i> Mobile No :</span>
        <p><a href="tel:15628675309">{{ getSettings('Phone')}}</a></p>        
        <div class="clr"></div>
      </div>
      
      <div> <span><i class="fa fa-envelope" aria-hidden="true"></i> Email :</span>
        <p><a href="setsail@select.com">{{ getSettings('Email')}}</a> </p>
        <div class="clr"></div>
      </div>
    </div>
   		<div class="col-md-6 col-sm-12 col-xs-12 contact-right">
      <form method="post"action="{{ route('add-contact') }}" enctype="multipart/form-data">
      	@csrf
        <div class="form-group">
          <label for="name">Name :</label>
          <input type="text" class="form-control" id="email" name="name" required>
        </div>
        <div class="form-group">
          <label for="email">Email :</label>
          <input type="email" class="form-control" id="pwd" name="email" required>
        </div>
        <div class="form-group">
          <label for="phoneno">Phone No :</label>
          <input type="text" class="form-control" id="" name="phone_no" required>
        </div>
        <div class="form-group">
          <label for="pwd">Message :</label>
          <textarea class="contact_message" name="message" required></textarea>
        </div>
        <button type="submit" class="btn btn-default contact_button">Submit</button>
      </form>
    </div>
       </div>
        <div class="clr"></div>    
        <div class="contact_map">
     	<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3024.582151855161!2d-74.01612258506377!3d40.70519937933256!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a1160594d29%3A0x425c4a404a3afe0f!2sBroadway%2FMorris+St!5e0!3m2!1sen!2sin!4v1549432750849" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
    </div>
		</div>
	</div>
</div>



@endsection

@section('script')

@endsection