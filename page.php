<?php get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <titlebar>
        <h1><?php the_title(); ?></h1>
    </titlebar>
	

	
           
            
    

<?php endwhile; ?>
<?php get_footer(); ?>