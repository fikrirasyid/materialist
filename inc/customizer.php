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
		'label'    	=> __( 'Pre-Defined Color Scheme', 'materialist' ),
		'section'  	=> 'colors',
		'type'     	=> 'select',
		'choices'  	=> materialist_color_schemes(),
		'priority' 	=> 1
	) );	

	// Adding accent color control
	$wp_customize->add_setting( 'accent_color', array(
		'default'           => '#607D8B',
		'sanitize_callback' => 'sanitize_hex_color'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_color', array(
		'label'       => esc_html__( 'Accent color', 'materialist' ),
		'description' => esc_html__( 'Select one light color of your choice. Cinnamon will adjust its color scheme based on this color of choice..', 'materialist' ),
		'section'     => 'colors',
	) ) );
}
add_action( 'customize_register', 'materialist_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function materialist_customize_preview_js() {
	wp_enqueue_script( 'materialist_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20150128', true );
}
add_action( 'customize_preview_init', 'materialist_customize_preview_js' );

/**
 * Define Materialist color scheme
 */
function materialist_color_schemes(){
	return apply_filters( 'materialist_color_schemes', array(
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