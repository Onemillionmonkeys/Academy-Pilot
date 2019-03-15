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
                <titleicon><faction class="<?php echo $term->slug; $factioncol .= $term->slug.'-colour ';?>"></faction></titleicon>
            <?php endforeach; ?>
        </titlebar>
    <?php endif; ?>
	
    <column class="col-4 col-wrapper">
     <?php 
        if(get_field('thumb')) : 
            $thumb = get_field('thumb');
        else :
            $blur = '';
            $thumb = get_field('placeholder_pilot', 'options');
            $shipimgs = get_field('ship_conf');
            foreach($shipimgs as $shipimg) :
                $shimgs = get_field('ship', $shipimg->ID);
                foreach($shimgs as $shimg) :
                    if(get_field('thumb', $shimg->ID)) { $thumb = get_field('thumb', $shimg); $blur = 'blurred'; }
                endforeach;
            endforeach;
        endif; 
        ?>
    <column class="col-2 col-thumb <?php echo $factioncol.' '.$blur; ?>">
		<h3><?php if(get_field('call_sign')) { echo get_field('call_sign'); } else { echo get_the_title(); } ?></h3>    
        
            <thumbframe class="desaturation">
               
                
				<img class="<?php echo $blur; ?>" src="<? echo $thumb[sizes][pilotthumblarge]; ?>" alt="<?php the_title(); ?>" itemprop="image"/>
            </thumbframe>
            <div class="thumb-overlay"></div>
			<article>
                <description itemprop="description">
                    <?php if(get_field('description')) : ?>   
                        <?php the_field('description'); ?>
                        <?php if(get_field('source')) : ?>
                            <p>
                                <a class="source" href="<?php the_field('source'); ?>" rel="nofollow" target="_blank">Source</a>
                            </p>
                        <?php endif; ?>     
                    <?php else : ?>
                        <?php $meta = get_field('ship');
                        if( $meta ): ?>
                            <?php foreach( $meta as $m ): // variable must NOT be called $post (IMPORTANT) ?>
                                    <?php $metaship = $m->ID; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>        
                        <?php $metaterms = get_field('faction', $m->ID);
                        if( $metaterms ): ?>
                            <?php foreach( $metaterms as $metaterm ): ?>
                                <?php $metafaction = $metaterm->name; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>            
						<?php 
							$posts = get_field('ship_conf');
							if( $posts ): foreach( $posts as $p ): 
								$shiptitle = get_the_title($p->ID);	
							endforeach; endif; ?>
					
                    
					
                        <p><?php the_title(); ?> is one of the <?php echo $metafaction . ' ' . $shiptitle; ?> pilots from the Star Wars X-Wing Second Edition Miniatures Game</p>
                    
                    <?php endif; ?>                
                </description>  
            </article>                    
        
    </column>
    <column class="col-2 col-wrapper">
    	<column class="col-1">
            <h3>Pilot</h3>
            <?php $expanded = 1; ?>
            <?php include(locate_template('pilotpanel.php')); ?>
            <?php 
                if(have_rows('conditions')) : 
                    while ( have_rows('conditions') ) : the_row();
            ?>
                <div class="condition">
                    <h4><?php the_sub_field('condition_title'); ?></h4>
                    <?php the_sub_field('condition'); ?>
                    <img src="<?php $icon = get_sub_field('condition_icon'); echo $icon[sizes][thumbnail]; ?>">
                </div>

            <?php 
                    endwhile;
                endif;
            ?>
        </column>
        <column class="col-1 col-wrapper">
            <column class="col-1">
                <?php $posts = get_field('ship_conf');

                if( $posts ): ?>

                    <?php foreach( $posts as $p ): ?>
                        <h3>Ship</h3>			
                        <div class="column-content">            
                            <?php $pilotid = $the_ID; $shipid = $p->ID; $linked = true; include(locate_template('statpanel.php')); ?>	
                        </div>
                    <?php endforeach; ?>

                <?php endif; ?>

               
            </column>   
            <column class="col-1">
                <h3>Maneuvers</h3>
                <?php $shipclass = get_field('ship', $shipid); ?>
                <?php $man_ID = $shipclass[0]->ID; include(locate_template('maneuverpanel.php')); ?>
            </column> 
        </column>
                
    </column>
