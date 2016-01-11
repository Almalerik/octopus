<?php
// -*- coding: utf-8 -*-

// Called directly or at least not in WordPress context.
! defined ( 'ABSPATH' ) and exit ();

add_action ( 'init', 'octopus_slider_post_type' );
function octopus_slider_post_type() {
	register_post_type ( 'octopus_slider', array (
			'labels' => array (
					'name' => __ ( 'Theme Sliders', 'octopus' ),
					'singular_name' => __ ( 'Theme Slider', 'octopus' ) 
			),
			'rewrite' => array (
					'slug' => 'octopus-slider' 
			),
			'public' => true,
			'has_archive' => false,
			'supports' => array (
					'title' 
			),
			'hierarchical' => false,
			'can_export' => true 
	) );
}

add_action ( 'after_setup_theme', array (
		'Octopus_Slides_Meta_Box',
		'init' 
) );
class Octopus_Slides_Meta_Box {
	/**
	 * Global accessible instance (per init()).
	 * A singleton is not enforced tough.
	 *
	 * @type object
	 */
	protected static $instance = NULL;
	/**
	 * Internal identifier for the meta box.
	 * Must be unique in WordPress.
	 *
	 * @type string
	 */
	protected $handle = 'octopus_slider_meta_box';
	/**
	 * Box Title.
	 * In a real application make sure the title is translatable.
	 *
	 * You may use markup here, an icon for example.
	 *
	 * @type string
	 */
	protected $box_title = 'Slides';
	/**
	 * May be 'normal' or 'side'
	 *
	 * @type string
	 */
	protected $priority = 'normal';
	/**
	 * Where to show the meta box.
	 * Any post type or link.
	 *
	 * @type array
	 */
	protected $post_types = array (
			'octopus_slider' 
	);
	/**
	 * nonce = number used once, unique identifier for request validation.
	 *
	 * @type string
	 */
	protected $nonce_name = 'octopus_slider_meta_box_nonce';
	
	/**
	 * Creates a new instance.
	 * Called on 'plugins_loaded'.
	 *
	 * @see __construct()
	 * @return void
	 */
	public static function init() {
		NULL == self::$instance and self::$instance = new self ();
		return self::$instance;
	}
	
	/**
	 * Called by 'init()'.
	 * Registers the action handlers.
	 *
	 * @see save()
	 * @see register_meta_box()
	 * @see front_box()
	 * @return void
	 */
	public function __construct() {
		add_action ( 'save_post', array (
				$this,
				'save' 
		) );
		add_action ( 'add_meta_boxes', array (
				$this,
				'register_meta_box' 
		) );
		$this->extra_actions ();
	}
	
	/**
	 * More actions.
	 * May be overridden in a child class.
	 *
	 * @return void
	 */
	protected function extra_actions() {
		add_action ( 'basic_meta_box', array (
				$this,
				'front_box' 
		), 10, 1 );
	}
	
	/**
	 * Handler to get the content of the meta box.
	 *
	 * Usage:
	 * do_action( 'basic_meta_box' ); or
	 * do_action( 'basic_meta_box', array ( 'post_id' => 15 ) );
	 *
	 * You could also use:
	 * octopus_slider_Basic_Meta_Box::init()->front_box();
	 *
	 * But do_action() is better: It doesn’t require a theme update after
	 * disabling them meta box script.
	 *
	 * @param array $options
	 *        	See $defaults for possible options.
	 * @return string
	 */
	public function front_box($options = array ()) {
		global $post;
		$defaults = array (
				'post_id' => isset ( $post->ID ) ? $post->ID : FALSE,
				'template' => '<div class="octopus_slider_basic_meta_box"><h2>%1$s</h2>%2$s</div>',
				'print' => TRUE 
		);
		$options = array_merge ( $defaults, $options );
		extract ( $options );
		// We are not on a single page, and no post id was set. Nothing to do.
		if (FALSE == $post_id) {
			return;
		}
		// Prepare the variables.
		$title = get_post_meta ( $post_id, '_octopus_slider_basic_meta_box_title', TRUE );
		$text = get_post_meta ( $post_id, '_octopus_slider_basic_meta_box_text', TRUE );
		$text = wpautop ( $text );
		$output = sprintf ( $template, $title, $text );
		$print and print $output;
		return $output;
	}
	
	/**
	 * Called on 'add_meta_boxes'.
	 *
	 * @see __construct()()
	 * @see show()
	 * @return void
	 */
	public function register_meta_box() {
		foreach ( $this->post_types as $post_type ) {
			add_meta_box ( $this->handle, $this->box_title, array (
					$this,
					'show' 
			), $post_type, $this->priority );
			$this->add_help ( $post_type );
		}
	}
	
	/**
	 * Set help tab content.
	 *
	 * @param string $post_type        	
	 * @return void
	 */
	protected function add_help($post_type) {
		if (get_current_screen ()->post_type == $post_type) {
			get_current_screen ()->add_help_tab ( array (
					'id' => $this->handle,
					'title' => strip_tags ( $this->box_title ),
					'content' => '<p>Detailed instructions for your meta box.</p>' 
			) );
		}
	}
	
