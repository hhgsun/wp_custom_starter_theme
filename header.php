<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package HHGsun_Theme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php
	// CANLIDA DÜZENLEME YAPARKEN YAPIM AŞAMASINDAYIZ ETİKETİ
  $developerMode = get_option('setting_yapim_asamasinda') ? 1 : 0;
  if ( $developerMode ) {
    if(!is_user_logged_in()){
			echo '<style>body{background:#dddddd;display: flex;flex-direction: column;text-align: center;font-family:arial;} img{margin:30px;}</style>';
			the_custom_logo();
			echo '<h2>Yapım Aşamasındayız...</h2>';
			if( get_option('setting_yapim_asamasinda_url') ){
        echo '<script>window.location.replace("'. get_option('setting_yapim_asamasinda_url') .'");</script>';
      }
      exit;
    }
  } ?>

	<!-- Owl Carousel -->
	<link href="<?php echo get_template_directory_uri() . '/assets/owlcarousel/owl.carousel.min.css'; ?>" rel="stylesheet">
	<!-- Bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
	<!-- AOS -->
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

	<?php wp_head(); ?>

	<?php if( isset(get_option('setting_extracode')['head']) ){
		echo get_option('setting_extracode')['head'];
	} ?>

</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'hhgsun' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			$hhgsun_description = get_bloginfo( 'description', 'display' );
			if ( $hhgsun_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $hhgsun_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'hhgsun' ); ?></button>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
					'depth'           => 2, // 1 = no dropdowns, 2 = with dropdowns.
					'container'       => '',
					'container_class' => '',
					'container_id'    => '',
					'menu_class'      => 'navbar-nav ms-auto',
					'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback',
					'walker'         => new Bootstrap5_wp_nav_menu_walker(),
				)
			);
			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->



