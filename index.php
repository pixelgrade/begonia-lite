<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>

				<?php
			endif;
			$begonia_sticky_posts = count(get_option('sticky_posts'));
			$begonia_post_archive_counter = 0;
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
							break;
						}
						get_template_part( 'template-parts/content', 'hero' );
						break;
					case '2':
						if ( ( $begonia_post_archive_counter !== 2 ) && is_home() && is_front_page() ) {
							get_template_part( 'template-parts/content', 'no_top' );
							break;
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
	</div><!-- #primary -->

<?php

get_sidebar();
get_footer();
