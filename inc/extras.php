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
			'container_max_width' => '1000' 
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
	return get_theme_mod ($key) ? get_theme_mod ($key) : octopus_get_option_defaults ()[$key] ;
}