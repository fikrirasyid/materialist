<?php
/**
 * Materialist Theme Customizer
 *
 * @package Materialist
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function materialist_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	// Adding color scheme control
	$wp_customize->add_setting( 'color_scheme', array(
		'default'           => '#607D8B',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'color_scheme', array(
		'label'    		=> __( 'Pre-Defined Color Scheme', 'materialist' ),
		'description' 	=> __( 'Select pre-defined tested color schemes.', 'materialist' ),
		'section'  		=> 'colors',
		'type'     		=> 'select',
		'choices'  		=> materialist_color_schemes_choices(),
		'priority' 		=> 1
	) );	

	// Adding accent color control
	$wp_customize->add_setting( 'accent_color', array(
		'default'           => '#607D8B',
		'sanitize_callback' => 'sanitize_hex_color',
			'transport'			=> 'postMessage'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_color', array(
		'label'       => esc_html__( 'Accent color', 'materialist' ),
		'description' => esc_html__( 'Select one light color of your choice. Materialist will adjust its color scheme based on this color of choice..', 'materialist' ),
		'section'     => 'colors',
	) ) );
}
add_action( 'customize_register', 'materialist_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function materialist_customize_preview_js( $wp_customize ) {
	wp_enqueue_script( 'materialist_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20150129', true );

	// Default params
	$materialist_customizer_params = array(
		'generate_color_scheme_endpoint' 		=> esc_url( admin_url( 'admin-ajax.php?action=materialist_generate_customizer_color_scheme' ) ),
		'generate_color_scheme_error_message' 	=> __( 'Error generating color scheme. Please try again.', 'materialist' ),
		'clear_customizer_settings'				=> esc_url( admin_url( 'admin-ajax.php?action=materialist_clear_customizer_settings' ) )		
	);

	// Adding proper error message when customizer fails to generate color scheme in live preview mode (theme hasn’t been activated). 
	// The color scheme is generated using wp_ajax and wp_ajax cannot be registered if the theme hasn’t been activated.
	if( ! $wp_customize->is_theme_active() ){
		$materialist_customizer_params['generate_color_scheme_error_message'] = __( 'Color scheme cannot be generated. Please activate Materialist theme first.', 'materialist' );
	}

	// Attaching variables
	wp_localize_script( 'materialist_customizer', 'materialist_customizer_params', apply_filters( 'materialist_customizer_params', $materialist_customizer_params ) );

	// Display color scheme previewer
	$color_scheme = get_theme_mod( 'color_scheme_customizer', false );

	if( $color_scheme ){
		remove_action( 'wp_enqueue_scripts', 'materialist_color_scheme' );

		/**
		 * Reload default style, wp_add_inline_style fail when the handle doesn't exist 
		 */
		wp_enqueue_style( 'materialist-style', get_stylesheet_uri() );
		$inline_style = wp_add_inline_style( 'materialist-style', $color_scheme );
	}		
}
add_action( 'customize_preview_init', 'materialist_customize_preview_js' );

/**
 * Define Materialist color scheme
 */
function materialist_color_schemes_choices(){
	return apply_filters( 'materialist_color_schemes_choices', array(
		'#F44336' 	=> __( 'Red', 'materialist' ),
		'#E91E63' 	=> __( 'Pink', 'materialist' ),
		'#9C27B0' 	=> __( 'Purple', 'materialist' ),
		'#673AB7' 	=> __( 'Deep Purple', 'materialist' ),
		'#3F51B5' 	=> __( 'Indigo', 'materialist' ),
		'#2196F3' 	=> __( 'Blue', 'materialist' ),
		'#03A9F4' 	=> __( 'Light Blue', 'materialist' ),
		'#00BCD4' 	=> __( 'Cyan', 'materialist' ),
		'#009688' 	=> __( 'Teal', 'materialist' ),
		'#4CAF50' 	=> __( 'Green', 'materialist' ),
		'#8BC34A' 	=> __( 'Light Green', 'materialist' ),
		'#CDDC39' 	=> __( 'Lime', 'materialist' ),
		'#FFEB3B' 	=> __( 'Yellow', 'materialist' ),
		'#FFC107' 	=> __( 'Amber', 'materialist' ),
		'#FF9800' 	=> __( 'Orange', 'materialist' ),
		'#FF5722' 	=> __( 'Deep Orange', 'materialist' ),
		'#795548' 	=> __( 'Brown', 'materialist' ),
		'#9E9E9E' 	=> __( 'Grey', 'materialist' ),
		'#607D8B' 	=> __( 'Blue Grey', 'materialist' ),
	));
}

