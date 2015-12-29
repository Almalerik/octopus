<?php

// Block direct requests
if (! defined ( 'ABSPATH' ))
	die ( '-1' );

add_action ( 'widgets_init', function () {
	register_widget ( 'Octopus_Feature_Widget' );
} );

/**
 * Adds Octopus_Feature_Widget widget.
 */
class Octopus_Feature_Widget extends WP_Widget {
	
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct ( 
				// Base ID of your widget
				'octopus_feature_widget', 
				
				// Widget name will appear in UI
				__ ( 'Octopus - Feature', 'octopus' ), 
				
				// Widget description
				array (
						'description' => __ ( 'Add a feature ', 'octopus' ) 
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
		
		$instance["title_text"] = $instance['title'];
		if ( ! empty( $instance['title'] ) ) {
			$instance['title'] = $args['before_title'] . 
				apply_filters( 'widget_title', $instance['title'] ) .
				'<span class="octopus-decoration ' . $instance['color'] . '"></span>'. $args['after_title'];
		}
		
		$args ['before_widget'] = str_replace('class="', 'class="placeholder ', $args ['before_widget']);
				
		// use a template for the output so that it can easily be overridden by theme
		// check for template in active theme
		$template = locate_template ( array (
				'feature-widget-template.php' 
		) );
		
		// if none found use the default template
		if ($template == '')
			$template = 'feature-widget-template.php';
		
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
		$image = (isset ( $instance ['image'] )) ? $instance ['image'] : '';
		$font_icon = (isset ( $instance ['font_icon'] )) ? $instance ['font_icon'] : '';
		$title = (isset ( $instance ['title'] )) ? $instance ['title'] : '';
		$description = (isset ( $instance ['description'] )) ? $instance ['description'] : '';
		$link = (isset ( $instance ['link'] )) ? $instance ['link'] : '';
		$color = (isset ( $instance ['color'] )) ? $instance ['color'] : '#ffffff';
		
		?>
		<div class="octopus-feature-widget octopus-cf-container">
			<div class="hide-if-no-js">
				<div class="octopus-cf-option-button" style="display: <?php echo ( !empty($image) || !empty($font_icon)) ? 'none' : 'block'?>;">
					<input class="octopus-cf-add-font-icon button" type="button" value="<?php _e('Add font icon', 'octopus');?>" />
					<input class="octopus-cf-add-image button" type="button" value="<?php _e('Add image', 'octopus');?>" />
				</div>
				<div class="octopus-cf-add-font-icon-container octopus-cf-field-custom" style="display: <?php echo ( empty($font_icon) ) ? 'none' : 'block'?>;">
					<label for="<?php echo $this->get_field_id( 'font_icon' ); ?>"><?php esc_html_e( 'Icon: ', 'octopus' ); ?></label>
					<select class="octopus-cf-icon-select2 octopus-cf-options-val regular-text" id="<?php echo $this->get_field_id( 'font_icon' ); ?>" name="<?php echo $this->get_field_name( 'font_icon' ); ?>" style="width: 70%;">
						<option value="<?php echo $font_icon; ?>" selected="selected"><?php echo $font_icon != '' ? $font_icon : ''; ?></option>
					</select>
					<a class="button octopus-cf-option-reset octopus-btn-danger" href="#">
						<i class="fa fa-trash"></i>
					</a>
				</div>
				<div class="octopus-cf-add-image-container octopus-cf-field-custom" style="display: <?php echo ( empty($image) ) ? 'none' : 'block'?>;">
					<table class="form-table">
						<tbody>
							<tr>
								<td>
									<label for="<?php echo $this->get_field_id( 'image' ); ?>"><?php _e( 'Select or upload an image', 'octopus' ); ?></label><br />
									<input class="octopus-cf-options-val widefat" id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" value="<?php echo $image ?>" type="hidden" />
									<a class="button octopus-cf-image-upload-button" href="#" onclick="octopus_cf_media_button_click('<?php _e('Choose feature image', 'octopus');?>','<?php _e('Select', 'octopus');?>','image','octopus-cf-image-preview-<?php echo $this->id; ?>','<?php echo $this->get_field_id( 'image' );  ?>');">
										<i class="fa fa-upload"></i>
									</a>
									<a class="button octopus-cf-option-reset octopus-btn-danger" href="#">
										<i class="fa fa-trash"></i>
									</a>
								</td>
								<td>
									<div class="octopus-cf-image-preview" id="octopus-cf-image-preview-<?php echo $this->id;?>">
										<?php if ($image!='') echo wp_get_attachment_image( $image, 'thumbnail' ); ?>				
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php esc_html_e( 'Description:', 'octopus' ); ?></label>
				<textarea class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>"><?php echo $description; ?></textarea>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php esc_html_e( 'Link:', 'octopus' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo $link; ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'color' ); ?>"><?php esc_html_e( 'Color:', 'octopus' ); ?></label>
				<select id="<?php echo $this->get_field_id( 'color' ); ?>" name="<?php echo $this->get_field_name( 'color' ); ?>">
					<?php foreach (get_octopus_colors_schema() as $key => $value):?>
						<option value="<?php echo $key;?>"><?php echo $value;?></option>
					<?php endforeach;?>
				</select>
			</p>
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
		$instance ['font_icon'] = (! empty ( $new_instance ['font_icon'] )) ? strip_tags ( $new_instance ['font_icon'] ) : '';
		$instance ['image'] = (! empty ( $new_instance ['image'] )) ? strip_tags ( $new_instance ['image'] ) : '';
		$instance ['description'] = (! empty ( $new_instance ['title'] )) ? strip_tags ( $new_instance ['description'] ) : '';
		$instance ['title'] = (! empty ( $new_instance ['title'] )) ? strip_tags ( $new_instance ['title'] ) : '';
		$instance ['link'] = (! empty ( $new_instance ['link'] )) ? strip_tags ( $new_instance ['link'] ) : '';
		$instance ['color'] = (! empty ( $new_instance ['color'] )) ? strip_tags ( $new_instance ['color'] ) : 'navy';
		return $instance;
	}
} // class Octopus_Feature_Widget end
  

