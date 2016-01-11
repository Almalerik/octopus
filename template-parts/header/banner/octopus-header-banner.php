	<?php if ( octopus_get_option('header_banner_show') ):?>
		<?php if ( octopus_get_option('header_banner') !=  '' ):?>
			<?php 
				$slides = get_post_meta ( octopus_get_option('header_banner'), '_octopus_slides', true );
				$meta = get_post_meta ( octopus_get_option('header_banner') );
			?>
			<div class="octopus-header-banner text-center">
				<div class="swiper-container<?php echo count($slides) > 1 ? ' octopus-swiper' : ''; echo isset( $meta['_octopus_slider_settings_nav_buttons']) ? ' octopus-swiper-nav-buttons' : '';?>">
					<div class="swiper-wrapper">
						<?php foreach ( $slides as $slide ): ?>
							<div class="swiper-slide" style="background-image: url('<?php echo wp_get_attachment_url( $slide['image_id']); ?>');">
								<div class="swiper-slide-caption-table">
									<div class="swiper-slide-caption-table-cell octopus-slider-overlay">
										<div class="octopus-slide-caption">
											<?php if ($slide["title"]) : ?>
											<h2>
												<span><?php echo esc_html($slide["title"]);?></span>
											</h2>
											<?php endif;?>
											<?php if ($slide["subtitle"]) : ?>
											<p class="octopus-banner-subtitle">
												<span><?php echo esc_html($slide["subtitle"]);?></span>
											</p>
											<?php endif;?>
											<p class="octopus-banner-link">
												<?php if ($slide["first_button_text"]) : ?>
												<a href="#" class="octopus-slide-btn1 btn btn-primary"><?php esc_html_e($slide["first_button_text"]);?></a>
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
					<?php if ( isset( $meta['_octopus_slider_settings_pagination'] ) ):?>
						<div class="swiper-pagination"></div>
					<?php endif;?>
					<?php if ( isset( $meta['_octopus_slider_settings_pagination'] ) ):?>
						<div class="swiper-button-next"></div>
						<div class="swiper-button-prev"></div>
					<?php endif;?>
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
										<h2>
											<span>HELLO</span>
										</h2>
										<p class="octopus-banner-subtitle">
											<span>I'm a free Worpdress theme!</span>
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