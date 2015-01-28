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

	<div id="drawer">
		<div class="drawer-content sliding-content" data-direction="left">
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

		<div class="drawer-overlay toggle-button" data-target-id="drawer"></div>
	</div><!-- #drawer -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">

			<a href="<?php echo esc_url( 'http://wordpress.org' ); ?>"><?php printf( __( 'Proudly powered by %s', 'materialist' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( __( 'Theme: %1$s', 'materialist' ), '<a href="http://fikrirasy.id/portfolio/materialist/">Materialist</a>' ); ?>

		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
