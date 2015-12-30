	<?php if ( octopus_get_option('header_banner_show') ):?>
		<?php if ( octopus_get_option('header_banner') !=  '' ):?>
			<?php $slides = get_post_meta ( octopus_get_option('header_banner'), '_octopus_slides', true ); ?>
			<div class="octopus-header-banner text-center">
				<div class="swiper-container">
					<div class="swiper-wrapper">
						<?php foreach ( $slides as $slide ): ?>
							<div class="swiper-slide" style="background-image: url('<?php echo wp_get_attachment_url( $slide['image_id']); ?>');">
								<div class="swiper-slide-caption-table">
									<div class="swiper-slide-caption-table-cell octopus-slider-overlay">
										<div class="octopus-slide-caption">
											<?php if ($slide["title"]) : ?>
											<h2 class="octopus-slide-title">
												<span><?php echo esc_html($slide["title"]);?></span>
											</h2>
											<?php endif;?>
											<?php if ($slide["subtitle"]) : ?>
											<p class="octopus-slide-subtitle">
												<span><?php echo esc_html($slide["subtitle"]);?></span>
											</p>
											<?php endif;?>
											<p class="octopus-slide-link">
												<?php if ($slide["first_button_text"]) : ?>
												<a href="#" class="octopus-slide-btn1"><?php esc_html_e($slide["first_button_text"]);?></a>
												<?php endif;?>
												<?php if ($slide["second_button_text"]) : ?>
												<a href="#" class="octopus-slide-btn2"><?php esc_html_e($slide["second_button_text"]);?></a>
												<?php endif;?>
											</p>
											
										</div>
									</div>
								</div>
							</div>
						<?php endforeach;?>
					</div>
				</div>
			</div>
			<?php else:?>
			<!-- Example banner -->
			<div class="octopus-header-banner text-center">
				<div class="swiper-container">
					<div class="swiper-wrapper">
						<div class="swiper-slide" style="background-image: url('http://almalerik.github.io/octopus/assets/images/bridge.jpeg');">
							<div class="swiper-slide-caption-table">
								<div class="swiper-slide-caption-table-cell octopus-slider-overlay">
									<div class="octopus-slide-caption">
										<h2 class="octopus-slide-title">
											<span>Octopus</span>
										</h2>
										<p class="octopus-slide-subtitle">
											<span>This is the begin ...</span>
										</p>
										<p class="octopus-slide-link">
											<a href="#" class="octopus-slide-btn1">Button 1</a>
											<a href="#" class="octopus-slide-btn2">Button 2</a>
										</p>
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- #Example banner -->
		<?php endif;?>
	<?php endif;?>