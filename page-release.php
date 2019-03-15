<?php 
/*
* Template Name: Release
*/
get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
     <titlebar>
    
            <h1><?php the_title(); ?></h1>
    
    </titlebar>
	    <column class="col-4 col-second-edition">
		<h3>X-Wing Second Edition</h3>
		<div class="countdown">
			<div class="targeting-computer">
				<div class="target-lines"></div>
                
			</div>
			<div class="countdown-display-con">	
				<p class="countdown-display"><?php $date = get_field('release_date', 'options', false, false); $date = new DateTime($date); echo $date->getTimestamp(); ?></p>
			    </div>
			
		</div>
		
        <?php the_field('second_edition_frontpage_text', 'options'); ?>
        
	</column>
<?php endwhile; ?>

<?php get_footer(); ?>