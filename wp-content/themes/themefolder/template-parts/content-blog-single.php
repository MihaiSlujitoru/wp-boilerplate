<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('blog-single-posts'); ?> role='article'>
	<header class="entry-header">
		<?php 
			echo "<p class='meta-entry'><time class='entry-date' datetime='". get_the_date('F jS, Y') ."'>". get_the_date('F d, Y') ."</time>" . "</p>";		
			the_title( '<h1 class="entry-title h4">', '</h1>' );
		?>		
	</header><!-- .entry-header -->

	<?php
		if ( has_post_thumbnail() ) {
			echo "<div class='post-thumbnail'>";
			echo get_the_post_thumbnail(  get_the_ID() , 'large',  array( 'class' => 'img-responsive' ));
			echo "</div>";
		}
	?>					
	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php            
			echo "<div class='share-links' aria-label='Share Posts'>";
			echo "<ul>";
			echo "<li class='linkedin'><a href='https://www.linkedin.com/shareArticle?mini=true&url=" . get_the_permalink() . "&title=" .  get_the_title() . "&summary=" . get_the_excerpt() ."' target='_blank'><span><i class='fab fa-linkedin'></i> Share on LinkedIn</span></a></li>";
			echo "<li class='fb'><a href='https://www.facebook.com/sharer/sharer.php?u=". get_the_permalink() . "' target='_blank'><span><i class='fab fa-facebook'></i> Share on Facebook</span></a></li>";
            echo "</ul>";
            echo "</div>";
			echo "<div class='prev'>" . get_previous_post_link( '%link', '<i class=\'fas fa-chevron-left\' aria-hidden=\'true\'></i><span class=\'sr-only\'>Previous Post</span>', TRUE ) .  "</div>";
			echo "<div class='next'>" . get_next_post_link( '%link', '<i class=\'fas fa-chevron-right\' aria-hidden=\'true\'></i><span class=\'sr-only\'>Next Post</span>', TRUE) . "</div>";
		?>
	</footer>

<!-- 	<div class="comments">
		<?php
			// if ( comments_open() || get_comments_number() ) :
			// 	comments_template();
			// endif;
 		?>
	</div> -->
</article><!-- #post-## -->