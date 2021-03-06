<?php
/*
 * Template for the output of the Octopus Highlight Widget
 * Override by placing a file called octopus-highlight-default.php in your active theme
 */
?>
<!-- Highlight post -->
	<div class="row octopus-highlight">
		<div class="col-sm-12">
			<div style="background-image: url('<?php echo $instance ["image"];?>');" class="octopus-background-fullpage octopus-highlight-image">
				<div class="octopus-highlight-text <?php echo array_key_exists( 'text_align', $instance) ? $instance["text_align"] : '';?>">
					<?php echo $instance ["title"];?>
					<p><?php echo wp_trim_words( $instance ["description"], $num_words = 45, $more='&nbsp;&hellip;');?></p>
					<?php if ( $instance ["link_text"] ):?>
					<a href="#" class="btn btn-primary"><?php esc_html_e("Read more ...", "octopus");?></a>
					<?php endif;?>
				</div>	
			</div>
		</div>
	</div>
<!-- #Highlight post -->