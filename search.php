<?php get_header(); ?>

<?php if ( have_posts() ) : ?>

		<titlebar>
        	<h1><?php printf( __( 'Search: %s', 'boilerplate' ), '' . get_search_query() . '' ); ?></h1>
		</titlebar>
        
        <column class="col-4 col-wrapper stm">
            <h3 class="full-title">Search Results</h3>
		<?php while ( have_posts() ) : the_post(); ?>
            <?php if(get_post_type() != 'ship-configuration' && get_field('second_edition')) { ?>
            
            <column class="col-1 col-res-half col-search">
                <thumbframe>
                    <?php if(get_field('thumb')) { $thumb = get_field('thumb'); } else { $thumb = get_field('placeholder', 'options'); } ?>
                    <a href="<?php echo get_permalink( $post->ID ); ?>"><img src="<?php echo $thumb[sizes][medium]; ?>" alt="<?php echo get_the_title( $post->ID ); ?>" /></a>
                </thumbframe>
                <thumbdescription>
                        <thumbtitle>
                            <div class="thumbtitleflex">
                                <h4><a href="<?php echo get_permalink( $post->ID ); ?>"><?php echo get_the_title( $post->ID ); ?></a></h4>
                                <?php if(get_field('full_title')) { echo '<p>'.get_field('full_title').'</p>'; } ?>
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
                            <?php } else {
                                $terms = get_field('upgrade_type'); if( $terms ): foreach( $terms as $term ): $slug = $term->slug; endforeach; endif;
                                echo '<div class="thumbfaction">';
                                    echo '<titleicon><faction class="'.$slug.'"></faction></titleicon>';
                                echo '</div>';
                            } ?>
                        </thumbtitle>
                </thumbdescription>
            </column>
            <?php } ?>
        <?php endwhile; ?>
        </column>
    

<?php else : ?>


<h1><?php printf( __( '<span class="grey">Nothing found:</span> %s', 'boilerplate' ), '' . get_search_query() . '' ); ?></h1>

<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'boilerplate' ); ?></p>

        
<?php endif; ?>

<?php get_footer(); ?>
