<?php
/**
 * Theme default values
 *
 * @return valuable filterable By making the return valuable filterable, the Theme defaults can be easily overridden by a Child Theme or Plugin.
 */
function octopus_get_option_defaults() {
	$defaults = array (
			
			
			
			'page_layout' => 'no-sidebar',
			'gridsystem_class' => 'col-md-',
			'left_sidebar_grid_size' => '3',
			'content_sidebar_grid_size' => '6',
			'right_sidebar_grid_size' => '3',
			
			'color_text' => '#404040',
			
			'color_link' => '#4169e1',
			'color_link_visited' => '#800080',
			'color_link_hover' => '#191970',
			
			
			
			'header_position' => 'octopus-header-sticky-top',

			'header_bg_color_opacity_onscroll' => '0.8',
			
			'header_title_color' => '#ffffff',
			'header_desription_color' => '#efefef',
			'header_nav_color' => '#ffffff',
			'header_nav_decoration_hover' => '#ff851b',
			'header_nav_decoration_active' => '#ff4136',
			
			'header_banner' => '',
			'header_banner_show' => true,
			'header_banner_layout' => 'octopus-fullscreen-banner',
			'header_banner_height' => '400',
			
			'homepage_features_show' => true,
			'homepage_features_wrapped' => true,
			'homepage_features_title' => 'FEATURES',
			'homepage_features_description' => 'Features description',
			'homepage_features_bg_color' => '#ffffff',
			'homepage_features_text_color' => '#404040',
			'homepage_features_description_color' => '#777777',
			
			'homepage_highlights_show' => true,
			'homepage_highlights_wrapped' => true,
			'homepage_highlights_title' => 'HIGHLIGHTS',
			'homepage_highlights_description' => 'Highlights description',
			'homepage_highlights_bg_color' => '#ffffff',
			'homepage_highlights_text_color' => '#404040',
			'homepage_highlights_description_color' => '#777777',
			
			'homepage_portfolio_show' => true,
			'homepage_portfolio_wrapped' => true,
			'homepage_portfolio_title' => 'PORTFOLIO',
			'homepage_portfolio_description' => 'Portfolio description',
			'homepage_portfolio_bg_color' => '#ffffff',
			'homepage_portfolio_text_color' => '#404040',
			'homepage_portfolio_description_color' => '#777777',
			
			'homepage_staff_show' => true,
			'homepage_staff_wrapped' => true,
			'homepage_staff_title' => 'STAFF',
			'homepage_staff_description' => 'Who made this possible!',
			'homepage_staff_bg_color' => '#ffffff',
			'homepage_staff_text_color' => '#404040',
			'homepage_staff_description_color' => '#777777',
	);
	return apply_filters ( 'octopus_option_defaults', $defaults );
}

/**
 * Get All theme options using Theme Modification API
 *
 * @return array
 */
function octopus_get_options() {
	return wp_parse_args ( get_theme_mods (), octopus_get_option_defaults () );
}

/**
 * Return Bootstrap class to apply to the sidebar column; empty if layout is full
 *
 * @param string $sidebar        	
 * @return string Empty if no sidebar else bootstrap class
 */
function octopus_get_aside_sidebar($sidebar) {
	if (octopus_get_option ( 'page_layout' ) == 'no-sidebar') {
		return '';
	}
	
	if (octopus_get_option ( 'page_layout' ) == $sidebar || octopus_get_option ( 'page_layout' ) == 'all-sidebar') {
		if ($sidebar == 'left-sidebar') {
			return octopus_get_option ( 'gridsystem_class' ) . octopus_get_option ( 'left_sidebar_grid_size' );
		} else {
			return octopus_get_option ( 'gridsystem_class' ) . octopus_get_option ( 'right_sidebar_grid_size' );
		}
	}
}

/**
 * Return header css class from options.
 *
 * @param bool $echo
 *        	Optional. Whether to print directly to the page (default: TRUE).
 * @return string
 */
