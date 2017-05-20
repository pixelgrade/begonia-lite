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
					$output .= '<a href="' . get_category_link( $category->term_id ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", 'begonia-lite' ), $category->name ) ) . '">' . $category->cat_name . '</a>' . $separator;
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
		$posted_on = sprintf(
			_x( '%s', 'post date', 'begonia-lite' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);
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

function begonia_lite_single_post_navigation() {
	echo '<div class="navigation_posts">';

	$prevPost = get_previous_post( true );
	if ( $prevPost ) { ?>

		<div class="nav-box previous">

		<?php $prevthumbnail = get_the_post_thumbnail( $prevPost->ID, 'begonia-navigation-thumbnails' ); ?>

		<?php previous_post_link( '%link', "$prevthumbnail  <div class='prev-title'>%title</div> <div class='prev'>Prev</div>", true ); ?>

		</div><?php }

	$nextPost = get_next_post( true );
	if ( $nextPost ) { ?>

		<div class="nav-box next">

		<?php $nextthumbnail = get_the_post_thumbnail( $nextPost->ID, 'begonia-navigation-thumbnails' ); ?>

		<?php next_post_link( '%link', "$nextthumbnail <div class='next-title'>%title</div> <div class='next'>Next</div>", true ); ?>

		</div><?php }

	echo '</div>';
}