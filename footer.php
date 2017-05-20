<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _s
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'begonia-lite' ) ); ?>"><?php printf( esc_html__( ' Proudly powered by %s', 'begonia-lite' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( esc_html__( '%1$s Theme by %2$s.', 'begonia-lite' ), 'Begonia Lite', '<a href="https://pixelgrade.com/" title="'. __( 'The PixelGrade Website', 'begonia-lite' ) .'" rel="designer">PixelGrade</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
