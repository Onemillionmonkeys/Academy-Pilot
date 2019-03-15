<?php 
/*
* Template Name: Faction
*/
get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
     <titlebar>
    
            <h1><?php the_title(); ?></h1>
    
    </titlebar>
        <?php 
            $term = get_field('faction'); 
            if( $term ): 
        ?>
                <titlebar class="faction">
                    
                        <titleicon><faction class="<?php echo $term->slug; $factioncol .= $term->slug.'-colour '; ?>"></faction></titleicon>
                    
                </titlebar>
        <?php 
            endif; 
        ?>
	    <column class="col-2 col-thumb <?php echo $factioncol; ?>">
        	<h3><?php the_title(); ?></h3>
            
            <thumbframe>
                <img src="<?php $thumb = get_field('thumb'); echo $thumb[sizes][large]; ?>" alt="<?php the_title(); ?>" itemprop="image" />
            </thumbframe>        
            
            <div class="thumb-overlay"></div>
            <article>
                
                <description itemprop="description">
                    <?php the_field('excerpt'); ?>
                </description>
            </article>
        </column>
        <column class="col-2 col-wrapper stm">
            <h3 class="full-title"><?php echo $term->name; ?> guides &amp; strategies</h3>
            <?php 
            $guidenum == 0;
            $guides = get_posts(array(
                    'post_type' => 'post',
                    
                    'posts_per_page' => 5,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'faction-tax',
                            'field' => 'slug',
                            'terms' => $term->slug
                    ))
                ));
            ?>
            <?php if( $guides ): ?>


                <?php foreach( $guides as $guide ): ?>
                    <column class="col-<?php if(++$guidenum == 1) { echo '2'; $toolsize = 'toolthumblarge'; } else { echo '1'; $toolsize = 'toolthumb'; } ?>">
                        <thumbframe>
                            <a href="<?php echo get_permalink( $guide->ID ); ?>"><img src="<?php $thumb = get_field('thumb', $guide->ID); echo $thumb[sizes][$toolsize]; ?>" alt="<?php echo get_the_title( $guide->ID ); ?>" /></a>
                        </thumbframe> 
                            <h4 class="blog-title"><a href="<?php echo get_permalink( $guide->ID ); ?>" <?php if(get_field('unique',$guide->ID)) { echo 'class="unique"'; } ?>><?php echo get_the_title( $guide->ID ); ?></a></h4>
                            <?php if(get_field('excerpt',$guide->ID)) : ?><p><?php the_field('excerpt',$guide->ID); ?></p><?php endif; ?>
                    </column>
                <?php endforeach; ?>

            <?php endif; ?>
        </column>


        <column class="col-4 col-wrapper ltm">
            
            <?php 
                $shiplink = get_field('ship_link');    
                $pilotlink = get_field('pilot_link');
                $upgradelink = get_field('upgrade_link');
                $productlink = get_field('product_link');
            
                $posts = get_posts(array(
					'post_type' => 'ship-configuration',
					'posts_per_page'=> 4,
					'orderby' => 'rand',
					'order' => 'ASC',					
					'tax_query' => array(
						array(
							'taxonomy' => 'faction-tax',
							'field' => 'slug',
							'terms' => $term->slug,
						)
					)
				));	
            
							
    
                if( $posts ): 
                    echo '<h3 class="full-title">'.$term->name.' ships <span class="full-title-link"><a href="'.$shiplink.'">All '.$term->name.' ships</span></a></h3>';
                    foreach( $posts as $post ): 
                        $ships = get_field('ship'); foreach($ships as $ship) { $shipID = $ship->ID ; }
                        ?>
                        <column class="col-1 col-res-half">
                            <thumbframe>
                                <?php if(get_field('thumb', $shipID)) { $thumb = get_field('thumb', $shipID); } else { $thumb = get_field('placeholder', 'options'); } ?>
                                <a href="<?php echo get_the_permalink($shipID); ?>"><img src="<?php echo $thumb[sizes][medium]; ?>" alt="<?php the_title(); ?>" /></a>
                            </thumbframe>
                            <thumbdescription>
                                <thumbtitle>
                                    <div class="thumbtitleflex">
                                        <h4><a href="<?php echo get_the_permalink($shipID); ?>"><?php the_title(); ?></a></h4>
                                    </div>
                                    <div class="thumbfaction">
                                       <titleicon><faction class="<?php echo $term->slug; ?>"></faction></titleicon> 
                                    </div>
                                </thumbtitle>
                            </thumbdescription>
                        </column>
            <?php 
                    endforeach; wp_reset_postdata();  
                endif; 
            ?>  
        </column>

        
        <column class="col-4 col-wrapper ltm">
            
            <?php 
                
                $posts = get_posts(array(
					'post_type' => 'pilot',
					'posts_per_page'=>8,
					'orderby' => 'rand',
					'order' => 'ASC',					
					'tax_query' => array(
						array(
							'taxonomy' => 'faction-tax',
							'field' => 'slug',
							'terms' => $term->slug,
						)
					),
                    'meta_query' => array(
                        array(
                            'key' => 'second_edition',
                            'compare' => '==',
                            'value' => '1'
                        ),
                        array(
                            'key' => 'unique',
                            'value' => '1',
                            'compare' => '=='
                        ),
                        array(
                            'key' => 'pilot_skill_value',
                            'value' => '5',
                            'compare' => '>='
                        )
                    )
				));	
            
							
    
                if( $posts ): 
                     echo '<h3 class="full-title">'.$term->name.' aces  <span class="full-title-link"><a href="'.$pilotlink.'">All '.$term->name.' pilots</span></a></h3>';
                    foreach( $posts as $post ): 
            ?>
                        <column class="col-1 col-res-half">
                            <thumbframe class="desaturation">
                                <?php if(get_field('thumb')) { $thumb = get_field('thumb'); } else { $thumb = get_field('placeholder_pilot', 'options'); } ?>
                                <a href="<?php the_permalink(); ?>"><img src="<?php echo $thumb[sizes][medium]; ?>" alt="<?php the_title(); ?>" /></a>
                            </thumbframe>
                            <thumbdescription>
                                <thumbtitle>
                                    <div class="thumbtitleflex">
                                        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                        <?php 
                                            $ship_confs = get_field('ship_conf'); 
											foreach( $ship_confs as $ship_conf ): 
                                                $ships = get_field('ship', $ship_conf->ID); foreach($ships as $ship) { $link = get_the_permalink( $ship->ID ); }
                                            ?>
                                                    
													<p><a href="<?php echo $link; ?>"><?php echo get_the_title( $ship_conf->ID ); ?></a></p>

										<?php 
                                            endforeach; 
                                        ?>
											
                                    </div>
                                    <div class="thumbfaction">
                                       <titleicon><faction class="<?php echo $term->slug; ?>"></faction></titleicon> 
                                    </div>
                                </thumbtitle>
                            </thumbdescription>
                        </column>
            <?php 
                    endforeach; wp_reset_postdata();  
                endif; 
            ?>  
        </column>
        <column class="col-4 col-wrapper ltm">
            
            <?php 
                
                $posts = get_posts(array(
					'post_type' => 'upgrade',
					'posts_per_page'=>8,
                    'orderby' => 'rand',
					'order' => 'DESC',					
					'tax_query' => array(
						array(
							'taxonomy' => 'faction-tax',
							'field' => 'slug',
							'terms' => $term->slug,
						)
					)
				));	
            
							
    
                if( $posts ): 
                     echo '<h3 class="full-title">'.$term->name.' upgrades  <span class="full-title-link"><a href="'.$upgradelink.'">All '.$term->name.' upgrade</span></a></h3>';
                    foreach( $posts as $post ): 
            ?>
                         <column class="col-1 col-res-half <?php $colpos = 1 - $colpos; echo 'col-pos-'.$colpos; ?>">
                            <thumbframe class="desaturation">
                                <?php if(get_field('thumb')) { $thumb = get_field('thumb'); } else { $thumb = get_field('placeholder_upgrade', 'options'); } ?>
                                <a href="<?php echo get_permalink( $post->ID ); ?>"><img src="<?php echo $thumb[sizes][medium]; ?>" alt="<?php echo get_the_title( $post->ID ); ?>" /></a>
                            </thumbframe>
                            <thumbdescription>
									<thumbtitle>
										<div class="thumbtitleflex">
											<h4><a href="<?php echo get_permalink( $post->ID ); ?>"><?php echo get_the_title( $post->ID ); ?></a></h4>
										</div>
                                        
                                        <div class="thumbfaction">
                                            <?php 
                                                $thumbfactions = get_field('upgrade_type');
                                                foreach($thumbfactions as $thumbfaction) 
                                            { ?>  
                                                <titleicon><faction class="<?php echo $thumbfaction->slug; ?>"></faction></titleicon>
                                            <?php } ?>
                                        </div>
                                        
                                    </thumbtitle>
                            </thumbdescription>
                        </column>
            <?php 
                    endforeach; wp_reset_postdata();  
                endif; 
            ?>  
        </column>
        <column class="col-4 col-wrapper ltm">
            
            <?php 
                
                $posts = get_posts(array(
					'post_type' => 'product',
					'posts_per_page'=>4,
					'order' => 'DESC',					
					'tax_query' => array(
						array(
							'taxonomy' => 'faction-tax',
							'field' => 'slug',
							'terms' => $term->slug,
						)
					)
				));	
            
							
    
                if( $posts ): 
                     echo '<h3 class="full-title">'.$term->name.' products  <span class="full-title-link"><a href="'.$productlink.'">All '.$term->name.' products</span></a></h3>';
                    foreach( $posts as $post ): 
            ?>
                        <column class="col-1 col-res-half <?php $colpos = 1 - $colpos; echo 'col-pos-'.$colpos; ?>">
                            <thumbframe>
                                <?php if(get_field('thumb')) { $thumb = get_field('thumb'); } else { $thumb = get_field('placeholder_upgrade', 'options'); } ?>
                                <a href="<?php echo get_permalink( $post->ID ); ?>"><img src="<?php echo $thumb[sizes][medium]; ?>" alt="<?php echo get_the_title( $post->ID ); ?>" /></a>
                            </thumbframe>
                            <thumbdescription>
									<thumbtitle>
										<div class="thumbtitleflex">
											<h4><a href="<?php echo get_permalink( $post->ID ); ?>"><?php echo get_the_title( $post->ID ); ?></a></h4>
                                            <p><?php echo get_field('product_code', $post->ID); ?> Wave: <?php $waves = get_field('wave', $post->ID); echo $waves->name; ?></p>
										</div>
                                        
                                        <div class="thumbfaction">
                                            <?php 
                                                $thumbfactions = get_field('faction');
                                                foreach($thumbfactions as $thumbfaction) 
                                            { ?>  
                                                <titleicon><faction class="<?php echo $thumbfaction->slug; ?>"></faction></titleicon>
                                            <?php } ?>
                                        </div>
                                        
                                    </thumbtitle>
                            </thumbdescription>
                        </column>
            <?php 
                    endforeach; wp_reset_postdata();  
                endif; 
            ?>  
        </column>
        <column class="col-1">
            <?php include('meta.php'); ?>
        </column>

<?php /*?><?php if ( is_user_logged_in() ) { 
    $posts = get_posts(array(
        'post_type' => 'upgrade',
        'posts_per_page'=>-1,
        'order' => 'ASC',					
    ));	



    if( $posts ): 
        foreach( $posts as $post ): 
            if(!get_field('second_edition')) :
                     $my_post = array(
                      'ID'           => get_the_ID(),
                         'post_status' => 'draft'

                  );
                     wp_update_post( $my_post );
            endif;
        endforeach; wp_reset_postdata();  
    endif; 
} ?>
<?php */?>        
<?php endwhile; ?>
<?php get_footer(); ?>