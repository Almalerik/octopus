<?php
/**
 * Sample implementation of the Custom Header feature.
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
	</a>
	<?php endif; // End header image check. ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Octopus
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses octopus_header_style()
 */
function octopus_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'octopus_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '000000',
		'width'                  => 1000,
		'height'                 => 250,
		'flex-height'            => true,
		'wp-head-callback'       => 'octopus_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'octopus_custom_header_setup' );

if ( ! function_exists( 'octopus_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see octopus_custom_header_setup().
	 */
	function octopus_header_style() {
		$header_text_color = get_header_textcolor();
	
		// If no custom options are set, let's bail.
		if ( ! get_theme_mods() ) {
			return;
		}
	
		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css" id="octopus-custom-style">
		<?php
			/*
			 * If no custom options for text are set, let's bail.
			 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: HEADER_TEXTCOLOR.
			 */
		 	if ( ! HEADER_TEXTCOLOR === $header_text_color ) :
				// Has the text been hidden?
				if ( ! display_header_text() ) :
		?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php
				// If the user has set a custom color for the text use that.
				else :
		?>
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		<?php 	endif; ?>
		<?php endif; ?>
			<?php
			octopus_generate_css( '#page.container', 'max-width', 'container_max_width', '', '', true);
			//Header
			octopus_generate_css( '.container-fluid .octopus-wrapper', 'max-width', 'wrapped_element_max_width', '', 'px', true);
			//	Header banner
			octopus_generate_css( '.octopus-header-banner', 'height', 'header_banner_height', '', 'px', true);
			?>
			
		</style>
		<?php
	}
	
endif;

/**
 * Enqueues front-end CSS for colors schema.
 *
 * @since Octopus 1.0.0
 */
function octopus_colors_schema_css() {
	
	$css = '';
	$css .= octopus_generate_css( 'body', 'color', 'color_text', '', '', false);
	$css .= octopus_generate_css( 'a', 'color', 'color_link', '', '', false);
	$css .= octopus_generate_css( 'a:visited', 'color', 'color_link_visited', '', '', false);
	$css .= octopus_generate_css( 'a:hover, a:focus, a:active', 'color', 'color_link_hover', '', '', false);
	
	if ( count (octopus_hex2rgba ('header_bg_color', 'header_bg_color_opacity') ) > 0 ) {
		$css .= ".octopus-navbar-default { background-color: rgba(" . implode (',', octopus_hex2rgba ('header_bg_color', 'header_bg_color_opacity') ). ")}\n";
	}
	
	if ( count (octopus_hex2rgba ('header_bg_color', 'header_bg_color_opacity_onscroll') ) > 0 ) {
		$css .= ".octopus-scrolling .octopus-navbar-default { background-color: rgba(" . implode (',', octopus_hex2rgba ('header_bg_color', 'header_bg_color_opacity_onscroll') ). ")}\n";
	}
	
	$css .= octopus_generate_css( '.site-title a, .site-title a:hover, .site-title a:focus, .site-title a:active, .site-title a:visited', 'color', 'header_title_color', '', '', false);
	$css .= octopus_generate_css( '.site-description', 'color', 'header_desription_color', '', '', false);
	$css .= octopus_generate_css( '.octopus-navbar-default .navbar-nav > li > a,
								   .octopus-navbar-default .navbar-nav > li > a:hover,
								   .octopus-navbar-default .navbar-nav > li > a:focus,
								   .octopus-navbar-default .navbar-nav > .active > a,
								   .octopus-navbar-default .navbar-nav > .active > a:hover,
								   .octopus-navbar-default .navbar-nav > .active > a:focus', 'color', 'header_nav_color', '', '', false);
	$css .= octopus_generate_css( '.octopus-navbar-default .navbar-toggle .icon-bar', 'background-color', 'header_nav_color', '', '', false);
	
	$css .= octopus_generate_css( '.octopus-navbar-default .navbar-nav > li > a:hover, .octopus-navbar-default .navbar-nav > li > a:focus', 'border-color', 'header_nav_decoration_hover', '', '', false);
	$css .= octopus_generate_css( '.octopus-navbar-default .navbar-nav > .active > a, .octopus-navbar-default .navbar-nav > .active > a:hover, .octopus-navbar-default .navbar-nav > .active > a:focus', 'border-color', 'header_nav_decoration_active', '', '', false);
	
	//Homepage Features
	$css .= octopus_generate_css( '.octopus-features-sidebar', 'background-color', 'homepage_features_bg_color', '', '', false);
	$css .= octopus_generate_css( '.octopus-features-sidebar .widget-title', 'color', 'homepage_features_text_color', '', '', false);
	$css .= octopus_generate_css( '.octopus-features-sidebar .widget-description', 'color', 'homepage_features_description_color', '', '', false);
	
	
	
	if ($css) {
		echo '<style type="text/css" id="octopus-color-schema-css" />' . "\n";
		echo $css;
		echo '</style>' . "\n";
	}
}
add_action('wp_head', 'octopus_colors_schema_css', 100);
