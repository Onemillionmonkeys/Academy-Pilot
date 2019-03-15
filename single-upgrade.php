<?php acf_form_head(); ?>
<?php get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<?php $the_ID = get_the_id(); ?>
	<?php 
        $terms = get_field('upgrade_type'); 
        if( $terms ): 
            foreach( $terms as $term ): 
                $upgradeslug = $term->slug; $title = $term->name;  
            endforeach; 
        endif; 
        if(get_field('faction_limit')) { 
            $fterms = get_field('faction_limit');
            $factioncol = '';
            foreach( $fterms as $fterm ):
                $factioncol .= $fterm->slug.'-colour ';

            endforeach;
        } 
    ?>
    <titlebar>
        <h1><?php the_title(); ?></h1>
    </titlebar>
    <titlebar class="faction">
        <titleicon class="upgrade"><faction class="<?php echo $upgradeslug; ?>"></faction></titleicon>
    </titlebar>


        <column class="col-2 col-thumb <?php echo $factioncol; ?>">
            <h3><?php the_title(); ?></h3>
            <thumbframe class="desaturation">
                <img src="<?php if(get_field('thumb')) { $thumb = get_field('thumb'); } else { $thumb = get_field('placeholder_upgrade', 'options'); } echo $thumb[sizes][large]; ?>" alt="<?php the_title(); ?>" itemprop="image"/>
            </thumbframe>        
            
            <div class="thumb-overlay"></div>
                <article> 
                    <description>
                        <?php if(get_field('description')) : ?>            
                            <?php the_field('description'); ?>
                            <?php if(get_field('source')) : ?>
                                <a class="source" href="<?php the_field('source'); ?>" rel="nofollow" target="_blank">Source</a>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php $terms = get_field('upgrade_type'); if( $terms ): foreach( $terms as $term ): $upgradeslug = $term->slug; $title = $term->name;  endforeach; endif; ?>
                            <p><?php the_title(); ?> is one of the <?php echo $title; ?> upgrades from the Star Wars X-Wing Miniatures Game</p>
                        <?php endif; ?>     
                    </description>
                </article>
        </column>
        <column class="col-2 col-wrapper">
            <column class="col-1 related-div">            
                <h3>Upgrade</h3>
                <?php
                    if( have_rows('rules_repeater') ): 
                        while ( have_rows('rules_repeater') ) : the_row();
                ?>
                <div class="upgrade-content">
                    <?php if(get_sub_field('alt_thumb')) { ?>
                        <thumbframe class="desaturation">
                            <img src="<?php if(get_sub_field('alt_thumb')) { $thumb = get_sub_field('alt_thumb'); } else { $thumb = get_field('placeholder_upgrade', 'options'); } echo $thumb[sizes][medium]; ?>" alt="<?php the_title(); ?>" itemprop="image"/>
                        </thumbframe>
                    <?php } ?>
                    <h4 class="configuration-title<?php if(get_field('unique')) { echo ' unique'; } ?>">
                        <span class="ship-type">
                            <span class="content-title"><?php if(get_sub_field('title')) { echo get_sub_field('title'); } else { echo get_the_title(); } ?></span>
                        </span>
                    </h4>
                    <statpanel class="pilot upgrade-list-extra">
                        <div>
                            <?php if(have_rows('upgrade_cost')) { ?>
                                <?php  while ( have_rows('upgrade_cost') ) : the_row(); ?>
                                    <?php for($au = 1; $au <= get_sub_field('upgrade_cost_amount'); $au++) {  ?>
                                    <?php $altupgrade = get_sub_field('upgrade_cost_type'); echo '<stat class="faction upgrade-icon '.$altupgrade->slug.'"></stat>'; ?>
                                    <?php } ?>
                                <?php endwhile; ?>
                            <?php } elseif(get_sub_field('alt_upgrade')) { ?>
                                <?php $altupgrade = get_sub_field('alt_upgrade'); echo '<stat class="faction upgrade-icon '.$altupgrade->slug.'"></stat>'; ?>
                            <?php } else { ?>
                                <stat class="faction upgrade-icon <?php echo $term->slug; ?>"></stat>
                            <?php } ?>
                            <?php 
                            if(get_field('faction_limit')) { 
                                $fterms = get_field('faction_limit');

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
                    <?php /*?><?php if(get_field('cost')) { ?><stat class="squadcost"><h4><?php echo get_field('cost'); ?></h4></stat><?php } ?><?php */?>
                    <?php if(get_sub_field('text')) { ?>
                        <rules>
                            <?php the_sub_field('text'); ?>
                        </rules>
                    <?php } ?>
                    <?php if(get_field('upgrade_actions') ): $actionnum = 0; else : $actionnum = -1; endif; ?>
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
                                    <?php if(get_sub_field('min_range')) { 
                                        echo '<stat class="range">';
                                        if(get_sub_field('no_range_bonus')) { echo '<norange></norange>'; }
                                        echo '<h4>'.get_sub_field('min_range'); if(get_sub_field('max_range')) { echo '-'.get_sub_field('max_range'); } echo '</h4></stat>'; 
                                    } ?>
                                    
                                    <?php if(get_sub_field('additional_stat')) { ?><stat class="<?php the_sub_field('additional_stat_type'); ?>"><h4><?php the_sub_field('additional_stat'); ?></h4><?php if(get_sub_field('additional_stat_regain')) { echo '<regain></regain>'; } ?></stat><?php } ?>
                                     <?php if(get_sub_field('extra_additional_stat')) { ?><stat class="<?php the_sub_field('extra_additional_stat_type'); ?>"><h4><?php the_sub_field('extra_additional_stat'); ?></h4><?php if(get_sub_field('extra_additional_stat_regain')) { echo '<regain></regain>'; } ?></stat><?php } ?>
                                    <?php if(get_sub_field('extra_extra_additional_stat')) { ?><stat class="<?php the_sub_field('extra_extra_additional_stat_type'); ?>"><h4><?php the_sub_field('extra_extra_additional_stat'); ?></h4><?php if(get_sub_field('extra_extra_additional_stat_regain')) { echo '<regain></regain>'; } ?></stat><?php } ?>
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
                    
                    
                               
                                
                </div>
                <?php
                        endwhile;
                    endif;
                ?>
                
                
                <?php if(get_field('limits')) { ?>
                    <div class="limitations">
                        <p>
                        <?php
                            $separator = '';
                            if(get_field('size_limit')) {
                                $sterms = get_field('size_limit');
                                $sizelimit = array(); 
                                $termnum = 1;
                                $termcount = count($sterms);
                                foreach( $sterms as $sterm ): 
                                    array_push($sizelimit, $sterm->slug);
                                    if($termnum > 1 && $termnum != $termcount) {
                                        echo ', ';
                                    }
                                    if($termnum > 1 && $termnum == $termcount) {
                                        echo ' or ';
                                    }
                                    echo $sterm->name;
                                    $termnum++;
                                endforeach;
                                echo ' ship';
                                $separator = ', ';
                            }
                        ?>
                        
                        <?php 
                            if(get_field('faction_limit')) {
                                echo $separator;
                                $fterms = get_field('faction_limit');
                                $faction = array(); 
                                $termnum = 1;
                                $termcount = count($fterms);
                                
                                foreach( $fterms as $fterm ): 
                                    array_push($faction, $fterm->slug);
                                    if($termnum > 1 && $termnum != $termcount) {
                                        echo ', ';
                                    }
                                    if($termnum > 1 && $termnum == $termcount) {
                                        echo ' or ';
                                    }
                                    if($fterm->slug == 'empire') { echo 'Empire'; };
                                    if($fterm->slug == 'rebel') { echo 'Rebel'; }; 
                                    if($fterm->slug == 'scum-and-villainy') { echo 'Scum'; }; 
                                    if($fterm->slug == 'first-order') { echo 'First Order'; };
                                    if($fterm->slug == 'resistance') { echo 'Resistance'; };
                                    if($fterm->slug == 'galactic-republic') { echo 'Galactic Republic'; };
                                    if($fterm->slug == 'separatist-alliance') { echo 'Separatist'; };
                                    $termnum++;
                                endforeach;
                                $separator = ', ';
                                
                            } else if(get_field('allegiance_limit')) {
                                
                                if(get_field('allegiance_limit') == "Dark Side") {
                                    $faction = array('empire', 'first-order', 'separatist-alliance');
                                }
                            }
                        ?>
                        <?php 
                            if(get_field('ship_limit')) {
                                echo $separator;
                                $xposts = get_field('ship_limit');
                                $termnum = 1;
                                $termcount = count($xposts);
                                $ship_ids = array();
                                foreach( $xposts as $p ): 
                                    if($termnum > 1 && $termnum == $termcount) {
                                        echo ' or ';
                                    }
                                    $ship_id = $p->ID;
                                    echo get_the_title($ship_id);
                                    array_push($ship_ids, $ship_id);
                                    $termnum++;
                                endforeach;
                                $separator = ', ';                              
                            }
                        ?>
                        
                         <?php 
                            if(get_field('arc_limit')) {
                                echo $separator;
                                echo '<arcs>';
                                $arcterms = get_field('arc_limit');
                                $arcslimit = array();
                                foreach( $arcterms as $arcterm ): 
                                    array_push($arcslimit, $arcterm->slug);
                                    echo '<'.$arcterm->slug.'></'.$arcterm->slug.'>';
                                endforeach;
                                echo '</arcs>';
                                $separator = ', ';                              
                            }
                        ?>
                        <?php 
                            if(get_field('allegiance_limit')) {
                                echo $separator;
                                echo get_field('allegiance_limit');
                                $separator = ', ';                              
                            }
                        ?>
                        
                        <?php 
                            if(get_field('action_limit')) { 
                                echo $separator;
                                $action_limit = get_field('action_limit');
                                if(get_field('action_limit_difficulty')) $action_limit_diff = get_field('action_limit_difficulty'); echo $action_limit_diff;
                                echo '<'.$action_limit->slug.' class="action-limit-icon">'.$action_limit->name.'</'.$action_limit->slug.'>'; 
                                $separator = ', ';
                        } ?>
                       
                        <?php
                            $upgLimits = get_field('upgrade_limit');
                            $upgLimitIndex = 0;
                            if($upgLimits) {
                                $upgLimitNames = '';
                                foreach($upgLimits as $upgLimit) {
                                    if($upgLimitIndex > 0) { $upgLimitNames .= ', '; }
                                    $upgLimitNames .= get_the_title($upgLimit);
                                    $upgLimitIndex++;
                                }
                                echo $separator;
                                echo 'or squads including '.$upgLimitNames;
                            }
                        ?>
                            
                        
                        </p>
                    </div>
                <?php } ?>
            </column>
             <?php 
                    if(have_rows('conditions')) : 
                        while ( have_rows('conditions') ) : the_row();
                ?>
                    <column class="col-1">
                        <div class="condition">
                            <h4><?php the_sub_field('condition_title'); ?></h4>
                            <?php the_sub_field('condition'); ?>
                            <?php if(get_sub_field('condition_icon')) : ?><img src="<?php $icon = get_sub_field('condition_icon'); echo $icon[sizes][thumbnail]; ?>"><?php endif; ?>
                        </div>
                    </column>
                <?php 
                        endwhile;
                    endif;
                ?>
            
        </column>


    
        
	
        
		<column class="col-2 col-wrapper col-last">
            <?php
                $pilotname = get_field('upgrade_name');
                $samepilots = get_posts(array(
                        'post_type' => 'pilot',
                        'post__not_in' => array($the_ID),
                        'meta_query' => array(
                            array(
                                'key' => 'pilot_name', // name of custom field
                                'value' => $pilotname, // matches exaclty "123", not just 123. This prevents a match for "1234"
                                'compare' => '=='
                            )
                        )
                   
                    ));
                    
                
                if($samepilots) :
                    echo '<column class="col-1 col-wrapper stm">';
                    echo '<h3 class="full-title ">'.$pilotname.' piloted ships</h3>';
                    $colpos = 1;
                    foreach($samepilots as $pilot) : ?>
                        <column class="col-1 col-res-half <?php $colpos = 1 - $colpos; echo 'col-pos-'.$colpos; ?>">
                            <?php $hidden = 'hidden'; $includeimg = 2; include(locate_template('pilotpanel.php')); ?>
                        </column>
                    <?php 
                    endforeach;
                    echo '</column>';
                endif;
            ?>
            <?php
                $pilotname = get_field('upgrade_name');
                $sameupgrades = get_posts(array(
                        'post_type' => 'upgrade',
                        'post__not_in' => array($the_ID),
                        'meta_query' => array(
                            array(
                                'key' => 'upgrade_name', // name of custom field
                                'value' => $pilotname, // matches exaclty "123", not just 123. This prevents a match for "1234"
                                'compare' => '=='
                            )
                        )
                   
                    ));
                          
                
                if($sameupgrades) :
                    echo '<column class="col-1 col-wrapper stm">';
                    echo '<h3 class="full-title">'.$pilotname.' as personnel</h3>';
                    $colpos = 1;
                    foreach($sameupgrades as $upgrade) : ?>
                        <column class="col-1 col-res-half <?php $colpos = 1 - $colpos; echo 'col-pos-'.$colpos; ?>">
                            <?php $hidden = 'hidden'; $sameimg = 1; $includeimg = 2; ; $list = 'list'; include('upgradepanel.php'); ?>
                        </column>
                    <?php 
                    endforeach;
                    echo '</column>';
                endif;
            ?>
            <column class="col-2 col-half-content"> 
                <h3><?php the_title(); ?> eligible Ships</h3>
                    

                   
                    <?php
                        $tax = array();
                
                        array_push(
                            $tax, array(
                                'taxonomy' => 'upgrade-types-tax',
                                'field' => 'slug',
                                'terms' => $upgradeslug,
                            )
                        );

                        if($faction) {
                            array_push(
                                $tax, array(
                                    'taxonomy' => 'faction-tax',
                                    'field' => 'slug',
                                    'terms' => $faction,
                                )
                            );
                        };

                        if($sizelimit) {
                            
                            array_push(
                                $tax, array(
                                    'taxonomy' => 'size-tax',
                                    'field' => 'slug',
                                    'terms' => $sizelimit,
                                )
                            );
                        };
                
                        if($arcslimit) {
                            array_push(
                                $tax, array(
                                    'taxonomy' => 'firing-arcs-tax',
                                    'field' => 'slug',
                                    'terms' => $arcslimit,
                                )
                            );
                        };
                
                        if($action_limit) {
                            
                            array_push(
                                $tax, array(
                                    'taxonomy' => 'action-types-tax',
                                    'field' => 'slug',
                                    'terms' => $action_limit->slug,
                                )
                            );
                        };


                        $ships = get_posts(array(
                            'post_type' => 'ship-configuration',
                            'posts_per_page' => -1,
                            'post__in' => $ship_ids,
                            'orderby' => 'name',
                            'order' => 'ASC',		
                            'tax_query' => array(
                                'relation' => 'AND',
                                $tax
                            )
                        ));
                        $shipnum = [];
                    ?>
                    <?php if( $ships ):  ?>
                        
                        <?php foreach( $ships as $ship ): ?>
                
                            <?php 
                                $show = true; 
                                if($action_limit_diff != '') {
                                    if( have_rows('actions', $ship->ID) ):
                                        while ( have_rows('actions', $ship->ID) ) : the_row();
                                            $sla = get_sub_field('action');
                                            $slad = get_sub_field('action_difficulty');
                                            
                                            if($action_limit->slug == $sla->slug) {

                                                if($slad != $action_limit_diff) { 
                                                    $show = false;
                                                };
                                            }
                                            
                                        endwhile;
                                    endif;
                
                                }
                            ?>
                            <?php
                                
                                if($au > 1) {
                                    
                                    $show = false;
                                    //$altupgrade
                                    if( have_rows('upgrades', $ship->ID) ):
                                        while ( have_rows('upgrades', $ship->ID) ) : the_row();
                                            $upgradetype = get_sub_field('upgrade_type');
                                            if($altupgrade->slug == $upgradetype->slug) {
                                                if(get_sub_field('upgrade_count') >= $au-1) {
                                                    $show = true;
                                                }
                                            }
                                        endwhile;
                                    endif;
                                }
                
                                if($show) {  array_push($shipnum, $ship->ID); }
                            endforeach;
                        endif; 
                            for($x = 0; $x < count($shipnum); $x++) :
                                $mainships = get_field('ship', $shipnum[$x]); foreach($mainships as $mainship) : ?>
                                    <?php if(count($shipnum) > 4) { ?>
                                        <h4 class="ship-list">
                                            <span class="ship-type">
                                                <span class="faction <?php $shipfaction = get_field('faction', $shipnum[$x]); echo $shipfaction->slug; ?>"></span>    
                                                <a href="<?php echo get_permalink($mainship->ID); ?>"><?php echo get_the_title( $shipnum[$x] ); ?></a>
                                            </span>
                                        </h4>
                                    <?php } else { ?>
                                        <div class="ship-list">
                                            <?php if(get_field('thumb', $mainship->ID)) { $shipimg = get_field('thumb', $mainship->ID); } else { $shipimg = get_field('placeholder', 'options'); } ?>
                                            <a href="<?php echo get_permalink($mainship->ID); ?>"><img src="<?php echo $shipimg[sizes][shipthumb]; ?>" alt="<?php echo get_the_title( $mainship->ID ); ?>"></a>
                                            <h4>
                                                 
                                               <span class="ship-type">
                                                    <span class="faction <?php $shipfaction = get_field('faction', $shipnum[$x]); echo $shipfaction->slug; ?>"></span>    
                                                    <a href="<?php echo get_permalink($mainship->ID); ?>"><?php echo get_the_title( $shipnum[$x] ); ?></a>
                                                </span>
                                            </h4>
                                        </div>
                                    <?php } ?>
                                
                                <?php endforeach; ?>
                        <?php endfor; ?>
            </column>
            <column class="col-1 col-wrapper">
                <?php 
                    $guides = get_posts(array(
                            'post_type' => 'post',
                            'meta_query' => array(
                                array(
                                    'key' => 'related_upgrades', // name of custom field
                                    'value' => '"' . $the_ID . '"', // matches exaclty "123", not just 123. This prevents a match for "1234"
                                    'compare' => 'LIKE'
                                )
                            )
                        ));

                ?>
                <?php if( $guides ): $num = 0; ?>
                    <column class="col-1">
                        <h3><?php the_title(); ?> Guides &amp; strategies</h3>        
                        <?php foreach( $guides as $guide ): ?>
                            <links class="guide">
                                    <?php if(++$num == 1) { ?>
                                        <thumbframe>
                                            <a href="<?php echo get_permalink( $guide->ID ); ?>"><img src="<?php $thumb = get_field('thumb', $guide->ID); echo $thumb[sizes][medium]; ?>" alt="<?php echo get_the_title( $guide->ID ); ?>" /></a>
                                        </thumbframe> 
                                    <?php } ?>
                                    <h4><a href="<?php echo get_permalink( $guide->ID ); ?>" <?php if(get_field('unique',$guide->ID)) { echo 'class="unique"'; } ?>><?php echo get_the_title( $guide->ID ); ?></a></h4>
                                    <?php if(get_field('excerpt',$guide->ID)) : ?><p><?php the_field('excerpt',$guide->ID); ?></p><?php endif; ?>
                                </links>

                        <?php endforeach; ?>
                    </column> 
                <?php endif; ?>

                <column class="col-1">

                    <?php include(locate_template('meta.php')); ?>
                    <?php /*?><?php if(is_user_logged_in()) {
                        acf_form(array(
                            'fields' => array('field_535a649ccf08b'),
                            'submit_value'	=> 'Update the post!'
                        ));
                    } ?><?php */?>
                </column>    
            </column>
 
           

                        <?php 

                             $products = get_posts(array(
                                    'post_type' => 'product',
                                    'meta_query' => array(
                                        array(
                                            'key' => 'content', // name of custom field
                                            'value' => '"' . $the_ID . '"', // matches exaclty "123", not just 123. This prevents a match for "1234"
                                            'compare' => 'LIKE'
                                        )
                                    )
                                ));

                        ?>
                        <?php if( $products ): 
                            $waveapp = false; $wavetitel = ''; $wavenum = 999;
                        ?>
                            <column class="col-1">
                                <h3><?php the_title(); ?> featured Products</h3>
                                <?php foreach( $products as $product ): ?>
                                    <h4 class="ship-list">
                                        <span class="ship-type">
                                            <?php $terms = get_field('faction', $product->ID); 
                                            foreach($terms as $term) { 
                                                echo '<span class="faction '.$term->slug.'"></span>'; 
                                            } ?>
                                            <a href="<?php echo get_permalink( $product->ID ); ?>"><?php echo get_the_title( $product->ID ); ?></a>
                                        </span>
                                    </h4>
                                    <?php 
                                        $wave = get_field('wave', $product->ID);
                                        if(intval($wave->description) < $wavenum) {
                                            $wavenum = intval($wave->description);
                                            $wavetitel = $wave->name;
                                            $waveapp = true;
                                        }
                                    ?>
                                <?php endforeach; ?>
                                <?php if($waveapp) { ?>
                                    <p>First appearance of <?php the_title(); ?>: Wave <?php echo $wavetitel; ?></p>
                                <?php } ?>
                            </column>
                        <?php endif; ?>                            


              
        </column>
    
       
    
 
		



            
        <column class="col-2 col-wrapper">
            
            <?php 
                 $upgrades = get_posts(array(
                    'post_type' => 'upgrade',
                    'posts_per_page' => -1,
                    'orderby' => 'title',
                    'order' => 'ASC',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'upgrade-types-tax',
                            'field' => 'slug',
                            'terms' => $upgradeslug
                        )
                    ),
                    'meta_query' => array(
                        array(
                            'key' => 'second_edition',
                            'compare' => '==',
                            'value' => '1'
                        )
                    )
                ));
                $ugCount = count($upgrades); 
            ?>
            <?php if( $upgrades ): ?>
                <column class="col-2 col-half-content">
                    
                    <h3 class="expand-justify"><span><?php echo $title; ?>s</span> <span class="expand-nav"><span class="show-img-btn <?php if($ugCount <= 6) { echo 'show-thumbs'; } ?>"></span><span class="expand-btn">+</span></span></h3>
                    <?php foreach( $upgrades as $upgrade ): ?>
                        <?php $hidden = 'hidden'; if($ugCount > 6) { $includeimg = 1; } else { $includeimg = 2; }; $list = 'list'; $sameimg = 0; include('upgradepanel.php'); ?>
                    <?php endforeach; ?>
                </column>
            <?php endif; ?>
            <column class="col-2">
                <h3>Upgrade Types</h3>
                <div class="upgrade-list">
                    <?php $terms_type = get_terms('upgrade-types-tax');

                    foreach ( $terms_type as $term_type ) : ?>
                        <a href="<?php bloginfo('url'); ?>/upgrade-types-tax/<?php echo $term_type->slug; ?>"><upgrade class="<?php echo $term_type->slug; ?>"></upgrade></a>
                    <?php endforeach; ?>
                </div>
            </column>
            
            
        </column>
<?php endwhile; // end of the loop. ?>



<?php get_footer(); ?>