	/**
	 * Print the meta box in the editor page.
	 *
	 * @return void
	 */
	public function show($post) {
		// Our secret key for validation.
		$nonce = wp_create_nonce ( __FILE__ );
		echo "<input type='hidden' name='$this->nonce_name' value='$nonce' />";
		$this->print_markup ( $post );
	}
	
	/**
	 * The visible meta box markup for the post editor.
	 *
	 * @param object $post        	
	 * @return void
	 */
	protected function print_markup($post) {
		$slides = get_post_meta ( $post->ID, '_octopus_slides', true );
		// set a variable so we can append it to each row
		$default = array (
				"image_id" => "",
				"title" => "",
				"link" => "",
				"subtitle" => "",
				"first_button_text" => "",
				"first_button_url" => "",
				"second_button_text" => "",
				"second_button_url" => "" 
		);
		if (empty ( $slides ) || ! is_array ( $slides )) {
			$slides [] = $default;
		} else {
			array_unshift ( $slides, $default );
		}
		
		require_once 'slider-metabox-edit-template.php';
	}
	
	/**
	 * Save the POSTed values on 'save_post'.
	 *
	 * @param int $post_id        	
	 * @return void
	 */
	public function save($post_id) {
		if (! $this->save_allowed ( $post_id )) {
			return;
		}
		$slides = array ();
		
		if (isset ( $_POST ['_octopus_slide'] ) && is_array ( $_POST ['_octopus_slide'] )) {
			foreach ( $_POST ['_octopus_slide'] as $sn => $slide ) {
				// skip the hidden "to copy" row for jQuery
				if ($sn == '0' || ! isset ( $slide ['image_id'] ) || empty ( $slide ['image_id'] )) {
					continue;
				}
				
				$slides [] = array (
						'image_id' => isset ( $slide ['image_id'] ) ? sanitize_text_field ( $slide ['image_id'] ) : null,
						'subtitle' => isset ( $slide ['subtitle'] ) ? sanitize_text_field ( $slide ['subtitle'] ) : null,
						'title' => isset ( $slide ['title'] ) ? sanitize_text_field ( $slide ['title'] ) : null,
						'link' => isset ( $slide ['link'] ) ? sanitize_text_field ( $slide ['link'] ) : null,
						'first_button_text' => isset ( $slide ['first_button_text'] ) ? sanitize_text_field ( $slide ['first_button_text'] ) : null,
						'first_button_url' => isset ( $slide ['first_button_url'] ) ? sanitize_text_field ( $slide ['first_button_url'] ) : null,
						'second_button_text' => isset ( $slide ['second_button_text'] ) ? sanitize_text_field ( $slide ['second_button_text'] ) : null,
						'second_button_url' => isset ( $slide ['second_button_url'] ) ? sanitize_text_field ( $slide ['second_button_url'] ) : null 
				);
			}
		}
		
		// save data
		if (! empty ( $slides )) {
			update_post_meta ( $post_id, '_octopus_slides', $slides );
		} else {
			delete_post_meta ( $post_id, '_octopus_slides' );
		}
	}
	
	/**
	 * Check permission to save the POSTed data.
	 *
	 * @param int $post_id        	
	 * @return bool
	 */
	protected function save_allowed($post_id) {
		// AJAX autosave
		if (defined ( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) {
			return FALSE;
		}
		// Some other POST request
		if (! isset ( $_POST ['post_type'] )) {
			return FALSE;
		}
		// Wrong post type.
		if (! in_array ( $_POST ['post_type'], $this->post_types )) {
			return FALSE;
		}
		// Missing capability
		if (! current_user_can ( 'edit_post', $post_id )) {
			return FALSE;
		}
		// Wrong or missing nonce
		return wp_verify_nonce ( $_POST [$this->nonce_name], __FILE__ );
	}
}

add_action ( 'cmb2_admin_init', 'octopus_slider_settings_metabox' );
function octopus_slider_settings_metabox() {
	
	// Start with an underscore to hide fields from custom fields list
	$prefix = '_octopus_slider_settings_';
	
	$cmb = new_cmb2_box ( array (
			'id' => $prefix . 'metabox',
			'title' => __ ( 'Settings', 'octopus' ),
			'object_types' => array (
					'octopus_slider' 
			) 
	) );
	
	$cmb->add_field ( array (
			'name' => __ ( 'Direction', 'octopus' ),
			'id' => $prefix . 'direction',
			'type' => 'select',
			'options'          => array(
					'horizontal' => __( 'Horizontal', 'octopus' ),
					'vertical'   => __( 'Vertical', 'octopus' )
			),
	) );
	
	$cmb->add_field ( array (
			'name' => __ ( 'Loop', 'octopus' ),
			'id' => $prefix . 'loop',
			'type' => 'checkbox' 
	) );
	
	$cmb->add_field ( array (
			'name' => __ ( 'Dot pagination', 'octopus' ),
			'id' => $prefix . 'pagination',
			'type' => 'checkbox'
	) );
	
	$cmb->add_field ( array (
			'name' => __ ( 'Navigation buttons', 'octopus' ),
			'id' => $prefix . 'nav_buttons',
			'type' => 'checkbox'
	) );
	
	function get_slider_data(){
		
	}
}