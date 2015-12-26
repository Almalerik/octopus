
<div id='octopus-edit-slides-wrapper' class='hide-if-no-js'>
	<a href="javascript:void(0);" id="octopus-edit-slide-add" class="button">
		<i class="fa fa-plus"></i> <?php esc_html_e('Add slide', 'octopus')?>
	</a>
	<input type="hidden" id="octopus-slide-thumbnail-delete-msg" value="<?php esc_html_e("Are you sure?", "octopus")?>" />
	<ul class="octopus-sortable">
		<?php $i = 0;?>
		<?php foreach ( $slides as $slide ) : ?>
		<li <?php echo $i== 0 ? 'id="octopus-edit-slide-template" class="hidden"': ''; ?>>
			<div class="octopus-accordion">
				<h4>
					<span class="octopus-action-move">
						<i class="fa fa-arrows-v"></i>
					</span>
					<span class="octopus-accordion-thumb" id="octopus-accordion-thumb-<?php echo $i;?>"><?php echo wp_get_attachment_image( $slide['image_id'], 'thumbnail' ); ?></span>
					<span class="octopus-accordion-title"><?php echo esc_attr( $slide['title'] );?></span>
				</h4>
				<div class="octopus-accordion-content" id="#octopus-accordion-content-<?php echo $i;?>">
					<table class="form-table">
						<tbody>
							<tr>
								<td>
									<div class="octopus-slide-thumbnail">
										<input type="hidden" name="_octopus_slide[<?php echo $i;?>][image_id]" id="octopus_slide-<?php echo $i;?>-image_id" value="<?php echo $slide['image_id'];?>" />
										<a title="<?php esc_html_e('Select image', 'octopus')?>" href="javascript:void(0);" class="octopus-slide-thumbnail-add button" onclick="octopus_cf_media_button_click('<?php _e('Choose an image', 'octopus');?>','<?php _e('Select', 'octopus');?>','image',new Array('octopus_slide-<?php echo $i;?>-preview','octopus-accordion-thumb-<?php echo $i;?>'),'octopus_slide-<?php echo $i;?>-image_id');">
											<i class="fa fa-image"></i> <?php _e('Select image', 'octopus')?>
										</a>
										<div class="octopus-cf-image-preview" id="octopus_slide-<?php echo $i;?>-preview">
											<?php echo wp_get_attachment_image( $slide['image_id'], 'thumbnail' ); ?>
										</div>
									</div>
								</td>
								<td>
									<div class="octopus-slide-meta">
										<p>
											<label for="_octopus_slide[<?php echo $i;?>][title]" class="octopus-title">
												<?php _e('Title', 'octopus')?>
											</label>
											<input type="text" class="large-text octopus-slide-title" id="_octopus_slide[<?php echo $i;?>][title]" name="_octopus_slide[<?php echo $i;?>][title]" value="<?php echo esc_attr( $slide['title'] );?>" />
										</p>
										<p>
											<label for="_octopus_slide[<?php echo $i;?>][subtitle]" class="octopus-title">
												<?php _e('Subtitle', 'octopus')?>
											</label>
											<input type="text" class="large-text" id="_octopus_slide[<?php echo $i;?>][subtitle]" name="_octopus_slide[<?php echo $i;?>][subtitle]" value="<?php echo esc_attr( $slide['subtitle'] );?>" />
										</p>
										<p>
											<label for="_octopus_slide[<?php echo $i;?>][link]" class="octopus-title">
												<?php _e('Link', 'octopus')?>
											</label>
											<input type="text" class="large-text" id="_octopus_slide[<?php echo $i;?>][link]" name="_octopus_slide[<?php echo $i;?>][link]" value="<?php echo esc_attr( $slide['link'] );?>" />
										</p>
										<div class="octopus-accordion">
											<h4>
												<?php _e("First button", "octopus");?>
											</h4>
											<div class="octopus-accordion-content" id="octopus-accordion-content-button1-<?php echo $i;?>">
												<p>
													<label for="_octopus_slide[<?php echo $i;?>][first_button_text]" class="octopus-title"><?php _e('Text', 'octopus')?></label>
													<input type="text" class="large-text" id="_octopus_slide[<?php echo $i;?>][first_button_text]" name="_octopus_slide[<?php echo $i;?>][first_button_text]" value="<?php echo esc_attr( $slide['first_button_text'] );?>" />
												</p>
												<p>
													<label for="_octopus_slide[<?php echo $i;?>][first_button_url]" class="octopus-title"><?php _e('Url', 'octopus')?></label>
													<input type="text" class="large-text" id="_octopus_slide[<?php echo $i;?>][first_button_url]" name="_octopus_slide[<?php echo $i;?>][first_button_url]" value="<?php echo esc_attr( $slide['first_button_url'] );?>" />
												</p>
											</div>
											<h4>
												<?php _e("Second button", "octopus");?>
											</h4>
											<div class="octopus-accordion-content" id="octopus-accordion-content-button2-<?php echo $i;?>">
												<p>
													<label for="_octopus_slide[<?php echo $i;?>][second_button_text]" class="octopus-title"><?php _e('Text', 'octopus')?></label>
													<input type="text" class="large-text" id="_octopus_slide[<?php echo $i;?>][second_button_text]" name="_octopus_slide[<?php echo $i;?>][second_button_text]" value="<?php echo esc_attr( $slide['second_button_text'] );?>" />
												</p>
												<p>
													<label for="_octopus_slide[<?php echo $i;?>][second_button_url]" class="octopus-title"><?php _e('Url', 'octopus')?></label>
													<input type="text" class="large-text" id="_octopus_slide[<?php echo $i;?>][second_button_url]" name="_octopus_slide[<?php echo $i;?>][second_button_url]" value="<?php echo esc_attr( $slide['second_button_url'] );?>" />
												</p>
											</div>
										</div>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
					<div class="clear">
						<a href="#" class="button octopus-edit-slide-delete octopus-btn-danger">
							<i class="fa fa-trash"></i> <?php esc_html_e('Delete slide', 'octopus')?>
						</a>
					</div>
				</div>
			</div>
		</li>
		<?php $i++;?>
		<?php endforeach; ?>	
	</ul>
</div>
