<?php get_header(); ?>

<?php if ( have_posts() ) the_post(); ?>
	<titlebar>
        <h1>Action: <?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); echo $term->name; ?></h1>			
    </titlebar>	

	<titlebar class="faction">
		<titleicon><faction class="<?php echo $term->slug; ?>"></faction></titleicon>
	</titlebar>
    
    
    
	 <column class="col-2 col-wrapper">    
        <column class="col-2 col-thumb rebel-colour">
            <h3><?php echo $term->name; ?></h3>
            <thumbframe class="icon-frame action-icon-frame">
                <img src="<?php $thumb = get_field('placeholder_upgrade', 'options'); echo $thumb[sizes][large]; ?>" alt="<?php the_title(); ?>" itemprop="image"/>
                <<?php echo $term->slug; ?>></<?php echo $term->slug; ?>>
            </thumbframe>
            <div class="thumb-overlay"></div>
            <article>
                <description itemprop="description">
                    <p><?php echo $term->name; ?> is an action type from Star Wars X-wing Second Edition</p>        
                </description>       
            </article>
        </column>
        <column class="col-2">
        	
           	<actionbar>
	            <?php $terms_type = get_terms('action-types-tax');
                    $actionnum = 0;
			     foreach ( $terms_type as $term_type ) : ?>
                    <?php if($actionnum != 0) { echo '<span class="splitter"></span>'; } $actionnum++; ?>
                     <action>   
					    <a href="<?php bloginfo('url'); ?>/action-types-tax/<?php echo $term_type->slug; ?>" class="<?php echo $term_type->slug; ?> white-diff"></a>
                    </action>
				<?php endforeach; ?>
                
            </actionbar>
        </column>
    </column>
  
        <column class="col-2 col-ship-action-list col-half-content">
                 <?php $ships = get_posts(array(
                            'post_type' => 'ship-configuration',
                            'posts_per_page' => -1,
                            'orderby' => 'name',
                            'order' => 'ASC',
                            'tax_query' => array(array(
                                'taxonomy' => 'action-types-tax',
                                'field' => 'slug',
                                'terms' => $term->slug
                            ))
                        ));
                    ?>
                 <?php if( $ships ): ?>
                        <?php for($x = 0; $x <= 4; $x++) : 
                            if($x == 0) {
                                $mainaction = 'action';
                                $actiondiff = 'action_difficulty';
                                $diffcol = 'white';
                                $linkedto = 'yes';
                            }
                            if($x == 1) {
                                $linkedto = 'no';
                            }
                            if($x == 2) {
                                $mainaction = 'linked_action';
                                $actiondiff = 'linked_action_difficulty';
                                $diffcol = 'white';
                                $linkedto = 'no';
                            }
                            if($x == 3) {
                                $mainaction = 'action';
                                $actiondiff = 'action_difficulty';
                                $diffcol = 'red';
                                $linkedto = 'no';
                            }
                            if($x == 4) {
                                $mainaction = 'linked_action';
                                $actiondiff = 'linked_action_difficulty';
                            }
            
            
                            echo '<actionbar><action>';
                                if($mainaction == 'linked_action') { echo '<span class="linked-action"></span>'; }
                                echo '<a href="" class="'.$term->slug.' '.$diffcol.'-diff"></a>'; 
                                if($linkedto == 'yes') { echo '<span class="linked-action"></span>'; }
                            echo '</action></actionbar>';    
                        ?>
                        <?php foreach( $ships as $ship ): ?>
                            
                            <?php $mainships = get_field('ship', $ship->ID); foreach($mainships as $mainship) : ?>
                                <?  if( have_rows('actions', $ship->ID) ): $actionnum = 0;
                                        $showship = 0;
                                         while ( have_rows('actions', $ship->ID) ) : the_row();
                                            $action = get_sub_field($mainaction);
                                            $diff = get_sub_field($actiondiff);
                                            switch ($x) :
                                                case 0:
                                                    if($action->slug == $term->slug && $diffcol == $diff && get_sub_field('linked_action')) { $showship = 1; }
                                                break;
                                                case 1:
                                                    if($action->slug == $term->slug && $diffcol == $diff && !get_sub_field('linked_action')) { $showship = 1; }
                                                break;
                                                case 2:
                                                    if($action->slug == $term->slug && $diffcol == $diff) { $showship = 1; }
                                                break;
                                                case 3:
                                                    if($action->slug == $term->slug && $diffcol == $diff && !get_sub_field('linked_action')) { $showship = 1; }
                                                break;
                                                case 4:
                                                    if($action->slug == $term->slug && $diffcol == $diff) { $showship = 1; }
                                                break;
            
                                            endswitch;
            
                                        endwhile;
                                        
            
                                    endif;
                                        
                                ?>
                                    <?php if($showship == 1) { ?>
            
                                        <h4 class="ship-list">
                                            <span class="ship-type">
                                                <span class="faction <?php $shipfaction = get_field('faction', $ship->ID); echo $shipfaction->slug; ?>"></span>    
                                                <a href="<?php echo get_permalink($mainship->ID); ?>"><?php echo get_the_title( $ship->ID ); ?></a>
                                            </span>
                                        </h4>
                                    <?php } ?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                        <?php endfor; ?>
				<?php endif; ?> 
        </column>
        
       
    


<?php get_footer(); ?>