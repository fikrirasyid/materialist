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
		$date 		= date( 'Y-m-d', $timestamp );
		$month 		= date( 'm', $timestamp );
		$year 		= date( 'Y', $timestamp );

		// Print hentry-month
		if( $month_index > 0 && $month_index != $month ){
			echo '<h3 class="hentry-separator">'. date( 'F Y', $timestamp ) .'</h3>';
		}

		// Print marker
		$month_label = date( 'F', $timestamp );
		echo "<span style='display: none;' class='hentry-marker' data-date='$date' data-month='$month_label' data-year='$year'></span>";

		// Set globals
		$GLOBALS['wp_query']->hentry_month 	= $month;

	}