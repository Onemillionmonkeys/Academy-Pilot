<?php
/*
* Template Name: Chart Initiative
*/
 get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<titlebar>
        <h1><?php the_title(); ?></h1>
    </titlebar>
	<column class="col-4 col-chart-action">
        <div class="filterbar filterbar-initiative">   
             <factionbar>
                <?php 
                    $cnt = 0; 
                    $factions_type = get_terms('faction-tax');
                    foreach ( $factions_type as $faction_type ) :
                    if(++$cnt > 1) { echo '<span class="splitter"></span>'; } 
                ?>
                    <faction factionselect="<?php echo $faction_type->slug; ?>" showfaction="show">
                        <div class="<?php echo $faction_type->slug; ?>"></div>
                    </faction>
                <?php endforeach; ?>

                
            </factionbar>
    	    <actionbar class="action-select-bar">
				<?php 

                    for( $cnt = 6; $cnt >= 1; $cnt-- ) :
                    if($cnt != 6) { echo '<span class="splitter"></span>'; } 
                ?>
                    <action actionselect="<?php echo $cnt; ?>" showupgrade="show">
                        <div class=""><h3><?php echo $cnt; ?></h3></div>
                    </action>
                <?php endfor; ?>

            </actionbar>
        </div>
    	<?php 
			$posts = get_posts(array(
				'post_type' => 'ship',
				'posts_per_page'=>-1,
				'orderby' => 'name',
				'order' => 'ASC',
				'meta_query' => array(
					array(
						'key' => 'second_edition',
						'compare' => '==',
						'value' => '1'
					)
				)
			));	?>
            <?php if( $posts ): ?>
				<?php foreach( $posts as $post ): setup_postdata($post); ?>
					
						<?php
						$configurations = get_posts(array(
						'post_type' => 'ship-configuration',
								'meta_query' => array(
									array(
										'key' => 'ship', // name of custom field
										'value' => '"' . get_the_ID() . '"', // matches exactly "123", not just 123. This prevents a match for "1234"
										'compare' => 'LIKE'
									)
								)
							));
							?>
							<?php if( $configurations ): ?>
								<?php foreach( $configurations as $conf): ?>
                                    <div class="chart-row chart-action chart-initiative" showship="yes" faction="<?php $faction = get_field('faction', $conf->ID); echo $faction->slug;; ?>" factionshow="yes">
                                        <thumbdescription>
                                            <thumbtitle>
                                                <div class="thumbtitleflex">
                                                    <h4><a href="<?php the_permalink(); ?>"><?php echo get_the_title($conf->ID); ?></a></h4>
                                                </div>
                                                <div class="thumbfaction">														 
                                                    <titleicon><faction class="<?php echo $faction->slug;; ?>"></faction></titleicon>
                                                </div>									
                                            </thumbtitle> 
                                        </thumbdescription>
                                        <div class="chart-items">
                                            <actionbar>
                                                <?php /*?><?php $cnt = 0; 
                                                    foreach ( $terms_type as $term_type ) :
                                                    if(++$cnt > 1) { echo '<span class="splitter"></span>'; } ?>
                                                    <action>
                                                        <?php 
                                                            $hasaction = 0;
                                                            if( have_rows('actions', $conf->ID) ):
                                                            while ( have_rows('actions', $conf->ID) ) : the_row();
                                                                $action = get_sub_field('action');
                                                                $linkedaction = get_sub_field('linked_action');
                                                                if($action->slug == $term_type->slug || $linkedaction->slug == $term_type->slug) {
                                                                    echo '<actioncon actiontype="'.$action->slug.'">';
                                                                    $hasaction = 1;
                                                                    echo '<div class="'.$action->slug.' '.get_sub_field('action_difficulty').'-diff" showupgrade=""></div>';
                                                                    if($linkedaction) {
                                                                        echo '<span class="linked-action"></span>';
                                                                        echo '<div class="'.$linkedaction->slug.' '.get_sub_field('linked_action_difficulty').'-diff" showupgrade=""></div>';
								                                    }
                                                                    echo '</actioncon>';
                                                                    
                                                                } 

                                                            endwhile;
                                                        endif; ?>
                                                    </action>




                                                    
                                                <?php endforeach; ?><?php */?>
                                                <?php $pilots = get_posts(array(
                                                    'post_type' => 'pilot',
                                                    'orderby' => 'meta_value_num',
                                                    'posts_per_page' => -1,				
                                                    'meta_key' => 'pilot_skill_value',
                                                    'order' => 'Desc',
                                                    'meta_query' => array(
                                                        array(
                                                            'key' => 'ship_conf', // name of custom field
                                                            'value' => '"' . $conf->ID . '"', // matches exaclty "123", not just 123. This prevents a match for "1234"
                                                            'compare' => 'LIKE'
                                                        )
                                                    )
                                                ));
                                                if( $pilots ):
                                                    for( $cnt = 6; $cnt >= 1; $cnt-- ) :
                                                        echo '<action>';
                                                            foreach( $pilots as $pilot ):
                                                                $curini = intval(get_field('pilot_skill_value', $pilot->ID));
                                                                    if($curini == $cnt) {
                                                                        echo '<actioncon actiontype="'.$curini.'" unique='.get_field('unique', $pilot->ID).'>';
                                                                            echo '<div class="'.$curini.'" showupgrade="" ></div>';
                                                                        echo '</actioncon>';   
                                                                    }
                                                            endforeach;
                                                        echo '</action>';
                                                    endfor;
                                                endif; 
                                                ?>

                                                
                                                
                                                        <?php /*?>echo '<action>';
                                                            echo '<actioncon actiontype="'.$curini.'">';
                                                                echo '<div class="'.$curini.'" showupgrade="">'.$curini.'</div>';
                                                            echo '</actioncon>';
                                                        echo '</action>';<?php */?>

                                            
                                            </actionbar>
                                        </div>
                                    </div>
								<?php endforeach; ?>
							<?php endif; ?>
                        
                <?php endforeach; wp_reset_postdata(); ?>
			<?php endif; ?>                    
    
    </column>
