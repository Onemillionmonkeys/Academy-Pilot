<?php get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<?php $the_ID = get_the_id(); $actionbar_num = 0; ?>
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
        <column class="col-2 col-thumb <?php echo $factioncol; ?>">
        	<h3><?php the_title(); ?></h3>
            <?php if(get_field('thumb')) { ?>
                <thumbframe>
                    <img src="<?php $thumb = get_field('thumb'); echo $thumb[sizes][large]; ?>" alt="<?php the_title(); ?>" itemprop="image" />
                </thumbframe>        
            <?php } ?>
            <div class="thumb-overlay"></div>
            <article>     
                
                <description itemprop="description">
                    <?php if(get_field('description')) : ?>
                        <?php the_field('description'); ?>
                        <?php if(get_field('source')) : ?>
                            <p><a class="source" href="<?php the_field('source'); ?>" rel="nofollow" target="_blank">– Source</a></p>
                        <?php endif; ?>
                    <?php else : ?>
                        <?php $metaterms = get_field('faction');
                        if( $metaterms ): ?>
                            <?php foreach( $metaterms as $metaterm ): ?>
                                <?php $metafaction[] = $metaterm->name; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <p><?php the_title(); ?> is one of the <?php echo $metafaction[0]; if ($metafaction[1] != null) { echo ' or ' . $metafaction[1]; } ?> ships from the Star Wars X-Wing Miniatures Game</p>                
                    <?php endif; ?>
                    <?php if(get_field('not_yet_available')) : ?>
                        <p class="warning"><?php the_title(); ?> <?php the_field('not_yet_available_text','options'); ?></p><p class="warning">ETA: <?php the_field('eta'); ?></p>
                    <?php endif; ?>     
                </description>
            </article>        
        </column>
        <column class="col-1 col-wrapper">	
            <column class="col-1">
            
                    <?php $rownum = count(get_field('ship_statistics')); 
                        if($rownum == 1) :
                            echo '<h3>Configuration</h3>';
                        else :
                            echo '<h3>Configurations</h3>';
                        endif;
                    ?>
    
                <div class="column-content">            
                    <?php if( have_rows('ship_statistics') ): $num = 0;
                        while ( have_rows('ship_statistics') ) : the_row(); $num++; ?>
							<?php $confaction = get_sub_field('configuration_faction'); ?>
							<h4 class="configuration-title">
                          		<span class="ship-type"><?php the_title(); ?></span>
								<span class="configuration"><stat class="ship-faction <?php echo $confaction->slug; ?>"></stat><?php if(get_sub_field('configuration') != '') { echo get_sub_field('configuration'); } else { echo $confaction->name; } ?> Configuration</span>
                           </h4>
                            <?php $shipid = $the_ID; include(locate_template('statpanel.php')); ?>	
                        <?php endwhile; ?>
                    <?php endif; ?>  
                </div>                                
            </column>		            
            <column class="col-1">
                <h3>Maneuvers</h3>
                <div class="column-content">
                    <?php $man_ID = $the_ID; include(locate_template('maneuverpanel.php')); ?>		            		   	
                </div>
            </column>
        </column>        
		<column class="col-1">
        <h3 class="expand-justify"><span><?php the_title(); ?> Pilots</span> <span class="expand-btn">+</span></h3>
			<?php $pilots = get_posts(array(
                    'post_type' => 'pilot',
                    'orderby' => 'meta_value_num',
                    'posts_per_page' => -1,				
                    'meta_key' => 'pilot_skill_value',							
                    'meta_query' => array(
                        array(
                            'key' => 'ship', // name of custom field
                            'value' => '"' . get_the_ID() . '"', // matches exaclty "123", not just 123. This prevents a match for "1234"
                            'compare' => 'LIKE'
                        )
                    )
                ));
    
                ?>
            <?php if( $pilots ): ?>
                
                <?php foreach( $pilots as $pilot ): ?>
                    <?php include(locate_template('pilotpanel.php')); ?>	
                <?php endforeach; ?>
            <?php endif; ?>             	   	    
    	</column>
        
        <column class="col-1">
            <?php include(locate_template('meta.php')); ?>    	
        </column>        
        
		<?php $guides = get_posts(array(
            'post_type' => 'post',
                'meta_query' => array(
                array(
                    'key' => 'related_ships', // name of custom field
                    'value' => '"' . get_the_ID() . '"', // matches exaclty "123", not just 123. This prevents a match for "1234"
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
			<?php if( $products ): ?>
          		<column class="col-1">
                    <h3><?php the_title(); ?> featured Products</h3>
                    <?php foreach( $products as $product ): ?>
                        <links>
                            <h4><a href="<?php echo get_permalink( $product->ID ); ?>"><?php echo get_the_title( $product->ID ); ?></a></h4>
<?php /*?>                            <?php 
     
                            $terms = get_field('wave', $product->ID);
                             
                            if( $terms ): ?>
                                <?php foreach( $terms as $term ): ?>
                                    <p><?php echo $term->name; ?></p>
                                <?php endforeach; ?>
                            <?php endif; ?><?php */?>
                        </links>
                    <?php endforeach; ?>
                </column>
            <?php endif; ?>
            

			<?php if( $products ): ?>
                <column class="col-1">
                    <h3><?php the_field('shop_title','options'); ?></h3>
                    <links>
                        <p><?php the_field('shop_plea', 'options'); ?></p>
                    </links>             
                    <?php foreach( $products as $product ): ?>            
						<?php if(get_field('amazon_embed_uk', $product->ID) || get_field('amazon_embed_us', $product->ID)) { ?>
                            
                    
                                <div class="amazon amazon-uk">
                                    <?php the_field('amazon_embed_uk', $product->ID); ?>
                                </div>
                    
                                <div class="amazon amazon-us">                            
                                    <?php the_field('amazon_embed_us', $product->ID); ?>
                                </div>
                        <?php } ?>
					<?php endforeach; ?>
                    <p class="lan-select">Change Store: <span class="uk">UK</span> | <span class="us"> US </span></p>            
                </column>                
			<?php endif; ?>                
 



	

<?php endwhile; // end of the loop. ?>


<?php get_footer(); ?>
