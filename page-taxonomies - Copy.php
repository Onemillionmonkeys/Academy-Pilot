<?php 
/*
* Template Name: List and Taxonomy
*/


get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

    <titlebar>
        <h1><?php the_title(); ?></h1>
    </titlebar>

    
    
	<?php if(get_field('page_type') == 'list') : ?>

		<?php 
			$posttype = get_field('post_type');

			$termarray = array();
	
			if( have_rows('terms') ):
				while ( have_rows('terms') ) : the_row();
					
					array_push($termarray, get_sub_field('term'));
				endwhile;
			endif;


			
			if(get_field('taxonomy')) {
				$posts = get_posts(array(
					'post_type' => $posttype,
					'posts_per_page'=>-1,
					'orderby' => 'name',
					'order' => 'ASC',					
					'tax_query' => array(
						array(
							'taxonomy' => get_field('taxonomy'),
							'field' => 'slug',
							'terms' => $termarray,
						)
					)
				));				
				
			} else {
				$posts = get_posts(array(
					'post_type' => $posttype,
					'posts_per_page'=>-1,
					'orderby' => 'name',
					'order' => 'ASC'
				));
			}

            ?>
            <?php if( $posts ): ?>
					<?php foreach( $posts as $post ): ?>
						<?php if(get_field('second_edition')) { ?>
							<column class="col-1">
							<?php if(get_field('thumb')) { ?>
								<?php 
									if($posttype == 'ship' || $posttype == 'pilot') {
										$class = ''; 
										$terms = get_field('faction');
											if( $terms ): 
												foreach( $terms as $term ): 
													$class .= $term->slug.' ';
												endforeach;
											endif;
									} 
								?>

								<thumbframe>
									<a href="<?php echo get_permalink( $post->ID ); ?>"><img src="<?php $thumb = get_field('thumb'); echo $thumb[sizes][medium]; ?>" alt="<?php echo get_the_title( $post->ID ); ?>" /></a>
								</thumbframe>        
							<?php } else { ?>
								<thumbframe>
									<?php if($posttype == 'ship') { $placeholder = 'placeholder'; } else { $placeholder = 'placeholder_pilot'; } ?>
									<a href="<?php echo get_permalink( $post->ID ); ?>"><img src="<?php $thumb = get_field($placeholder, 'options'); echo $thumb[sizes][medium]; ?>" alt="<?php echo get_the_title( $post->ID ); ?>" /></a>
								</thumbframe>        
							<?php } ?>
								<thumbdescription>
									<thumbtitle>
										<div class="thumbtitleflex">
											<h4><a href="<?php echo get_permalink( $post->ID ); ?>"><?php echo get_the_title( $post->ID ); ?></a></h4>
											<?php 
											$ships = get_field('ship_conf');
												if( $ships ): ?>
												<?php foreach( $ships as $p ): // variable must NOT be called $post (IMPORTANT) ?>
													<p><a href="<?php echo get_permalink( $p->ID ); ?>"><?php echo get_the_title( $p->ID ); ?></a></p>

												<?php endforeach; ?>
											<?php endif; ?>
										</div>
										<?php 
											if($posttype == 'ship' || $posttype == 'pilot') {
												echo '<div class="thumbfaction">';
												$terms = get_field('faction');
												if( $terms ): 
													foreach( $terms as $term ): ?>
														 <titleicon><faction class="<?php echo $term->slug; ?>"></faction></titleicon>
													<?php endforeach;
												endif;
												echo '</div>';
											} elseif($posttype == 'upgrade') {
												echo '<div class="thumbfaction">';
												$terms = get_field('upgrade_type');
												if( $terms ): 
													foreach( $terms as $term ): ?>
														 <titleicon><faction class="<?php echo $term->slug; ?>"></faction></titleicon>
													<?php endforeach;
												endif;
												echo '</div>';
											}
										?>
									</thumbtitle> 
									<?php if(get_field('excerpt')) { ?>
										<h3><?php the_time('d m y'); ?></h3>
										<p><?php the_field('excerpt'); ?></p>
									<?php } ?>
								</thumbdescription>
							</column>
						<?php } ?>
                    <?php endforeach; ?>

            <?php endif; ?>  

	<?php elseif(get_field('page_type') == 'taxonomy') : ?>

			<?php
            	$tax_posttype = get_field('post_type');
                $tax = get_field('taxonomy');
                $terms = get_terms($tax);
				$term_type = get_field('term_type');
				$term_type_term = get_field('term');
				
				foreach ( $terms as $term ) { ?>
				<column class="col-2 col-flex">
					<h3><?php echo $term->name; ?></h3>
                    <div>                
                        <column class="col-icon">
                            <upgrade class="<?php echo $term->slug; ?>"></upgrade>
                        </column>
                        <column class="col-content">
    
                                       
    
                        
                            <?php 
                                $tax_query = array(
                                    array(
                                        'taxonomy' => $tax,
                                        'field' => 'slug',
                                        'terms' => $term->slug
                                    )
                                );
                                
                                if ( $term_type != '') {
                                    array_push(
                                        $tax_query, array(
                                            'taxonomy' => $term_type,
                                            'field' => 'slug',
                                            'terms' => $term_type_term
                                        )
                                    );
                                }
                            
                                $posts = get_posts(array(
                                'post_type' => $tax_posttype,
                                'posts_per_page'=>-1,
                                'orderby' => 'name',
                                'order' => 'ASC',					
                                'tax_query' => $tax_query
                            )) ?>
                            <?php if( $posts ): ?>
 
                                <?php foreach( $posts as $post ): ?>                        
									<h4><a href="<?php echo get_permalink( $post->ID ); ?>"><?php echo get_the_title( $post->ID ); ?></a></h4>
                
                                <?php endforeach; ?>
                             <?php endif; ?>                                
                        </column>
                    </div>
				</column>
			<?php } ?>
            
    <?php endif; ?>

<?php endwhile; ?>
<?php get_footer(); ?>