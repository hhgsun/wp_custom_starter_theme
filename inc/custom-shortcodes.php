<?php


/**
* HHGSUN CUSTOM ALL SHORTCODES
*/
function hhgsun_shortcodes_init() {
  add_shortcode( 'section-features', 'shortcode_section_features' );
  add_shortcode( 'section-heros', 'shortcode_section_heros' );
}
add_action( 'init', 'hhgsun_shortcodes_init' );
/** */


function shortcode_section_features( $atts = [], $content = null ) {
  $atts = array_change_key_case( (array) $atts, CASE_LOWER );
  // override default attributes with user attributes
  $atts = shortcode_atts(array(
    'cat_id' => 1,
  ), $atts );

  ob_start(); ?>
		<div class="section-features mb-5">
      <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
          <?php
          $features_args = array(
            'cat' => $atts['cat_id']
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
  <?php
  $o = ob_get_contents();
  ob_end_clean();
  return $o;
} // end


function shortcode_section_heros( $atts = [], $content = null ) {
  $atts = array_change_key_case( (array) $atts, CASE_LOWER );
  // override default attributes with user attributes
  $atts = shortcode_atts(array(
    'cat_id' => null,
  ), $atts );

  ob_start(); ?>
		<div class="hero-slides owl-carousel">
			<?php
			$features_args = array();
      if( $atts['cat_id'] == null ) {
        $features_args['post__in'] = get_option( 'sticky_posts' );
      } else {
        $features_args['cat'] = $atts['cat_id'];
      }
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
  <?php
  $o = ob_get_contents();
  ob_end_clean();
  return $o;
} // end