function octopus_get_header_css_class($echo = true) {
	$result = '';
	
	// if (octopus_get_option ( 'header_banner' )) {
	$result [] = octopus_get_option ( 'header_banner_layout' );
	// }
	
	$result [] = octopus_get_option ( 'header_position' );
	
	if ($echo) {
		echo implode ( ' ', $result );
	}
	
	return implode ( ' ', $result );
}

/**
 * Return Bootstrap class to apply to the content column.
 *
 * @param string $sidebar        	
 * @return string
 */
function octopus_get_primary_column_class() {
	if (octopus_get_option ( 'page_layout' ) == 'no-sidebar') {
		return octopus_get_option ( 'gridsystem_class' ) . '12';
	} else {
		return octopus_get_option ( 'gridsystem_class' ) . octopus_get_option ( 'content_sidebar_grid_size' );
	}
}



/**
 * This will output the logo url.
 *
 * @return string Returns logo url.
 */
function octopus_get_logo() {
	$logo = octopus_get_option ( 'logo' );
	
	if (isset ( $logo ) && $logo != "") {
		return $logo;
	} else {
		if (file_exists ( get_stylesheet_directory () . "/assets/images/logo.png" )) {
			return get_stylesheet_directory_uri () . "/assets/images/logo.png";
		} else {
			return get_template_directory_uri () . "/assets/images/logo.png";
		}
	}
}

// FontAwesome List
if (! function_exists ( 'get_octopus_fontawesome_list' )) :
	function get_octopus_fontawesome_list() {
		// check for file in active theme
		$fa = locate_template ( array (
				'/inc/fontawesome-icons.php',
				'/fontawesome-icons.php' 
		) );
		
		// if none found use the default file
		if ($fa == '')
			$fa = '/inc/fontawesome-icons.php';
		
		include ($fa);
		
		return $fa_icon;
	}


endif;

if (is_admin ()) {
	add_action ( 'wp_ajax_octopus_get_fontawesome', 'octopus_get_fontawesome_callback' );
	function octopus_get_fontawesome_callback() {
		// Init font awesome class
		$fa = new Smk_FontAwesome ();
		
		// Get array
		$fontawesome_css = get_template_directory () . "/assets/font-awesome/css/font-awesome.css";
		if (file_exists ( get_stylesheet_directory () . "/assets/font-awesome/css/font-awesome.css" ))
			$fontawesome_css = get_stylesheet_directory () . "/assets/font-awesome/css/font-awesome.css";
		$icons = $fa->getArray ( $fontawesome_css );
		
		$response = array (
				"results" => array (),
				"more" => true 
		);
		$search = isset ( $_GET ['search'] ) ? $_GET ['search'] : '';
		
		foreach ( $fa->readableName ( $icons ) as $key => $value ) {
			if (empty ( $search ) || stripos ( $value, $search ) !== false)
				$response ["results"] [] = array (
						"id" => $key,
						"text" => $value 
				);
		}
		wp_send_json ( $response );
	}
}

/**
 *
 * @param unknown $mod_name_hex        	
 * @param unknown $mod_name_opacity        	
 */
function octopus_hex2rgba($mod_name_hex, $mod_name_opacity) {
	$rgba = array ();
	$mod_hex = octopus_get_option ( $mod_name_hex );
	$mod_hex_default = octopus_get_option_defaults () [$mod_name_hex];
	$mod_opacity = octopus_get_option ( $mod_name_opacity );
	$mod_opacity_default = octopus_get_option_defaults () [$mod_name_opacity];
	
	if (($mod_hex !== '' && $mod_hex !== $mod_hex_default) || ($mod_opacity !== '' && $mod_opacity !== $mod_opacity_default)) {
		
		$mod_hex = str_replace ( "#", "", $mod_hex );
		
		if (strlen ( $mod_hex ) == 3) {
			$r = hexdec ( substr ( $mod_hex, 0, 1 ) . substr ( $mod_hex, 0, 1 ) );
			$g = hexdec ( substr ( $mod_hex, 1, 1 ) . substr ( $mod_hex, 1, 1 ) );
			$b = hexdec ( substr ( $mod_hex, 2, 1 ) . substr ( $mod_hex, 2, 1 ) );
		} else {
			$r = hexdec ( substr ( $mod_hex, 0, 2 ) );
			$g = hexdec ( substr ( $mod_hex, 2, 2 ) );
			$b = hexdec ( substr ( $mod_hex, 4, 2 ) );
		}
		
		$rgba = array (
				$r,
				$g,
				$b,
				$mod_opacity 
		);
	}
	return $rgba;
	// return implode(",", $rgb); // returns the rgb values separated by commas
}

