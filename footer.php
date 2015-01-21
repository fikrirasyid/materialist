<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Materialist
 */
?>

	</div><!-- #content -->

	<div id="search-form">
		<?php get_search_form(); ?>

		<a href="#" class="genericon genericon-close-alt toggle-button" data-target-id="search-form"><span class="label">Close</span></a>
	</div><!-- #search-form -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php printf( __( '%1$s by %2$s.', 'materialist' ), '<a href="http://fikrirasy.id/portfolio/materialist/">Materialist</a>', '<a href="http://fikrirasy.id" rel="designer">Fikri Rasyid</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
