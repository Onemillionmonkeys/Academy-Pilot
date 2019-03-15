<?php 
/*
* Template Name: List and Taxonomy
*/
get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

    <titlebar>
        <h1><?php the_title(); ?></h1>
    </titlebar>
    <?php $factions = get_field('faction');
    if( $factions ): ?>
    	<titlebar class="faction">
			<?php foreach( $factions as $faction ): ?>
                <titleicon><faction class="<?php echo $faction->slug; $factioncol .= $faction->slug.'-colour '; ?>"></faction></titleicon>
            <?php endforeach; ?>
        </titlebar>
    <?php endif; ?>
    <?php $upgrades = get_field('upgrades');
    if( $upgrades ): ?>
    	<titlebar class="faction">
			<?php foreach( $upgrades as $upgrade ): ?>
                <titleicon class="upgrade"><faction class="<?php echo $upgrade->slug; $upgradecol .= $upgrade->slug.'-colour '; ?>"></faction></titleicon>
            <?php endforeach; ?>
        </titlebar>

    <?php endif; ?>
    <column class="col-4 col-wrapper stm">
    <?php 
        $type = get_field('list_type');  
        if($type == 'ship') :
    ?>
        
        <?php 
            $terms_type = get_terms('size-tax');
			foreach ( $terms_type as $term_type ) : 
                 $tax = array(
                    array(
                        'taxonomy' => 'size-tax',
                        'field' => 'slug',
                        'terms' => $term_type->slug
                ));
                
                if($faction) {
                    array_push(
                        $tax, array(
                            'taxonomy' => 'faction-tax',
                            'field' => 'slug',
                            'terms' => $faction->slug,
                        )
                    );
                };
        
                $posts = get_posts(array(
					'post_type' => $type,
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
                    'tax_query' => $tax
				));
                if( $posts ): 
                    echo '<h3 class="full-title">'.$term_type->name.' ships</h3>';
                    $colpos = 1;
                    foreach( $posts as $post ):
        ?>
                        <column class="col-1 col-res-half <?php $colpos = 1 - $colpos; echo 'col-pos-'.$colpos; ?>">
                            <thumbframe class="desaturation">
                                <?php if(get_field('thumb')) { $thumb = get_field('thumb'); } else { $thumb = get_field('placeholder', 'options'); } ?>
                                <a href="<?php echo get_permalink( $post->ID ); ?>"><img src="<?php echo $thumb[sizes][medium]; ?>" alt="<?php echo get_the_title( $post->ID ); ?>" /></a>
                            </thumbframe>
                            <thumbdescription>
									<thumbtitle>
										<div class="thumbtitleflex">
											<h4><a href="<?php echo get_permalink( $post->ID ); ?>"><?php echo get_the_title( $post->ID ); ?></a></h4>
                                            <p><?php if(get_field('full_title')) { echo get_field('full_title'); } else { echo get_the_title( $poxt->ID ); }?></p>
										</div>
                                        <?php if(get_field('faction')) { ?>
                                        <div class="thumbfaction">
                                            <?php 
                                                $thumbfactions = get_field('faction');
                                                foreach($thumbfactions as $thumbfaction) 
                                            { ?>  
                                                <titleicon><faction class="<?php echo $thumbfaction->slug; ?>"></faction></titleicon>
                                            <?php } ?>
                                        </div>
                                        <?php } ?>
                                    </thumbtitle>
                            </thumbdescription>
                        </column>
            <?php endforeach; wp_reset_postdata(); endif; ?>
        <?php 
            endforeach; //terms_types
        ?>

    <?php
        elseif($type == 'pilot') :
    ?>
        <?php 
            
			for ( $ini = 6; $ini >= 1; $ini-- ) : 
                
                $tax = [];
                if($faction) {
                    array_push(
                        $tax, array(
                            'taxonomy' => 'faction-tax',
                            'field' => 'slug',
                            'terms' => $faction->slug,
                        )
                    );
                };
        
                $posts = get_posts(array(
					'post_type' => $type,
					'posts_per_page'=>-1,
					'orderby' => 'name',
					'order' => 'ASC',
                    'meta_query' => array(
                        array(
                            'key' => 'second_edition',
                            'compare' => '==',
                            'value' => '1'
                        ),
                         array(
                            'key' => 'pilot_skill_value',
                            'value' => $ini,
                            'compare' => '=='
                        )
                    ),
                    'tax_query' => $tax
                    
				));
        
                $colpos = 1;
        
                if( $posts ): 
                    echo '<h3 class="full-title no-justify"><span class="initiative">'.$ini.'</span></h3>';
                    foreach( $posts as $post ):
                    
        ?>
                        <column class="col-1 col-res-half <?php $colpos = 1 - $colpos; echo 'col-pos-'.$colpos; ?>">
                            <thumbframe>
                                <?php if(get_field('thumb')) { $thumb = get_field('thumb'); } else { $thumb = get_field('placeholder_pilot', 'options'); } ?>
                                <a href="<?php echo get_permalink( $post->ID ); ?>"><img src="<?php echo $thumb[sizes][medium]; ?>" alt="<?php echo get_the_title( $post->ID ); ?>" /></a>
                            </thumbframe>
                            <thumbdescription>
									<thumbtitle>
										<div class="thumbtitleflex">
											<h4 <?php if(get_field('unique')) { echo 'class="unique"'; } ?>><a href="<?php echo get_permalink( $post->ID ); ?>"><?php echo get_the_title( $post->ID ); ?></a></h4>
                                            
                                            <?php $confs = get_field('ship_conf'); foreach( $confs as $conf ): ?>
								                 <p><a href="<?php $shiptype = get_field('ship', $conf->ID); echo get_the_permalink($shiptype[0]->ID); ?>"><?php echo get_the_title($conf->ID); ?></a></p>
                                                    
                                            <?php endforeach; ?>
                                            
										</div>
                                        <?php if(get_field('faction')) { ?>
                                        <div class="thumbfaction">
                                            <?php 
                                                $thumbfactions = get_field('faction');
                                                foreach($thumbfactions as $thumbfaction) 
                                            { ?>  
                                                <titleicon><faction class="<?php echo $thumbfaction->slug; ?>"></faction></titleicon>
                                            <?php } ?>
                                        </div>
                                        <?php } ?>
                                    </thumbtitle>
                            </thumbdescription>
                        </column>
            <?php endforeach; wp_reset_postdata(); endif; ?>
        <?php 
            endfor; //termtypes
        ?>
        
    <?php elseif($type == 'upgrade') : ?>
            
        
         <?php 
            $terms_type = get_terms('upgrade-types-tax');
			foreach ( $terms_type as $term_type ) : 
                $showupgradegroup = 1;
                if(get_field('upgrades')) { 
                    $showupgradegroup = 0;
                    $showupgrades = get_field('upgrades');
                    foreach($showupgrades as $showupgrade) {
                        if ($term_type->slug == $showupgrade->slug) $showupgradegroup = 1;
                    }
                }
                 $tax = array(
                    array(
                        'taxonomy' => 'upgrade-types-tax',
                        'field' => 'slug',
                        'terms' => $term_type->slug
                ));
                if($faction) {
                    array_push(
                        $tax, array(
                            'taxonomy' => 'faction-tax',
                            'field' => 'slug',
                            'terms' => $faction->slug,
                        )
                    );
                };
                
                $posts = get_posts(array(
					'post_type' => $type,
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
                    'tax_query' => $tax
				));
                if( $posts && $showupgradegroup == 1 ):
                    $colpos = 0;
                    echo '<h3 class="full-title">'.$term_type->name.'s</h3>';
                    foreach( $posts as $post ):
                    //update_post_meta($post->ID, 'upgrade_name', get_the_title( $post->ID ));
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
            <?php endforeach; wp_reset_postdata(); endif; ?>
        <?php 
            endforeach; //termtypes
        ?>
    <?php elseif($type == 'product') : ?>        
        <?php 
            $terms_type = get_terms('product-type-tax');
			foreach ( $terms_type as $term_type ) : 
                $tax = [];
                 $tax = array(
                    array(
                        'taxonomy' => 'product-type-tax',
                        'field' => 'slug',
                        'terms' => $term_type->slug
                ));
                if($faction) {
                        array_push(
                            $tax, array(
                                'taxonomy' => 'faction-tax',
                                'field' => 'slug',
                                'terms' => $faction->slug,
                            )
                        );
                    };
                
                $posts = get_posts(array(
					'post_type' => 'product',
					'posts_per_page'=>-1,
					
					'order' => 'DESC',
                    'tax_query' => $tax
				));
                if( $posts ): 
                    echo '<h3 class="full-title">'.$term_type->name.'s</h3>';
                    $colpos = 1;
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
            <?php endforeach; wp_reset_postdata(); endif; ?>
        <?php 
            endforeach; //termtypes
        ?>
        
    <?php 
        endif;
    ?>
    
	</column>
            
    

<?php endwhile; ?>
<?php get_footer(); ?>