/**
 * Binds JS listener to make Customizer color_scheme control.
 */
function materialist_customize_control_js() {
	wp_enqueue_script( 'color-scheme-control', get_template_directory_uri() . '/js/color-scheme-control.js', array( 'customize-controls', 'iris', 'underscore', 'wp-util' ), '20141216', true );
}
add_action( 'customize_controls_enqueue_scripts', 'materialist_customize_control_js' );


/**
 * WordPress' native sanitize_hex_color seems to be hasn't been loaded
 * Provide theme's customizer with its own hex color sanitation
 */
if( ! function_exists( 'materialist_sanitize_hex_color' ) ) :
function materialist_sanitize_hex_color( $color ){
	if ( '' === $color )
		return '';

	// 3 or 6 hex digits, or the empty string.
	if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
		return $color;

	return null;
}
endif;

if ( ! function_exists( 'materialist_sanitize_hex_color_no_hash' ) ) :
function materialist_sanitize_hex_color_no_hash( $color ){
	$color = ltrim( $color, '#' );

	if ( '' === $color )
		return '';

	return materialist_sanitize_hex_color( '#' . $color ) ? $color : null;	
}
endif;

/**
 * Generate color scheme based on color accent given
 * 
 * @uses Materialist_Simple_Color_Adjuster
 */
if( ! function_exists( 'materialist_generate_color_scheme_css' ) ) :
function materialist_generate_color_scheme_css( $color__accent ){

	// Verify color accent
	if( ! materialist_sanitize_hex_color( $color__accent ) ){
		return false;
	}

	$color = new Materialist_Simple_Color_Adjuster;
	$color__accent_darker = $color->darken( $color__accent, 13 );
	$css = "
		/* _links.scss */
		a,
		a:visited,
		a:hover,
		a:focus,
		a:active {
			color: {$color__accent};
		}

		/* _buttons.scss */
		button,
		input[type='button'],
		input[type='reset'],
		input[type='submit']{
			background: {$color__accent};
			box-shadow: 0 2px 2px " . $color->darken( $color__accent, 20 ) . ";
		}

		button:hover,
		input[type='button']:hover,
		input[type='reset']:hover,
		input[type='submit']:hover{
			background-color: " . $color->lighten( $color__accent, 3 ) . ";
		}

		button:active,
		input[type='button']:active,
		input[type='reset']:active,
		input[type='submit']:active{
			background-color: " . $color->darken( $color__accent, 3 ) . ";
		}

		button:focus,
		input[type='button']:focus,
		input[type='reset']:focus,
		input[type='submit']:focus{
			background-color: " . $color->darken( $color__accent, 10 ) . ";
			box-shadow: 0 2px 2px " . $color->darken( $color__accent, 30 ) . ";	
		}

		button:focus:hover,
		input[type='button']:focus:hover,
		input[type='reset']:focus:hover,
		input[type='submit']:focus:hover{
			background-color: " . $color->lighten( $color__accent, 6 ) . ";	
		}

		button:focus:active,
		input[type='button']:focus:active,
		input[type='reset']:focus:active,
		input[type='submit']:focus:active{
			background-color: " . $color->darken( $color__accent, 6 ) . ";
		}

		/* _fields.scss */
		input[type='text']:focus,
		input[type='email']:focus,
		input[type='url']:focus,
		input[type='password']:focus,
		input[type='search']:focus,
		textarea:focus {
			border-color: {$color__accent};		
			box-shadow: inset 0 -1px 0 {$color__accent};
		}

		/* _menus.scss */
		body.scrolling #top-navigation{
			background: {$color__accent_darker};	
		}

		/* _header.scss */
		#masthead{
			background: {$color__accent};
		}

		/* _comments.scss */
		.comments-title{
			color: {$color__accent};
		}

		#reply-title{
			color: {$color__accent};
		}

		/* _posts-and-pages.scss */
		.page-header .page-title{
			color: {$color__accent};
		}

		.hentry-separator{
			color: {$color__accent};
		}

		.hentry.has-post-thumbnail .edit-link a{
			background: {$color__accent};
		}

		.hentry.sticky:after{
			color: {$color__accent_darker};	
		}


		.entry-title a:hover{
			color: " . $color->lighten( $color__accent, 10 ) . ";
		}

		.error404 .entry-title,
		.page .entry-title,
		.single .entry-title{
			color: {$color__accent};	
		}

		.page-links a .page-link{
			color: {$color__accent};	
		}

		/* _widgets.scss */
		.drawer-content .drawer-header{
			color: {$color__accent_darker};	
		}

		.widget .widgettitle,
		.widget .widget-title{
			color: {$color__accent_darker};	
		}

		/* _copy.scss */
		.entry-content h1,
		.entry-content h2,
		.entry-content h3,
		.entry-content h4,
		.entry-content b,
		.entry-content strong,
		.entry-content address,
		.entry-content code,
		.entry-content kbd,
		.entry-content tt,
		.entry-content var,

		.comment-body h1,
		.comment-body h2,
		.comment-body h3,
		.comment-body h4,
		.comment-body b,
		.comment-body strong,
		.comment-body address,
		.comment-body code,
		.comment-body kbd,
		.comment-body tt,
		.comment-body var,{
			color: {$color__accent_darker};	
		}
	";

	return $css;
}
endif;

