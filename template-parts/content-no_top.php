<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Begonia
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class($class='c-card'); ?>>
    <header class="entry-header">
		<?php if ( has_post_thumbnail() ) : ?>
            <div class="entry-thumbnail">
	            <a class="article__image  article__link" href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail(); ?>
	            </a><!-- .article__image -->
            </div>
		<?php endif;
		if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php begonia_lite_posted_on(); ?>
			</div><!-- .entry-meta -->
			<?php
		endif;
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;
		 ?>
    </header><!-- .entry-header -->

    <div class="entry-content">
		<?php
		global $post;
		// Check the content for the more text
		$has_more = strpos( $post->post_content, '<!--more' );
		if ( $has_more ) {
			the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'begonia-lite' ) );
		} else {
			the_excerpt(); ?>
            <div class="hero_read_more">
                <a href="<?php the_permalink(); ?>"><?php _e( 'Read More', 'begonia-lite' ); ?><div class="read-more--arrow"></div></a>
            </div>
			<?php
		}
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'begonia-lite' ),
			'after'  => '</div>',
		) ); ?>
    </div><!-- .entry-content -->

</article><!-- #post-## -->
