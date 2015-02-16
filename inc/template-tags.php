<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Materialist
 */

if ( ! function_exists( 'materialist_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function materialist_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'materialist' ); ?></h1>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav nav-previous">%link</div>', __( '<span class="label">Previously</span><span class="title">%title</span>', 'materialist' ) );
				next_post_link(     '<div class="nav nav-next">%link</div>',     __( '<span class="label">Read Next</span><span class="title">%title</span>', 'materialist' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if( ! function_exists( 'materialist_paging_nav_newer' ) ) :
/**
 * Display navigation to newer set of posts when applicable.
 */
function materialist_paging_nav_newer() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<?php if ( get_previous_posts_link() ) : ?>

	<nav class="navigation paging-navigation newer" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'materialist' ); ?></h1>
		<div class="nav-links">
			<div class="nav-next"><?php previous_posts_link( __( 'Newer Posts', 'materialist' ) ); ?></div>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->

	<?php endif; ?>

	<?php
}
endif; 

if ( ! function_exists( 'materialist_paging_nav_older' ) ) :
/**
 * Display navigation to older set of posts when applicable.
 */
function materialist_paging_nav_older() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<?php if ( get_next_posts_link() ) : ?>

	<nav class="navigation paging-navigation older" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'materialist' ); ?></h1>
		<div class="nav-links">
			<div class="nav-previous"><?php next_posts_link( __( 'More Posts', 'materialist' ) ); ?></div>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->

	<?php endif; ?>

	<?php
}
endif;


if ( ! function_exists( 'materialist_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function materialist_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	// Determine date format
	if( is_singular() ){
		$date_format = __( 'M jS Y', 'materialist' );
	} else {
		$date_format = __( 'M jS', 'materialist' );
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date( $date_format ) ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

	echo '<span class="posted-on">' . $posted_on . '</span>';

}
endif;

if ( ! function_exists( 'materialist_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function materialist_entry_footer() {

	edit_post_link( __( 'Edit', 'materialist' ), '<span class="edit-link">', '</span>' );
	
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( ', ', 'materialist' ) );
		if ( $categories_list && materialist_categorized_blog() ) {
			printf( '<span class="cat-links">' . __( '<span class="label">Posted in</span> %1$s', 'materialist' ) . '</span>', $categories_list );
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', __( ', ', 'materialist' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . __( '<span class="label">Tagged by</span> %1$s', 'materialist' ) . '</span>', $tags_list );
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( __( 'Leave a comment', 'materialist' ), __( '1 Comment', 'materialist' ), __( '% Comments', 'materialist' ) );
		echo '</span>';
	}
}
endif;

if ( ! function_exists( 'the_archive_title' ) ) :
/**
 * Shim for `the_archive_title()`.
 *
 * Display the archive title based on the queried object.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the title. Default empty.
 * @param string $after  Optional. Content to append to the title. Default empty.
 */
function the_archive_title( $before = '', $after = '' ) {
	if ( is_category() ) {
		$title = sprintf( __( 'Category: %s', 'materialist' ), single_cat_title( '', false ) );
	} elseif ( is_tag() ) {
		$title = sprintf( __( 'Tag: %s', 'materialist' ), single_tag_title( '', false ) );
	} elseif ( is_author() ) {
		$title = sprintf( __( 'Author: %s', 'materialist' ), '<span class="vcard">' . get_the_author() . '</span>' );
	} elseif ( is_year() ) {
		$title = sprintf( __( 'Year: %s', 'materialist' ), get_the_date( _x( 'Y', 'yearly archives date format', 'materialist' ) ) );
	} elseif ( is_month() ) {
		$title = sprintf( __( 'Month: %s', 'materialist' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'materialist' ) ) );
	} elseif ( is_day() ) {
		$title = sprintf( __( 'Day: %s', 'materialist' ), get_the_date( _x( 'F j, Y', 'daily archives date format', 'materialist' ) ) );
	} elseif ( is_tax( 'post_format' ) ) {
		if ( is_tax( 'post_format', 'post-format-aside' ) ) {
			$title = _x( 'Asides', 'post format archive title', 'materialist' );
		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			$title = _x( 'Galleries', 'post format archive title', 'materialist' );
		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			$title = _x( 'Images', 'post format archive title', 'materialist' );
		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			$title = _x( 'Videos', 'post format archive title', 'materialist' );
		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			$title = _x( 'Quotes', 'post format archive title', 'materialist' );
		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			$title = _x( 'Links', 'post format archive title', 'materialist' );
		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			$title = _x( 'Statuses', 'post format archive title', 'materialist' );
		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			$title = _x( 'Audio', 'post format archive title', 'materialist' );
		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			$title = _x( 'Chats', 'post format archive title', 'materialist' );
		}
	} elseif ( is_post_type_archive() ) {
		$title = sprintf( __( 'Archives: %s', 'materialist' ), post_type_archive_title( '', false ) );
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
		$title = sprintf( __( '%1$s: %2$s', 'materialist' ), $tax->labels->singular_name, single_term_title( '', false ) );
	} else {
		$title = __( 'Archives', 'materialist' );
	}

	/**
	 * Filter the archive title.
	 *
	 * @param string $title Archive title to be displayed.
	 */
	$title = apply_filters( 'get_the_archive_title', $title );

	if ( ! empty( $title ) ) {
		echo $before . $title . $after;
	}
}
endif;

if ( ! function_exists( 'the_archive_description' ) ) :
/**
 * Shim for `the_archive_description()`.
 *
 * Display category, tag, or term description.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function the_archive_description( $before = '', $after = '' ) {
	$description = apply_filters( 'get_the_archive_description', term_description() );

	if ( ! empty( $description ) ) {
		/**
		 * Filter the archive description.
		 *
		 * @see term_description()
		 *
		 * @param string $description Archive description to be displayed.
		 */
		echo $before . $description . $after;
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function materialist_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'materialist_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'materialist_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so materialist_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so materialist_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in materialist_categorized_blog.
 */
function materialist_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'materialist_categories' );
}
add_action( 'edit_category', 'materialist_category_transient_flusher' );
add_action( 'save_post',     'materialist_category_transient_flusher' );

