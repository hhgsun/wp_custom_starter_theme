<?php
/**
 * HHGsun Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package HHGsun_Theme
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'hhgsun_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function hhgsun_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on HHGsun Theme, use a find and replace
		 * to change 'hhgsun' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'hhgsun', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'hhgsun' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'hhgsun_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 60,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => false,
			)
		);

	}
endif;
add_action( 'after_setup_theme', 'hhgsun_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function hhgsun_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'hhgsun_content_width', 640 );
}
add_action( 'after_setup_theme', 'hhgsun_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function hhgsun_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'hhgsun' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'hhgsun' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer', 'hhgsun' ),
			'id'            => 'sidebar-footer',
			'description'   => esc_html__( 'Add widgets here.', 'hhgsun' ),
			'before_widget' => '<section id="%1$s" class="col widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="h5 widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'hhgsun_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function hhgsun_scripts() {
	wp_enqueue_style( 'hhgsun-style', get_stylesheet_uri(), array(), _S_VERSION );

	wp_enqueue_style( 'hhgsun-block-style', get_template_directory_uri() . '/block/custom-blocks.css', array(), _S_VERSION );

	wp_style_add_data( 'hhgsun-style', 'rtl', 'replace' );

	wp_enqueue_script( 'hhgsun-navigation', get_template_directory_uri() . '/js/main.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'hhgsun_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}




/**
 * Custom files: hhgsun
 */
require get_template_directory() . '/inc/custom-dashboard.php'; // custom panel

require get_template_directory() . '/inc/custom-shortcodes.php'; // custom panel

/**
 * Custom Gutenberg: hhgsun
 */
function custom_guten_enqueue() {
	wp_enqueue_script(
		'hhgsun-block-script',
		get_template_directory_uri() . '/block/custom-blocks.js',
		array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-data', 'wp-core-data', 'wp-block-editor', 'wp-i18n', 'wp-editor' )
	);
	wp_add_inline_script(
		'hhgsun-block-script',
		'const HHGSUN_JS_GLOBAL = { theme_path: "'. get_template_directory_uri() .'" }',
		'before' // block scriptlerinden öncesine global değişkeni ekler
	);
	wp_enqueue_style( 'hhgsun-block-style', get_template_directory_uri() . '/block/custom-blocks.css', array(), _S_VERSION );
}
add_action( 'enqueue_block_editor_assets', 'custom_guten_enqueue' );


/**
 * Custom: Register Navigation Walker: hhgsun
 */
function register_navwalker(){
	if ( file_exists( get_template_directory() . '/inc/class-bootstrap5-navwalker.php' ) ) {
		require_once get_template_directory() . '/inc/class-bootstrap5-navwalker.php';
	}
}
add_action( 'after_setup_theme', 'register_navwalker' );






/**
 * 
 * DENEME:
 * 	Gutenberg custom post type
 */
/**
 * template_lock => burdaki blocklar kullanılamıyor (all hepsini kapsıyor)
 * template => burdaki blocklar sıralı şekilde gösteriliyor.
 */

add_action( 'init', function() {
	$args = array(
			'public' => true,
			'label'  => 'News',
			'show_in_rest' => true,
			'template_lock' => 'all',
			'template' => array(
					array( 'core/paragraph', array(
							'placeholder' => 'Breaking News',
					) ),
					array( 'core/image', array(
							'align' => 'right',
					) ),
			),
	);
	register_post_type( 'news', $args );
} );
