<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package _s
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>

			<?php

			$begonia_sticky_posts = count(get_option('sticky_posts'));
			$begonia_post_archive_counter = 0;
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				$begonia_post_archive_counter++;
				switch ($begonia_post_archive_counter % get_option('posts_per_page') ) {
					case '1':
						if ( ( $begonia_post_archive_counter !== 1 ) && is_home() && is_front_page() ) {
							get_template_part( 'template-parts/content', 'no_top' );
							continue;
						}
						get_template_part( 'template-parts/content', 'hero' );
						break;
					case '2':
						if ( ( $begonia_post_archive_counter !== 2 ) && is_home() && is_front_page() ) {
							get_template_part( 'template-parts/content', 'no_top' );
							continue;
						}
						echo '<div class="main-posts">';
						get_template_part( 'template-parts/content', 'no_top' );
						break;
					default:
						get_template_part( 'template-parts/content', 'no_top' );
						break;
				}
			endwhile;
			echo '</div>';
			the_posts_pagination();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_sidebar();
get_footer();
