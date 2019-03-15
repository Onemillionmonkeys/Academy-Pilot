<?php get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<?php $the_ID = get_the_id(); ?>
	<titlebar>
        <h1><?php the_title(); ?></h1>
    </titlebar>
    <?php $terms = get_field('faction');
    if( $terms ): ?>
    	<titlebar class="faction">
			<?php foreach( $terms as $term ): ?>
                <titleicon><faction class="<?php echo $term->slug; $factioncol .= $term->slug.'-colour '; ?>"></faction></titleicon>
            <?php endforeach; ?>
        </titlebar>
    <?php endif; ?>
    <column class="col-3 col-wrapper">
	<column class="col-3 col-thumb <?php echo $factioncol; ?>">
        <h3>Preview</h3>
        <?php if(get_field('thumb')) { ?>
            <thumbframe>
                <img src="<?php $thumb = get_field('thumb'); echo $thumb[sizes][large]; ?>" alt="<?php the_title(); ?>" itemprop="image" />
            </thumbframe>        
        <?php } ?>
        <div class="thumb-overlay"></div>
        <div class="description-con">     
            <description itemprop="description">
                <?php if(get_field('excerpt')) : ?>
                    <?php the_field('excerpt'); ?>

                <?php endif; ?>
                <?php if(get_field('not_yet_available')) : ?>
                    <p class="warning"><?php the_title(); ?> <?php the_field('not_yet_available_text','options'); ?></p><p class="warning">ETA: <?php the_field('eta'); ?></p>
                <?php endif; ?>     
            </description>
        </div>
    </column>
    
    <column class="col-3">
        <article>
       <?php /*?> <?php
        if( have_rows('content_type') ):
            while ( have_rows('content_type') ) : the_row();
                if( get_row_layout() == 'content' ):

                    the_sub_field('text');

                elseif( get_row_layout() == 'expanded_content' ): 
                    echo '<h3>'.get_sub_field('expanded_title').'</h3>';
                    echo get_sub_field('expanded_text');

                endif;

            endwhile;

        endif;
        ?><?php */?>
        <?php
        if( have_rows('content_groups') ):
            while ( have_rows('content_groups') ) : the_row();
        ?>
            <div class="content-block">
                <?php if(get_sub_field('title')) { echo '<h3>'.get_sub_field('title'); } 
                if(get_sub_field('collapse_content')) { echo '<span class="uncollapsed">–</span>';  }
                echo '</h3>'; ?>
                <div class="collapse-content" <?php  if(get_sub_field('collapse_content')) { echo 'collapsed="0"';  } ?>>
                <?php
                if( have_rows('content_types') ):
                    while ( have_rows('content_types') ) : the_row();
                        if( get_row_layout() == 'text' ):

                            the_sub_field('text_content');

                        elseif( get_row_layout() == 'ships' ): 
                            echo '<div class="column-content column-content-'.get_sub_field('container_width').' '.get_sub_field('position').'">';
                                echo '<h3>'.get_sub_field('box_title').'</h3>';
                                $ships = get_sub_field('ship');
                                echo '<div class="column-bg">';
                                if( $ships ):
                                    foreach( $ships as $p ): 
                                        echo '<div class="column-content-single">';
                                            $mainships = get_field('ship', $p->ID); foreach($mainships as $mainship) { $mainshipID = $mainship->ID ; }
                                            if(get_sub_field('show_thumb')) { 
                                                if(get_field('thumb', $mainshipID)) { $thumb = get_field('thumb', $mainshipID ); } else { $thumb = get_field('placeholder', 'options'); } 
                                                echo '<img src="'.$thumb[sizes][medium].'"/>';
                                            }
                                            $shipid = $p->ID; include(locate_template('statpanel.php'));
                                        echo '</div>';
                                    endforeach;
                                endif;
                                echo '</div>';
                            echo '</div>';
                        elseif( get_row_layout() == 'upgrades' ): 
                            echo '<div class="column-content column-content-'.get_sub_field('container_width').' '.get_sub_field('position').'">';
                                echo '<h3>'.get_sub_field('box_title').'</h3>';
                                $upgrades = get_sub_field('ship');
                                echo '<div class="column-bg">';
                                if( $upgrades ):
                                    foreach( $upgrades as $upgrade ): 
                                        echo '<div class="column-content-single">';
                                            //$mainships = get_field('ship', $p->ID); foreach($mainships as $mainship) { $mainshipID = $mainship->ID ; }
                                            if(get_sub_field('show_thumb')) { 
                                                if(get_field('thumb', $upgrade->ID)) { $thumb = get_field('thumb', $upgrade->ID ); } else { $thumb = get_field('placeholder_upgrade', 'options'); } 
                                                echo '<img src="'.$thumb[sizes][medium].'"/>';
                                            }
                                            $hidden = 'hidden';
                                            include('upgradepanel.php');
                                        echo '</div>';
                                    endforeach;
                                endif;
                                echo '</div>';
                            echo '</div>';
                        elseif( get_row_layout() == 'pilots' ): 
                            echo '<div class="column-content column-content-'.get_sub_field('container_width').' '.get_sub_field('position').'">';
                                echo '<h3>'.get_sub_field('box_title').'</h3>';
                                $pilots = get_sub_field('ship');
                                echo '<div class="column-bg column-upgrade-bg">';
                                if( $pilots ):

                                    foreach( $pilots as $pilot ): 
                                        echo '<div class="column-content-single">';
                                            //$mainships = get_field('ship', $p->ID); foreach($mainships as $mainship) { $mainshipID = $mainship->ID ; }
                                            if(get_sub_field('show_thumb')) { 
                                                if(get_field('thumb', $pilot->ID)) { $thumb = get_field('thumb', $pilot->ID ); } else { $thumb = get_field('placeholder_pilot', 'options'); } 
                                                echo '<img src="'.$thumb[sizes][medium].'"/>';
                                            }
                                            $hidden = 'hidden';
                                            include('pilotpanel.php');
                                        echo '</div>';
                                    endforeach;
                                endif;
                                echo '</div>';
                            echo '</div>';
                        elseif( get_row_layout() == 'lists' ): 
                            echo '<div class="column-content list-column-bg">';
                                echo '<p><strong>'.get_sub_field('list_title').'</strong></p>';
                                if(get_sub_field('show_graph')) { $sg = 1; } else { $sg = 0; }
                                $gc = get_sub_field('graph_colour');
                                echo '<div class="list-content list-bg-'.$sg.'">';
                                    if( have_rows('list_repeater') ):
                                        while ( have_rows('list_repeater') ) : the_row();
                                            echo '<p>';
                                            if($sg == 1) { echo '<span class="graph graph-'.$gc.'" style="width: '.intval(get_sub_field('value')).'%"></span>'; }                        
                                            echo '<span class="string">'.get_sub_field('string').'</span>';
                                            
                                            echo '<span class="value">'.get_sub_field('value').'</span>';
                                            echo '</p>';
                                        endwhile;
                                    endif;
                                echo '</div>';
                            echo '</div>';
                        elseif( get_row_layout() == 'wrapper_start' ): 
                            echo '<div class="wrapper-start">';
                        elseif( get_row_layout() == 'wrapper_end' ): 
                            echo '</div>';
                        endif; // end flex
                    endwhile;

                endif;
                ?>    
            </div>
            </div>
        <?php
            endwhile;
        endif;
        ?>
        

        </article>
    </column>
