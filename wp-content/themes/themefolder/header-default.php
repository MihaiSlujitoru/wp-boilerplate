<header id="masthead" class="site-header" role="banner">
	<a class="site-branding" href="<?php echo get_site_url('/');?>">
		<img src="<?php echo get_stylesheet_directory_uri();?>/assets/img/logo.png" alt="">
	</a>

	<nav role="navigation">
		<button class="hamburger hamburger--slider" type="button" aria-label="Menu" aria-controls="navigation" aria-expanded="false">
			<span class="hamburger-box">
				<span class="hamburger-inner"></span>
			</span>
		</button><!--hamburger-->

	  	<div id="navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'master_menu', 'container'=> '', 'menu_id' => '') ); ?>
	  	</div><!--#navigation-->
	</nav><!--nav-->
</header>