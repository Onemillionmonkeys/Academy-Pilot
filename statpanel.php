	<h4 class="configuration-title">
		<?php if($linked) { ?>
			<?php $shipclass = get_field('ship', $shipid); ?>
            <span class="ship-type"><span class="faction <?php $faction = get_field('faction', $shipid); echo $faction->slug; ?>"></span><a href="<?php echo get_the_permalink($shipclass[0]->ID).'?shipconf='.$shipid; ?>"><?php echo get_the_title( $shipid ); ?></a><span class="size <?php $size= get_field('size', $shipclass[0]->ID); echo $size->slug; ?>"></span></span>
		<?php } else { ?>
            <span class="ship-type"><span class="faction <?php $faction = get_field('faction', $shipid); echo $faction->slug; ?>"></span><a href="<?php echo get_the_permalink($shipclass[0]->ID).'?shipconf='.$shipid; ?>"><?php echo get_the_title( $shipid ); ?></a><span class="size <?php $size= get_field('size', $the_ID); echo $size->slug; ?>"></span></span>
		<?php } ?>
	</h4>
    <statpanel>
		<?php if(get_field('primary_weapon_value', $shipid)) { ?>
			<stat class="attack">
				<h4><?php echo get_field('primary_weapon_value', $shipid); ?></h4>
                <arcs>
                    <?php 
                        $arcterms = get_field('firing_arc', $shipid);
                        foreach( $arcterms as $arcterm ): 
                            echo '<arc class="'.$arcterm->slug.'""></arc>';
                        endforeach;
                     ?>
                </arcs>
                              
                            
			</stat>
		<?php } ?>
        <?php if(get_field('secondary_weapon_value', $shipid)) { ?>
			<stat class="attack">
				<h4><?php echo get_field('secondary_weapon_value', $shipid); ?></h4>
                <arcs>
                    <?php 
                        $arcterms = get_field('secondary_firing_arc', $shipid);
                        foreach( $arcterms as $arcterm ): 
                            echo '<arc class="'.$arcterm->slug.'""></arc>';
                        endforeach;
                     ?>
                </arcs>
			</stat>
		<?php } ?>
		<?php $value = get_field('alt_energy_value', $shipid); if( $value != '') { ?>
			<stat class="energy">
				<h4><?php if(get_field('alt_energy_value', $shipid) >= 0) { echo get_field('alt_energy_value', $shipid); } else { echo '-'; } ?></h4>
			</stat>
		<?php } ?>                                
		<?php $value = get_field('agilty_value', $shipid); if( $value != '')  { ?>
			<stat class="agility">
				<h4><?php echo $value; ?></h4>
			</stat>
		<?php } ?>
		<?php $value = get_field('hull_value', $shipid); if( $value != '')  { ?>
			<stat class="hull">
				<h4><?php echo $value; ?></h4>
			</stat>
		<?php } ?>
		<?php $value = get_field('shield_value', $shipid); if($value != '') { ?>
			<stat class="shield">
				<h4><?php echo $value; ?></h4>
			</stat>
		<?php } ?>
        
        
		<?php if(get_field('force_capacity', $pilotid)) { ?>
			<stat class="force">
				<h4><?php echo get_field('force_capacity', $pilotid); ?></h4>
                <?php if(get_field('regain_force', $pilotid)) { echo '<regain></regain>'; } ?>
			</stat>
		<?php } ?>
		<?php if(get_field('energy', $pilotid)) { ?>
			<stat class="energy_capacity">
				<h4><?php echo get_field('energy', $pilotid); ?></h4>
                <?php if(get_field('regain_energy', $pilotid)) { echo '<regain></regain>'; } ?>
			</stat>
		<?php } ?>
	</statpanel>
	
	<actionbar>
		<?php
		if( have_rows('actions', $shipid) ): $actionnum = 0;
			while ( have_rows('actions', $shipid) ) : the_row();
				$action = get_sub_field('action');
				if($action) { ?>
					<?php if($actionnum != 0) { echo '<span class="splitter"></span>'; } $actionnum++; ?>
					<action>
                        <?php $mainaction = $action->slug; if($mainaction == 'focus' && get_field('droid', $pilotid)) { $mainaction = 'calculate'; } ?>

						<a href="<?php bloginfo('url'); ?>/action-types-tax/<?php echo $mainaction; ?>" class="<?php echo $mainaction; ?> <?php the_sub_field('action_difficulty'); ?>-diff"></a>
						<?php $linkedaction = get_sub_field('linked_action'); 
							 if($linkedaction) { ?>
                                <?php $linkedaction = $linkedaction->slug; if($linkedaction == 'focus' && get_field('droid', $pilotid)) { $linkedaction = 'calculate'; } ?>
								<span class="linked-action"></span>
								<a href="<?php bloginfo('url'); ?>/action-types-tax/<?php echo $linkedaction; ?>" class="<?php echo $linkedaction; ?> <?php the_sub_field('linked_action_difficulty'); ?>-diff"></a>
						
						<?php } ?>
						
					</action>
				<?php }
			endwhile;
		endif;
		?>
		
	</actionbar>
    <upgradebar>
        <?php
		if( have_rows('upgrades', $shipid) ): $actionnum = 0;
			while ( have_rows('upgrades', $shipid) ) : the_row();
				$upgrade = get_sub_field('upgrade_type');
                for($x = 1; $x <= get_sub_field('upgrade_count'); $x++ ) : 
                ?>
                    <a href="<?php bloginfo('url'); ?>/upgrade-types-tax/<?php echo $upgrade->slug; ?>" class="<?php echo $upgrade->slug; ?>"></a>
                <?php
                endfor;
            endwhile;
        endif;
        ?>
        
        
    </upgradebar>
	<?php if(get_field('rules', $shipid)) { ?>
		<rules>
			<?php the_field('rules', $shipid); ?> 
		</rules>

	<?php }	?>
	<?php if( have_rows('alt_upgrades') ): ?>
		<upgradebar>
			<?php while ( have_rows('alt_upgrades') ) : the_row(); ?>
			
				<?php for($i = 1; $i <= get_sub_field('alt_upgrade_type_number'); $i++) { ?>
					<a href="<?php bloginfo('url'); ?>/upgrade-types-tax/<?php $term = get_sub_field('alt_upgrade_type'); echo $term->slug; ?>" class="<?php echo $term->slug; ?>"></a>
				<?php } ?>             
			<?php endwhile; ?>
		</upgradebar>
	<?php endif; ?>
		
	
                
