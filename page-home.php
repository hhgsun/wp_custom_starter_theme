<?php
/**
 * Template Name: HOME
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package HHGsun_Theme
 */

get_header();
?>

	<main id="primary" class="site-main">

		<!-- SECTION HERO -->
		<div class="hero-slides owl-carousel">
			<?php
			$features_args = array(
        'post__in' => get_option( 'sticky_posts' ),
			);
			$features_query = new WP_Query( $features_args );
			if ( $features_query->have_posts() ) {
				while ( $features_query->have_posts() ) { $features_query->the_post(); ?>
					<article class="container col-xxl-8 px-4 py-2 post-<?php echo get_the_ID(); ?>">
						<div class="row flex-lg-row-reverse align-items-center g-5 py-5">
							<div class="col-10 col-sm-8 col-lg-6">
								<img src="<?php echo get_the_post_thumbnail_url(null,"large"); ?>" class="d-block mx-lg-auto img-fluid" alt="<?php the_title_attribute(); ?>" loading="lazy">
							</div><!-- .col -->
							<div class="col-lg-6">
								<h2 class="display-5 fw-bold lh-1 mb-3"><?php echo get_the_title(); ?></h2>
								<p class="lead">
									<?php echo get_the_excerpt(); ?>
								</p>
								<div class="d-grid gap-2 d-md-flex justify-content-md-start">
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="btn btn-primary btn-lg px-4 me-md-2">Devamı <i class="bi bi-arrow-right-short"></i></a>
								</div>
							</div><!-- .col -->
						</div><!-- .row -->
					</article>
				<?php 
				} 
			} wp_reset_postdata(); ?>
		</div><!-- .hero-slides -->



		<!-- SECTION FEATURES -->
		<?php if( get_option('setting_ozelbolum_cat') != -1 ) { ?>
			<div class="section-features mb-5">
				<div class="container">
					<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
						<?php
						$features_args = array(
							array( 'cat' => get_option('setting_ozelbolum_cat') )
						);
						$features_query = new WP_Query( $features_args );
						if ( $features_query->have_posts() ) {
							while ( $features_query->have_posts() ) { $features_query->the_post(); ?>
									<article class="col post-<?php echo get_the_ID(); ?>">
										<div class="card shadow-sm">
											<img class="card-img-top" src="<?php echo get_the_post_thumbnail_url(null,"medium"); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
											<div class="card-body">
												<p class="card-text"><?php echo get_the_title(); ?></p>
												<div class="d-flex justify-content-between align-items-center">
													<div class="btn-group">
														<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="btn btn-sm btn-outline-secondary">Detay</a>
													</div>
													<small class="text-muted"><?php the_date(); ?></small>
												</div>
											</div>
										</div><!-- .card -->
									</article><!-- .col -->
							<?php 
							} 
						} wp_reset_postdata(); ?>
					</div><!-- .row -->
				</div><!-- .container -->
			</div><!-- .section-features -->
		<?php } ?>

		<?php
		/* while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop. */
		?>

	</main><!-- #main -->

<?php
// get_sidebar();
get_footer();
