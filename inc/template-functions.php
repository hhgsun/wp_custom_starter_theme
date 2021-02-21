<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package HHGsun_Theme
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function hhgsun_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'hhgsun_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function hhgsun_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'hhgsun_pingback_header' );

// -- //

/**
 * CUSTOM LOGIN LOGO: hhgsun
 */
function custom_login_logo() {
	if ( function_exists('the_custom_logo') && get_theme_mod('custom_logo') ) {
		$_custom_logo = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ) , 'full' )[0];
		echo '<style type="text/css"> body.login div#login h1 a {
				background-image: url('. $_custom_logo .') !important;
				padding-bottom: 30px !important;
				background-size: contain !important;
				width: auto !important;
				height: auto !important;
				margin: 5px auto !important; }
				body { background: #2d2d2d !important; }
			</style>';
	} else {
		$_custom_logo = get_bloginfo('name');
		echo '<style type="text/css">
				body.login div#login h1 a {
					background: none;
					position: relative;
					width: 100%;
					height: auto;
					padding:10px 0;
				}
				body.login div#login h1 a::before {
					content: "'. $_custom_logo .'";
					position: absolute;
					text-indent: 0;
					background: white;
					left: 0;
					top: 0;
					text-align: center;
			    width: 100%;
					padding:10px 0;
				}
				body { background: #2d2d2d !important; }
			</style>';
	}
}
add_action( 'login_enqueue_scripts', 'custom_login_logo' );

/**
 * CUSTOM LOGIN LOGO URL: hhgsun
 */
function custom_login_url() { 
  return home_url();
}
add_filter( 'login_headerurl', 'custom_login_url' );

/**
 * REMOVE ADMIN BAR WPICON: hhgsun
 */
function admin_bar_remove_logo() {
  global $wp_admin_bar;
  $wp_admin_bar->remove_menu( 'wp-logo' );
}
add_action( 'wp_before_admin_bar_render', 'admin_bar_remove_logo' );

/**
 * CUSTOM ADMIN FOOTER TEXT: hhgsun
 */
function remove_footer_admin() {
	echo '<span id="footer-thankyou">Developed by <a href="http://hhgsun.wordpress.com" target="_blank">HHGsun</a></span>';
}
add_filter('admin_footer_text', 'remove_footer_admin');

/**
 * HIDDEN VERSION: hhgsun
 */
function complete_version_removal() {
  return '';
}
add_filter('the_generator', 'complete_version_removal');
