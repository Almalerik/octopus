<?php
if (! class_exists ( 'WP_Customize_Control' ))
	return NULL;

/**
 * A class to create a dropdown for all google fonts
 */
class Google_Font_Dropdown_Custom_Control extends WP_Customize_Control {
	private $fonts = false;
	public function __construct($manager, $id, $args = array(), $options = array()) {
		$this->fonts = $this->get_fonts ('all');
		parent::__construct ( $manager, $id, $args );
	}
	
	/**
	 * Render the content of the category dropdown
	 *
	 * @return HTML
	 */
	public function render_content() {
		if (! empty ( $this->fonts )) {
			?>
<label>
	<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	<select <?php $this->link(); ?>>
		<option value=""></option>
                        <?php
			foreach ( $this->fonts as $k => $f ) {
				printf ( '<optgroup label="%s">', $f->family );
				foreach ( $f->variants as $v ) {
					$value = $f->family . ':' . $v;
					printf ( '<option value="%s" %s>%s</option>', $value, selected ( $this->value (), $value, false ), $f->family . ' ' . $v );
				}
				printf ( '</optgroup>' );
			}
			?>
     </select>
</label>
<?php
		}
	}
	
	/**
	 * Get the google fonts from the API or in the cache
	 *
	 * @param integer $amount        	
	 *
	 * @return String
	 */
	public function get_fonts($amount = 30) {
		$selectDirectory = get_stylesheet_directory () . '/wordpress-theme-customizer-custom-controls/select/';
		$selectDirectoryInc = get_stylesheet_directory () . '/inc/wordpress-theme-customizer-custom-controls/select/';
		
		$finalselectDirectory = '';
		
		if (is_dir ( $selectDirectory )) {
			$finalselectDirectory = $selectDirectory;
		}
		
		if (is_dir ( $selectDirectoryInc )) {
			$finalselectDirectory = $selectDirectoryInc;
		}
		
		$fontFile = $finalselectDirectory . '/cache/google-web-fonts.txt';
		
		if (file_exists ( $fontFile )) {
			$content = json_decode ( file_get_contents ( $fontFile ) );
		}
		
		if ($amount == 'all') {
			return $content->items;
		} else {
			return array_slice ( $content->items, 0, $amount );
		}
	}
}
?>