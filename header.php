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
	<?php include( locate_template( 'template-parts/header/' . octopus_get_option( 'header_template' ) ) );?>

	<div id="content" class="site-content row">
		
		
		
		<div class="sidebar-full col-md-12 text-center">Qui una sidebar???</div>
