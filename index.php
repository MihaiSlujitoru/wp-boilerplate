<?php
	get_header();
	get_header('default');
?>

	<div id="content" class="site-content">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
				<?php
				if ( have_posts() ) : while ( have_posts() ) : the_post();
					the_content();
				endwhile;
				endif; ?>
			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- #content -->

<?php get_footer() ?>