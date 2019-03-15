<?php get_header(); ?>
    <titlebar>
        <h1><?php the_field('frontpage_title', 'options'); ?></h1>
    </titlebar>
    
    <column class="col-2 col-wrapper">
        <column class="col-2">
    	    <?php the_field('frontpage_text','options'); ?>
        </column>
        
        
        <column class="col-2 col-wrapper">
            <h3 class="full-title expand-justify">Best of class<span class="expand-nav"><span class="show-img-btn show-thumbs"></span><span class="expand-btn">+</span></span></h3>            
            <?php 
            $pilots = get_posts(array(
                    'post_type' => 'pilot',
                    'posts_per_page' => 6,
                    'meta_key' => 'ratings_average', 
                    'orderby' => 'meta_value_num', 
                    'order' => 'DESC'
                    
                ));
            if( $pilots ):
                foreach( $pilots as $pilot ):
                    echo '<column class="col-1 col-best-of post-ratings">';
                    $hidden = 'hidden'; $includeimg = 2; include(locate_template('pilotpanel.php'));
                    echo do_shortcode('[ratings id="'.$pilot->ID.'" results="true"]');
                    echo '</column>';
                endforeach; 
            endif; 
            ?>
            <a class="btn lm" href="<?php echo get_field('all_grades', 'options'); ?>">All grades</a>
        </column>
        
        
    </column>

        <column class="col-2 col-wrapper stm">
            <h3 class="full-title">Guides &amp; Strategies</h3>
            <?php 
            $guidenum == 0;
            $guides = get_posts(array(
                    'post_type' => 'post',
                    
                    'posts_per_page' => 5,
                    
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
    
    <column class="col-2 col-wrapper col-factions stm">
        <h3 class="full-title">Factions</h3>
        <?php $factions = get_field('frontpage_factions', 'options');
            foreach($factions as $faction) :
            $factionterm = get_field('faction', $faction->ID); 
        ?>
        <column class="col-1 <?php echo $factionterm->slug.'-colour '; ?>col-res-half">
            <thumbframe>
                <a href="<?php echo get_the_permalink($faction->ID); ?>">
                    <img src="<?php $thumb = get_field('thumb', $faction->ID); echo $thumb[sizes][medium]; ?>" alt="<?php the_title(); ?>" />
                    <div class="thumb-overlay"></div>
                </a>
                
            </thumbframe>
            
            <thumbdescription>
                <thumbtitle>
                    <div class="thumbtitleflex">
                        <h4><a href="<?php echo get_the_permalink($faction->ID); ?>"><?php echo get_the_title($faction->ID); ?></a></h4>
                    </div>
                    <div class="thumbfaction">
                       <titleicon><faction class="<?php echo $factionterm->slug; ?>"></faction></titleicon> 
                    </div>
                </thumbtitle>
            </thumbdescription>
        </column>
        
        <?php
            endforeach; 
        ?>
        
    </column>
    <column class="col-2 col-wrapper">
        <column class="col-2 col-half-content">
            <h3>Tools</h3>
            <?php 

            $rels = get_field('frontpage_boxes_rel', 'options');

            if( $rels ): ?>
                <?php foreach( $rels as $p ): // variable must NOT be called $post (IMPORTANT) ?>
                    <div class="related-div">
                        <links class="guide">
                            <?php if(get_field('thumb', $p->ID)) { ?>
                                <thumbframe>
                                    
                                        <a href="<?php echo get_the_permalink($p->ID); ?>" ><img src="<?php $thumb = get_field('thumb', $p->ID); echo $thumb[sizes][medium]; ?>" /></a>
                                    
                                </thumbframe>        
                            <?php } ?>
                            <h4><a href="<?php echo get_the_permalink($p->ID); ?>" ><?php the_field('excerpt_title', $p->ID); ?></a></h4>
                            <p><?php the_field('excerpt', $p->ID); ?></p>
                        </links>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </column>
        <column class="col-2">
        	<h3>Upgrades</h3>
           	<div class="upgrade-list">
	            <?php $terms_type = get_terms('upgrade-types-tax');
			
				foreach ( $terms_type as $term_type ) : ?>
					<a href="<?php bloginfo('url'); ?>/upgrade-types-tax/<?php echo $term_type->slug; ?>"><upgrade class="<?php echo $term_type->slug; ?>"></upgrade></a>
				<?php endforeach; ?>
        	</div>
        </column>
    </column>
	<?php /*?><column class="col-1">
		<h3>Reviews</h3>
   <?php 
                 $posts = get_posts(array(
                        'post_type' => 'post',
						'posts_per_page' => 2,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'guide-type',
                                'field' => 'slug',
                                'terms' => 'review'
                            )
                        )
                    ));
            
            ?>
            <?php if( $posts ): ?>
                
                <?php foreach( $posts as $post ): ?>
                    <links class="guide">
                        <?php if(get_field('thumb',$post->ID)) { ?>
                            <thumbframe>
                                <a href="<?php echo get_permalink( $post->ID ); ?>" ><img src="<?php $thumb = get_field('thumb',$post->ID); echo $thumb[sizes][medium]; ?>" alt="<?php echo get_the_title( $post->ID ); ?>" /></a>
                            </thumbframe>        
                        <?php } ?>
                        <h4><a href="<?php echo get_permalink( $post->ID ); ?>" ><?php echo get_the_title( $post->ID ); ?></a></h4>
                        <?php if(get_field('excerpt',$post->ID)) : ?><p><?php the_field('excerpt',$post->ID); ?></p><?php endif; ?>                            
                    </links>          
                <?php endforeach; ?>
            <?php endif; ?>  			
	
	</column>
	<column class="col-1">
		<h3>Strategies</h3>
		 <?php 
			 $posts = get_posts(array(
					'post_type' => 'post',
					'tax_query' => array(
						array(
							'taxonomy' => 'guide-type',
							'field' => 'slug',
							'terms' => 'strategy'
						)
					)
				));

		?>
		<?php if( $posts ): ?>

			<?php foreach( $posts as $post ): ?>
				<links class="guide">
					<?php if(get_field('thumb',$post->ID)) { ?>
						<thumbframe>
						
								<a href="<?php echo get_permalink( $post->ID ); ?>" ><img src="<?php $thumb = get_field('thumb',$post->ID); echo $thumb[sizes][medium]; ?>" alt="<?php echo get_the_title( $post->ID ); ?>" /></a>
						
						</thumbframe>        
					<?php } ?>
					<h4><a href="<?php echo get_permalink( $post->ID ); ?>" ><?php echo get_the_title( $post->ID ); ?></a></h4>
					<?php if(get_field('excerpt',$post->ID)) : ?><p><?php the_field('excerpt',$post->ID); ?></p><?php endif; ?>                            
				</links>                    
			<?php endforeach; ?>
		<?php endif; ?>                    
    </column>
	
	
      
        
        <?php 
            if( have_rows('frontpage_boxes', 'options') ):
                while ( have_rows('frontpage_boxes', 'options') ) : the_row(); ?>
                    <column class="col-1 wbg">
                        <h3><?php the_sub_field('top_title'); ?></h3>
                        <links class="guide">
                            <?php if(get_sub_field('thumb')) { ?>
                                <thumbframe class="dbg">
                                    
                                        <a href="<?php the_sub_field('link'); ?>" ><img src="<?php $thumb = get_sub_field('thumb'); echo $thumb[sizes][medium]; ?>" /></a>
                                    
                                </thumbframe>        
                            <?php } ?>
                            <h4><a href="<?php the_sub_field('link'); ?>" ><?php the_sub_field('title'); ?></a></h4>
                            <p><?php the_sub_field('text'); ?></p>
                        </links>
                    </column>
                <?php endwhile;
            endif;
        ?>
         <column class="col-1">
            <h3>Latest ships</h3>
            
            <?php 
                 $posts = get_posts(array(
                        'post_type' => 'ship',
                        'posts_per_page' => 4
    
                    ));
            
            ?>
            <?php if( $posts ): $num = 0 ?>
                
                <?php foreach( $posts as $post ): ?>
                    <links class="guide slide slide-<?php echo ++$num; ?>">
                        <?php if(get_field('thumb',$post->ID)) { ?>
                            <thumbframe>
                                
                                    <a href="<?php echo get_permalink( $post->ID ); ?>" ><img src="<?php $thumb = get_field('thumb',$post->ID); echo $thumb[sizes][medium]; ?>" alt="<?php echo get_the_title( $post->ID ); ?>" /></a>
                                
                            </thumbframe>        
                        <?php } ?>                
                        <h4 <?php if(get_field('unique',$post->ID)) { echo 'class="unique"'; } ?>><a href="<?php echo get_permalink( $post->ID ); ?>" ><?php echo get_the_title( $post->ID ); ?></a></h4>
                        <?php if(get_field('excerpt',$post->ID)) : ?><p><?php the_field('excerpt',$post->ID); ?></p><?php endif; ?>                            
                    </links>                    
                <?php endforeach; ?>
            <?php endif; ?>       
        </column><?php */?>
        <?php /*?>
        <column class="col-1 wbg">
            <h2>Latest ships</h2>
            
            <?php 
                 $posts = get_posts(array(
                        'post_type' => 'ship',
                        'posts_per_page' => 4
    
                    ));
            
            ?>
            <?php if( $posts ): $num = 0 ?>
                
                <?php foreach( $posts as $post ): ?>
                    <links class="slide slide-<?php echo ++$num; ?>">
                        <?php if(get_field('thumb',$post->ID)) { ?>
                            <thumbframe class="starfield dbg">
                                <thumb>
                                    <a href="<?php echo get_permalink( $post->ID ); ?>" ><img src="<?php $thumb = get_field('thumb',$post->ID); echo $thumb[sizes][medium]; ?>" alt="<?php echo get_the_title( $post->ID ); ?>" /></a>
                                </thumb>
                            </thumbframe>        
                        <?php } ?>                
                        <h3 <?php if(get_field('unique',$post->ID)) { echo 'class="unique"'; } ?>><a href="<?php echo get_permalink( $post->ID ); ?>" ><?php echo get_the_title( $post->ID ); ?></a></h3>
                        <?php if(get_field('excerpt',$post->ID)) : ?><p><?php the_field('excerpt',$post->ID); ?></p><?php endif; ?>                            
                    </links>                    
                <?php endforeach; ?>
            <?php endif; ?>       
        </column>
        
  		<column class="col-1 wbg">
            <h2>Aces</h2>
            
            <?php 
                 $posts = get_posts(array(
                        'post_type' => 'pilot',
                        'posts_per_page' => 2,
						'orderby' => 'rand',
						'meta_query' => array(
							array(
								'key' => 'unique',
								'value' => '1',
								'compare' => '=='
							),
							array(
								'key' => 'pilot_skill_value',
								'value' => '7',
								'compare' => '>='
							)
						)
    
                    ));
            
            ?>
            <?php if( $posts ): $num = 0 ?>
                
                <?php foreach( $posts as $post ): ?>
                    <links>
                        <?php if(get_field('thumb',$post->ID)) { ?>
                            <thumbframe class="dbg">
                                <thumb>
                                    <a href="<?php echo get_permalink( $post->ID ); ?>" ><img src="<?php $thumb = get_field('thumb',$post->ID); echo $thumb[sizes][medium]; ?>" alt="<?php echo get_the_title( $post->ID ); ?>" /></a>
                                </thumb>
                            </thumbframe>        
                        <?php } ?>                
                        <h3><a href="<?php echo get_permalink( $post->ID ); ?>" ><?php echo get_the_title( $post->ID ); ?></a></h3>
                        <?php if(get_field('excerpt',$post->ID)) : ?><p><?php the_field('excerpt',$post->ID); ?></p><?php endif; ?>                            
                    </links>                    
                <?php endforeach; ?>
            <?php endif; ?>       
        </column>   
<?php */?>
        	<?php /*?>        <column class="col-1 wbg">
<h2><?php the_field('shop_title','options'); ?></h2>
            <links>
            	<p><?php the_field('shop_plea', 'options'); ?></p>
            </links>  

      		<div class="amazon amazon-uk">
				<?php the_field('frontpage_amazon_embed_uk','options'); ?>
			</div>

      		<div class="amazon amazon-us">                            
				<?php the_field('frontpage_amazon_embed_us','options'); ?>
        	</div>

            <p class="lan-select">Change Store: <span class="uk">UK</span> | <span class="us"> US </span></p>  
              
                    
		</column>
        <?php */?>          
                            
    
<script type="text/javascript">
	jQuery(document).ready(function($) {
		/*slidenum = 1;
		slidemax = $('.slide').size();
		$('.slide').parent().css('min-height',$('.slide').parent().innerHeight()+'px');
	

		int=self.setInterval(function(){slider()},8000);
		
		function slider() {
			$('.slide-'+slidenum+' img').animate({'opacity': '0'}, 1000, function() {
				$('.slide-'+slidenum).css('display','none');
				slidenum++;
				if(slidenum > slidemax) {
					slidenum = 1;	
				}
				$('.slide-'+slidenum).css('display','block');
				$('.slide-'+slidenum+' img').animate({'opacity': '1'}, 1000);
			
			
			});
		}*/
		
		
		
		
		
	});
</script>

<?php get_footer(); ?>
