	<header id="masthead" class="site-header row octopus-logo-right <?php octopus_get_header_css_class();?>" role="banner">
		
		<nav id="site-navigation" class="navbar navbar-default octopus-navbar-default" role="navigation">
			
			<div class="octopus-navbar-wrapper <?php echo octopus_get_option('header_wrapped') ? 'octopus-wrapper' : ''?>">
			
				<div class="navbar-header">
					
					<div class="site-branding">
						
						<div class="site-title-wrapper">
							<?php if ( is_front_page() && is_home() ) : ?>
							<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<?php else : ?>
							<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
							<?php endif; ?>
		
							<?php $description = get_bloginfo( 'description', 'display' );
							  if ( $description || is_customize_preview() ) : ?>
							<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
							<?php	endif; ?>
						</div>
						
						<div class="site-logo-wrapper">
							<a href="<?php echo esc_url( home_url( '/' ) );?>" rel="home">
								<img src="<?php echo octopus_get_logo();?>" alt="<?php echo get_bloginfo('title');?>" class="site-logo image-responsive">
							</a>
						</div>
						
					</div><!-- .site-branding -->
		
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="screen-reader-text"><?php esc_html_e( 'Primary Menu', 'octopus' ); ?></span>
						<span class="icon-bar top-bar"></span>
						<span class="icon-bar middle-bar"></span>
						<span class="icon-bar bottom-bar"></span>
					</button>
				
				</div><!-- .navbar-header -->
				
				<div id="navbar" class="navbar-collapse collapse" role="navigation" aria-label="<?php esc_html_e( 'Primary Menu', 'octopus' );?>" aria-expanded="false">
					<?php wp_nav_menu( array( 
							'theme_location' 	=> 'primary', 
							'menu_id' 			=> 'primary-menu',
							'container' 		=> false,
							'items_wrap' 		=> '<ul id="%1$s" class="nav navbar-nav octopus-navbar-nav" role="menubar">%3$s</ul>',
							'fallback_cb'		=> 'wp_bootstrap_navwalker::fallback',
							'walker' 			=> new Octopus_Walker()
					) );?>
				</div>
				<div class="clearfix"></div>
			</div>
		</nav><!-- #site-navigation -->

		<div class="clearfix"></div>
		
		<?php locate_template( 'banner/octopus-header-banner.php' );?>
		
	</header><!-- #masthead -->