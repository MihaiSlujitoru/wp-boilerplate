
/*****************************
Check the width of the screen
******************************/
(function(n){n.viewportSize={},n.viewportSize.getHeight=function(){return t("Height")},n.viewportSize.getWidth=function(){return t("Width")};var t=function(t){var f,o=t.toLowerCase(),e=n.document,i=e.documentElement,r,u;return n["inner"+t]===undefined?f=i["client"+t]:n["inner"+t]!=i["client"+t]?(r=e.createElement("body"),r.id="vpw-test-b",r.style.cssText="overflow:scroll",u=e.createElement("div"),u.id="vpw-test-d",u.style.cssText="position:absolute;top:-1000px",u.innerHTML="<style>@media("+o+":"+i["client"+t]+"px){body#vpw-test-b div#vpw-test-d{"+o+":7px!important}}<\/style>",r.appendChild(u),i.insertBefore(r,e.head),f=u["offset"+t]==7?i["client"+t]:n["inner"+t],i.removeChild(r)):f=n["inner"+t],f}})(this);

var w = (function() {
	windowWidth = viewportSize.getWidth();
});

$(document).ready(w);
$(window).resize(w);


/*****************************
Navigation
******************************/

 $(document).ready(function () {
	var $navState = $('.navState');
	var $nav = $('nav');
	var $dropDown = $('.page_item_has_children  ul');
	var $menuHasChildren = $('.page_item_has_children');


	$navState.on('click', function() {
		$(this).toggleClass('active');
		$nav.slideToggle(300);
		
		if (windowWidth < 768)  {
			$dropDown.slideUp(300);
		}	

		$('.page_item_has_children span.icon').removeClass('icon-active');
		$('.page_item_has_children').removeClass('active');
	});


	if (windowWidth < 768)  {
		$('.page_item_has_children  span.icon').on('click', function(event) {
			event.preventDefault();
			$(this).toggleClass('icon-active').parent().parent().toggleClass('active').children('ul.children').slideToggle(300);
		});	
	}
});

$(window).resize( function() {
	if (windowWidth < 768)  {
		$('.page_item_has_children  span.icon').on('click', function(event) {
			event.preventDefault();
			$(this).toggleClass('icon-active').parent().parent().toggleClass('active').children('ul.children').slideToggle(300);
		});	
	}	
});

/*****************************
Sidebar - Navigation
******************************/

 $(document).ready(function () {
	var $sidebarState = $('#filter');
	var $sidebarMenu = $('.sidebarMenu');
	
	$sidebarMenu.hide();

	$sidebarState.on('click', function() {
		$(this).toggleClass('sidebarActive').children('img.arrow').toggleClass('arrow-up');
		$sidebarMenu.slideToggle(300);
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















