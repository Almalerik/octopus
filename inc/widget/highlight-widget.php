<?php

// Block direct requests
if (! defined ( 'ABSPATH' ))
	die ( '-1' );

add_action ( 'widgets_init', function () {
	register_widget ( 'Octopus_Highlight_Widget' );
} );

/**
 * Adds Octopus_Highlight_Widget widget.
 */
class Octopus_Highlight_Widget extends WP_Widget {
	
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct ( 
				// Base ID of your widget
				'octopus_highlight_widget', 
				
				// Widget name will appear in UI
				__ ( 'Octopus - Highlight', 'octopus' ), 
				
				// Widget description
				array (
						'description' => __ ( 'Highlight a post or a page or a fixed text.', 'octopus' ) 
				) );
	}
	
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args
	 *        	Widget arguments.
	 * @param array $instance
	 *        	Saved values from database.
	 */
	public function widget($args, $instance) {
		
		// Check if show a post
		if (isset ( $instance ['post_id'] ) && $instance ['post_id'] != '') {
			$p = get_post ( $instance ['post_id'] );
			$instance ["title"] = $p->post_title;
			$instance ["description"] = $p->post_content;
			$post_thumbnail_id = get_post_thumbnail_id ( $instance ['post_id'] );
			$instance ["image"] = wp_get_attachment_image_src ( $post_thumbnail_id, 'full' ) [0];
			$instance ["image_alt"] = trim(strip_tags( get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true) ));
		}
		
		if ( ! empty( $instance['title'] ) ) {
			$instance['title'] = $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		
		if (! isset( $instance ["layout"] ) || empty($instance ["layout"]) || !array_key_exists( $instance ["layout"], get_octopus_highlight_templates() ) ) {
			$instance ["layout"] = 'octopus-highlight-default.php';
		}
		// use a template for the output so that it can easily be overridden by theme
		// check for template in active theme
		
		$template = locate_template ( array (
				'/template-parts/highlights/' . $instance ["layout"]
		) );
		
		// if none found use the default template
		if ($template == '')
			$template = get_template_directory() . '/template-parts/highlights/octopus-highlight-default.php';
		
		echo $args ['before_widget'];
		
		include ($template);
		
		echo $args ['after_widget'];
	}
	
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance
	 *        	Previously saved values from database.
	 */
	public function form($instance) {
		$post_id = (isset ( $instance ['post_id'] )) ? $instance ['post_id'] : '';
		$title = (isset ( $instance ['title'] )) ? $instance ['title'] : '';
		$description = (isset ( $instance ['description'] )) ? $instance ['description'] : '';
		$image = (isset ( $instance ['image'] )) ? $instance ['image'] : '';
		$bg_color = (isset ( $instance ['bg_color'] )) ? $instance ['bg_color'] : '';
		$title_color = (isset ( $instance ['title_color'] )) ? $instance ['title_color'] : '';
		$description_color = (isset ( $instance ['description_color'] )) ? $instance ['description_color'] : '';
		$layout = (isset ( $instance ['layout'] )) ? $instance ['layout'] : '';
		$link_text = (isset ( $instance ['link_text'] )) ? $instance ['link_text'] : __("Read more...", "octopus");
		
		?>
<div class="octopus-highlight-widget octopus-cf-container">
	<div class="hide-if-no-js">
		<div class="octopus-cf-option-button" style="display: <?php echo ( !empty($post_id) ) ? 'none' : 'block'?>;">
			<input class="octopus-cf-select-post button" type="button" value="<?php _e('Post or Page', 'octopus');?>" /> <input class="octopus-cf-add-custom button"
				type="button" value="<?php _e('Custom', 'octopus');?>" />
		</div>

		<div class="octopus-cf-select-post-container octopus-cf-field-custom" style="display: <?php echo ( empty($post_id) ) ? 'none' : 'block'?>;">
			<label for="<?php echo $this->get_field_id( 'post_id' ); ?>"><?php esc_html_e( 'Select a post: ', 'octopus' ); ?></label> <select
				class="octopus-cf-post-select2 octopus-cf-options-val regular-text" id="<?php echo $this->get_field_id( 'post_id' ); ?>"
				name="<?php echo $this->get_field_name( 'post_id' ); ?>" style="width: 70%;">
				<option value="<?php echo $post_id ; ?>" selected="selected"><?php echo $post_id != '' ? get_post($post_id) -> post_title : ''; ?></option>
			</select>
			<a class="button octopus-cf-option-reset" href="#">
				<i class="fa fa-trash octopus-color-alert"></i>
			</a>
		</div>

		<div class="octopus-cf-add-custom-container octopus-cf-field-custom octopus-cf-container-bordered" style="display: <?php echo empty($title) && empty($description) && empty($image) ? 'none' : 'block'?>;">
			<a class="button octopus-cf-option-reset" href="#">
				<i class="fa fa-trash octopus-color-alert"></i>
			</a>

			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:' ); ?></label> <input class="widefat"
				id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /> <br> <label
				for="<?php echo $this->get_field_id( 'description' ); ?>"><?php esc_html_e( 'Description:'); ?></label>
			<textarea id="<?php echo $this->get_field_id( 'description' ); ?>" class="widefat octopus-cf-options-val" rows="3" cols="20"
				name="<?php echo $this->get_field_name( 'description' ); ?>"><?php echo esc_attr( $description ); ?></textarea>
			<br> <label for="<?php echo $this->get_field_id( 'image' );?>"><?php _e( 'Enter a URL or upload an image', 'octopus' ); ?></label><br /> <input
				class="octopus-cf-options-val widefat" id="<?php echo $this->get_field_id( 'image' );?>" name="<?php echo $this->get_field_name( 'image' );?>"
				value="<?php echo esc_attr( $image ); ?>" type="text" />
			<a class="button octopus-cf-image-upload-button" href="#"
				onclick="octopus_cf_media_button_click('<?php _e('Choose an image');?>','<?php _e('Select');?>','image','preview-<?php echo $this->get_field_id( 'image' );?>','<?php echo $this->get_field_id( 'image' );?>');">
				<i class="fa fa-upload"></i>
			</a>
			<div class="octopus-cf-image-preview" id="preview-<?php echo $this->get_field_id( 'image' );?>">
				<?php if ($image!='') echo '<img src="' . $image . '" />'; ?>				
			</div>

		</div>
		<p>
			<label for="<?php echo $this->get_field_id( 'layout' ); ?>"><?php esc_html_e( 'Layout:', 'octopus' ); ?></label><br />
			<select id="<?php echo $this->get_field_id( 'layout' );?>" name="<?php echo $this->get_field_name( 'layout' );?>">
				<?php foreach (get_octopus_highlight_templates() as $key => $value): ?>
				<option value="<?php echo $key;?>" <?php echo $key == $layout ? "selected" : "";?>><?php echo esc_html($value)?></option>
				<?php endforeach;?>
			</select>
		</p>
		<div class="octopus-accordion">
			<h4>
				<?php _e('Advanced options')?>
			</h4>
			<div class="octopus-accordion-content" id="#octopus-accordion-content-<?php echo $this->id;?>">
				<p>
					<label for="<?php echo $this->get_field_id( 'bg_color' ); ?>"><?php esc_html_e( 'Background color:', 'octopus' ); ?></label><br /> <input type="text"
						value="<?php echo esc_attr( $bg_color ); ?>" class="octopus-colorpicker" data-default-color="#ffffff" id="<?php echo $this->get_field_id( 'bg_color' );?>"
						name="<?php echo $this->get_field_name( 'bg_color' );?>" />
				</p>
				<p>
					<label for="<?php echo $this->get_field_id( 'title_color' ); ?>"><?php esc_html_e( 'Title color:', 'octopus' ); ?></label><br /> <input type="text"
						value="<?php echo esc_attr( $title_color ); ?>" class="octopus-colorpicker" data-default-color="#000000" id="<?php echo $this->get_field_id( 'title_color' );?>"
						name="<?php echo $this->get_field_name( 'title_color' );?>" />
				</p>
				<p>
					<label for="<?php echo $this->get_field_id( 'description_color' ); ?>"><?php esc_html_e( 'Description color:', 'octopus' ); ?></label><br /> <input type="text"
						value="<?php echo esc_attr( $description_color ); ?>" class="octopus-colorpicker" data-default-color="#555555"
						id="<?php echo $this->get_field_id( 'description_color' );?>" name="<?php echo $this->get_field_name( 'description_color' );?>" />
				</p>
				<p>
					<label for="<?php echo $this->get_field_id( 'show_link' ); ?>">
					<?php esc_html_e( 'Show link button', 'octopus' ); ?>
					<span class="howto"><?php esc_html_e('Empty value will be hide button','octopus')?></span>
					<input type="text"
						value="<?php echo esc_attr( $link_text ); ?>" class="widefat"
						id="<?php echo $this->get_field_id( 'link_text' );?>" name="<?php echo $this->get_field_name( 'link_text' );?>" />				</p>
			</div>
		</div>
	</div>
</div>
<?php
	}
	
	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance
	 *        	Values just sent to be saved.
	 * @param array $old_instance
	 *        	Previously saved values from database.
	 *        	
	 * @return array Updated safe values to be saved.
	 */
	public function update($new_instance, $old_instance) {
		$instance = array ();
		$instance ['post_id'] = (! empty ( $new_instance ['post_id'] )) ? strip_tags ( $new_instance ['post_id'] ) : '';
		$instance ['title'] = (! empty ( $new_instance ['title'] )) ? strip_tags ( $new_instance ['title'] ) : '';
		$instance ['description'] = (! empty ( $new_instance ['description'] )) ? strip_tags ( $new_instance ['description'] ) : '';
		$instance ['image'] = (! empty ( $new_instance ['image'] )) ? strip_tags ( $new_instance ['image'] ) : '';
		
		$instance ['bg_color'] = (! empty ( $new_instance ['bg_color'] )) ? strip_tags ( $new_instance ['bg_color'] ) : '#ffffff';
		$instance ['title_color'] = (! empty ( $new_instance ['title_color'] )) ? strip_tags ( $new_instance ['title_color'] ) : '#000000';
		$instance ['description_color'] = (! empty ( $new_instance ['description_color'] )) ? strip_tags ( $new_instance ['description_color'] ) : '#555555';
		$instance ['layout'] = (! empty ( $new_instance ['layout'] )) ? strip_tags ( $new_instance ['layout'] ) : '0';
		$instance ['link_text'] = (! empty ( $new_instance ['link_text'] )) ? strip_tags ( $new_instance ['link_text'] ) : '';
		return $instance;
	}
} // class Octopus_Highlight_Widget end
  

