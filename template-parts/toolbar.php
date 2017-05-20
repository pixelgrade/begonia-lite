<?php
/**
 * The template for the lateral toolbar.
 * @package Begonia
 */ ?>
			<nav id="social-navigation" class="toolbar-navigation" role="navigation">
				<h5 class="screen-reader-text"><?php _e( 'Main navigation', 'begonia-lite' ); ?></h5>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => '',
						'menu_class'     => 'nav  nav--main  nav--toolbar',
						'depth'          => - 1, //flatten if there is any hierarchy
						'fallback_cb'    => false,
					)
				); ?>
			</nav>
			<!-- #main-navigation -->