/**
 * Post thumbnail
 */
if( ! function_exists( 'materialist_entry_thumbnail' ) ) :
function materialist_entry_thumbnail( $post_id = false ){

	if( ! $post_id ){
		$post_id = get_the_ID();
	}

	if( has_post_thumbnail() ){

		echo '<a href="'. esc_url( get_permalink( $post_id ) ) .'" title="'. esc_attr( get_the_title( $post_id ) ) .'" class="entry-thumbnail">';
		echo get_the_post_thumbnail( $post_id, 'medium' );
		echo '</a>';

	} 
}
endif;

/**
 * Custom callback for displaying comment
 */
if( ! function_exists( 'materialist_comment' ) ) :
function materialist_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'materialist' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'materialist' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment-body">
			<div class="comment-author vcard">
				<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
				<?php printf( __( '<cite class="fn">%s</cite>' ), get_comment_author_link() ); ?>
			</div>

			<?php if ( '0' == $comment->comment_approved ) : ?>
			<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'materialist' ) ?></em>
			<br />
			<?php endif; ?>

			<div class="comment-meta commentmetadata">
				<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
				<?php echo get_comment_date(); ?>
				</a>

				<?php edit_comment_link( __( '| Edit', 'materalist' ), '&nbsp;', '' ); ?>
			</div>

			<?php comment_text( get_comment_id(), array_merge( $args, array( 'add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>

			<div class="reply">
				<?php
					comment_reply_link( array_merge( $args, array(
						'add_below' => 'comment',
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
						'before'    => '<div class="reply">',
						'after'     => '</div>'
					) ) );
				?>
			</div><!-- .reply -->
		</div><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;