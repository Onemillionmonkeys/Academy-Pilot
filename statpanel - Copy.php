<?php if(get_field('alt_primary_weapon_value')) { ?>
    <statpanel>
		<?php $value = get_field('alt_primary_weapon_value', $shipid); if( $value !== '') { ?>
			<stat class="attack <?php echo get_field('firing_arch'); ?>-arch">
				<h4><?php if(get_field('alt_primary_weapon_value', $shipid) >= 0) { echo $value; } else { echo '-'; } ?></h4>
			</stat>
		<?php } ?>
		<?php $value = get_field('alt_energy_value', $shipid); if( $value != '') { ?>
			<stat class="energy">
				<h4><?php if(get_field('alt_energy_value', $shipid) >= 0) { echo get_field('alt_energy_value', $shipid); } else { echo '-'; } ?></h4>
			</stat>
		<?php } ?>                                
		<?php $value = get_field('alt_agility_value', $shipid); if( $value != '')  { ?>
			<stat class="agility">
				<h4><?php if(get_field('alt_agility_value', $shipid) >= 0) { echo get_field('alt_agility_value', $shipid); } else { echo '-'; } ?></h4>
			</stat>
		<?php } ?>
		<?php $value = get_field('alt_hull_value', $shipid); if( $value != '')  { ?>
			<stat class="hull">
				<h4><?php if(get_field('alt_hull_value', $shipid) >= 0) {echo get_field('alt_hull_value', $shipid); } else { echo '-'; } ?></h4>
			</stat>
		<?php } ?>
		<?php $value = get_field('alt_shield_value', $shipid); if($value != '') { ?>
			<stat class="shield">
				<h4><?php if(get_field('alt_shield_value', $shipid) >= 0) {echo get_field('alt_shield_value', $shipid); } else { echo '-'; } ?></h4>
			</stat>
		<?php } ?>                        		
	</statpanel>
	
	<actionbar>
		<?php $terms = wp_get_post_terms( $shipid, 'action-types-tax' ); ?>
		<?php foreach($terms as $term) { ?>
			<a href="<?php bloginfo('url'); ?>/action-types-tax/<?php echo $term->slug; ?>" class="<?php echo $term->slug; ?>"></a>
		<?php } ?>
	</actionbar> 	
				
	<?php if( have_rows('alt_upgrades') ): ?>
		<upgradebar>
			<?php while ( have_rows('alt_upgrades') ) : the_row(); ?>
			
				<?php for($i = 1; $i <= get_sub_field('alt_upgrade_type_number'); $i++) { ?>
					<a href="<?php bloginfo('url'); ?>/upgrade-types-tax/<?php $term = get_sub_field('alt_upgrade_type'); echo $term->slug; ?>" class="<?php echo $term->slug; ?>"></a>
				<?php } ?>             
			<?php endwhile; ?>
		</upgradebar>
	<?php endif; ?>
		
	
<?php } else { ?>
	<statpanel>
		<?php $value = get_sub_field('primary_weapon_value'); if( $value !== '') { ?><stat class="attack <?php the_sub_field('firing_arch'); ?>-arch"><h4><?php if(get_sub_field('primary_weapon_value') >= 0) { the_sub_field('primary_weapon_value'); } else { echo '-'; } ?></h4></stat><?php } ?>
		<?php $value = get_sub_field('energy_value'); if( $value != '') { ?><stat class="energy"><h4><?php if(get_sub_field('energy_value') >= 0) { the_sub_field('energy_value'); } else { echo '-'; } ?></h4></stat><?php } ?>                                
		<?php $value = get_sub_field('agility_value'); if( $value != '')  { ?><stat class="agility"><h4><?php if(get_sub_field('agility_value') >= 0) {the_sub_field('agility_value'); } else { echo '-'; } ?></h4></stat><?php } ?>
		<?php $value = get_sub_field('hull_value'); if( $value != '')  { ?><stat class="hull"><h4><?php if(get_sub_field('hull_value') >= 0) {the_sub_field('hull_value'); } else { echo '-'; } ?></h4></stat><?php } ?>
		<?php $value = get_sub_field('shield_value'); if($value != '') { ?><stat class="shield"><h4><?php if(get_sub_field('shield_value') >= 0) {the_sub_field('shield_value'); } else { echo '-'; } ?></h4></stat><?php } ?>                        		
	</statpanel>
	<div class="margin-bottom">
		<?php if( have_rows('actions_bar') ): ?>
			<actionbar>
				<?php while ( have_rows('actions_bar') ) : the_row(); ?>
					<a href="<?php bloginfo('url'); ?>/action-types-tax/<?php $term = get_sub_field('action_type'); echo $term->slug; ?>" class="<?php echo $term->slug; ?>"></a>
				<?php endwhile; ?>
			</actionbar>                            
		<?php endif; ?>

		<?php
			if( have_rows('upgrades') ):
				while ( have_rows('upgrades') ) : the_row(); ?>
					<?php if( have_rows('upgrade_bar') ): ?>
						<upgradebar>
							<?php while ( have_rows('upgrade_bar') ) : the_row(); ?>
								<?php for($i = 1; $i <= get_sub_field('upgrade_type_number'); $i++) { ?>
									<a href="<?php bloginfo('url'); ?>/upgrade-types-tax/<?php $term = get_sub_field('upgrade_type'); echo $term->slug; ?>" class="<?php echo $term->slug; ?>"></a>
								<?php } ?>             
							<?php endwhile; ?>
						</upgradebar>
					<?php endif; ?>
			<?php endwhile; ?>
		<?php endif; ?>
	</div>                      
<?php } ?>