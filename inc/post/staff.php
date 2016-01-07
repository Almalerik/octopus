<?php
// -*- coding: utf-8 -*-

// Called directly or at least not in WordPress context.
! defined ( 'ABSPATH' ) and exit ();

add_action ( 'init', 'octopus_staff_post_type' );
function octopus_staff_post_type() {
	register_post_type ( 'octopus_staff', array (
			'labels' => array (
					'name' => __ ( 'Staffs', 'octopus' ),
					'singular_name' => __ ( 'Staff', 'octopus' ) 
			),
			'rewrite' => array (
					'slug' => 'staff' 
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
			)
			,
			'hierarchical' => false,
			'can_export' => true 
	) );
}

add_action( 'cmb2_admin_init', 'octopus_staff_info_metabox' );
function octopus_staff_info_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_octopus_staff_info_';

	$cmb = new_cmb2_box( array(
			'id'            => $prefix . 'metabox',
			'title'         => __( 'Information', 'octopus' ),
			'object_types'  => array( 'octopus_staff', )
	) );

	$cmb->add_field( array(
			'name'       => __('Occupation', 'octopus'),
			'id'         => $prefix . 'occupation',
			'type'       => 'text'
	) );


}


add_action( 'cmb2_admin_init', 'octopus_staff_contacts_metabox' );
function octopus_staff_contacts_metabox() {
	
	// Start with an underscore to hide fields from custom fields list
	$prefix = '_octopus_staff_contacts_';
	
	$cmb = new_cmb2_box( array(
			'id'            => $prefix . 'metabox',
			'title'         => __( 'Staff contacts', 'octopus' ),
			'object_types'  => array( 'octopus_staff', )
	) );
	
	foreach ( octopus_get_staff_contacts() as $key => $value ) {
		
		$cmb->add_field( array(
			'name'       => $value['label'],
			'id'         => $prefix . $key,
			'type'       => 'text'
		) );
		
	}
	
}

add_action( 'cmb2_admin_init', 'octopus_staff_skills_metabox' );
function octopus_staff_skills_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_octopus_staff_skills_';

	$cmb_group = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Skills', 'octopus' ),
			'object_types' => array( 'octopus_staff', ),
	) );

	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_id = $cmb_group->add_field( array(
			'id'          => $prefix . 'skills',
			'type'        => 'group',
			'options'     => array(
					'group_title'   => __( 'Skill {#}', 'octopus' ), // {#} gets replaced by row number
					'add_button'    => __( 'Add Another Skill', 'octopus' ),
					'remove_button' => __( 'Remove Skill', 'octopus' ),
					'sortable'      => true, // beta
			),
	) );

	$cmb_group->add_group_field( $group_field_id, array(
			'name'       => __( 'Skill Title', 'octopus' ),
			'id'         => 'title',
			'type'       => 'text'
	) );

	$cmb_group->add_group_field( $group_field_id, array(
			'name'        => __( 'Percent', 'octopus' ),
			'id'          => 'percent',
			'type'        => 'text_small',
			'after'       => ' %',
	) );

}

