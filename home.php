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
		
		<?php if ( octopus_customize_show_sidebar( 'homepage_features_show' ) ):?>
			<!-- octopus-features-sidebar -->
			<section id="features" class="octopus-homepage-section">
				<div class="row octopus-features-sidebar <?php echo octopus_customize_show_sidebar( 'homepage_features_show' );?>">
					<div class="col-md-12">
						<div class="octopus-features-wrapper <?php echo octopus_get_option('homepage_features_wrapped') ? 'octopus-wrapper' : ''?>">
							<?php if ( octopus_get_option( 'homepage_features_title' ) ):?>
							<h2 class="octopus-features-title">
								<?php echo octopus_get_option( 'homepage_features_title' );?>
								<span class="octopus-decoration-line">
									<span>
										<?php echo octopus_get_option( 'homepage_features_description' );?>
									</span>
								</span>
							</h2>
							<?php endif;?>
							
							<ul class="list-inline text-center">
								<?php 
									if ( is_active_sidebar ( 'homepage-features' ) ):
									  	dynamic_sidebar( 'homepage-features' );
									else:
										locate_template( 'template-parts/examples/homepage-features.php', true, true );
									endif;
								?>
							</ul>
						</div>
					</div>
				</div>
			</section>
			<!-- #octopus-features-sidebar -->
		<?php endif;?>
		
		<?php if ( octopus_customize_show_sidebar( 'homepage_highlights_show' ) ):?>
		<!-- octopus-highlights-sidebar -->
		<section id="highlights" class="octopus-homepage-section">
			<div class="row octopus-highlights-sidebar <?php echo octopus_customize_show_sidebar( 'homepage_highlights_show' );?>">
				<div class="col-md-12">
					<div class="octopus-highlights-wrapper <?php echo octopus_get_option('homepage_highlights_wrapped') ? 'octopus-wrapper' : ''?>">
						<?php if ( octopus_get_option( 'homepage_highlights_title' ) ):?>
						<h2 class="octopus-highlights-title">
							<?php echo octopus_get_option( 'homepage_highlights_title' );?>
							<span class="octopus-decoration-line">
								<span>
									<?php echo octopus_get_option( 'homepage_highlights_description' );?>
								</span>
							</span>
						</h2>
						<?php endif;?>
						<?php dynamic_sidebar('homepage-highlights'); ?>
					</div>
				</div>
			</div>
		</section>
		<!-- #octopus-hightlights-sidebar -->
		<?php endif;?>
		
		<?php if ( octopus_get_option( 'homepage_portfolio_show' ) ):?>
		<!-- octopus-portfolio-sidebar -->
		<section id="portfolio" class="octopus-homepage-section">
			<div class="row octopus-portfolio-sidebar">
				<div class="col-md-12">
					<div class="octopus-portfolio-wrapper <?php echo octopus_get_option('homepage_portfolio_wrapped') ? 'octopus-wrapper' : ''?>">
						<?php if ( octopus_get_option( 'homepage_portfolio_title' ) ):?>
						<h2 class="octopus-portfolio-title">
							<?php echo octopus_get_option( 'homepage_portfolio_title' );?>
							<span class="octopus-decoration-line">
								<span>
									<?php echo octopus_get_option( 'homepage_portfolio_description' );?>
								</span>
							</span>
						</h2>
						<?php endif;?>
						<?php locate_template( 'template-parts/portfolio/octopus-portfolio-default.php', true, true );?>
					</div>
				</div>
			</div>
		</section>
		<!-- #octopus-portfolio-sidebar -->
		<?php endif;?>
		
		<?php if ( octopus_get_option( 'homepage_staff_show' ) ):?>
		<!-- octopus-staff-sidebar -->
		<section id="staff" class="octopus-homepage-section">
			<div class="row octopus-staff-sidebar">
				<div class="col-md-12">
					<div class="octopus-staff-wrapper <?php echo octopus_get_option('homepage_staff_wrapped') ? 'octopus-wrapper' : ''?>">
						<?php if ( octopus_get_option( 'homepage_staff_title' ) ):?>
						<h2 class="octopus-staff-title">
							<?php echo octopus_get_option( 'homepage_staff_title' );?>
							<span class="octopus-decoration-line">
								<span>
									<?php echo octopus_get_option( 'homepage_staff_description' );?>
								</span>
							</span>
						</h2>
						<?php endif;?>
						<?php locate_template( 'template-parts/staff/default.php', true, true );?>
					</div>
				</div>
			</div>
		</section>
		<!-- #octopus-staff-sidebar -->
		<?php endif;?>

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