</column>
<column class="col-1 col-wrapper col-top-bottom">
    <column class="col-1">
        <?php 
            $guides = get_posts(array(
                'post_type' => 'post',
                'posts_per_page' => 5,
            ));
        
        ?>
        <?php if( $guides ): ?>

                <h3>Guides &amp; strategies</h3>        
                <?php foreach( $guides as $guide ): ?>
                    <links class="guide">
                        <?php if(get_field('thumb', $guide->ID)) { $thumb = get_field('thumb', $guide->ID); } else { $thumb = get_field('placeholder_pilot', 'options'); } ?>
                            <thumbframe>
                                <a href="<?php echo get_permalink( $guide->ID ); ?>"><img src="<?php echo $thumb[sizes][medium]; ?>" alt="<?php echo get_the_title( $guide->ID ); ?>" /></a>
                            </thumbframe> 
                        
                        <h4><a href="<?php echo get_permalink( $guide->ID ); ?>" <?php if(get_field('unique',$guide->ID)) { echo 'class="unique"'; } ?>><?php echo get_the_title( $guide->ID ); ?></a></h4>
                        <?php if(get_field('excerpt',$guide->ID)) : ?><p><?php the_field('excerpt',$guide->ID); ?></p><?php endif; ?>
                    </links>
    
                <?php endforeach; ?>

        <?php endif; ?> 
    </column>  
    
    <column class="col-1">
        <?php include(locate_template('meta.php')); ?>    	
    </column>    
</column>
    

<?php endwhile; // end of the loop. ?>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.content-block > h3 > span').click(function() {
            
            if($(this).hasClass('collapsed')) {
                $(this).removeClass('collapsed');
                $(this).addClass('uncollapsed');
                $(this).text('–');
                $(this).parents('.content-block').find('.collapse-content').attr('collapsed', '0');
            } else {
                $(this).addClass('collapsed');
                $(this).removeClass('uncollapsed');
                $(this).text('+');
                $(this).parents('.content-block').find('.collapse-content').attr('collapsed', '1');
            }
            
        })
        
    });
</script>

<?php get_footer(); ?>