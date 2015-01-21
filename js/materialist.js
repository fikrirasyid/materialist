jQuery(document).ready(function($) { 
	/**
	* Detect touch device
	*/
	if( is_touch_device() == false ){
		$('body').addClass( 'not-touch-device' );
	}

	/**
	* Scrolling state
	*/
	$(window).scroll( function(){

		var window_offset = $(window).scrollTop();

		// Adding scroll state
		if( window_offset > 5 ){
			$('body').addClass( 'scrolling' );
		} else {
			$('body').removeClass( 'scrolling' );			
		}
	});

	/**
	* Toggle expanded UI
	*/
	$('.toggle-button').click(function(e){
		e.preventDefault();

		// Get target ID
		var target_id = $(this).attr( 'data-target-id' );

		// Display target ID
		$('#'+target_id).fadeToggle();

		// Mark body
		$('body').toggleClass( target_id + '-expanded' );
	});

});

/**
* Detect touch device
*/
function is_touch_device() {
	return 'ontouchstart' in window // works on most browsers 
		|| 'onmsgesturechange' in window; // works on ie10
};