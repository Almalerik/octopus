<?php
/**
 * The homepage template file.
 *
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Octopus
 */

get_header(); ?>

	<?php if ( octopus_get_aside_sidebar('left-sidebar')): ?>
	<div id="octopus-sidebar-left" class="<?php echo octopus_get_aside_sidebar('left-sidebar');?>">
		<?php dynamic_sidebar ( 'left-sidebar' );?>
	</div><!-- #main -->
	<?php endif; ?>

	<div id="primary" class="content-area <?php echo octopus_get_primary_column_class();?>">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>

			<?php
			endif;

			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->


	<?php if ( octopus_get_aside_sidebar('right-sidebar')): ?>
	<div id="octopus-sidebar-right" class="<?php echo octopus_get_aside_sidebar('right-sidebar');?>">
		<?php dynamic_sidebar ( 'right-sidebar' );?>
	</div>
	<?php endif; ?>
	
<?php
get_footer();