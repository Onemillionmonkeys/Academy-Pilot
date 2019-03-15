 <?php if( have_rows('maneuver-template', $man_ID) ): ?>
 	<?php $manarray = array(0,0,0,0,0,0,0,0,0,0,0); ?>
	<?php while ( have_rows('maneuver-template', $man_ID) ) : the_row(); ?>
    	<?php if(get_sub_field('left_turn') != '0') { $manarray[1] = 1; } ?>
    	<?php if(get_sub_field('left_bank') != '0') { $manarray[2] = 1; } ?>        
    	<?php if(get_sub_field('straight') != '0') { $manarray[3] = 1; } ?>        
    	<?php if(get_sub_field('right_bank') != '0') { $manarray[4] = 1; } ?>        
    	<?php if(get_sub_field('right_turn') != '0') { $manarray[5] = 1; } ?>        
        <?php if(get_sub_field('koiogran_turn') != '0') { $manarray[6] = 1; } ?>
        <?php if(get_sub_field('segnors_loop_left') != '0') { $manarray[7] = 1; } ?>
        <?php if(get_sub_field('segnors_loop_right') != '0') { $manarray[8] = 1; } ?>
		<?php if(get_sub_field('tallon_roll_left') != '0') { $manarray[9] = 1; } ?>
        <?php if(get_sub_field('tallon_roll_right') != '0') { $manarray[10] = 1; } ?>        
	
	
	<?php endwhile; ?>
    <maneuvertemplate>
        <?php while ( have_rows('maneuver-template', $man_ID) ) : the_row(); ?>
            <maneuverbar>
                <maneuverbox class="speed-<?php the_sub_field('speed'); ?>"></maneuverbox>
                <?php if($manarray[9] == 1) { ?><maneuverbox class="tallon-roll-left man-diff-<?php the_sub_field('tallon_roll_left'); ?>"></maneuverbox><?php } ?>
				<?php if($manarray[7] == 1) { ?><maneuverbox class="segnors-loop-left man-diff-<?php the_sub_field('segnors_loop_left'); ?>"></maneuverbox><?php } ?>
				<?php if($manarray[1] == 1) { ?><maneuverbox class="left-turn man-diff-<?php the_sub_field('left_turn'); ?>"></maneuverbox><?php } ?>
                <?php if($manarray[2] == 1) { ?><maneuverbox class="left-bank man-diff-<?php the_sub_field('left_bank'); ?>"></maneuverbox><?php } ?>
                <?php if($manarray[3] == 1) { ?>
					<?php if(get_sub_field('speed') == 0) { ?>
                        <maneuverbox class="stationary man-diff-<?php the_sub_field('straight'); ?>"></maneuverbox>
                    <?php } else { ?>
                        <maneuverbox class="straight man-diff-<?php the_sub_field('straight'); ?>"></maneuverbox>                            
                    <?php } ?> 
				<?php } ?>                                                   
                <?php if($manarray[4] == 1) { ?><maneuverbox class="right-bank man-diff-<?php the_sub_field('right_bank'); ?>"></maneuverbox><?php } ?>
                <?php if($manarray[5] == 1) { ?><maneuverbox class="right-turn man-diff-<?php the_sub_field('right_turn'); ?>"></maneuverbox><?php } ?>
                <?php if($manarray[8] == 1) { ?><maneuverbox class="segnors-loop-right man-diff-<?php the_sub_field('segnors_loop_right'); ?>"></maneuverbox><?php } ?>
				<?php if($manarray[10] == 1) { ?><maneuverbox class="tallon-roll-right man-diff-<?php the_sub_field('tallon_roll_right'); ?>"></maneuverbox><?php } ?>
				<?php if($manarray[6] == 1) { ?><maneuverbox class="koiogran-turn man-diff-<?php the_sub_field('koiogran_turn'); ?>"></maneuverbox><?php } ?>
            </maneuverbar>
            
        <?php endwhile; ?>
    </maneuvertemplate>
<?php endif; ?>