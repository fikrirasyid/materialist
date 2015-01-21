<?php
/**
 * @package Materialist
 */
?>

<?php 
	// hentry separator
	get_template_part( 'content', 'hentry-separator' ); 
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-date">
		<?php materialist_posted_on(); ?>		
	</div>

	<header class="entry-header">
		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

	<?php materialist_entry_thumbnail(); ?>
</article><!-- #post-## -->