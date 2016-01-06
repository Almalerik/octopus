<?php
$octopus_cats = get_terms ( 'octopus_portfolio_categories' );

if ( $octopus_cats ): 
?>
	<ul class="list-inline octopus-portfolio-filters">
<?php 	
	foreach ( $octopus_cats as $octopus_cat):
?>
	<li><button class="btn bth-default" data-group="<?php echo $octopus_cat->slug;?>"><?php echo $octopus_cat->name;?></button></li>
<?php
	endforeach;
?>
	</ul>
<?php
endif;	

?>

<?php
$args = array (
		'posts_per_page' => - 1,
		'orderby' => 'title',
		'order' => 'ASC',
		'post_status' => 'publish',
		'post_type' => 'any',
		'suppress_filters' => false,
		'nopaging' => true,
		'post_type' => 'octopus_portfolio'
);

$the_query = new WP_Query( $args );
?>

<?php if ( $the_query->have_posts() ) : ?>
	<ul class="list-inline octopus-portfolio-items">
		<!-- inizio del ciclo -->
		<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
			<?php if ( has_post_thumbnail() ):
					$data_groups = array();
					foreach (wp_get_post_terms( get_the_ID(), 'octopus_portfolio_categories') as $term):
						$data_groups[] = $term -> slug;
					endforeach;
			?>
				<li data-groups="['<?php echo implode('\', \'', $data_groups); ?>']" class="octopus-portfolio-item">
				<?php the_post_thumbnail('medium');?>
				<?php the_excerpt(); ?>
				</li>
			<?php endif;?>
		<?php endwhile; ?>
		<!-- fine del ciclo -->
	</ul>
	<?php wp_reset_postdata(); ?>

<?php endif; ?>