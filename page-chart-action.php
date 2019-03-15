<?php
/*
* Template Name: Chart Actions
*/
 get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<titlebar>
        <h1><?php the_title(); ?></h1>
    </titlebar>
	<column class="col-4 col-chart-action">
        <div class="filterbar">   
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
                    $cnt = 0; 
                    $terms_type = get_terms('action-types-tax');
                    foreach ( $terms_type as $term_type ) :
                    if(++$cnt > 1) { echo '<span class="splitter"></span>'; } 
                ?>
                    <action actionselect="<?php echo $term_type->slug; ?>" showupgrade="show">
                        <div class="<?php echo $term_type->slug; ?>"></div>
                    </action>
                <?php endforeach; ?>

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
                                    <div class="chart-row chart-action" showship="yes" faction="<?php $faction = get_field('faction', $conf->ID); echo $faction->slug;; ?>" factionshow="yes">
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
                                                <?php $cnt = 0; 
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
                                                            //if($hasaction == 0) { echo '<actioncon><div class="" showupgrade=""></div></actioncon>'; }
                                                        
                                                        endif; ?>
                                                    </action>




                                                    
                                                <?php endforeach; ?>
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