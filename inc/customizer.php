<?php
/**
 * Octopus Theme Customizer.
 *
 * @package Octopus
 */

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
			'active_callback' => 'is_container_fixed_callback' 
	) );
	// Page layout
	$wp_customize->add_setting ( 'page_layout', array (
			'default' => octopus_get_option ( 'page_layout' ),
			'sanitize_callback' => 'octopus_sanitize_page_layout' 
	) );
	$wp_customize->add_control ( new Layout_Picker_Custom_Control ( $wp_customize, 'octopus_page_layout', array (
			'label' => esc_html__ ( 'Page layout', 'octopus' ),
			'section' => 'octopus_layout',
			'settings' => 'page_layout',
			'priority' => 30 
	) ) );
	// Grid system class
	$wp_customize->add_setting ( 'gridsystem_class', array (
			'default' => octopus_get_option ( 'gridsystem_class' ),
			'sanitize_callback' => 'octopus_sanitize_gridsystem_class'
	) );
	$wp_customize->add_control ( 'octopus_gridsystem_class', array (
			'label' => esc_html__ ( 'Columns not collapse in', 'octopus' ),
			'section' => 'octopus_layout',
			'settings' => 'gridsystem_class',
			'type' => 'select',
			'choices' => array (
					'col-xs-' => esc_html__ ( 'All devices', 'loungeact' ),
					'col-sm-' => esc_html__ ( 'Small devices ( >= 768px )', 'loungeact' ),
					'col-md-' => esc_html__ ( 'Medium devices ( >= 992px )', 'loungeact' ),
					'col-lg-' => esc_html__ ( 'Large devices ( >= 1200px )', 'loungeact' )
			),
			'priority' => 40,
			'active_callback' => 'is_page_layout_not_fullpage_callback'
	) );
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
function is_container_fixed_callback($control) {
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
			'full',
			'left',
			'right',
			'all' 
	) ))
		$value = 'full';
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
function is_page_layout_not_fullpage_callback($control) {
	if ($control->manager->get_setting ( 'page_layout' )->value () == 'full') {
		return false;
	}
	return true;
}

require_once 'wordpress-theme-customizer-custom-controls/layout/layout-picker-custom-control.php';