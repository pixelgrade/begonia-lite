<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package _s
 */

if ( ! function_exists( 'begonia_lite_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function begonia_lite_posted_on() { ?>
	<div class="hero_categories">
			<?php
			//Display the categories of the post
			$categories = get_the_category();
			$separator  = ' ';
			$output     = '';
			if ( $categories ) {
				foreach ( $categories as $category ) {
					// translators: the %s is replaced with the category name
					$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", 'begonia-lite' ), esc_html( $category->name ) ) ) . '">' . esc_html( $category->cat_name ) . '</a>' . $separator;
				}
				echo trim( $output, $separator );
			} ?>
	</div>

	<?php echo '<span class="separator">  </span>'; ?>

		<?php
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" hidden datetime="%3$s">%4$s</time>';
		}
		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);
		$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>' ;
		echo '<span class="posted-on">' . $posted_on . '</span>';
}
endif;

if ( ! function_exists( 'begonia_lite_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function begonia_lite_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ' ', 'begonia-lite' ) );
		if ( $tags_list ) {
			// translators: the %1$s is replaced with the tags list
			printf( '<span class="tags-links">' . esc_html__( 'Tags: %1$s', 'begonia-lite' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		/* translators: %s: post title */
		comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'begonia-lite' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'begonia-lite' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

if ( ! function_exists( 'begonia_lite_single_post_navigation' ) ) :

function begonia_lite_single_post_navigation() {
	echo '<div class="navigation_posts">';

	$nextPost = get_next_post( true );
	if ( $nextPost ) { ?>

		<div class="nav-box next">

		<?php next_post_link( '%link', "<div class='next'>Next</div><div class='next-title'>%title</div>", true ); ?>

		</div><?php }

	echo '</div>';
}
endif;

if ( ! function_exists( 'begonia_get_post_thumbnail_aspect_ratio_class' ) ) :

	/**
	 * Get the aspect ratio of the featured image
	 *
	 * @param int|WP_Post $post_id Optional. Post ID or post object.
	 * @return string Aspect ratio specific class.
	 */
	function begonia_get_post_thumbnail_aspect_ratio_class( $post_id = null ) {

		$post = get_post( $post_id );

		$class = '';

		if ( empty( $post ) ) {
			return $class;
		}

		// [tall|portrait|square|landscape|wide] class depending on the aspect ratio
		// 16:9 = 1.78
		// 3:2 = 1.500
		// 4:3 = 1.34
		// 1:1 = 1.000
		// 3:4 = 0.750
		// 2:3 = 0.67
		// 9:16 = 0.5625

		//$image_data["width"] is width
		//$image_data["height"] is height
		//get directly the raw metadata
		$image_data = wp_get_attachment_metadata( get_post_thumbnail_id( $post->ID ) );

		if ( ! empty( $image_data["width"] ) && ! empty( $image_data["height"] ) ) {
			$image_aspect_ratio = $image_data["width"] / $image_data["height"];

			//now let's begin to see what kind of featured image we have
			//first TALL ones; lower than 9:16
			if ( $image_aspect_ratio < 0.5625 ) {
				$class = 'tall';
			} elseif ( $image_aspect_ratio < 0.75 ) {
				//now PORTRAIT ones; lower than 3:4
				$class = 'portrait';
			} elseif ( $image_aspect_ratio > 1.78 ) {
				//now WIDE ones; higher than 16:9
				$class = 'wide';
			} elseif ( $image_aspect_ratio > 1.34 ) {
				//now LANDSCAPE ones; higher than 4:3
				$class = 'landscape';
			} else {
				//it's definitely a SQUARE-ish one; between 3:4 and 4:3
				$class = 'square';
			}
		}

		return $class;
	} #function

endif;