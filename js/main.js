/*****************************
Navigation
******************************/

 $(document).ready(function () {
	var $navState = $('.navState');
	var $nav = $('nav');
	var $dropDown = $('.page_item_has_children  ul');
	var $menuHasChildren = $('.page_item_has_children');


	$navState.on('click', function(e) {
		e.preventDefault();
		//Do the magic
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
Smooth Scroll //https://css-tricks.com/snippets/jquery/smooth-scrolling/
******************************/

$(function() {
	$('a[href*="#"]:not([href="#"])').click(function() {
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			if (target.length) {
				$('html, body').animate({
				scrollTop: target.offset().top - 50
			}, 1000);
				return false;
			}
		}
	});
});


