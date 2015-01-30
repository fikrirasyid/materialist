<?php
	// Update the date in given condition
	if( isset( $GLOBALS['wp_query'] ) && is_sticky() ){
		$GLOBALS['wp_query']->has_sticky = true;
	}

	if( isset( $GLOBALS['wp_query'] ) && !is_sticky() ){	
		
		// Define month index
		if( !isset( $GLOBALS['wp_query']->hentry_month ) ){		
			$month_index = 0;
		} else {
			$month_index = $GLOBALS['wp_query']->hentry_month;
		}

		// Define timestamp
		$timestamp 	= strtotime( $post->post_date );

		// Define date, month and year
		$date 		= date_i18n( __( 'Y-m-d', 'materialist' ), $timestamp );
		$month 		= date_i18n( __( 'm', 'materialist' ), $timestamp );
		$year 		= date_i18n( __( 'Y', 'materialist' ), $timestamp );

		// Print hentry-month
		if( $month_index > 0 && $month_index != $month || isset( $GLOBALS['wp_query']->has_sticky ) && $GLOBALS['wp_query']->has_sticky ){
			echo '<h3 class="hentry-separator">'. date_i18n( __( 'F Y', 'materialist' ), $timestamp ) .'</h3>';

			// Set sticky back to false
			if( isset( $GLOBALS['wp_query']->has_sticky ) && $GLOBALS['wp_query']->has_sticky ){
				$GLOBALS['wp_query']->has_sticky = false;
			}
		}

		// Print marker
		$month_label = date_i18n( __( 'F', 'materialist' ), $timestamp );
		echo "<span style='display: none;' class='hentry-marker' data-date='$date' data-month='$month_label' data-year='$year'></span>";

		// Set globals
		$GLOBALS['wp_query']->hentry_month 	= $month;

	}