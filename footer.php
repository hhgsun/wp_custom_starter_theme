<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package HHGsun_Theme
 */

?>

	<footer id="colophon" class="site-footer bg-dark text-light text-center text-md-start">
		<div class="container py-5">
			<div class="row row-cols-1 row-cols-md-4">
				<?php
				if ( is_active_sidebar( 'sidebar-footer' ) ) {
					dynamic_sidebar( 'sidebar-footer' );
				}
				?>
			</div><!-- .row -->

			<div class="site-info mt-5 small text-secondary">
				Powered by <a href="https://hhgsun.wordpress.com" title="Powered by Hhgsun" class="text-reset">HHGsun</a>
			</div><!-- .site-info -->
		</div><!-- .container -->
	</footer><!-- #colophon -->

</div><!-- #page -->


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<!-- Owl Carousel -->
<script src="<?php echo get_template_directory_uri() . '/assets/owlcarousel/owl.carousel.min.js'; ?>"></script>
<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
<!-- AOS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>


<?php wp_footer(); ?>

<?php if( isset(get_option('setting_extracode')['foot']) ){
	echo get_option('setting_extracode')['foot'];
} ?>

</body>
</html>
