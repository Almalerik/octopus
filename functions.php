<?php
/**
 * Octopus functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Octopus
 */
$octopus_version = '1.0.0';

if (! function_exists ( 'octopus_setup' )) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function octopus_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Octopus, use a find and replace
		 * to change 'octopus' to the name of your theme in all the template files.
		 */
		load_theme_textdomain ( 'octopus', get_template_directory () . '/languages' );
		
		// Add default posts and comments RSS feed links to head.
		add_theme_support ( 'automatic-feed-links' );
		
		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support ( 'title-tag' );
		
		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support ( 'post-thumbnails' );
		
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus ( array (
				'primary' => esc_html__ ( 'Primary', 'octopus' ) 
		) );
		
		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support ( 'html5', array (
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption' 
		) );
		
		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support ( 'post-formats', array (
				'aside',
				'image',
				'video',
				'quote',
				'link' 
		) );
		
		// Set up the WordPress core custom background feature.
		add_theme_support ( 'custom-background', apply_filters ( 'octopus_custom_background_args', array (
				'default-color' => 'ffffff',
				'default-image' => '' 
		) ) );
	}

endif;
add_action ( 'after_setup_theme', 'octopus_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function octopus_content_width() {
	$GLOBALS ['content_width'] = apply_filters ( 'octopus_content_width', 640 );
}
add_action ( 'after_setup_theme', 'octopus_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function octopus_widgets_init() {
	register_sidebar ( array (
			'name' => esc_html__ ( 'Sidebar left', 'octopus' ),
			'id' => 'sidebar-left',
			'description' => '',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>'
	) );
	register_sidebar ( array (
			'name' => esc_html__ ( 'Sidebar right', 'octopus' ),
			'id' => 'sidebar-right',
			'description' => '',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>'
	) );
	register_sidebar ( array (
			'name' => esc_html__ ( 'Homepage features', 'octopus' ),
			'id' => 'homepage-features',
			'description' => esc_html__ ( 'From the widgets list, select "Loungeact Feature".', 'octopus' ),
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
	) );
	register_sidebar ( array (
			'name' => esc_html__ ( 'Homepage highlights', 'octopus' ),
			'id' => 'homepage-highlights',
			'description' => esc_html__ ( 'From the widgets list, select "Loungeact Highlights".', 'octopus' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
	) );
}
add_action ( 'widgets_init', 'octopus_widgets_init' );

/**
 * Enqueue public scripts and styles.
 */
if (! function_exists ( 'octopus_public_scripts' )) {

	function octopus_public_scripts() {
		
		// FontAwesome
		wp_enqueue_style ( 'octopus-fontawesome', get_template_directory_uri () . '/assets/font-awesome/4.4.0/css/font-awesome.min.css' );
		
		// Bootstrap
		wp_enqueue_style ( 'octopus-bootstrap-style', get_template_directory_uri () . '/assets/bootstrap/3.3.6/css/bootstrap.css' );
		wp_enqueue_script ( 'octopus-bootstrap-script', get_template_directory_uri () . '/assets/bootstrap/3.3.6/js/bootstrap.min.js', array (
				'jquery'
		), '3.3.6', true );
		
		// Sticky-kit
		wp_enqueue_script ( 'octopus-stickykit-script', get_template_directory_uri () . '/assets/sticky-kit/1.1.2/jquery.sticky-kit.min.js', array (
				'jquery'
		), '1.1.2', true );
		
		// Swiper
		wp_enqueue_style ( 'octopus-swiper-style', get_template_directory_uri () . '/assets/swiper/css/swiper.css' );
		wp_enqueue_script ( 'octopus-swiper-script', get_template_directory_uri () . '/assets/swiper/js/swiper.jquery.js', array (
				'jquery'
		), '3.3.5', true );
		
		wp_enqueue_style ( 'octopus-style', get_stylesheet_uri () );
		
		wp_enqueue_script ( 'octopus-navigation', get_template_directory_uri () . '/js/navigation.js', array (), '20120206', true );
		
		wp_enqueue_script ( 'octopus-skip-link-focus-fix', get_template_directory_uri () . '/js/skip-link-focus-fix.js', array (), '20130115', true );
		
		if (is_singular () && comments_open () && get_option ( 'thread_comments' )) {
			wp_enqueue_script ( 'comment-reply' );
		}
	}
	
}
add_action ( 'wp_enqueue_scripts', 'octopus_public_scripts' );

/**
 * Enqueue admin scripts and styles.
 */
if (! function_exists ( 'octopus_admin_scripts' )) {
	function octopus_admin_scripts($hook) {
		
		// FontAwesome
		wp_enqueue_style ( 'octopus-admin-fontawesome', get_template_directory_uri () . '/assets/font-awesome/4.4.0/css/font-awesome.min.css', array (
				'octopus-admin-style'
		) );
		
		// Select2
		wp_enqueue_style ( 'octopus-select2-style', get_template_directory_uri () . '/assets/admin/select2/css/select2.min.css', array (
				'octopus-admin-style'
		) );
		wp_enqueue_script ( 'octopus-select2-script', get_template_directory_uri () . '/assets/admin/select2/js/select2.full.min.js', array (
				'jquery'
		), true );
		
	}
}
add_action ( 'admin_enqueue_scripts', 'octopus_admin_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory () . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory () . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory () . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory () . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory () . '/inc/jetpack.php';