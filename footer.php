<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Octopus
 */

?>

		<?php if ( octopus_get_aside_sidebar('right')): ?>
		<div class="octopus-sidebar-right <?php echo octopus_get_aside_sidebar('right');?>">
			<?php dynamic_sidebar ( 'sidebar-right' );?>
		</div>
		<?php endif; ?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'octopus' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'octopus' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'octopus' ), 'octopus', '<a href="https://github.com/Almalerik/" rel="designer">Almalerik</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
