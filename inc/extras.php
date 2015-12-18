<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Octopus
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes
 *        	Classes for the body element.
 * @return array
 */
function octopus_body_classes($classes) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if (is_multi_author ()) {
		$classes [] = 'group-blog';
	}
	
	// Adds a class of hfeed to non-singular pages.
	if (! is_singular ()) {
		$classes [] = 'hfeed';
	}
	
	return $classes;
}
add_filter ( 'body_class', 'octopus_body_classes' );

/**
 * Theme default values
 *
 * @return valuable filterable By making the return valuable filterable, the Theme defaults can be easily overridden by a Child Theme or Plugin.
 */
function octopus_get_option_defaults() {
	$defaults = array (
			'logo' => '',
			'container_class' => 'container-fluid',
			'container_max_width' => '1000',
			'page_layout' => 'no-sidebar',
			'gridsystem_class' => 'col-md-',
			'left_sidebar_grid_size' => '3',
			'content_sidebar_grid_size' => '6',
			'right_sidebar_grid_size' => '3',
			
			'color_text' => '#404040',
			
			'color_link' => '#4169e1',
			'color_link_visited' => '#800080',
			'color_link_hover' => '#191970',
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
 * Get theme options value using Theme Modification API
 *
 * @param stringt $key        	
 * @return string
 */
function octopus_get_option($key) {
	return get_theme_mod ( $key ) ? get_theme_mod ( $key ) : octopus_get_option_defaults () [$key];
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
 * This will generate a line of CSS for use in header output.
 * If the setting (octopus_get_option()) has no defined value or value is equal to default (octopus_get_option_defaults()), the CSS will not be output.
 *
 * @uses get_theme_mod()
 * @param string $selector
 *        	CSS selector
 * @param string $style
 *        	The name of the CSS *property* to modify
 * @param string $mod_name
 *        	The name of the 'theme_mod' option to fetch
 * @param string $prefix
 *        	Optional. Anything that needs to be output before the CSS property
 * @param string $postfix
 *        	Optional. Anything that needs to be output after the CSS property
 * @param bool $echo
 *        	Optional. Whether to print directly to the page (default: TRUE).
 * @return string Returns a single line of CSS with selectors and a property.
 */
function octopus_generate_css($selector, $style, $mod_name, $prefix = '', $postfix = '', $echo = TRUE) {
	$return = '';
	$mod = octopus_get_option ( $mod_name );
	$default = octopus_get_option_defaults () [$mod_name];
	
	if ($mod != '' && $mod !== $default) {
		$return = sprintf ( "%s { %s:%s; }\n", $selector, $style, $prefix . $mod . $postfix );
		if ($echo) {
			echo $return;
		}
	}
	
	return $return;
}

/**
 * This will output the logo url.
 * 
 *  @return string Returns logo url.
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