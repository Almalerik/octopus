<?php
// -*- coding: utf-8 -*-

// Called directly or at least not in WordPress context.
! defined ( 'ABSPATH' ) and exit ();

add_action ( 'init', 'octopus_portfolio_post_type' );
function octopus_portfolio_post_type() {
	register_post_type ( 'octopus_portfolio', array (
			'labels' => array (
					'name' => __ ( 'Portfolio', 'octopus' ),
					'singular_name' => __ ( 'Portfolio', 'octopus' ) 
			),
			'rewrite' => array (
					'slug' => 'portfolio' 
			),
			'public' => true,
			'has_archive' => false,
			'supports' => array (
					'title',
					'editor',
					'author',
					'thumbnail',
					'excerpt',
					'trackbacks',
					'custom-fields',
					'comments',
					'revisions' 
			),
			'hierarchical' => false,
			'can_export' => true 
	) );
}

/**
 * Setup custom metaboxes and fields.
 */

add_filter ( 'cmb_meta_boxes', 'octopus_portfolio_metaboxes' );

/**
 * Define the metabox and field configurations.
 *
 * @param array $meta_boxes        	
 * @return array
 */
function octopus_portfolio_metaboxes(array $meta_boxes) {
	
	// Start with an underscore to hide fields from custom fields list
	$prefix = '_octopus_portfolio_';
	
	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$meta_boxes ['test_metabox'] = array (
			'id' => 'test_metabox',
			'title' => __ ( 'Details', 'octopus' ),
			'pages' => array (
					'octopus_portfolio' 
			), // Post type
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true, // Show field names on the left
			'fields' => array (
					array (
							'name' => __ ( 'Project', 'octopus' ),
							'id' => $prefix . 'project',
							'type' => 'text' 
					) 
			) 
	);
	
	return $meta_boxes;
}

/**
 * Add custom porfolio's taxonomy
 */
add_action( 'init', 'octopus_create_portfolio_taxonomy', 0 );
function octopus_create_portfolio_taxonomy() {
	$labels = array(
			'name' => _x( 'Portfolio Categories', 'octopus' ),
			'singular_name' => _x( 'Portfolio Category', 'octopus' ),
			'search_items' =>  __( 'Search Portfolio Categories', 'octopus' ),
			'popular_items' => __( 'Popular Portfolio Categories', 'octopus' ),
			'all_items' => __( 'All Portfolio Categories', 'octopus' ),
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => __( 'Edit Portfolio Category', 'octopus' ),
			'update_item' => __( 'Update Portfolio Category', 'octopus' ),
			'add_new_item' => __( 'Add New Portfolio Category', 'octopus' ),
			'new_item_name' => __( 'New Portfolio Category Name', 'octopus' ),
			'separate_items_with_commas' => __( 'Separate portfolio categories with commas', 'octopus' ),
			'add_or_remove_items' => __( 'Add or remove portfolio categories', 'octopus' ),
			'choose_from_most_used' => __( 'Choose from the most used portfolio categories', 'octopus' ),
			'menu_name' => __( 'Categories' ),
	);

	// Now register the non-hierarchical taxonomy like tag

	register_taxonomy('octopus_portfolio_categories', array('octopus_portfolio') ,array(
			'hierarchical' => false,
			'labels' => $labels,
			'show_ui' => true,
			'show_admin_column' => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var' => true,
			'rewrite' => array( 'slug' => 'portfolio-categories' ),
	));
}

