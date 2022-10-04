//Product Carousel
var cc = $('#gamehighlight');
if(cc.length > 0){
    cc.owlCarousel({
        autoplay:true,
        loop:true,
        nav:true,
        dots:false,
        //animateOut: 'fadeOut',
        items: 1,
        navText: [ '<i class="fa fa-chevron-circle-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-circle-right" aria-hidden="true"></i>' ],
        
        responsive : {
        // breakpoint from 0 up
    0:{
                items:1,
                nav:true,
            },
        // breakpoint from 480 up
    480:{
                items:1,
                nav:true,	
            },
        // breakpoint from 768 up
        768:{
                items:1,
                nav:true,
            }
    }
    });
}



//Product Carousel
var cc = $('#videoevidence');
if(cc.length > 0){
    cc.owlCarousel({
        autoplay:true,
        loop:true,
        nav:true,
        dots:false,
        //animateOut: 'fadeOut',
        items: 2,
        navText: [ '<i class="fa fa-chevron-circle-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-circle-right" aria-hidden="true"></i>' ],
        
        responsive : {
        // breakpoint from 0 up
    0:{
                items:1,
                nav:true,
            },
        // breakpoint from 480 up
    480:{
                items:1,
                nav:true,	
            },
        // breakpoint from 768 up
        768:{
                items:2,
                nav:true,
            }
    }
    });
}

$(function(){
    if($('#testDiv').length > 0){
      $('#testDiv').slimScroll({
          alwaysVisible: true,
          railVisible: true,
		  height : '360px',
		  color : '#FFD500',
		  opacity : '1',
		  paddingRight : '12px',
      });
    }
  });


$(function(){
    if($('.ourteam').length > 0){
      $('.ourteam').slimScroll({
          alwaysVisible: true,
          railVisible: true,
          height : '210px',
          color : '#FFD500',
          opacity : '1',
          paddingRight : '12px',
      });
    }
  });


