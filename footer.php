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

	<div id="drawer">
		<div class="drawer-content">
			<div class="drawer-header">
				<a href="#" data-target-id="drawer" class="genericon genericon-close-alt toggle-button">
					<span class="label">Close Drawer</span>
				</a>
				<h2 class="site-name"><?php bloginfo('name' ); ?></h2>
			</div><!-- .drawer-header -->

			<div class="drawer-navigation">
				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			</div><!-- .drawer-navigation -->
			
			<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>	
			<div class="drawer-widgets">
				<?php dynamic_sidebar( 'sidebar-1' ); ?>				
			</div><!-- .drawer-widgets -->
			<?php endif; ?>
		</div><!-- .drawer-content -->

		<div class="drawer-overlay"></div>
	</div><!-- #drawer -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php printf( __( '%1$s by %2$s.', 'materialist' ), '<a href="http://fikrirasy.id/portfolio/materialist/">Materialist</a>', '<a href="http://fikrirasy.id" rel="designer">Fikri Rasyid</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
