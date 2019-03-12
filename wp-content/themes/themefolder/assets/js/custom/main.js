
/*****************************
	Helper Functions
******************************/
$.fn.equalHeights = function(){
    var max_height = 0;
    $(this).each(function(){
            $(this).css({'height':''});
        max_height = Math.max($(this).height(), max_height);
    });
    $(this).each(function(){
        $(this).height(max_height);
    });
};


/*****************************
Navigation
******************************/

 $(document).ready(function () {
	var $hamburger = $(".hamburger");
    var $subMenuToggle = $(".sub-menu-toggle");
	var $nav = $('nav');

	$hamburger.on("click", function(e) {
		e.preventDefault();
		$this = $(this); 
		$this.attr( 'aria-expanded', function(index, attr){
    		return attr == 'false' ? 'true' : 'false';
		});
		$this.toggleClass("is-active");
 		$this.siblings('#navigation').toggleClass('is-active').slideToggle();
 		$('body, html').toggleClass('no-scroll');
        $('.sub-menu').hide();
	});

    $subMenuToggle.on("click", function(e) {
        e.preventDefault();
        $this = $(this) 
        $this.parent().next().slideToggle();
    });

});

/*****************************
    Accordion
******************************/
$(document).ready(function() {

    $allHeader  = $('.accordion-container .accordion-header');
    $allContainers = $('.accordion-container .accordion-content').hide();

    $('.accordion-container .accordion-header').click(function(e) {
        $this = $(this);
        $target =  $this.next();

        if($this.hasClass('is-active')){
            $this.removeClass('is-active').next().slideUp(); 
        }else{
            $allContainers.slideUp();
            $allHeader.removeClass('is-active');

            $this.addClass('is-active').next().slideDown();
        }
    });
});

/*****************************
    Slick Slider
******************************/

// $('.gallery-slider').slick({
//   dots: true,
//   // arrows: true,
//   prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-chevron-left" aria-hidden="true"></i><span class="sr-only">Previous</span></button>',
//   nextArrow: '<button type="button" class="slick-next"><i class="fas fa-chevron-right" aria-hidden="true"></i><span class="sr-only">Next</span></button>',
//   infinite: true,
//   centerPadding: 20,
//   speed: 300,
//   slidesToShow: 3,
//   slidesToScroll: 3,

//   responsive: [
//     {
//       breakpoint: 992,
//       settings: {
//         slidesToShow: 2,
//         slidesToScroll: 2,
//       }
//     },
//     {
//       breakpoint: 480,
//       settings: {
//         slidesToShow: 1,
//         slidesToScroll: 1
//       }
//     }
//   ]
// });


// $('.solutions-slider').slick({
//     dots: true,
//     arrows: false,
//     infinite: true,
//     speed: 300,
//     mobileFirst: true,
//     slidesToShow: 1,
//     slidesToScroll: 1,
//     responsive: [
//         {
//             breakpoint: 992,
//             settings: 'unslick',
//         },
//         {
//             breakpoint: 480,
//             settings: {
//                 slidesToShow: 2,
//                 slidesToScroll: 2,
//         }
//         },
//     ]
// });

// $('.recent-posts-slider').slick({
//     dots: true,
//     arrows: false,
//     infinite: true,
//     speed: 300,
//     mobileFirst: true,
//     slidesToShow: 1,
//     slidesToScroll: 1,
//     responsive: [
//         {
//             breakpoint: 992,
//             settings: 'unslick',
//         },
//         {
//             breakpoint: 480,
//             settings: {
//                 slidesToShow: 2,
//                 slidesToScroll: 2,
//         }
//         },
//     ]
// });


/**
 * File skip-link-focus-fix.js.
 *
 * Helps with accessibility for keyboard only users.
 *
 * Learn more: https://git.io/vWdr2
 */
( function() {
	var isIe = /(trident|msie)/i.test( navigator.userAgent );

	if ( isIe && document.getElementById && window.addEventListener ) {
		window.addEventListener( 'hashchange', function() {
			var id = location.hash.substring( 1 ),
				element;

			if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
				return;
			}

			element = document.getElementById( id );

			if ( element ) {
				if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
					element.tabIndex = -1;
				}

				element.focus();
			}
		}, false );
	}
} )();

/*****************************
Smooth Scroll //https://css-tricks.com/snippets/jquery/smooth-scrolling/
******************************/

// Select all links with hashes
$('a[href*="#"]')
  // Remove links that don't actually link to anything
  .not('[href="#"]')
  .not('[href="#0"]')
  .click(function(event) {
    // On-page links
    if (
      location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 
      && 
      location.hostname == this.hostname
    ) {
      // Figure out element to scroll to
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      // Does a scroll target exist?
      if (target.length) {
        // Only prevent default if animation is actually gonna happen
        event.preventDefault();
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000, function() {
          // Callback after animation
          // Must change focus!
          var $target = $(target);
          $target.focus();
          if ($target.is(":focus")) { // Checking if the target was focused
            return false;
          } else {
            $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
            $target.focus(); // Set focus again
          };
        });
      }
    }
  });