// Colors schema
if (! function_exists ( 'get_octopus_colors_schema' )) :
	function get_octopus_colors_schema() {
		$colors_schema = array (
				'white' => 'White',
				'aqua' => 'Aqua',
				'blue' => 'Blue',
				'teal' => 'Teal',
				'green' => 'Green',
				'olive' => 'Olive',
				'lime' => 'Lime',
				'navy' => 'Navy',
				'yellow' => 'Yellow',
				'orange' => 'Orange',
				'red' => 'Red',
				'fuchsia' => 'Fuchsia' 
		);
		return $colors_schema;
	}

endif;

/**
 * Filter added to WP_Query to filter by title with like
 */
add_filter ( 'posts_where', 'octopus_title_like_posts_where', 10, 2 );
function octopus_title_like_posts_where($where, &$wp_query) {
	global $wpdb;
	if ($post_title_like = $wp_query->get ( 'post_title_like' )) {
		$where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql ( $wpdb->esc_like ( $post_title_like ) ) . '%\'';
	}
	return $where;
}

// Post list from ajax request only for admin
if (is_admin ()) {
	add_action ( 'wp_ajax_octopus_get_post_json', 'octopus_get_post_json' );
	function octopus_get_post_json() {
		$response = array (
				"results" => array (),
				"more" => true 
		);
		
		$posts_per_page = - 1;
		if (! isset ( $_GET ['title'] ) || $_GET ['title'] == "") {
			$posts_per_page = 100;
		}
		
		$title = $_GET ['title'];
		
		$args = array (
				'post_title_like' => $title,
				'orderby' => 'title',
				'order' => 'ASC',
				'post_status' => 'publish',
				'post_type' => 'any',
				'suppress_filters' => false,
				'posts_per_page' => $posts_per_page,
				'nopaging' => true 
		);
		if (isset ( $_GET ['type'] ) && $_GET ['type'] != "") {
			$args ["post_type"] = explode ( ",", $_GET ['type'] );
		}
		
		$query = new WP_Query ( $args );
		
		if ($query->have_posts ()) {
			while ( $query->have_posts () ) {
				$query->the_post ();
				$response ["results"] [] = array (
						"id" => get_the_ID (),
						"text" => "[" . get_post_type () . "] " . get_the_title () 
				);
			}
		}
		wp_reset_postdata ();
		wp_send_json ( $response );
	}
}

// HighLight templates
if (! function_exists ( 'get_octopus_highlight_templates' )) :
	function get_octopus_highlight_templates() {
		$result = array (
				'octopus-highlight-default.php' => 'Full page',
				'octopus-highlight-half-left-image.php' => 'Left image 50%',
				'octopus-highlight-half-right-image.php' => 'Right image 50%' 
		);
		return $result;
	}

endif;

/**
 * This function is needed because in customize if a sidebar is not present will be removed from view.
 * 
 * @param unknown $setting        	
 */
function octopus_customize_show_sidebar($setting) {
	if (octopus_get_option ( $setting )) {
		return 'octopus-display-block';
	} else {
		if (is_customize_preview ()) {
			return 'hidden';
		} else {
			return false;
		}
	}
}

if (! function_exists ( 'octopus_get_staff_contacts' )) :
	function octopus_get_staff_contacts() {
		$result = array (
				'facebook' => array (
						'label' => 'Facebook',
						'icon' => 'fa fa-facebook-square'
				),
				'twitter' => array (
						'label' => 'Twitter',
						'icon' => 'fa fa-twitter-square'
				),
				'email' => array (
						'label' => 'Email',
						'icon' => 'fa fa-paper-plane'
				),
		);
		return $result;
	}

endif;

/**
 * Implement the FontAwesome class.
 */
require get_template_directory () . '/inc/font-awesome.class.php';