<?php get_header(); ?>

<?php if ( have_posts() ) the_post(); ?>

	<titlebar>
		<h1>Upgrade: <?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); $slug = $term->slug; echo $term->name; ?></h1>			
	</titlebar>
    <titlebar class="faction">
	    <titleicon class="upgrade"><faction class="<?php echo $slug; ?>"></faction></titleicon>
    </titlebar>

	
    <column class="col-4 col-wrapper">    
        <column class="col-2 col-thumb rebel-colour">
            <h3><?php echo $term->name; ?></h3>
            <thumbframe class="icon-frame">
                <img src="<?php $thumb = get_field('placeholder_upgrade', 'options'); echo $thumb[sizes][large]; ?>" alt="<?php the_title(); ?>" itemprop="image"/>
                <upgrade class="<?php echo $term->slug; ?>"></upgrade>
            </thumbframe>
            <div class="thumb-overlay"></div>
            <article>
                <description itemprop="description">
                    <p><?php echo $term->name; ?> is an upgrade type from Star Wars X-wing Second Edition</p>        
                </description>       
            </article>
        </column>
    </column>
 <column class="col-2 col-half-content">
            <h3><?php echo $term->name; ?> eligible ships</h3>
        
        
                   <?php $ships = get_posts(array(
                            'post_type' => 'ship-configuration',
                            'posts_per_page' => -1,
                            'orderby' => 'name',
                            'order' => 'ASC',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'upgrade-types-tax',
                                    'field' => 'slug',
                                    'terms' => $term->slug
                                )
                            )
    
                        ));
                    ?>
                    <?php if( $ships ): ?>
                        <?php foreach( $ships as $ship ): ?>
                            <?php $mainships = get_field('ship', $ship->ID); foreach($mainships as $mainship) : ?>
								<h4 class="ship-list">
                                        <span class="ship-type">
                                            <span class="faction <?php $shipfaction = get_field('faction', $ship->ID); echo $shipfaction->slug; ?>"></span>    
                                            <a href="<?php echo get_permalink($mainship->ID); ?>"><?php echo get_the_title( $ship->ID ); ?></a>
                                        </span>
                                    </h4>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
    
				<?php endif; ?> 
        
        </column>
    <column class="col-2 col-wrapper">
            <?php 
                 $upgrades = get_posts(array(
                    'post_type' => 'upgrade',
                    'posts_per_page' => -1,
                    'orderby' => 'name',
                    'order' => 'Asc',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'upgrade-types-tax',
                            'field' => 'slug',
                            'terms' => $term->slug
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
                $colpos = 1;
                $ugCount = count($upgrades);
            ?>
                <?php if( $upgrades ): ?>
                    <column class="col-2 col-half-content">
                        <h3 class="expand-justify"><span><?php echo $term->name; ?>s</span> <span class="expand-nav"><span class="show-img-btn <?php if($ugCount <= 6) { echo 'show-thumbs'; } ?>"></span><span class="expand-btn">+</span></span></h3>
                        <?php foreach( $upgrades as $upgrade ): ?>
                            
                            <?php $hidden = 'hidden'; $sameimg = 1; if($ugCount > 6) { $includeimg = 1; } else { $includeimg = 2; } $list = 'list'; include('upgradepanel.php'); ?>
                            
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
        
        
        
        
            


<?php get_footer(); ?>