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
var cc = $('#gamehighlightnew');
if(cc.length > 0){
	cc.owlCarousel({
	autoplay:true,
  autoplayTimeout:8000,
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
var cc = $('#coachslider');
if(cc.length > 0 ){
	cc.owlCarousel({
	autoplay:true,
   autoplayTimeout:8000,
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
if(cc.length > 0 ){
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

//Scroling

$(document).ready(function(){
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
    if($('#testDiv2').length > 0){
        $('#testDiv2').slimScroll({
            alwaysVisible: true,
            railVisible: true,
            height : '450px',
            color : '#FFD500',
            opacity : '1',
            paddingRight : '12px',
        });
    }
    if($('#testDiv3').length > 0){
        $('#testDiv3').slimScroll({
            alwaysVisible: true,
            railVisible: true,
            height : '300px',
            color : '#FFD500',
            opacity : '0.4',
            paddingRight : '12px',
        });
    }
    if($('#testDiv4').length > 0){
            $('#testDiv4').slimScroll({
            alwaysVisible: true,
            railVisible: true,
            height : '510px',
            color : '#4BFF00',
            opacity : '1',
            paddingRight : '12px',
        });
    }
    if($('#temsuse').length > 0){
        $('#temsuse').slimScroll({
            alwaysVisible: true,
            railVisible: true,
            height : '450px',
            color : '#4BFF00',
            opacity : '1',
            paddingRight : '12px',
        });
    }
    if($('#workout_l_box').length > 0){
        $('#workout_l_box').slimScroll({
            alwaysVisible: true,
            railVisible: true,
            height : '780px',
            color : '#4BFF00',
            opacity : '1',
            paddingRight : '12px',
        });
    }

    if($('#workout_library_scroll').length > 0){
        $('#workout_library_scroll').slimScroll({
            alwaysVisible: true,
            railVisible: true,
            height : '624px',
            color : '#4BFF00',
            opacity : '1',
            paddingRight : '12px',
        });
    }
	
	
	
	
	if($('.popupcompareleftbox').length > 0){
        $('.popupcompareleftbox').slimScroll({
            alwaysVisible: true,
            railVisible: true,
            height : '500px',
            color : '#4BFF00',
            opacity : '1',
            paddingRight : '12px',
        });
    }

    if($('.popupcomparerightbox').length > 0){
        $('.popupcomparerightbox').slimScroll({
            alwaysVisible: true,
            railVisible: true,
            height : '460px',
            color : '#4BFF00',
            opacity : '1',
            paddingRight : '12px',
        });
    }
  });

//tab
$('.tab-a').click(function(e){  
      e.preventDefault();
      $(".tab").removeClass('tab-active');
      $(".tab[data-id='"+$(this).attr('data-id')+"']").addClass("tab-active");
      $(".tab-a").removeClass('active-a');
      $(this).parent().find(".tab-a").addClass('active-a');
     });

//Multiple Select Dropdown
$(document).ready(function(){
  //Select2
  $(".multipleSelect2").select2({
		placeholder: "What's your rating" //placeholder
	});
});



//Product Carousel
var cc = $('#athletesliderworkout');
if(cc.length > 0){
    cc.owlCarousel({
        autoplay:true,
        loop:true,
        nav:true,
        dots:false,
        margin:30,
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
            },
        // breakpoint from 768 up
        992:{
                items:2,
                nav:true,
            }
    }
    });
}

//Product Carousel
var cc = $('#teamingupgroupslider');
if(cc.length > 0){
    cc.owlCarousel({
        autoplay:true,
        loop:true,
        nav:true,
        dots:false,
        margin:30,
        //animateOut: 'fadeOut',
        items: 3,
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
            },
        // breakpoint from 768 up
        992:{
                items:3,
                nav:true,
            }
    }
    });
}


//Product Carousel
var cc = $('#gamehighlightscthleteslider');
if(cc.length > 0 ){
	cc.owlCarousel({
	autoplay:true,
    loop:true,
    nav:true,
	dots:false,
	margin:30,
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
        },
    // breakpoint from 768 up
    992:{
            items:1,
            nav:true,
        }
}
});
}




//Product Carousel
var cc = $('#upcomingevents');
if(cc.length > 0 ){
  cc.owlCarousel({
  autoplay:true,
   autoplayTimeout:8000,
    loop:true,
    nav:true,
  dots:false,
  margin:30,
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
        },
    // breakpoint from 768 up
    992:{
            items:1,
            nav:true,
        }
}
});
}




