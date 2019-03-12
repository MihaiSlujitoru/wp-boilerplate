<header class="site-header" role="banner" itemscope="itemscope" itemtype="http://schema.org/WPHeader">
	<?php if( is_front_page() ) : ?>
		<h1 class="site-title" itemscope itemtype="http://schema.org/Organization">
			<img class="site-logo"
				src="<?php echo esc_url( get_template_directory_uri() . '/image/folder/path' ); ?>"
				height="40" width="140"
				itemprop="logo"
				alt="">
			<!--
				Visually hide this text.
				WCAG 2.1: “image alt text cannot be the primary text of a link"
			-->
			<span class="sr-text"><?php echo esc_attr( bloginfo( 'name' ) ); ?></span>
		</h1>
	<?php else : ?>
		<div class="site-title" itemscope itemtype="http://schema.org/Organization">
			<a href="<?php echo esc_url( home_url() ); ?>" rel="home" class="site-link" itemprop="url">
				<img class="site-logo"
					src="<?php echo esc_url( get_template_directory_uri() . '/image/folder/path' ); ?>"
					height="42" width="140"
					itemprop="logo"
					alt="">
				<!--
					Visually hide this text.
					WCAG 2.1: “image alt text cannot be the primary text of a link"
				-->
				<span class="sr-text"><?php echo esc_attr( bloginfo( 'name' ) ); ?></span>
			</a>
		</div>
	<?php endif; ?>

	<nav class="site-navigation" role="navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">

        <button class="hamburger hamburger--slider" type="button" aria-label="Open Navigation" aria-controls="navigation" aria-expanded="false">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
			<span class="sr-text"><?php esc_html_e( 'Primary Menu', 'soda' ); ?></span>            
        </button><!--hamburger-->

		<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'menu_class'     => 'primary-menu',
				'menu_id'        => 'menu-main-nav',
				'walker' => new Main_Menu_Walker()
			) );
		?>
	</nav>
</header>
