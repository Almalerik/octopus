<?php
if (! class_exists ( 'WP_Customize_Control' ))
	return NULL;

/**
 * Class to create a custom layout control
 */
class Layout_Picker_Custom_Control extends WP_Customize_Control {
	/**
	 * Render the content on the theme customizer page
	 */
	public function render_content() {
		$imageDirectory = '/wordpress-theme-customizer-custom-controls/layout/img/';
		$imageDirectoryInc = '/inc/wordpress-theme-customizer-custom-controls/layout/img/';
		
		$finalImageDirectory = '';
		
		if (is_dir ( get_stylesheet_directory () . $imageDirectory )) {
			$finalImageDirectory = get_stylesheet_directory_uri () . $imageDirectory;
		}
		
		if (is_dir ( get_stylesheet_directory () . $imageDirectoryInc )) {
			$finalImageDirectory = get_stylesheet_directory_uri () . $imageDirectoryInc;
		}
		$name = '_customize-radio-' . $this->id;
		?>
<label> <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span></label>
	<ul class="custom-customize-sidebar">
		<li><img src="<?php echo $finalImageDirectory; ?>full.png"
			alt="Full Width" /><input type="radio"
			value="full"
			name="<?php echo esc_attr( $name ); ?>"
			<?php $this->link(); checked( $this->value(), 'full' ); ?> /></li>
		<li><img src="<?php echo $finalImageDirectory; ?>left.png"
			alt="Left Sidebar" /><input type="radio"
			value="left"
			name="<?php echo esc_attr( $name ); ?>"
			<?php $this->link(); checked( $this->value(), 'left' ); ?> /></li>
		<li><img src="<?php echo $finalImageDirectory; ?>right.png"
			alt="Right Sidebar" /><input type="radio"
			value="right"
			name="<?php echo esc_attr( $name ); ?>"
			<?php $this->link(); checked( $this->value(), 'right' ); ?> /></li>
        <li><img src="<?php echo $finalImageDirectory; ?>all.png"
            alt="Left and Right Sidebar" /><input type="radio"
            value="all"
            name="<?php echo esc_attr( $name ); ?>"
            <?php $this->link(); checked( $this->value(), 'all' ); ?> /></li>
	</ul>

<?php
	}
}
?>