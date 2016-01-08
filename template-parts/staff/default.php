<?php
$args = array (
		'posts_per_page' => - 1,
		'orderby' => 'title',
		'order' => 'ASC',
		'post_status' => 'publish',
		'suppress_filters' => false,
		'nopaging' => true,
		'post_type' => 'octopus_staff'
);

$the_query = new WP_Query( $args );
?>

<?php if ( $the_query->have_posts() ) : ?>
	<ul class="list-inline octopus-staff-items">
		<!-- inizio del ciclo -->
		<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
			<?php $meta = get_post_meta( get_the_ID() );?>
			<?php if ( has_post_thumbnail() ): ?>
				<li class="octopus-staff-item">
				<?php the_post_thumbnail('thumbnail', array('class'	=> "attachment-thumbnail img-circle img-responsive center-block"));?>
				<h3 class="widget-title">
					<?php echo get_the_title();?>
					<span class="octopus-decoration"></span>
				</h3>
				<p class="octopus-staff-position"><?php echo array_key_exists ('_octopus_staff_info_occupation', $meta ) ? $meta['_octopus_staff_info_occupation'][0] : '' ;?></p>
				<ul class="list-inline octopus-staff-contacts">
					<?php foreach ( octopus_get_staff_contacts() as $key => $value ): ?>
						<?php if ( array_key_exists ('_octopus_staff_contacts_' . $key, $meta ) ): ?>
							<li><a href="<?php echo $meta['_octopus_staff_contacts_' . $key][0];?>"><span class="<?php echo $value ['icon']?>"></span></a></li>
						<?php endif;?>
					<?php endforeach;?>
				</ul>
				
				
				
				<?php the_excerpt(); ?>
				</li>
			<?php endif;?>
		<?php endwhile; ?>
		<!-- fine del ciclo -->
	</ul>
	<?php wp_reset_postdata(); ?>

<?php endif; ?>