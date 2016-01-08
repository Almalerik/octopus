<?php
/*
 * Template for the output of the Octopus Highlight Widget
 * Override by placing a file called octopus-highlight-half-right-image.php in your active theme
 */
?>
<!-- Highlight post -->
	<div class="row octopus-highlight octopus-row-eq-height-sm">
		<div class="col-sm-6">
			<div class="octopus-highlight-text <?php echo $instance ["text_align"];?>">
				<?php echo $instance ["title"];?>
				<p><?php echo wp_trim_words( $instance ["description"], $num_words = 45, $more='&nbsp;&hellip;');?></p>
				<?php if ( $instance ["link_text"] ):?>
				<a href="#" class="btn btn-primary"><?php esc_html_e("Read more ...", "octopus");?></a>
				<?php endif;?>
			</div>	
		</div>
		<div class="col-sm-6 octopus-background-fullpage" style="background-image: url('<?php echo $instance ["image"];?>');">
			<img src="<?php echo $instance ["image"];?>" alt="<?php echo $instance ["image_alt"];?>" title="<?php echo $instance ["image_alt"];?>" class="attachment-full wp-post-image invisible" />
		</div>
	</div>
<!-- #Highlight post -->