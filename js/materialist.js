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

});

/**
* Detect touch device
*/
function is_touch_device() {
	return 'ontouchstart' in window // works on most browsers 
		|| 'onmsgesturechange' in window; // works on ie10
};