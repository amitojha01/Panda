@extends('frontend.layouts.apphome')
@section('title', 'Welcome')

@section('content')


<div class="innerheadinghome">
  <div class="container">
    <h2>Features</h2>
<div class="row">
 	<div class="col-md-3 col-sm-12 col-xs-12">
 	<div class="featured_left adsss">
 	<nav id="desktop-nav">  
    <ul>
      <!-- <li class="active"><a href="#home" class="page-scroll">Dashboard</a></li>
      <li><a href="#about" class="page-scroll">Compare</a></li>
      <li><a href="#portfolio" class="page-scroll">TeamingUp Groups</a></li>
      <li><a href="#contact" class="page-scroll">Chat</a></li> -->
      <?php 
        if (!empty(count($features))) {
        for($i=0; $i<count($features); $i++) {
        ?>
     <!-- <li class="<?php if($i== 0){ echo "active";} ?>" onclick="activelink(this)"><a href="#home{{$i}}" class="page-scroll">{{ $features[$i]->title }}</a></li> -->
     <li class="featurelink" onclick="activelink(this)"><a href="#home{{$i}}" class="page-scroll">{{ $features[$i]->title }}</a></li>
 		<?php }} ?>
    </ul>
  </nav>
   </div>
    </div>
    <div class="col-md-9 col-sm-12 col-xs-12">
   		<div class="featured_right">
   			 <?php 
        if (!empty(count($features))) {
        for($i=0; $i<count($features); $i++) {
        ?>
    		<section id="home{{$i}}">
    			 <h3>{{ $features[$i]->title }}</h3> 
             <?php if(!empty($features[$i]->image)){ ?><img src="{{ asset($features[$i]->image) }}" alt="dashboard"/> <?php } ?>
            <p>{!! $features[$i]->content !!}</p>           
           
           
    		</section>
    	<?php } } ?>
		</div>
		</div>
    </div>
    
    
  </div>
</div>



@endsection

@section('script')
<script src="https://leafo.net/sticky-kit/src/jquery.sticky-kit.js"></script>
<script>jQuery(function(){jQuery(".adsss").stick_in_parent({offset_top:10});});</script>

<script>
	jQuery(function($){
	var topMenuHeight = $("#desktop-nav").outerHeight();
	$("#desktop-nav").menuScroll(topMenuHeight);
});

// COPY THE FOLLOWING FUNCTION INTO ANY SCRIPTS
jQuery.fn.extend({
    menuScroll: function(offset) {
		// Declare all global variables
        var topMenu = this;
		var topOffset = offset ? offset : 0;
        var menuItems = $(topMenu).find("a");
        var lastId;
	
		// Save all menu items into scrollItems array
        var scrollItems = $(menuItems).map(function() {
            var item = $($(this).attr("href"));
            if (item.length) {
                return item;
            }
        });

		// When the menu item is clicked, get the #id from the href value, then scroll to the #id element
        $(topMenu).on("click", "a", function(e){
            var href = $(this).attr("href");
            
            var offsetTop = href === "#" ? 0 : $(href).offset().top-topOffset;

            $('html, body').stop().animate({ 
                scrollTop: offsetTop
            }, 300);
            e.preventDefault();

        });
		
		// When page is scrolled
        $(window).scroll(function(){
            var nm = $("html").scrollTop();
            var nw = $("body").scrollTop();
            var fromTop = (nm > nw ? nm : nw)+topOffset;

			
			// When the page pass one #id section, return all passed sections to scrollItems and save them into new array current
            var current = $(scrollItems).map(function(){
                if ($(this).offset().top <= fromTop)
                return this;
            });
			
			// Get the most recent passed section from current array
            //current = current[current.length-1];
             current = current[current.length-1];
            var id = current && current.length ? current[0].id : "";
            
            if (lastId !== id) {
                lastId = id;
                // Set/remove active class
                $(menuItems)
                //.parent().removeClass("active")
                //.end().filter("[href='#"+id+"']").parent().addClass("active");
            }      

        });
    }
});

function activelink(dis){
    $('.featurelink').removeClass('active');
     $(dis).addClass("active");
}


	</script>
@endsection