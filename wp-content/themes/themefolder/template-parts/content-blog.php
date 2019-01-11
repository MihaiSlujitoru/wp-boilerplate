<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('blog-posts'); ?> role='article'>
	<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
		<?php
			if ( has_post_thumbnail() ) {
				echo get_the_post_thumbnail(  get_the_ID() , '670-380',  array( 'class' => 'img-responsive' ));
			} else {
				echo "<img src='" . esc_url( get_template_directory_uri() ) . "/assets/img/delta-default.jpeg' class='img-responsive'/>";
			}
		?>					
	</a>	
	<header class="entry-header">
		<?php
			echo "<p class='meta-entry'><time class='entry-date published updated' datetime='". get_the_date('F jS, Y') ."'>". get_the_date('F d, Y') ."</time>" . "</p>";		
			the_title( '<h2 class="h6 entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		?>		
	</header><!-- .entry-header -->
</article><!-- #post-## -->