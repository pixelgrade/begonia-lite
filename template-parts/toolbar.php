<?php
/**
 * The template for the lateral toolbar.
 * @package Begonia
 */ ?>
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
					<?php _e( '', 'begonia-lite' ); ?>
				</button>
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