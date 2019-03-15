<?php get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<?php $the_ID = get_the_id(); $actionbar_num = 0; $shipconfid = intval($_GET['shipconf']); ?>
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
        	<h3 class="same"><?php if(get_field('full_title')) { $fulltitle = get_field('full_title'); } else { $fulltitle = get_the_title(); } echo $fulltitle; ?></h3>
            
                <thumbframe>
                    <img src="<?php if(get_field('thumb')) { $thumb = get_field('thumb'); } else { $thumb = get_field('placeholder', 'options'); } echo $thumb[sizes][large]; ?>" alt="<?php the_title(); ?>" itemprop="image" />
                </thumbframe>        
            
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
                   
                </description>
            </article>        
        </column>
        <column class="col-2 col-wrapper">	
            <column class="col-1">
				
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
						 <?php
								if(count($configurations) == 1 || $shipconfid > 0) :
									echo '<h3>Configuration</h3>';
								else :
									echo '<h3>Configurations</h3>';
								endif;
							?>
							
							<?php foreach( $configurations as $configuration ): ?>
                                <?php if($shipconfid > 0 && $shipconfid == $configuration->ID || $shipconfid == null || count($configurations) == 1) { ?>
                                    <div class="column-content <?php echo $shipconfid; ?>">            
                                        <?php $shipid = $configuration->ID; include(locate_template('statpanel.php')); ?>	
                                    </div> 
                                <?php } ?>
							<?php endforeach; ?>
							
						<?php endif; ?>
                        <?php if($shipconfid != null && count($configurations) > 1) {
                            echo '<p><a href="'.get_the_permalink().'">All '.$fulltitle.' configurations</a></p>';
    
                        } ?>
            </column>		            
            <column class="col-1">
                <h3>Maneuvers</h3>
                <div class="column-content">
                    <?php $man_ID = $the_ID; include(locate_template('maneuverpanel.php')); ?>		            		   	
                </div>
            </column>
            
            <column class="col-2 col-half-content">
                
                <?php
                    $pilotIds = [];
                    foreach( $configurations as $configuration ):
                        if($shipconfid > 0 && $shipconfid == $configuration->ID || $shipconfid == null || count($configurations) == 1) {
                            $pilots = get_posts(array(
                                'post_type' => 'pilot',
                                'posts_per_page' => -1,				
                                'meta_query' => array(
                                    array(
                                        'key' => 'ship_conf', // name of custom field
                                        'value' => '"' . $configuration->ID . '"', // matches exaclty "123", not just 123. This prevents a match for "1234"
                                        'compare' => 'LIKE'
                                    )
                                )
                            ));

                            if( $pilots ):
                                foreach( $pilots as $pilot ):
                                    array_push($pilotIds, $pilot->ID);

                                endforeach;
                            endif;
                        }
                    endforeach; 

                    $pilots = get_posts(array(
                            'post_type' => 'pilot',
                            'orderby' => 'meta_value_num',
                            'posts_per_page' => -1,				
                            'meta_key' => 'pilot_skill_value',							
                            'post__in' => $pilotIds,
                        ));
                        $ugCount = count($pilots);
                        if( $pilots && $pilotIds != null): ?>
                            <h3 class="expand-justify"><span><?php the_title(); ?> Pilots</span><span class="expand-nav"><span class="show-img-btn <?php if($ugCount <= 6) { echo 'show-thumbs'; } ?>"></span><span class="expand-btn">+</span></span></h3>
                            <?php $hidden = 'hidden'; 
                            if($ugCount > 6) { $includeimg = 1; } else { $includeimg = 2; };
                            foreach( $pilots as $pilot ):
                                include(locate_template('pilotpanel.php'));
                            endforeach;
                        endif;

                ?>
            </column>
        </column>        
		
        <column class="col-2 col-wrapper">
            <?php
                $pilots = get_posts(array(
                    'post_type' => 'upgrade',
                    'posts_per_page' => -1,				
                     'meta_query' => array(
                        array(
                            'key' => 'ship_limit', // name of custom field
                            'value' => '"' . $configuration->ID . '"', // matches exaclty "123", not just 123. This prevents a match for "1234"
                            'compare' => 'LIKE'
                        )
                    )
                ));
                $ugCount = count($pilots);
                if( $pilots): ?>
                    <column class="col-2 col-wrapper stm">
                        <h3 class="full-title"><?php if(get_field('full_title')) { echo get_field('full_title'); } else {echo get_the_title(); } ?> limited upgrades<span class="expand-nav"></h3>
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
            <column class="col-1 col-wrapper">
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
                <column class="col-1">
                    <h3>Evaluate the <?php the_title(); ?></h3>

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
                <?php if( $products ): ?>
                    <column class="col-1 col-half-content">
                        <h3><?php the_title(); ?> featured Products</h3>
                        <?php foreach( $products as $product ): ?>
                            <h4 class="ship-list">
                                <span class="ship-type">
                                    <?php $fterms = get_field('faction', $product->ID); 
                                    foreach($fterms as $fterm) { 
                                        echo '<span class="faction '.$fterm->slug.'"></span>'; 
                                    } ?>
                                    <a href="<?php echo get_permalink( $product->ID ); ?>"><?php echo get_the_title( $product->ID ); ?></a>
                                </span>
                            </h4>

                        <?php endforeach; ?>
                    </column>
                <?php endif; ?>
                <column class="col-1">
                    <?php include(locate_template('meta.php')); ?>    	
                </column>

            </column> 
        </column>
			<?php /*?><?php if( $products ): ?>
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
			<?php endif; ?>    <?php */?>            
    
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
                      <h4 class="ship-list <?php if($ship->ID == get_the_id()) echo 'selected'; ?>">
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


	

<?php endwhile; // end of the loop. ?>


<?php get_footer(); ?>
