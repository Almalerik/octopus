<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Octopus
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site <?php echo octopus_get_option('container_class');?>">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'octopus' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
			<div class="site-logo-wrapper">
				<a href="<?php echo esc_url( home_url( '/' ) );?>" rel="home">
					<img src="<?php echo octopus_get_logo();?>" alt="<?php echo get_bloginfo('title');?>" class="site-logo image-responsive">
				</a>
			</div>
			<div class="site-title-wrapper">
			<?php if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php endif;

			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) : ?>
				<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
			<?php	endif; ?>
			</div>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="navbar navbar-default navbar-static-top" role="navigation">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="screen-reader-text"><?php esc_html_e( 'Primary Menu', 'octopus' ); ?></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<div id="navbar" class="navbar-collapse collapse" role="navigation" aria-label="<?php esc_html_e( 'Primary Menu', 'octopus' );?>">
			<?php wp_nav_menu( array( 
					'theme_location' => 'primary', 
					'menu_id' => 'primary-menu',
					'container' => false,
					'items_wrap' => '<ul id="%1$s" class="%2$s nav navbar-nav" role="menubar">%3$s</ul>',
					'walker' => new LoungeAct_Walker()
			) );?>
			</nav><!-- #site-navigation -->
		</div>
		<div class="clearfix"></div>
	</header><!-- #masthead -->

	<div id="content" class="site-content row">
		
		<div class="slider col-md-12 text-center">Qui lo slider</div>
		
		<div class="sidebar-full col-md-12 text-center">Qui una sidebar???</div>
