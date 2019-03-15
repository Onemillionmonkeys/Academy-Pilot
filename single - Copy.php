<?php get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<?php $the_ID = get_the_id(); ?>
	<titlebar>
        <h1><?php the_title(); ?></h1>
    </titlebar>
	
    <column class="col-1 col-aside">
        

    	<h3>META</h3>
        <links class="guide">
        <?php if(get_field('thumb')) { ?>
                <thumbframe>
                    
                        <img src="<?php $thumb = get_field('thumb'); echo $thumb[sizes][medium]; ?>" title="<?php the_title(); ?>" />
                    
                </thumbframe>        
            <?php } ?>
			<h4><?php the_title(); ?></h4>
			<p><?php the_field('excerpt'); ?></p>
			<p>
				<?php $term = get_field('meta'); if( $term ): ?>
					Written according to the <?php echo $term->name; ?> meta.<br>
				<?php endif; ?>
				Posted on: <time itemprop="startDate" datetime="<?php the_time('Y-m-d')?>T<?php the_time('H:i'); ?>"><?php the_time('d-m Y');?></time><br>
				<?php $modtxt = get_the_modified_date('d/m/y'); if(get_the_modified_date('d/m/y') != get_the_date('d/m/y')) { ?> 
					Revised: <?php the_modified_time('d-m Y'); ?><br>
				<?php } ?>
				By: <?php the_author(); ?>
            </p>
    	</links>
	</column>
        
        
    
       
		
        <column class="col-2">
        	<article>
			<h3><?php the_title(); ?></h3>
        
			<?php
            if( have_rows('content_type') ):
                while ( have_rows('content_type') ) : the_row();
             
                    if( get_row_layout() == 'content' ): ?>
                        
    
						<?php the_sub_field('text'); ?>

                    <?php elseif( get_row_layout() == 'expanded_content') : ?>
						<div class="txt-expand-div">
                        	<h3><?php the_sub_field('expanded_title'); ?><span class="txt-expand-btn">+</span></h3>

	                        <div class="txt-expand-con">
                            	<div class="txt-expand-content">
									<?php the_sub_field('expanded_text'); ?>
                            	</div>
                        	</div>
    					</div>        
                    
                    <?php elseif( get_row_layout() == 'squad_list') : $totalvalue = 0; ?>
                    		<div class="squad-list">
                            	<h3><?php the_sub_field('squad_list_title'); ?></h3>
								<div class="squad-list-titles">
                                    <h4>
                                        <span class="pilot-title">Pilot</span>
                                        <span class="upgrades-title">Upgrades</span>
                                        <span class="cost-title">Cost</span>
                                    </h4>
                                </div>
                                <?php if( have_rows('squad') ):
 									while ( have_rows('squad') ) : the_row(); ?>
 									<div class="squad-list-ship">                                            
										<?php $value = 0; ?>
                                        <?php $xposts = get_sub_field('pilot');
										 
										if( $xposts ): ?>
										
											<?php foreach( $xposts as $pilot ): // variable must NOT be called $post (IMPORTANT) ?>
                                            	<?php $value += intval(get_field('squad_point_cost', $pilot->ID)); ?>
												
                                                
                                                    <div class="squad-pilot">
                                                    	<?php include(locate_template('pilotpanel.php')); ?>
													</div>
											<?php endforeach; ?>
											
										<?php endif; ?>
                                            <div class="squad-upgrades">
                                                <?php
                                                if( have_rows('squad_upgrades') ):
                                                    while ( have_rows('squad_upgrades') ) : the_row(); ?>
                                                        
    
                                                        <?php 
                                                         
                                                        $upgrade = get_sub_field('upgrade');
                                                         
                                                        if( $upgrade ): ?>
                                                        
                                                            <?php foreach( $upgrade as $pilot ): // variable must NOT be called $post (IMPORTANT) ?>
                                                            
                                                                <?php for($i = 1; $i <= get_sub_field('number'); $i++) { ?>
                                                                    <?php $value += intval(get_field('cost', $pilot->ID)); ?>
                                                                    
                                                                    <?php include('upgradepanel.php'); ?>
                                                                <?php } ?>
                                                            
                                                            <?php endforeach; ?>
                                                            
                                                        <?php endif; ?>   
    
    
                                                        
                                                    <?php endwhile;
                                                endif; ?>
                                                
    
                                            </div>
                                            <div class="pricetag">
                                                <div class="value">
                                                    <h4><?php echo $value; $totalvalue += $value; ?></h4>
                                                </div>
                                            </div>
                                        </div>
									<?php endwhile;
								endif; ?>
                                <div class="totalvalue">
									<div class="pricetag">
                                        <div class="value">		
                                            <h4><?php echo $totalvalue; ?></h4>
                                        </div>
									</div>
								</div>
                            </div>
                    
                    <?php endif; ?>
                
                <?php endwhile; ?>
        
            <?php endif; ?>   

			<?php if ( is_user_logged_in() ) : ?>


                <div class="expand-div">
                    <h2>Comments (<?php comments_number('%','%','%'); ?>)<span class="expand-btn">+</span></h2>

                    <div class="clear"></div>
                    <div class="expand-con">
                        <div class="expand-content">
							<?php comments_template(); ?>

                        </div>
                    </div>
                </div>  


    
    


			<?php endif; // USER LOGGED IN ?>
			</article>
    	</column>
		