</column>
             

    <?php /*?><column class="col-1">
        <?php include(locate_template('meta.php')); ?>	
    </column><?php */?>
    <column class="col-2 col-wrapper col-last">
        <?php
                $pilotname = get_field('pilot_name');
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
                    $stm = true;
                    echo '<column class="col-1 col-wrapper stm">';
                    echo '<h3 class="full-title">'.$pilotname.' piloted ships</h3>';
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
                $pilotname = get_field('pilot_name');
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
                    $stm = true;
                    echo '<column class="col-1 col-wrapper stm">';
                    echo '<h3 class="full-title">'.$pilotname.' as personnel</h3>';
                    $colpos = 1;
                    foreach($sameupgrades as $upgrade) : ?>
                        <column class="col-1 col-res-half <?php $colpos = 1 - $colpos; echo 'col-pos-'.$colpos; ?>">
                            <?php $hidden = 'hidden'; $includeimg = 2; ; $list = 'list'; $sameimg = 1; include('upgradepanel.php'); ?>
                        </column>
                    <?php 
                    endforeach;
                    echo '</column>';
                endif;
            ?>
            <?php
                $pilots = get_posts(array(
                    'post_type' => 'upgrade',
                    'posts_per_page' => -1,				
                     'meta_query' => array(
                        array(
                            'key' => 'ship_limit', // name of custom field
                            'value' => '"' . $shipid . '"', // matches exaclty "123", not just 123. This prevents a match for "1234"
                            'compare' => 'LIKE'
                        )
                    )
                ));
                $ugCount = count($pilots);
                if( $pilots): ?>
                    <column class="col-2 col-wrapper<?php if($stm != true) { echo ' stm'; } ?>">
                        <h3 class="full-title"><?php if(get_field('full_title')) { echo get_field('full_title'); } else {echo get_the_title(); } ?> limited upgrades</h3>
                        <?php $hidden = 'hidden'; 
                        if($ugCount > 6) { $includeimg = 1; } else { $includeimg = 2; };
                        foreach( $pilots as $upgrade ):
                            echo '<column class="col-1 col-res-half">';
                                $hidden = 'hidden'; $sameimg = 1; $includeimg = 2; $list = 'list'; include('upgradepanel.php');
                            echo '</column>';
                        endforeach;
                    echo '</column>';
                endif;

            ?>
        <column class="col-2 col-wrapper">
            <column class="col-1 col-wrapper">
            
                <?php 
                    $guides = get_posts(array(
                            'post_type' => 'post',
                            'meta_query' => array(
                                array(
                                    'key' => 'related_pilots', // name of custom field
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
                                    <thumbframe class="dbg">
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
                <h3>Evaluate <?php the_title(); ?></h3>

                <p>How do you grade the relative strength of <?php the_title(); ?>?</p>
                
                <?php if(function_exists('the_ratings')) { the_ratings(); } ?>

            </column>
        </column>
        <column class="col-1 col-wrapper">
            
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
                        <p>First appearance: Wave <?php echo $wavetitel; ?></p>
                    <?php } ?>
                </column>
            <?php endif; ?>         

            
            <column class="col-1">
                <?php include(locate_template('meta.php')); ?>
                
                
                
            </column>
        </column>
    </column>
    </column>
        <column class="col-2 col-wrapper">
            <?php 
                $ids = get_field('ship');	
                $pilots = get_posts(array(
                        'post_type' => 'pilot',
                        'orderby' => 'meta_value_num',
                        'posts_per_page' => -1,
                        'meta_key' => 'pilot_skill_value',							
                        'meta_query' => array(
                            array(
                                'key' => 'ship_conf', // name of custom field
                                'value' => '"' . $shipid . '"', // matches exaclty "123", not just 123. This prevents a match for "1234"
                                'compare' => 'LIKE'
                            )
                        )
                    ));
                $ugCount = count($pilots);
            ?>
            <?php if( $pilots ): ?>
                <column class="col-2 col-half-content">
                    <?php $shipclass = get_field('ship', $shipid); ?>
                    <h3 class="expand-justify"><span><?php echo get_the_title($p->ID); ?> Pilots</span><span class="expand-nav"><span class="show-img-btn <?php if($ugCount <= 6) { echo 'show-thumbs'; } ?>"></span><span class="expand-btn">+</span></span></h3>

                    <?php foreach( $pilots as $pilot ): ?>
                        <?php $hidden = 'hidden'; if($ugCount > 6) { $includeimg = 1; } else { $includeimg = 2; }; include(locate_template('pilotpanel.php')); ?>
                    <?php endforeach; ?>
                </column>  	
            <?php endif; ?>
            
            <column class="col-2 col-half-content">
            <?php 
                $facships = array();
            
                
                $facnum = count($terms);
                echo '<h3>';
                foreach($terms as $term) {
                    array_push($facships, $term->slug);
                    echo $term->name;
                    if(--$facnum > 0) echo ' & ';
                }
                echo ' ships</h3>';
                
            ?>
            <?php 
                 $ships = get_posts(array(
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
                        ),
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'faction-tax',
                                'field' => 'slug',
                                'terms' => $facships
                        ))
                    ));
            
            ?>
			<?php if( $ships ): ?>
                <?php foreach($ships as $ship) : ?>
                      <h4 class="ship-list <?php if($ship->ID == $man_ID) echo 'selected'; ?>">
                        <span class="ship-type">
                            <?php 
                                $thumbfactions = get_field('faction', $ship->ID);
                                foreach($thumbfactions as $thumbfaction) 
                            { ?>
                                <span class="faction <?php echo $thumbfaction->slug; ?>"></span>
                            <?php } ?>
                            <a href="<?php echo get_permalink($ship->ID); ?>"><?php echo get_the_title( $ship->ID ); ?></a>
                        </span>
                    </h4>
                <?php endforeach; ?>
            <?php endif; ?>
        </column>
        </column>
    
   
        
        
                   
        
        

	

<?php endwhile; // end of the loop. ?>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		btn_act = 0;

		$('.related-div .expand-btn').click( function() {
			if($(this).parent().parent().children('rules').hasClass("hidden")) {
				$(this).parent().parent().children('rules').removeClass("hidden");
				$(this).text('-');
			} else {
				$(this).parent().parent().children('rules').addClass("hidden");
				$(this).text('+');				
			}
		});
		
		$('h2 .expand-btn').click( function() {
			
			if($(this).text() == '+') {
				$(this).text('-')
				$('.related-div rules').removeClass("hidden");
				$('.related-div .expand-btn').text('-');	
			} else {
				$(this).text('+')
				$('.related-div rules').addClass("hidden");
				$('.related-div .expand-btn').text('+');
			}
		});
			
	});
</script>

<?php get_footer(); ?>
