/* global colorScheme, Color */
/**
 * Add a listener to the Color Scheme control to update other color controls to new values/defaults.
 * Also trigger an update of the Color Scheme CSS when a color is changed.
 */

( function( api ) {

	api.controlConstructor.select = api.Control.extend( {
		ready: function() {
			if ( 'color_scheme' === this.id ) {
				this.setting.bind( 'change', function( value ) {
					// Update Background Color.
					api( 'accent_color' ).set( value );
					api.control( 'accent_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', value )
						.wpColorPicker( 'defaultColor', value );
				} );
			}
		}
	} );

	// Update the CSS whenever a color setting is changed.
	_.each( colorSettings );

} )( wp.customize );