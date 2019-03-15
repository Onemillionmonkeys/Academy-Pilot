<?php $tterms = get_field('upgrade_type', $upgrade->ID); if( $tterms ): foreach( $tterms as $tterm ): $slug = $tterm->slug; endforeach; endif; ?>
<div class="related-div <?php if($upgrade->ID == get_the_ID() && $noselect != 1) { echo ' selected'; } ?> <?php if($includeimg == 2) { echo 'show-thumb'; } ?>">
    <?php if($includeimg >= 1) { ?>
        <a href="<?php echo get_permalink( $upgrade->ID ); ?>" ><img class="hidden-thumb" src="<?php if(get_field('thumb', $upgrade->ID)) { $thumb = get_field('thumb', $upgrade->ID); } else { $thumb = get_field('placeholder_upgrade', 'options'); } if ($sameimg == 1) { $imgsize = 'samethumb'; } else { $imgsize = 'medium'; } echo $thumb[sizes][$imgsize]; ?>" alt="<?php echo get_the_title($upgrade->ID); ?>" itemprop="image"/></a>
    <?php } ?>
	<h4 class="configuration-title configuration-upgrade-title<?php if(get_field('unique',$upgrade->ID)) { echo ' unique'; } if($list == 'list') { echo ' upgrade-list-title'; } ?>">
        <span class="ship-type">
            <?php if($list != 'list') { echo '<span class="'.$slug.' faction"></span>'; } ?>
            <a href="<?php echo get_permalink( $upgrade->ID ); ?>" ><?php if($count > 1) echo ' <strong>['.$count.']</strong> '; ?><?php echo get_the_title( $upgrade->ID ); ?></a>
        </span>
        <?php if(get_field('rules_repeater', $upgrade->ID) && $expanded !== 1) { ?><span class="expand-btn">+</span><?php } ?>
    </h4>
    <?php if($list == 'list') { ?>
        <statpanel class="pilot upgrade-list-extra">
            <div>
                <?php if(have_rows('upgrade_cost', $upgrade->ID)) { ?>
                    <?php  while ( have_rows('upgrade_cost', $upgrade->ID) ) : the_row(); ?>
                        <?php for($au = 1; $au <= get_sub_field('upgrade_cost_amount'); $au++) {  ?>
                        <?php $altupgrade = get_sub_field('upgrade_cost_type'); echo '<stat class="faction upgrade-icon '.$altupgrade->slug.'"></stat>'; ?>
                        <?php } ?>
                    <?php endwhile; ?>
                <?php } else { ?>
                    <stat class="faction upgrade-icon <?php echo $slug; ?>"></stat>
                <?php } ?>
                <?php 
                if(get_field('faction_limit', $upgrade->ID)) { 
                    $fterms = get_field('faction_limit', $upgrade->ID);
                    
                    foreach( $fterms as $fterm ):
                        echo '<stat class="faction '.$fterm->slug.'"></stat>';
                    
                    endforeach;
                } 
                ?>
            
            </div>
            <div class="extra">
                <?php if(get_field('special_cost', $upgrade->ID)) { 
                        if(get_field('special_cost_type', $upgrade->ID) == 'size') { 
                            if( have_rows('special_size_cost', $upgrade->ID) ):

                                // loop through the rows of data
                                while ( have_rows('special_size_cost', $upgrade->ID) ) : the_row();
                                    $size = get_sub_field('sizes');
                                    echo '<stat class="squadcost"><span class="size '.$size->slug.'"></span><h4>'.get_sub_field('sizes_cost').'</h4></stat>';

                                endwhile;
                            endif;
                        } elseif(get_field('special_cost_type', $upgrade->ID) == 'agility') { 
                            if( have_rows('special_agility_cost_', $upgrade->ID) ):

                                // loop through the rows of data
                                while ( have_rows('special_agility_cost_', $upgrade->ID) ) : the_row();
                                    
                                    echo '<stat class="squadcost"><h4 class="cost-type agility">'.get_sub_field('sizes').'</h4><h4>'.get_sub_field('agility_cost').'</h4></stat>';

                                endwhile;
                            endif;
                        }
                    
                      
                ?>
                
                
                <?php } elseif(get_field('upgrades_cost', $upgrade->ID) || get_field('upgrades_cost', $upgrade->ID) == '0') { echo '<stat class="squadcost"><h4>'.get_field('upgrades_cost', $upgrade->ID).'</h4></stat>'; } ?>
            </div>
        </statpanel>
    <?php } ?>           
	<?php /*?><statpanel class="upgrade-panel">
		<?php $tterms = get_field('upgrade_type', $upgrade->ID); if( $tterms ): foreach( $tterms as $tterm ): $slug = $tterm->slug; endforeach; endif; ?>

		<stat class="<?php echo $slug; ?> upgrade-type"></stat>
		<?php $uvalue = get_field('attack_value', $upgrade->ID); if( $uvalue != '') { ?><stat class="attack"><h4><?php the_field('attack_value', $upgrade->ID); ?></h4></stat><?php } ?>
		<?php $uvalue = get_field('min_range', $upgrade->ID); if( $uvalue != '') { ?><stat class="range"><h4><?php the_field('min_range', $upgrade->ID); ?><?php if(get_field('min_range', $upgrade->ID) != get_field('max_range', $upgrade->ID)) { ?>-<?php the_field('max_range', $upgrade->ID); ?><?php } ?></h4></stat><?php } ?>
		                                       
	</statpanel><?php */?>
    <div class="hidden-div <?php echo $hidden; ?>">
        <?php
            if( have_rows('rules_repeater', $upgrade->ID) ):
                while ( have_rows('rules_repeater', $upgrade->ID) ) : the_row();
        ?>
		
            <?php if(get_sub_field('text')) { ?>
            <rules>
                <?php if(get_sub_field('title')) { echo '<h5>'.get_sub_field('title').'</h5>'; } ?>
                <?php the_sub_field('text'); ?>
            </rules>
            <?php } ?>
            <?php if(get_field('upgrade_actions', $upgrade->ID) ): $actionnum = 0; else : $actionnum = -1; endif; ?>
            <?php if(get_sub_field('stats') || $actionnum == 0) { ?>

                <actionbar <?php if($actionnum != 0) echo 'class="only-stats"'; ?>>
                    <?php if(get_sub_field('stats')) { ?>
                        <statpanel class="upgrade">
                            <?php if(get_sub_field('arc')) {
                                echo '<arcs>';
                                $arcs = get_sub_field('arc');
                                foreach($arcs as $arc) {
                                    echo '<arc class="'.$arc->slug.'"></arc>';
                                }

                                echo '</arcs>';
                            } ?>
                            <?php if(get_sub_field('attack_value')) { echo '<stat class="attack"><h4>'.get_sub_field('attack_value').'</h4></stat>'; } ?>
                            <?php if(get_sub_field('min_range')) { echo '<stat class="range">';
                            if(get_sub_field('no_range_bonus')) { echo '<norange></norange>'; }
                            echo '<h4>'.get_sub_field('min_range'); if(get_sub_field('max_range')) { echo '-'.get_sub_field('max_range'); } echo '</h4></stat>'; } ?>

                            <?php if(get_sub_field('additional_stat')) { ?><stat class="<?php the_sub_field('additional_stat_type'); ?>"><h4><?php the_sub_field('additional_stat'); ?></h4><?php if(get_sub_field('additional_stat_regain')) { echo '<regain></regain>'; } ?></stat><?php } ?>
                            <?php if(get_sub_field('extra_additional_stat')) { ?><stat class="<?php the_sub_field('extra_additional_stat_type'); ?>"><h4><?php the_sub_field('extra_additional_stat'); ?></h4><?php if(get_sub_field('extra_additional_stat_regain')) { echo '<regain></regain>'; } ?></stat><?php } ?>
                        </statpanel>
                    <?php } ?>

                    <?php
                        if( have_rows('upgrade_actions') ): $actionnum = 0; while ( have_rows('upgrade_actions') ) : the_row();
                            $action = get_sub_field('action');
                            if($action) { ?>
                                <?php if($actionnum != 0) { echo '<span class="splitter"></span>'; } $actionnum++; ?>
                                <action>
                                    <a href="<?php bloginfo('url'); ?>/action-types-tax/<?php echo $action->slug; ?>" class="<?php echo $action->slug; ?> <?php the_sub_field('action_difficulty'); ?>-diff"></a>
                                    <?php $linkedaction = get_sub_field('linked_action'); 
                                         if($linkedaction) { ?>	
                                            <span class="linked-action"></span>
                                            <a href="<?php bloginfo('url'); ?>/action-types-tax/<?php echo $linkedaction->slug; ?>" class="<?php echo $linkedaction->slug; ?> <?php the_sub_field('linke_action_difficulty'); ?>-diff"></a>

                                    <?php } ?>

                                </action>
                            <?php }
                        endwhile; endif;
                    ?>
                </actionbar>
            <?php } ?>
		
	<?php endwhile; endif; ?>
        </div>
</div>