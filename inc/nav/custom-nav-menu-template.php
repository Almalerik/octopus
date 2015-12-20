<div class="loungeact-menu-options loungeact-cf-container description-wide">
	<div class="loungeact-cf-option-button hide-if-no-js" style="display: <?php echo ( !empty($item->loungeact_icon) || !empty($item->loungeact_image) || !empty($item->loungeact_custom_html)) ? 'none' : 'block'?>;">
		<p>
			<a href="#" class="loungeact-cf-add-font-icon button"><?php esc_html_e('Add font icon', 'loungeact');?></a>
			<a href="#" class="loungeact-cf-add-image button"><?php esc_html_e('Add image', 'loungeact');?></a>
			<a href="#" class="loungeact-cf-add-custom button"><?php esc_html_e('Add custom html', 'loungeact');?></a>
		</p>
		<div class="clear"></div>
	</div>
	<div class="loungeact-cf-add-font-icon-container loungeact-cf-field-custom description-wide" style="display: <?php echo ( empty($item->loungeact_icon) ) ? 'none' : 'block'?>;">
		<p class="description description-wide">
			<label for="edit-menu-item-loungeact-icon-<?php echo $item_id; ?>"><?php esc_html_e( 'Icon: ', 'loungeact' ); ?><br>
			<select class="loungeact-cf-icon-select2 loungeact-cf-options-val regular-text" id="edit-menu-item-loungeact-icon-<?php echo $item_id; ?>"
				name="menu-item-loungeact-icon[<?php echo $item_id; ?>]">
				<option value=""><?php esc_html_e( 'None' ); ?></option>
				<?php foreach (get_loungeact_fontawesome_list() as $label => $css_class): ?>
				<option value="<?php echo esc_attr( $css_class );?>" <?php echo $css_class == $item->loungeact_icon ? 'selected' : ''; ?>><?php echo esc_html( $label );?></option>
				<?php endforeach;?>
			</select>
			<a class="button loungeact-cf-option-reset loungeact-btn-danger" href="#">
				<i class="fa fa-trash"></i>
			</a>
			</label>
		</p>
	</div>
	<div class="loungeact-cf-add-image-container loungeact-cf-field-custom description-wide" style="display: <?php echo empty($item->loungeact_image) ? 'none' : 'block'?>;">
		<p class="description description-wide">
			<label for="edit-menu-item-loungeact-image-<?php echo $item_id; ?>"><?php esc_html_e( 'Enter a URL or upload an image', 'loungeact' ); ?></label><br>
			<input class="loungeact-cf-options-val loungeact-cf-image-url widefat" id="edit-menu-item-loungeact-image-<?php echo $item_id; ?>" name="menu-item-loungeact-image[<?php echo $item_id; ?>]" value="<?php echo esc_url( $item->loungeact_image ); ?>" type="text" />
			<a class="button loungeact-cf-image-upload-button loungeact-btn-default" href="#" 
				onclick="loungeact_cf_media_button_click('<?php esc_html_e('Choose an image', 'loungeact');?>','<?php esc_html_e('Select', 'loungeact');?>','image',null,'edit-menu-item-loungeact-image-<?php echo $item_id; ?>', true);">
				<i class="fa fa-upload"></i>
			</a>
			<a class="button loungeact-cf-option-reset loungeact-btn-danger" href="#">
				<i class="fa fa-trash loungeact-color-alert"></i>
			</a>
		</p>
		<div class="loungeact-cf-image-preview" id="loungeact-cf-image-preview-<?php echo $item_id; ?>">
			<?php if ($item->loungeact_image!='') echo '<img src="' . esc_url($item->loungeact_image) . '">'; ?>				
		</div>
	</div>
	<div class="loungeact-cf-add-custom-container loungeact-cf-field-custom description-wide" style="display: <?php echo empty($item->loungeact_custom_html) ? 'none' : 'block'?>;">
		<p class="description description-wide">
			<label for="edit-menu-item-loungeact-custom-html-<?php echo $item_id; ?>"><?php esc_html_e( 'Custom html: ', 'loungeact' ); ?></label><br>
			<textarea id="edit-menu-item-loungeact-custom-html-<?php echo $item_id; ?>" class="widefat edit-menu-item-custom loungeact-cf-options-val" rows="3" cols="20"
				name="menu-item-loungeact-custom-html[<?php echo $item_id; ?>]"><?php echo esc_attr( $item->loungeact_custom_html ); ?></textarea>
			<a class="button loungeact-cf-option-reset loungeact-btn-danger" href="#">
				<i class="fa fa-trash loungeact-color-alert"></i>
			</a>
		</p>
	</div>
</div>