<column class="col-1 col-aside">

            <h3>Related content</h3>
                       
                <? $xposts = get_field('related_ships');
                if( $xposts ): ?>
		            <div class="child-content"> 
                        <?php foreach( $xposts as $p ): ?>
                            <div class="col-half">
                                <?php if(get_field('thumb', $p->ID)) { ?>
                                    <a href="<?php echo get_permalink( $p->ID ); ?>"><img src="<?php $thumb = get_field('thumb', $p->ID); echo $thumb[sizes][medium]; ?>" alt="<?php echo get_the_title( $p->ID ); ?>" /></a>
                                <?php } ?>                                    
								<h4><a href="<?php echo get_permalink( $p->ID ); ?>"><?php echo get_the_title($p->ID); ?></a></h4>
                            </div>                                 
                        <?php endforeach; ?>
					</div>
                <?php endif; ?>
                
                <? $xposts = get_field('related_pilots');
                if( $xposts ): ?>
		            <div class="child-content"> 
                        <?php foreach( $xposts as $p ): ?>
                            <div class="col-half">
                                <?php if(get_field('thumb', $p->ID)) { ?>
                                    
                                        <a href="<?php echo get_permalink( $p->ID ); ?>"><img src="<?php $thumb = get_field('thumb', $p->ID); echo $thumb[sizes][medium]; ?>" alt="<?php echo get_the_title( $p->ID ); ?>" /></a>
                                    
                                <?php } ?>                                    
                                <h4><?php echo get_the_title($p->ID); ?></h4>
                            </div>                                 
                        <?php endforeach; ?>
					</div>
                <?php endif; ?>  

                <? $xposts = get_field('related_upgrades');
                if( $xposts ): ?>
		            <div class="child-content"> 
                        <?php foreach( $xposts as $p ): ?>
                            <div class="col-half">
                                <?php if(get_field('thumb', $p->ID)) { ?>
                                        <a href="<?php echo get_permalink( $p->ID ); ?>"><img src="<?php $thumb = get_field('thumb', $p->ID); echo $thumb[sizes][medium]; ?>" alt="<?php echo get_the_title( $p->ID ); ?>" /></a>
                                <?php } ?>                                    
                                <h4><?php echo get_the_title($p->ID); ?></h4>
                            </div>                                 
                        <?php endforeach; ?>
					</div>
                <?php endif; ?> 
                
		                                                                       

        </column>                
	
    
        
    <div class="clear"></div>
	

<?php endwhile; // end of the loop. ?>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		btn_act = 0;

		$('.txt-expand-btn').click( function() {
			if(btn_act == 0) {
				btn_act = 1;	

				var h = $(this).parents('.txt-expand-div').find('.txt-expand-content').innerHeight();
				var eh = $(this).parents('.txt-expand-div').find('.txt-expand-con').innerHeight();
				if(eh > 0) {
					$(this).text('+');
				} else {
					$(this).text('-');
				}
				$(this).parent().parent().children('.txt-expand-con').animate({'height': (h-eh)+'px'},500, function() {
					btn_act = 0;	
					
				});
			}
		});	
	});
</script>


<?php get_footer(); ?>