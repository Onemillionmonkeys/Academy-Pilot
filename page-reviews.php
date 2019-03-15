<?php 
/*
* Template Name: Reviews
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
                
        <?php
        if($faction) {
            $tax = array(
                array(
                    'taxonomy' => 'faction-tax',
                    'field' => 'slug',
                    'terms' => $faction->slug
            ));
        }

        for($x = 5; $x >= 0; $x--) :
            $pilots = get_posts(array(
                    'post_type' => 'pilot',
                    'posts_per_page' => -1,
                    'meta_query' => array(
                        'relation' => 'AND',
                        array(
                            'key'		=> 'ratings_average',
                            'compare'	=> '<',
                            'value'		=> ($x+1)
                        ),
                        array(
                            'key'		=> 'ratings_average',
                            'compare'	=> '>=',
                            'value'		=> $x
                        ),

                    ),
                    'tax_query' => $tax,
                    'orderby' => 'meta_value_num', 
                    'order' => 'DESC'

                ));
            if( $pilots ): ?>
                <column class="col-4 col-wrapper stm">
                    <h3 class="full-title expand-justify"><?php echo($x == 5 ? 'Best of class' : ($x+1).' to '.$x); ?><span class="expand-nav"><span class="show-img-btn show-thumbs"></span><span class="expand-btn">+</span></span></h3>
                    <?php 
                    foreach( $pilots as $pilot ):
                        echo '<column class="col-1 col-best-of post-ratings">';
                        $hidden = 'hidden'; $includeimg = 2; include(locate_template('pilotpanel.php'));
                        echo do_shortcode('[ratings id="'.$pilot->ID.'" results="true"]');
                    
                        echo '</column>';
                    endforeach; 
                    ?>
                </column>
            <?php 
            endif; 
        endfor;
        ?>
    
	
            
    

<?php endwhile; ?>
<?php get_footer(); ?>