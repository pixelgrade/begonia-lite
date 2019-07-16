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
		<a href="<?php // translators: the %s is replaced with WordPress word
		echo esc_url( __( 'https://wordpress.org/', 'begonia-lite' ) ); ?>"><?php printf( esc_html__( ' Proudly powered by %s', 'begonia-lite' ), 'WordPress' ); ?></a>
		<span class="sep"> | </span>
		<?php printf(
			'%1$s <a href="%2$s" title="%3$s" rel="nofollow">%4$s</a>.',
			esc_html__( 'Theme: Begonia Lite by', 'begonia-lite' ),
			esc_attr( 'https://pixelgrade.com/' ),
			esc_attr( 'The Pixelgrade Website' ),
			esc_html( 'Pixelgrade' )
		); ?>
	</div><!-- .site-info -->
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>


</body>
</html>
