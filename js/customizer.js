/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a, .site-title-nav a, .drawer-header .site-name' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Accent color.
	wp.customize( 'accent_color', function( value ) {
		value.bind( function( to ) {

			// Updating the color scheme
			var accent_color = to.substr( 1 );

			$.getJSON( materialist_customizer_params.generate_color_scheme_endpoint, { accent_color : accent_color, header_image : materialist_customizer_params.current_header_image }, function( data ){
				if( true == data.status ){
					$('body').append( '<style type="text/css" media="screen">'+data.colorscheme+'</style>');
				} else {
					alert( materialist_customizer_params.generate_color_scheme_error_message );
				}
			});
		} );
	} );

	// Header Image.
	wp.customize( 'header_image', function( value ) {
		value.bind( function( to ) {

			$.getJSON( materialist_customizer_params.generate_color_scheme_endpoint, { accent_color : materialist_customizer_params.current_color_scheme, header_image : to }, function( data ){
				if( true == data.status ){
					$('body').append( '<style type="text/css" media="screen">'+data.colorscheme+'</style>');
				} else {
					alert( materialist_customizer_params.generate_header_scheme_error_message);
				}
			});
		} );
	} );

	// Clear temporary settings if customizer is closed
	window.addEventListener("beforeunload", function (e) {
		$.post( materialist_customizer_params.clear_customizer_settings );
	});
} )( jQuery );