/**
 * AJAX endpoint for generating color scheme in near real time for customizer
 */
if( ! function_exists( 'materialist_generate_customizer_color_scheme' ) ) :
function materialist_generate_customizer_color_scheme(){

	if( current_user_can( 'customize' ) && isset( $_GET['accent_color'] ) && materialist_sanitize_hex_color_no_hash( $_GET['accent_color'] ) ){

		// Get accent color
		$accent_color = materialist_sanitize_hex_color_no_hash( $_GET['accent_color'] );

		if( $accent_color ){

			$accent_color = '#' . $accent_color;

			// Generate color scheme css
			$css = materialist_generate_color_scheme_css( $accent_color );

			// Set Color Scheme
			set_theme_mod( 'color_scheme_customizer', $css );

			$generate = array( 'status' => true, 'colorscheme' => $css );

		} else {

			$generate = array( 'status' => false, 'colorscheme' => false );

		}
	} else {

		$generate = array( 'status' => false, 'colorscheme' => false );

	}

	// Transmit message
	echo json_encode( $generate ); 

	die();
}
endif;
add_action( 'wp_ajax_materialist_generate_customizer_color_scheme', 'materialist_generate_customizer_color_scheme' );

/**
 * Generate color scheme based on one accent color choosen by user
 */
if ( ! function_exists( 'materialist_generate_color_scheme' ) ) :
function materialist_generate_color_scheme(){

	$accent_color = get_theme_mod( 'accent_color', false );

	if( $accent_color ){

		// SCSS template
		$css = materialist_generate_color_scheme_css( $accent_color );

		// Bail if color scheme doesn't generate valid CSS
		if( ! $css ){
			return;
		}

		// Set Color Scheme
		set_theme_mod( 'color_scheme', $css );

		// Remove Customizer Color Scheme
		remove_theme_mod( 'color_scheme_customizer' );
	}

}
endif;
add_action( 'customize_save_after', 'materialist_generate_color_scheme' );

/**
 * Endpoint for clearing all customizer temporary settings
 * This is made to be triggered via JS call (upon tab is closed)
 * 
 * @return void
 */
if( ! function_exists( 'materialist_clear_customizer_settings' ) ) :
function materialist_clear_customizer_settings(){
	if( current_user_can( 'customize' ) ){
		remove_theme_mod( 'color_scheme_customizer' );		
	}

	die();
}
endif;
add_action( 'wp_ajax_materialist_clear_customizer_settings', 'materialist_clear_customizer_settings' );