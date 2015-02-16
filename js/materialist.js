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
		var target_id 		= $(this).attr( 'data-target-id' );
		var sliding_content = $('#'+target_id).find('.sliding-content');
		var direction		= sliding_content.attr( 'data-direction' );

		// Display target ID
		if( $('#'+target_id).is(':visible') ){
			$('#'+target_id).fadeOut();

			if( 'left' == direction ){
				if( $('body').is( '.rtl' ) ){
					sliding_content.animate({ 'right' : '-100%' } );
				} else {
					sliding_content.animate({ 'left' : '-100%' } );
				}
			}
		} else {
			$('#'+target_id).fadeIn();

			if( 'left' == direction ){
				if( $('body').is( '.rtl' ) ){
					sliding_content.animate({ 'right' : '0' } );
				} else {
					sliding_content.animate({ 'left' : '0' } );
				}
			}
		}

		// Mark body
		$('body').toggleClass( target_id + '-expanded' );
	});

	/**
	* Civil Footnotes Support
	* Slide the window instead of jumping it
	*/
	$('#main').on( 'click', 'a[rel="footnote"], a.backlink', function(e){
		e.preventDefault();
		var target_id = $(this).attr('href');
		var respond_offset = $(target_id).offset();

		$('html, body').animate({
			scrollTop : respond_offset.top - 100
		});
	});	
});

/**
* Detect touch device
*/
function is_touch_device() {
	return 'ontouchstart' in window // works on most browsers 
		|| 'onmsgesturechange' in window; // works on ie10
};