//Product Carousel
var cc = $('#last_attend_event');
if(cc.length > 0 ){
  cc.owlCarousel({
  autoplay:true,
  autoplayTimeout:8000,
    loop:true,
    nav:true,
  dots:false,
  margin:30,
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
        },
    // breakpoint from 768 up
    992:{
            items:1,
            nav:true,
        }
}
});
}




//Product Carousel
var cc = $('#athlete_rvideoevidenceslider');
if(cc.length > 0 ){
	cc.owlCarousel({
	autoplay:true,
    loop:true,
    nav:true,
	dots:false,
	margin:30,
	//animateOut: 'fadeOut',
    items: 3,
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
        },
    // breakpoint from 768 up
    992:{
            items:3,
            nav:true,
        }
}
});
}


(function($) {
$.fn.menumaker = function(options) {  
 var cssmenu = $(this), settings = $.extend({
   format: "dropdown",
   sticky: false
 }, options);
 return this.each(function() {
   $(this).find(".button").on('click', function(){
     $(this).toggleClass('menu-opened');
     var mainmenu = $(this).next('ul');
     if (mainmenu.hasClass('open')) { 
       mainmenu.slideToggle().removeClass('open');
     }
     else {
       mainmenu.slideToggle().addClass('open');
       if (settings.format === "dropdown") {
         mainmenu.find('ul').show();
       }
     }
   });
   cssmenu.find('li ul').parent().addClass('has-sub');
multiTg = function() {
     cssmenu.find(".has-sub").prepend('<span class="submenu-button"></span>');
     cssmenu.find('.submenu-button').on('click', function() {
       $(this).toggleClass('submenu-opened');
       if ($(this).siblings('ul').hasClass('open')) {
         $(this).siblings('ul').removeClass('open').slideToggle();
       }
       else {
         $(this).siblings('ul').addClass('open').slideToggle();
       }
     });
   };
   if (settings.format === 'multitoggle') multiTg();
   else cssmenu.addClass('dropdown');
   if (settings.sticky === true) cssmenu.css('position', 'fixed');
resizeFix = function() {
  var mediasize = 1000;
     if ($( window ).width() > mediasize) {
       cssmenu.find('ul').show();
     }
     if ($(window).width() <= mediasize) {
       cssmenu.find('ul').hide().removeClass('open');
     }
   };
   resizeFix();
   return $(window).on('resize', resizeFix);
 });
  };
})(jQuery);

(function($){
$(document).ready(function(){
$("#cssmenu").menumaker({
   format: "multitoggle"
});
});
})(jQuery);



//Filter Tab
$(document).ready(function(){
    $('.tab-a01').click(function(e){  
      e.preventDefault();
      $(".tab01").removeClass('tab-active01');
      $(".tab01[data-id='"+$(this).attr('data-id')+"']").addClass("tab-active01");
      $(".tab-a01").removeClass('active-a01');
      $(this).parent().find(".tab-a01").addClass('active-a01');
     });
});




$('.tab-a02').click(function(e){  
    e.preventDefault();
    $(".tab02").removeClass('tab-active02');
    $(".tab02[data-id='"+$(this).attr('data-id')+"']").addClass("tab-active02");
    $(".tab-a02").removeClass('active-a02');
    $(this).parent().find(".tab-a02").addClass('active-a02');
   });

   $('.tab-a03').click(function(e){  
    e.preventDefault();
    $(".tab03").removeClass('tab-active03');
    $(".tab03[data-id='"+$(this).attr('data-id')+"']").addClass("tab-active03");
    $(".tab-a03").removeClass('active-a03');
    $(this).parent().find(".tab-a03").addClass('active-a03');
   });



$('.tab-a1').click(function(e){  
    e.preventDefault();
    $(".tab1").removeClass('tab-active1');
    $(".tab1[data-id='"+$(this).attr('data-id')+"']").addClass("tab-active1");
    $(".tab-a1").removeClass('active-a1');
    $(this).parent().find(".tab-a1").addClass('active-a1');
   });


//Product Carousel
var cc = $('#gamehighlightnew2');
if(cc.length > 0){
  cc.owlCarousel({
  autoplay:true,
    loop:false,
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
var cc = $('#last_attend_event2');
if(cc.length > 0){
  cc.owlCarousel({
  autoplay:true,
    loop:false,
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
var cc = $('#coachprofilebox_bottomslider');
if(cc.length > 0){
  cc.owlCarousel({
  autoplay:true,
    loop:false,
    nav:true,
  dots:false,
  margin:30,
  //animateOut: 'fadeOut',
    items: 3,
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
            items:3,
            nav:true,
        }
}
});
}