<?php endwhile; ?>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('.action-select-bar action').click(function() {
            if($('.action-select-bar action[showupgrade="notshow"]').size() == 0) {
               $('.action-select-bar action').attr('showupgrade','notshow');
                $(this).attr('showupgrade', 'show');
            } else if($('.action-select-bar action[showupgrade="show"]').size() == 1 && $(this).attr('showupgrade') == 'show') {
                $('.action-select-bar action').attr('showupgrade','show');
            
            } else {
                if($(this).attr('showupgrade') == 'show') {
                    $(this).attr('showupgrade','notshow');
                } else {
                    $(this).attr('showupgrade', 'show');
                }    
            }
            
			
			
			var showupgradenum = $('.action-select-bar action[showupgrade="show"]').size();
			var notshowupgradenum = $('.action-select-bar action[showupgrade="notshow"]').size();
			
            
            
			if(showupgradenum == 0 || notshowupgradenum == 0) {
				$('.chart-action').attr('showship','yes');
			} else {
                $('.chart-action').each(function() {
                    var curchart = $(this);
                    var showship = 'yes';
                    
                    $('.action-select-bar action[showupgrade="show"]').each(function() {
                        var curaction = $(this).attr('actionselect');
                        if(curchart.find('actioncon .'+curaction).size() == 0) { showship = 'no'; }
                    })
                    
                    curchart.attr('showship', showship);
                })
                
						
			
			}
		});
        
        
        $('factionbar faction').click(function() {
            if($('factionbar faction[showfaction="notshow"]').size() == 0) {
                $('factionbar faction').attr('showfaction', 'notshow');
                $(this).attr('showfaction', 'show');
            } else if($('factionbar faction[showfaction="show"]').size() == 1 && $(this).attr('showfaction') == 'show') {
               
                $('factionbar faction').attr('showfaction', 'show');
            } else {
                if($(this).attr('showfaction') == 'show') {
                    $(this).attr('showfaction', 'notshow');
                    
                } else {
                    $(this).attr('showfaction', 'show');
                    
                }    
            }
            
            $('factionbar faction').each(function() {
                var faction = $(this).attr('factionselect');
                if($(this).attr('showfaction') == 'show') {
                    $('.chart-action[faction="'+faction+'"]').attr('factionshow', 'yes');
                } else {
                    $('.chart-action[faction="'+faction+'"]').attr('factionshow', 'no');
                }
            });
            
        });
        
	});
</script>

<?php get_footer(); ?>