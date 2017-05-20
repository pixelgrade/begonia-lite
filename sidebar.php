<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _s
 */

if ( ! is_active_sidebar( 'footer-sidebar' ) ) {
	return;
}
?>

<div class="widgets-area"> <!-- widgets-area -->
	<?php
	if ( is_active_sidebar( 'footer-sidebar' ) ) : ?>

		<div id="footer-sidebar" class="footer-area widget-area" role="complementary">
			<?php dynamic_sidebar( 'footer-sidebar' ); ?>
		</div><!-- #footer-sidebar -->

	<?php endif; ?>
</div>
