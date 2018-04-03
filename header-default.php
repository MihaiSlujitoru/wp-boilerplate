<header id="masthead" class="site-header" role="banner">
	<div class="lower-menu">
		<a class="site-branding" href="<?php echo get_site_url('/');?>"></a>

		<div class="menu-toggle">
			<div class="bar bar-1"></div>
			<div class="bar bar-2"></div>
			<div class="bar bar-3"></div>
		</div>

		<nav id="site-navigation-desktop" class="desktop-nav" role="navigation">
				<?php wp_nav_menu( array( 'theme_location' => 'personal_menu', 'container'=> '', 'menu_id' => 'personal-menu'  ) ); ?>
		</nav>
    </div><!--lower-menu-->
</header>