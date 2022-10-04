// JavaScript Document




//Product Carousel
var cc = $('#product-carousel, #product-carousel1');
cc.owlCarousel({
	autoplay:true,
    loop:true,
    nav:true,
	dots:false,
	//animateOut: 'fadeOut',
    items: 4,
	navText: [ '<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>' ],
	
	responsive : {
    // breakpoint from 0 up
   0:{
            items:1,
            nav:false
        },
    // breakpoint from 480 up
   480:{
            items:1,
            nav:false	
        },
    // breakpoint from 768 up
    768:{
            items:4,
            nav:false,
        }
}
});




