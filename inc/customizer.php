<?php
/**
 * Octopus Theme Customizer.
 *
 * @package Octopus
 */
require_once 'wordpress-theme-customizer-custom-controls/text/fixed-text-custom-control.php';

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize
 *        	Theme Customizer object.
 */
function octopus_customize_register($wp_customize) {
	$wp_customize->get_setting ( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting ( 'blogdescription' )->transport = 'postMessage';
	$wp_customize->get_setting ( 'header_textcolor' )->transport = 'postMessage';
	
	/*
	 * ============== SITE IDENTITY ==============
	 */
	$wp_customize->add_setting ( 'logo', array (
			'default' => octopus_get_option ( "logo" ),
	) );
	$wp_customize->add_control ( new WP_Customize_Image_Control ( $wp_customize, 'logo', array (
			'label' => esc_html__ ( 'Logo', 'octopus' ),
			'section' => 'title_tagline',
			'settings' => 'logo',
			'priority' => 1
	) ) );
	
	/*
	 * ============== LAYOUT ==============
	 */
	$wp_customize->add_section ( 'octopus_layout', array (
			'title' => esc_html__ ( 'Layout', 'octopus' ),
			'priority' => 10 
	) );
	// Container_class
	$wp_customize->add_setting ( 'container_class', array (
			'default' => octopus_get_option ( 'container_class' ),
			'transport' => 'postMessage',
			'sanitize_callback' => 'octopus_sanitize_container' 
	) );
	$wp_customize->add_control ( 'octopus_container_class', array (
			'label' => esc_html__ ( 'Container', 'octopus' ),
			'section' => 'octopus_layout',
			'settings' => 'container_class',
			'type' => 'select',
			'choices' => array (
					'container-fluid' => esc_html__ ( 'Fluid', 'octopus' ),
					'container' => esc_html__ ( 'Fixed', 'octopus' ) 
			),
			'priority' => 10 
	) );
	// Fixed container max width
	$wp_customize->add_setting ( 'container_max_width', array (
			'default' => octopus_get_option ( 'container_max_width' ),
			'transport' => 'postMessage',
			'sanitize_callback' => 'octopus_sanitize_int',
			'sanitize_js_callback' => 'octopus_sanitize_int' 
	) );
	$wp_customize->add_control ( 'octopus_container_max_width', array (
			'label' => esc_html__ ( 'Fixed container max width (px)', 'octopus' ),
			'description' => esc_html__ ( 'Value must be a positive number', 'octopus' ),
			'section' => 'octopus_layout',
			'settings' => 'container_max_width',
			'type' => 'text',
			'priority' => 20,
			'active_callback' => 'octopus_is_container_fixed_callback' 
	) );
	// Page layout
	$wp_customize->add_setting ( 'page_layout', array (
			'default' => octopus_get_option ( 'page_layout' ),
			'sanitize_callback' => 'octopus_sanitize_page_layout' 
	) );
	$wp_customize->add_control ( 'octopus_page_layout', array (
			'label' => esc_html__ ( 'Page layout', 'octopus' ),
			'section' => 'octopus_layout',
			'settings' => 'page_layout',
			'type' => 'select',
			'choices' => array (
					'no-sidebar' => esc_html__ ( 'Full page', 'octopus' ),
					'left-sidebar' => esc_html__ ( 'Left sidebar', 'octopus' ),
					'right-sidebar' => esc_html__ ( 'Right sidebar', 'octopus' ),
					'all-sidebar' => esc_html__ ( 'Left and right sidebar', 'octopus' ) 
			),
			'priority' => 30 
	) );
	// Grid system class
	$wp_customize->add_setting ( 'gridsystem_class', array (
			'default' => octopus_get_option ( 'gridsystem_class' ),
			'transport' => 'postMessage',
			'sanitize_callback' => 'octopus_sanitize_gridsystem_class' 
	) );
	$wp_customize->add_control ( 'octopus_gridsystem_class', array (
			'label' => esc_html__ ( 'Columns not collapse in', 'octopus' ),
			'section' => 'octopus_layout',
			'settings' => 'gridsystem_class',
			'type' => 'select',
			'choices' => array (
					'col-xs-' => esc_html__ ( 'All devices', 'octopus' ),
					'col-sm-' => esc_html__ ( 'Small devices ( >= 768px )', 'octopus' ),
					'col-md-' => esc_html__ ( 'Medium devices ( >= 992px )', 'octopus' ),
					'col-lg-' => esc_html__ ( 'Large devices ( >= 1200px )', 'octopus' ) 
			),
			'priority' => 40,
			'active_callback' => 'octopus_is_page_layout_not_fullpage_callback' 
	) );
	
	// Helper
	$wp_customize->add_control ( new Fixed_Text_Custom_Control ( $wp_customize, 'octopus_sidebar_grid_size_help', array (
			'label' => esc_html__ ( 'Grid system columns', 'octopus' ),
			'description' => __ ( 'Bootstrap grid system is configured to 12 columns so the sum must be equal to 12.' ),
			'section' => 'octopus_layout',
			'priority' => 50,
			'active_callback' => 'octopus_is_page_layout_not_fullpage_callback' 
	) ) );
	
	$columns = array (
			'left' => esc_html__ ( 'Left' ),
			'content' => esc_html__ ( 'Content' ),
			'right' => esc_html__ ( 'Right' ) 
	);
	// Generate three settings and controls from $columns array
	foreach ( $columns as $key => $label ) {
		
		$wp_customize->add_setting ( $key . '_sidebar_grid_size', array (
				'default' => octopus_get_option ( $key . '_sidebar_grid_size' ),
				'transport' => 'postMessage' 
		) );
		$wp_customize->add_control ( 'octopus_' . $key . '_sidebar_grid_size', array (
				'label' => sprintf ( esc_html__ ( '%s sidebar grid size', 'octopus' ), $label ),
				'description' => esc_html__ ( 'Value must be a positive number', 'octopus' ),
				'section' => 'octopus_layout',
				'settings' => $key . '_sidebar_grid_size',
				'type' => 'select',
				'choices' => array (
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'6' => '6',
						'7' => '7',
						'8' => '8',
						'9' => '9',
						'10' => '10',
						'11' => '11' 
				),
				'priority' => 60,
				'active_callback' => 'octopus_' . $key . '_sidebar_grid_size_active_callback' 
		) );
		
		// ============== COLORS ==============
		$wp_customize->add_panel ( 'octopus_colors', array (
				'title' => esc_html__ ( 'Colors', 'octopus' ),
				'priority' => 11 
		) );
		$wp_customize->add_section ( 'octopus_colors_text', array (
				'title' => esc_html__ ( 'Text Colors', 'octopus' ),
				'panel' => 'octopus_colors',
				'priority' => 20 
		) );
		$wp_customize->add_setting ( 'color_text', array (
				'default' => octopus_get_option ( 'color_text' ),
				'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage' 
		) );
		$wp_customize->add_control ( new WP_Customize_Color_Control ( $wp_customize, 'octopus_color_text', array (
				'label' => esc_html__ ( 'Text', 'octopus' ),
				'section' => 'octopus_colors_text',
				'settings' => 'color_text',
				'priority' => 10 
		) ) );
		// Link
		$wp_customize->add_section ( 'octopus_colors_link', array (
				'title' => esc_html__ ( 'Link Colors', 'octopus' ),
				'panel' => 'octopus_colors',
				'priority' => 30 
		) );
		$wp_customize->add_setting ( 'color_link', array (
				'default' => octopus_get_option ( 'color_link' ),
				'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage' 
		) );
		$wp_customize->add_control ( new WP_Customize_Color_Control ( $wp_customize, 'octopus_color_link', array (
				'label' => esc_html__ ( 'Link', 'octopus' ),
				'section' => 'octopus_colors_link',
				'settings' => 'color_link',
				'priority' => 10 
		) ) );
		$wp_customize->add_setting ( 'color_link_visited', array (
				'default' => octopus_get_option ( 'color_link_visited' ),
				'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage' 
		) );
		$wp_customize->add_control ( new WP_Customize_Color_Control ( $wp_customize, 'octopus_color_link_visited', array (
				'label' => esc_html__ ( 'Visited link', 'octopus' ),
				'section' => 'octopus_colors_link',
				'settings' => 'color_link_visited',
				'priority' => 20 
		) ) );
		$wp_customize->add_setting ( 'color_link_hover', array (
				'default' => octopus_get_option ( 'color_link_hover' ),
				'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage' 
		) );
		$wp_customize->add_control ( new WP_Customize_Color_Control ( $wp_customize, 'octopus_color_link_hover', array (
				'label' => esc_html__ ( 'Hover link', 'octopus' ),
				'section' => 'octopus_colors_link',
				'settings' => 'color_link_hover',
				'priority' => 30 
		) ) );
	}
}
add_action ( 'customize_register', 'octopus_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function octopus_customize_preview_js() {
	wp_enqueue_script ( 'octopus_customizer', get_template_directory_uri () . '/assets/admin/js/customizer.js', array (
			'customize-preview' 
	), '20130508', true );
}
add_action ( 'customize_preview_init', 'octopus_customize_preview_js' );

/**
 * Binds JS handlers to Theme Customizer control.
 */
function octopus_customize_init_js() {
	wp_enqueue_script ( 'octopus_customizer_init', get_template_directory_uri () . '/assets/admin/js/customizer-init.js', array (
			'jquery' 
	), '20130508', true );
}
add_action ( 'customize_controls_enqueue_scripts', 'octopus_customize_init_js' );

/**
 * Sanitize callback for container class
 *
 * @param string $value        	
 * @return string
 */
function octopus_sanitize_container($value) {
	if (! in_array ( $value, array (
			'container-fluid',
			'container' 
	) ))
		$value = 'container-fluid';
	
	return $value;
}

/**
 * Sanitize callback for integer
 *
 * @param mixed $value        	
 * @return int
 */
function octopus_sanitize_int($value) {
	return absint ( $value );
}

/**
 * Check if container is fluid
 *
 * @param unknown $control        	
 * @return boolean
 */
function octopus_is_container_fixed_callback($control) {
	if ($control->manager->get_setting ( 'container_class' )->value () == 'container') {
		return true;
	}
	return false;
}

/**
 * Sanitize callback for page layout
 *
 * @param string $value        	
 * @return string
 */
function octopus_sanitize_page_layout($value) {
	if (! in_array ( $value, array (
			'no-sidebar',
			'left-sidebar',
			'right-sidebar',
			'all-sidebar' 
	) ))
		$value = 'no-sidebar';
	return $value;
}

/**
 * Sanitize callback for grid system class
 *
 * @param string $value        	
 * @return string
 */
function octopus_sanitize_gridsystem_class($value) {
	if (! in_array ( $value, array (
			'col-xs-',
			'col-sm-',
			'col-md-',
			'col-lg-' 
	) ))
		$value = 'col-md-';
	return $value;
}

/**
 * Check if page layout is full page
 *
 * @param unknown $control        	
 * @return boolean
 */
function octopus_is_page_layout_not_fullpage_callback($control) {
	if (octopus_get_option ( 'page_layout' ) == 'no-sidebar') {
		return false;
	}
	return true;
}

/**
 * Check if show octopus_left_sidebar_grid_size control
 *
 * @param unknown $control        	
 * @return boolean
 */
function octopus_left_sidebar_grid_size_active_callback($control) {
	if (octopus_get_option ( 'page_layout' ) == 'left-sidebar' || octopus_get_option ( 'page_layout' ) == 'all-sidebar') {
		return true;
	}
	return false;
}

/**
 * Check if show octopus_content_sidebar_grid_size control
 *
 * @param unknown $control        	
 * @return boolean
 */
function octopus_content_sidebar_grid_size_active_callback($control) {
	if (octopus_get_option ( 'page_layout' ) != 'no-sidebar') {
		return true;
	}
	return false;
}

/**
 * Check if show octopus_right_sidebar_grid_size control
 *
 * @param unknown $control        	
 * @return boolean
 */
function octopus_right_sidebar_grid_size_active_callback($control) {
	if (octopus_get_option ( 'page_layout' ) == 'right-sidebar' || octopus_get_option ( 'page_layout' ) == 'all-sidebar') {
		return true;
	}
	return false;
}
