<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Begonia
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="c-hero  c-hero--full entry-header">
		<div class="c-hero__background">

			<?php if ( has_post_thumbnail() ) :
				$thumb_id = get_post_thumbnail_id();
				$thumb_url = wp_get_attachment_image_src( $thumb_id, 'thumbnail-size', true );
				?>

				<img class="c-hero__image" src="<?php echo esc_url( $thumb_url[0] ); ?>">

			<?php else: ?>

				<img class="c-hero__image">

			<?php endif; ?>

		</div>
		<div class="c-hero__wrap">

			<?php
			if ( 'post' === get_post_type() ) : ?>

				<div class="c-hero__entry-meta">

					<?php begonia_lite_posted_on(); ?>

				</div><!-- .entry-meta -->

				<?php
			endif; ?>

			<a href="<?php the_permalink(); ?>">

				<?php the_title( '<h1 class="c-hero__entry-title">', '</h1>' ); ?>

			</a>

			<div class="c-hero__content entry-content">
				<div class="c-hero_read_more">
					<a href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read More', 'begonia-lite' ); ?></a>
				</div>
			</div><!-- .entry-content -->
		</div>
	</header><!-- .entry-header -->
</article><!-- #post-## -->
