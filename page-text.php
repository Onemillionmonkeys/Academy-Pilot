<?php 
/*
* Template Name: Plain text
*/
get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
     <titlebar>
    
            <h1><?php the_title(); ?></h1>
    
    </titlebar>
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
    
    
        <column class="col-2">
            
            <?php the_field('content'); ?>
        	<?php if(get_field('email')) : ?>
            	<p>Contact <?php bloginfo('title'); ?>: <a href="mailto:<?php echo antispambot(get_field('email')); ?>" rel="nofollow"><?php echo antispambot(get_field('email')); ?></a></p>
            <?php endif; ?>
            <?php if(get_field('aside_title')) : ?><h2><?php the_field('aside_title'); ?></h2><?php endif; ?>
            <div class="icon-field">
				<?php
                if( have_rows('icon_field') ):
                    while ( have_rows('icon_field') ) : the_row(); ?>
                    	<?php if(get_sub_field('icon')) { ?>
                            <thumbframe>
                                <a href="<?php the_sub_field('link'); ?>" target="_blank" rel="nofollow"><img src="<?php $thumb = get_sub_field('icon'); echo $thumb[sizes][medium]; ?>" alt="" /></a>
                            </thumbframe>        
                        <?php } ?>                                    
                    <?php endwhile;
                endif;
                ?>            
            </div>  
        </column>
<?php endwhile; ?>
<?php get_footer(); ?>