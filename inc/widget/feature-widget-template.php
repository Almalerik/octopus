<?php
/*
 * Template for the output of the Lougeact Feature Widget
 * Override by placing a file called feature-widget-template.php in your active theme
 */
?>

<!-- Feature image -->
<div class="loungeact-feature-image-wrapper">
<?php if (isset ( $instance ['image'] ) && $instance ['image'] != ''):?>
	<img class="widget-image" src="<?php echo $instance ['image']; ?>" title="<?php echo $instance ['title_text']; ?>" alt="<?php echo $instance ['title_text']; ?>" class="img-responsive img-circle" />
<?php endif;?>
<?php if (isset ( $instance ['font_icon'] ) && $instance ['font_icon'] != ''):?>
	<i class="<?php echo $instance ['font_icon']; ?> widget-icon"></i>
<?php endif;?>
</div>
<?php if (isset ( $instance ['title'] )):?>
	<?php echo $instance ['title']; ?>
<?php endif;?>
<?php if (isset ( $instance ['description'] )):?>
	<p class="widget-description text-muted"><?php echo $instance ['description']; ?></p>
<?php endif;?>
