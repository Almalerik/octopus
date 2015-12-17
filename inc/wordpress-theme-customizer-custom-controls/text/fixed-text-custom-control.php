<?php
if (! class_exists ( 'WP_Customize_Control' ))
	return NULL;

/**
 * Class to create a custom tags control
 */
class Fixed_Text_Custom_Control extends WP_Customize_Control {
	public $settings = 'blogname';
	public $description = '';
	
	/**
	 * Render the content on the theme customizer page
	 */
	public function render_content() {
		switch ($this->type) {
			default :
			case 'text' :
				echo '<p class="description">' . $this->description . '</p>';
				break;
			
			case 'heading' :
				echo '<span class="customize-control-title">' . esc_html ( $this->label ) . '</span>';
				break;
			
			case 'line' :
				echo '<hr />';
				break;
		}
	}
}
?>