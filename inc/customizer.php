<?php
/**
 * Octopus Theme Customizer.
 *
 * @package Octopus
 */
require_once 'wordpress-theme-customizer-custom-controls/text/fixed-text-custom-control.php';
require_once 'wordpress-theme-customizer-custom-controls/select/post-dropdown-custom-control.php';

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
		

		
		
		
		
		
		
		
		
		
		
		



		

		
		$wp_customize->add_setting ( 'header_nav_color', array (
				'default' => octopus_get_option ( 'header_nav_color' ),
				'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage'
		) );
		$wp_customize->add_control ( new WP_Customize_Color_Control ( $wp_customize, 'octopus_header_nav_color', array (
				'label' => esc_html__ ( 'Navigation menu', 'octopus' ),
				'section' => 'octopus_header_colors',
				'settings' => 'header_nav_color',
				'priority' => 50
		) ) );
		$wp_customize->add_setting ( 'header_nav_decoration_hover', array (
				'default' => octopus_get_option ( 'header_nav_decoration_hover' ),
				'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage'
		) );
		$wp_customize->add_control ( new WP_Customize_Color_Control ( $wp_customize, 'octopus_header_nav_decoration_hover', array (
				'label' => esc_html__ ( 'Navigation menu hover', 'octopus' ),
				'section' => 'octopus_header_colors',
				'settings' => 'header_nav_decoration_hover',
				'priority' => 60
		) ) );
		$wp_customize->add_setting ( 'header_nav_decoration_active', array (
				'default' => octopus_get_option ( 'header_nav_decoration_active' ),
				'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage'
		) );
		$wp_customize->add_control ( new WP_Customize_Color_Control ( $wp_customize, 'octopus_header_nav_decoration_active', array (
				'label' => esc_html__ ( 'Navigation menu active', 'octopus' ),
				'section' => 'octopus_header_colors',
				'settings' => 'header_nav_decoration_active',
				'priority' => 70
		) ) );
		
		// Header banner
		$wp_customize->add_section ( 'octopus_header_banner', array (
				'title' => esc_html__ ( 'Banner', 'octopus' ),
				'panel' => 'octopus_header',
				'priority' => 30 
		) );
		// Helper
		$wp_customize->add_control ( new Fixed_Text_Custom_Control ( $wp_customize, 'octopus_header_banner_helper', array (
				'description' => sprintf ( 'To create or edit a slider, save and click <a href="%s" class="button">%s</a>', admin_url ( 'edit.php?post_type=octopus_slider' ), esc_html__ ( 'Here', 'octopus' ) ),
				'section' => 'octopus_header_banner',
				'priority' => 10 
		) ) );
		// Show
		$wp_customize->add_setting ( 'header_banner_show', array (
				'default' => octopus_get_option ( 'header_banner_show' ),
				'transport' => 'postMessage'
		) );
		$wp_customize->add_control ( 'octopus_header_banner_show', array (
				'label' => esc_html__ ( 'Show', 'octopus' ),
				'section' => 'octopus_header_banner',
				'settings' => 'header_banner_show',
				'type' => 'checkbox',
				'priority' => 20
		) );
		// select slider
		$wp_customize->add_setting ( 'header_banner', array (
				'default' => octopus_get_option ( 'header_banner' ) 
		) );
		$wp_customize->add_control ( new Post_Dropdown_Custom_Control ( $wp_customize, 'octopus_header_banner', array (
				'label' => esc_html__ ( 'Slider', 'octopus' ),
				'section' => 'octopus_header_banner',
				'settings' => 'header_banner',
				'priority' => 20,
				'active_callback' => 'octopus_slider_exist_callback' 
		), array (
				'post_type' => 'octopus_slider' 
		) ) );
		// slide layout
		$wp_customize->add_setting ( 'header_banner_layout', array (
				'default' => octopus_get_option ( 'header_banner_layout' ),
				'transport' => 'postMessage'
		) );
		$wp_customize->add_control ( 'octopus_header_banner_layout', array (
				'label' => esc_html__ ( 'Slider layout', 'octopus' ),
				'section' => 'octopus_header_banner',
				'settings' => 'header_banner_layout',
				'type' => 'select',
				'choices' => array (
						'' => esc_html__ ( 'Normal', 'octopus' ),
						'octopus-fullscreen-banner' => esc_html__ ( 'FullScreen', 'octopus' ),
						'octopus-header-inside-banner' => esc_html__ ( 'Header inside', 'octopus' )
				),
				'priority' => 30,
				'active_callback' => 'octopus_slider_selected'
		) );
		// slider height
		$wp_customize->add_setting ( 'header_banner_height', array (
				'default' => octopus_get_option ( 'header_banner_height' ),
				'sanitize_callback' => 'octopus_sanitize_int',
				'sanitize_js_callback' => 'octopus_sanitize_int',
				'transport' => 'postMessage'
		) );
		$wp_customize->add_control ( 'octopus_header_banner_height', array (
				'label' => esc_html__ ( 'Slider height (px)', 'octopus' ),
				'description' => esc_html__ ( 'Only integer value are accepted', 'octopus' ),
				'section' => 'octopus_header_banner',
				'settings' => 'header_banner_height',
				'type' => 'text',
				'priority' => 40,
				'active_callback' => 'is_header_banner_not_fullscreen_callback' 
		) );
		
		/*
		 * ============== HOMEPAGE FEATURES ==============
		 */
		$wp_customize->add_panel ( 'octopus_homepage_features', array (
				'title' => esc_html__ ( 'Homepage Features', 'octopus' )
		) );
		$wp_customize->add_section ( 'octopus_homepage_features_settings', array (
				'title' => esc_html__ ( 'Settings' ),
				'panel' => 'octopus_homepage_features',
				'active_callback' => 'is_front_page',
				'priority' => 10
		) );
		// Helper
		$wp_customize->add_control ( new Fixed_Text_Custom_Control ( $wp_customize, 'octopus_homepage_features_helper', array (
				'description' => sprintf ( '%s <a href="#" class="button octopus-goto-swh-features">%s</a>', esc_html__ ( 'To add a Feature, save and click', 'octopus' ), esc_html__ ( 'Here', 'octopus' ) ),
				'section' => 'octopus_homepage_features_settings',
				'priority' => 10
		) ) );
		// Show
		$wp_customize->add_setting ( 'homepage_features_show', array (
				'default' => octopus_get_option ( 'homepage_features_show' ),
				'transport' => 'postMessage'
		) );
		$wp_customize->add_control ( 'octopus_homepage_features_show', array (
				'label' => esc_html__ ( 'Show' ),
				'section' => 'octopus_homepage_features_settings',
				'settings' => 'homepage_features_show',
				'type' => 'checkbox',
				'priority' => 20
		) );
		// Fixed max width
		$wp_customize->add_setting ( 'homepage_features_wrapped', array (
				'default' => octopus_get_option ( 'homepage_features_wrapped' ),
				'transport' => 'postMessage'
		) );
		$wp_customize->add_control ( 'octopus_homepage_features_wrapped', array (
				'label' => esc_html__ ( 'Wrapped', 'octopus' ),
				'description' => esc_html__ ( 'Set max-width element (value is set in "Layout" main section)', 'octopus' ),
				'section' => 'octopus_homepage_features_settings',
				'settings' => 'homepage_features_wrapped',
				'type' => 'checkbox',
				'priority' => 20
		) );
		// Title
		$wp_customize->add_setting ( 'homepage_features_title', array (
				'default' => octopus_get_option ( 'homepage_features_title' ),
				'transport' => 'postMessage'
		) );
		$wp_customize->add_control ( 'octopus_homepage_features_title', array (
				'label' => esc_html__ ( 'Title' ),
				'section' => 'octopus_homepage_features_settings',
				'settings' => 'homepage_features_title',
				'priority' => 30
		) );
		// Subtitle
		$wp_customize->add_setting ( 'homepage_features_description', array (
				'default' => octopus_get_option ( 'homepage_features_description' ),
				'transport' => 'postMessage'
		) );
		$wp_customize->add_control ( 'octopus_homepage_features_description', array (
				'label' => esc_html__ ( 'Description' ),
				'section' => 'octopus_homepage_features_settings',
				'settings' => 'homepage_features_description',
				'priority' => 40
		) );
		$wp_customize->add_setting ( 'homepage_features_bg_color', array (
				'default' => octopus_get_option ( 'homepage_features_bg_color' ),
				'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage'
		) );
		$wp_customize->add_control ( new WP_Customize_Color_Control ( $wp_customize, 'octopus_homepage_features_bg_color', array (
				'label' => esc_html__ ( 'Background color', 'octopus' ),
				'section' => 'octopus_homepage_features_settings',
				'settings' => 'homepage_features_bg_color',
				'priority' => 50
		) ) );
		$wp_customize->add_setting ( 'homepage_features_text_color', array (
				'default' => octopus_get_option ( 'homepage_features_text_color' ),
				'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage'
		) );
		$wp_customize->add_control ( new WP_Customize_Color_Control ( $wp_customize, 'octopus_homepage_features_text_color', array (
				'label' => esc_html__ ( 'Text color', 'octopus' ),
				'section' => 'octopus_homepage_features_settings',
				'settings' => 'homepage_features_text_color',
				'priority' => 60
		) ) );
		$wp_customize->add_setting ( 'homepage_features_description_color', array (
				'default' => octopus_get_option ( 'homepage_features_description_color' ),
				'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage'
		) );
		$wp_customize->add_control ( new WP_Customize_Color_Control ( $wp_customize, 'octopus_homepage_features_description_color', array (
				'label' => esc_html__ ( 'Description color', 'octopus' ),
				'section' => 'octopus_homepage_features_settings',
				'settings' => 'homepage_features_description_color',
				'priority' => 70
		) ) );
		
		/*
		 * ============== HOMEPAGE HIGHLIGHTS ==============
		 */
		$wp_customize->add_panel ( 'octopus_homepage_highlights', array (
				'title' => esc_html__ ( 'Homepage Highlights', 'octopus' )
		) );
		$wp_customize->add_section ( 'octopus_homepage_highlights_settings', array (
				'title' => esc_html__ ( 'Settings' ),
				'panel' => 'octopus_homepage_highlights',
				'active_callback' => 'is_front_page',
				'priority' => 10
		) );
		// Helper
		$wp_customize->add_control ( new Fixed_Text_Custom_Control ( $wp_customize, 'octopus_homepage_highlights_helper', array (
				'description' => sprintf ( '%s <a href="#" class="button octopus-goto-swh-highlights">%s</a>', esc_html__ ( 'To add a HighLights, save and click', 'octopus' ), esc_html__ ( 'Here', 'octopus' ) ),
				'section' => 'octopus_homepage_highlights_settings',
				'priority' => 10
		) ) );
		// Show
		$wp_customize->add_setting ( 'homepage_highlights_show', array (
				'default' => octopus_get_option ( 'homepage_highlights_show' ),
				'transport' => 'postMessage'
		) );
		$wp_customize->add_control ( 'octopus_homepage_highlights_show', array (
				'label' => esc_html__ ( 'Show' ),
				'section' => 'octopus_homepage_highlights_settings',
				'settings' => 'homepage_highlights_show',
				'type' => 'checkbox',
				'priority' => 20
		) );
		// Fixed max width
		$wp_customize->add_setting ( 'homepage_highlights_wrapped', array (
				'default' => octopus_get_option ( 'homepage_highlights_wrapped' ),
				'transport' => 'postMessage'
		) );
		$wp_customize->add_control ( 'octopus_homepage_highlights_wrapped', array (
				'label' => esc_html__ ( 'Wrapped', 'octopus' ),
				'description' => esc_html__ ( 'Set max-width element (value is set in "Layout" main section)', 'octopus' ),
				'section' => 'octopus_homepage_highlights_settings',
				'settings' => 'homepage_highlights_wrapped',
				'type' => 'checkbox',
				'priority' => 20
		) );
		// Title
		$wp_customize->add_setting ( 'homepage_highlights_title', array (
				'default' => octopus_get_option ( 'homepage_highlights_title' )
		) );
		$wp_customize->add_control ( 'octopus_homepage_highlights_title', array (
				'label' => esc_html__ ( 'Title' ),
				'section' => 'octopus_homepage_highlights_settings',
				'settings' => 'homepage_highlights_title',
				'priority' => 30
		) );
		// Subtitle
		$wp_customize->add_setting ( 'homepage_highlights_description', array (
				'default' => octopus_get_option ( 'homepage_highlights_description' )
		) );
		$wp_customize->add_control ( 'octopus_homepage_highlights_description', array (
				'label' => esc_html__ ( 'Description' ),
				'section' => 'octopus_homepage_highlights_settings',
				'settings' => 'homepage_highlights_description',
				'priority' => 40
		) );
		$wp_customize->add_setting ( 'homepage_highlights_bg_color', array (
				'default' => octopus_get_option ( 'homepage_highlights_bg_color' ),
				'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage'
		) );
		$wp_customize->add_control ( new WP_Customize_Color_Control ( $wp_customize, 'octopus_homepage_highlights_bg_color', array (
				'label' => esc_html__ ( 'Background color', 'octopus' ),
				'section' => 'octopus_homepage_highlights_settings',
				'settings' => 'homepage_highlights_bg_color',
				'priority' => 50
		) ) );
		$wp_customize->add_setting ( 'homepage_highlights_text_color', array (
				'default' => octopus_get_option ( 'homepage_highlights_text_color' ),
				'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage'
		) );
		$wp_customize->add_control ( new WP_Customize_Color_Control ( $wp_customize, 'octopus_homepage_highlights_text_color', array (
				'label' => esc_html__ ( 'Text color', 'octopus' ),
				'section' => 'octopus_homepage_highlights_settings',
				'settings' => 'homepage_highlights_text_color',
				'priority' => 60
		) ) );
		$wp_customize->add_setting ( 'homepage_highlights_description_color', array (
				'default' => octopus_get_option ( 'homepage_highlights_description_color' ),
				'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage'
		) );
		$wp_customize->add_control ( new WP_Customize_Color_Control ( $wp_customize, 'octopus_homepage_highlights_description_color', array (
				'label' => esc_html__ ( 'Description color', 'octopus' ),
				'section' => 'octopus_homepage_highlights_settings',
				'settings' => 'homepage_highlights_description_color',
				'priority' => 70
		) ) );
		
		/*
		 * ============== HOMEPAGE PORTFOLIOS ==============
		 */
		$wp_customize->add_panel ( 'octopus_homepage_portfolio', array (
				'title' => esc_html__ ( 'Homepage Portfolios', 'octopus' )
		) );
		$wp_customize->add_section ( 'octopus_homepage_portfolio_settings', array (
				'title' => esc_html__ ( 'Settings' ),
				'panel' => 'octopus_homepage_portfolio',
				'active_callback' => 'is_front_page',
				'priority' => 10
		) );
		// Show
		$wp_customize->add_setting ( 'homepage_portfolio_show', array (
				'default' => octopus_get_option ( 'homepage_portfolio_show' ),
				'transport' => 'postMessage'
		) );
		$wp_customize->add_control ( 'octopus_homepage_portfolio_show', array (
				'label' => esc_html__ ( 'Show' ),
				'section' => 'octopus_homepage_portfolio_settings',
				'settings' => 'homepage_portfolio_show',
				'type' => 'checkbox',
				'priority' => 20
		) );
		// Fixed max width
		$wp_customize->add_setting ( 'homepage_portfolio_wrapped', array (
				'default' => octopus_get_option ( 'homepage_portfolio_wrapped' ),
				'transport' => 'postMessage'
		) );
		$wp_customize->add_control ( 'octopus_homepage_portfolio_wrapped', array (
				'label' => esc_html__ ( 'Wrapped', 'octopus' ),
				'description' => esc_html__ ( 'Set max-width element (value is set in "Layout" main section)', 'octopus' ),
				'section' => 'octopus_homepage_portfolio_settings',
				'settings' => 'homepage_portfolio_wrapped',
				'type' => 'checkbox',
				'priority' => 20
		) );
		// Title
		$wp_customize->add_setting ( 'homepage_portfolio_title', array (
				'default' => octopus_get_option ( 'homepage_portfolio_title' )
		) );
		$wp_customize->add_control ( 'octopus_homepage_portfolio_title', array (
				'label' => esc_html__ ( 'Title' ),
				'section' => 'octopus_homepage_portfolio_settings',
				'settings' => 'homepage_portfolio_title',
				'priority' => 30
		) );
		// Subtitle
		$wp_customize->add_setting ( 'homepage_portfolio_description', array (
				'default' => octopus_get_option ( 'homepage_portfolio_description' )
		) );
		$wp_customize->add_control ( 'octopus_homepage_portfolio_description', array (
				'label' => esc_html__ ( 'Description' ),
				'section' => 'octopus_homepage_portfolio_settings',
				'settings' => 'homepage_portfolio_description',
				'priority' => 40
		) );
		$wp_customize->add_setting ( 'homepage_portfolio_bg_color', array (
				'default' => octopus_get_option ( 'homepage_portfolio_bg_color' ),
				'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage'
		) );
		$wp_customize->add_control ( new WP_Customize_Color_Control ( $wp_customize, 'octopus_homepage_portfolio_bg_color', array (
				'label' => esc_html__ ( 'Background color', 'octopus' ),
				'section' => 'octopus_homepage_portfolio_settings',
				'settings' => 'homepage_portfolio_bg_color',
				'priority' => 50
		) ) );
		$wp_customize->add_setting ( 'homepage_portfolio_text_color', array (
				'default' => octopus_get_option ( 'homepage_portfolio_text_color' ),
				'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage'
		) );
		$wp_customize->add_control ( new WP_Customize_Color_Control ( $wp_customize, 'octopus_homepage_portfolio_text_color', array (
				'label' => esc_html__ ( 'Text color', 'octopus' ),
				'section' => 'octopus_homepage_portfolio_settings',
				'settings' => 'homepage_portfolio_text_color',
				'priority' => 60
		) ) );
		$wp_customize->add_setting ( 'homepage_portfolio_description_color', array (
				'default' => octopus_get_option ( 'homepage_portfolio_description_color' ),
				'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage'
		) );
		$wp_customize->add_control ( new WP_Customize_Color_Control ( $wp_customize, 'octopus_homepage_portfolio_description_color', array (
				'label' => esc_html__ ( 'Description color', 'octopus' ),
				'section' => 'octopus_homepage_portfolio_settings',
				'settings' => 'homepage_portfolio_description_color',
				'priority' => 70
		) ) );
		
		/*
		 * ============== HOMEPAGE STAFF ==============
		 */
		$wp_customize->add_panel ( 'octopus_homepage_staff', array (
				'title' => esc_html__ ( 'Homepage Staff Members', 'octopus' )
		) );
		$wp_customize->add_section ( 'octopus_homepage_staff_settings', array (
				'title' => esc_html__ ( 'Settings' ),
				'panel' => 'octopus_homepage_staff',
				'active_callback' => 'is_front_page',
				'priority' => 10
		) );
		// Helper
		$wp_customize->add_control ( new Fixed_Text_Custom_Control ( $wp_customize, 'octopus_homepage_staff_helper', array (
				'description' => sprintf ( '%s <a href="#" class="button octopus-goto-swh-staff">%s</a>', esc_html__ ( 'To add a Staff Member, save and click', 'octopus' ), esc_html__ ( 'Here', 'octopus' ) ),
				'section' => 'octopus_homepage_staff_settings',
				'priority' => 10
		) ) );
		// Show
		$wp_customize->add_setting ( 'homepage_staff_show', array (
				'default' => octopus_get_option ( 'homepage_staff_show' ),
				'transport' => 'postMessage'
		) );
		$wp_customize->add_control ( 'octopus_homepage_staff_show', array (
				'label' => esc_html__ ( 'Show' ),
				'section' => 'octopus_homepage_staff_settings',
				'settings' => 'homepage_staff_show',
				'type' => 'checkbox',
				'priority' => 20
		) );
		// Fixed max width
		$wp_customize->add_setting ( 'homepage_staff_wrapped', array (
				'default' => octopus_get_option ( 'homepage_staff_wrapped' ),
				'transport' => 'postMessage'
		) );
		$wp_customize->add_control ( 'octopus_homepage_staff_wrapped', array (
				'label' => esc_html__ ( 'Wrapped', 'octopus' ),
				'description' => esc_html__ ( 'Set max-width element (value is set in "Layout" main section)', 'octopus' ),
				'section' => 'octopus_homepage_staff_settings',
				'settings' => 'homepage_staff_wrapped',
				'type' => 'checkbox',
				'priority' => 20
		) );
		// Title
		$wp_customize->add_setting ( 'homepage_staff_title', array (
				'default' => octopus_get_option ( 'homepage_staff_title' )
		) );
		$wp_customize->add_control ( 'octopus_homepage_staff_title', array (
				'label' => esc_html__ ( 'Title' ),
				'section' => 'octopus_homepage_staff_settings',
				'settings' => 'homepage_staff_title',
				'priority' => 30
		) );
		// Subtitle
		$wp_customize->add_setting ( 'homepage_staff_description', array (
				'default' => octopus_get_option ( 'homepage_staff_description' )
		) );
		$wp_customize->add_control ( 'octopus_homepage_staff_description', array (
				'label' => esc_html__ ( 'Description' ),
				'section' => 'octopus_homepage_staff_settings',
				'settings' => 'homepage_staff_description',
				'priority' => 40
		) );
		$wp_customize->add_setting ( 'homepage_staff_bg_color', array (
				'default' => octopus_get_option ( 'homepage_staff_bg_color' ),
				'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage'
		) );
		$wp_customize->add_control ( new WP_Customize_Color_Control ( $wp_customize, 'octopus_homepage_staff_bg_color', array (
				'label' => esc_html__ ( 'Background color', 'octopus' ),
				'section' => 'octopus_homepage_staff_settings',
				'settings' => 'homepage_staff_bg_color',
				'priority' => 50
		) ) );
		$wp_customize->add_setting ( 'homepage_staff_text_color', array (
				'default' => octopus_get_option ( 'homepage_staff_text_color' ),
				'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage'
		) );
		$wp_customize->add_control ( new WP_Customize_Color_Control ( $wp_customize, 'octopus_homepage_staff_text_color', array (
				'label' => esc_html__ ( 'Text color', 'octopus' ),
				'section' => 'octopus_homepage_staff_settings',
				'settings' => 'homepage_staff_text_color',
				'priority' => 60
		) ) );
		$wp_customize->add_setting ( 'homepage_staff_description_color', array (
				'default' => octopus_get_option ( 'homepage_staff_description_color' ),
				'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage'
		) );
		$wp_customize->add_control ( new WP_Customize_Color_Control ( $wp_customize, 'octopus_homepage_staff_description_color', array (
				'label' => esc_html__ ( 'Description color', 'octopus' ),
				'section' => 'octopus_homepage_staff_settings',
				'settings' => 'homepage_staff_description_color',
				'priority' => 70
		) ) );
	}
}
add_action ( 'customize_register', 'octopus_customize_register' );








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



/**
 * A function that check if a slider exist
 *
 * @return boolean
 */
function octopus_slider_exist_callback($control) {
	$posts_array = get_posts ( array (
			'post_type' => 'octopus_slider' 
	) );
	if (count ( $posts_array ) > 0) {
		return true;
	} else {
		return false;
	}
}

/**
 * A function that check if a slider is selected
 *
 * @return boolean
 */
function octopus_slider_selected($control) {
	if ($control->manager->get_setting ( 'header_banner' )->value () != '') {
		return true;
	} else {
		return false;
	}
}

/**
 * A function that check if a slider is selected and if is not fullscreen
 *
 * @return boolean
 */
function is_header_banner_not_fullscreen_callback($control) {
	if (octopus_slider_selected ( $control )) {
		if ($control->manager->get_setting ( 'header_banner_layout' )->value () == 'octopus-fullscreen-banner') {
			return false;
		} else {
			return true;
		}
	} else {
		return false;
	}
}