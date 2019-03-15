<div class="related-div <?php if($pilot->ID == get_the_id()) { echo ' selected'; } ?> <?php if($includeimg == 2) { echo 'show-thumb'; } ?>">
    <?php if($includeimg > 0) { ?>
        <a href="<?php echo get_permalink( $pilot->ID ); ?>" ><img class="hidden-thumb" src="<?php if(get_field('thumb', $pilot->ID)) { $thumb = get_field('thumb', $pilot->ID); } else { $thumb = get_field('placeholder_pilot', 'options'); } echo $thumb[sizes][medium]; ?>" alt="<?php echo get_the_title($pilot->ID); ?>" itemprop="image"/></a>
    <?php } ?>
    <h4 class="<?php if(get_field('unique',$pilot->ID)) { echo 'unique'; } ?>"><a href="<?php echo get_permalink( $pilot->ID ); ?>" ><?php if($count > 1) echo ' <strong>['.$count.']</strong> '; ?><?php echo get_the_title( $pilot->ID ); ?></a><?php if(get_field('rules', $pilot->ID) && $expanded !== 1) { ?><span class="expand-btn">+</span><?php } ?></h4>
    <statpanel class="pilot">
        
        <div>
            <stat class="pilotvalue"><h4><?php if(get_field('pilot_skill_value',$pilot->ID) == '0') { echo '*'; } else { echo get_field('pilot_skill_value',$pilot->ID); } ?></h4></stat>

            <?php $pilotfactionterms = get_field('faction', $pilot->ID);
            if( $pilotfactionterms ): ?>
                <?php foreach( $pilotfactionterms as $pilotfactionterm ): ?>
                        <stat class="<?php echo $pilotfactionterm->slug; ?> faction"></stat>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php /*?><?php if(get_field('elite_talent',$pilot->ID)) { ?><stat class="elite-talent"></stat><?php } ?><?php */?>
            
        </div>
        <div class="extra">
            <?php if(get_field('droid',$pilot->ID)) { ?><stat class="droid"></stat><?php } ?>
            <?php /*?><?php */?>
            <?php 
                $extras = get_field('extra_upgrades', $pilot->ID);
                if($extras) :
                    foreach($extras as $extra) :
                        if(get_field('extra_upgrade_count', $pilot->ID)) {
                            for($x = 1; $x <= get_field('extra_upgrade_count', $pilot->ID); $x++) {
                                echo '<stat class="'.$extra->slug.'"></stat>';        
                            }
                                    
                        } else {
                            echo '<stat class="'.$extra->slug.'"></stat>';        
                        }
                    endforeach;
                endif;
            ?>
            
             <?php if(get_field('force_capacity',$pilot->ID)) { ?><stat class="force <?php if(get_field('regain_force', $pilot->ID)) { echo 'regain'; } ?>"><h4><?php echo get_field('force_capacity',$pilot->ID); ?></h4></stat><?php } ?>
            <?php if(get_field('energy',$pilot->ID)) { ?><stat class="energy_capacity <?php if(get_field('regain_energy', $pilot->ID)) { echo 'regain'; } ?>"><h4><?php echo get_field('energy',$pilot->ID); ?></h4></stat><?php } ?>
            <?php if(get_field('point_cost', $pilot->ID)) { ?><stat class="squadcost"><h4><?php echo get_field('point_cost',$pilot->ID); ?></h4></stat><?php } ?>
        </div>
    </statpanel>
    <?php if(get_field('rules', $pilot->ID)) { ?>
        <div class="hidden-div <?php echo $hidden; ?>">
            <rules>
                <?php the_field('rules', $pilot->ID); ?>
            </rules>
        </div>
    <?php } ?>
	<?php $expanded = 0; ?>
</div>