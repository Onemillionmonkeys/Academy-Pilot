<?php
/*
* Template Name: Chart
*/
 get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<titlebar>
        <h1><?php the_title(); ?></h1>
    </titlebar>
	<column class="col-4">
    	<div class="chart-row chart-header">
        	<div class="chart-ship-title"></div>
            <div class="chart-items">
				<?php $terms_type = get_terms('upgrade-types-tax');
                foreach ( $terms_type as $term_type ) : ?>
                    <upgrade class="<?php echo $term_type->slug; ?>" showupgrade=""></upgrade>
                <?php endforeach; ?>
            </div>
        </div>
    	<?php 
			$posts = get_posts(array(
				'post_type' => 'ship',
				'posts_per_page'=>-1,
				'orderby' => 'name',
				'order' => 'ASC',
				'meta_query' => array(
					array(
						'key' => 'second_edition',
						'compare' => '==',
						'value' => '1'
					)
				)
			));	?>
            <?php if( $posts ): ?>
				<?php foreach( $posts as $post ): setup_postdata($post); ?>
					<div class="chart-row chart-ship" showship="yes">
						<?php
						$configurations = get_posts(array(
						'post_type' => 'ship-configuration',
								'meta_query' => array(
									array(
										'key' => 'ship', // name of custom field
										'value' => '"' . get_the_ID() . '"', // matches exactly "123", not just 123. This prevents a match for "1234"
										'compare' => 'LIKE'
									)
								)
							));
							?>
							<?php if( $configurations ): ?>
								<?php foreach( $configurations as $conf): ?>
									<thumbdescription>
										<thumbtitle>
											<div class="thumbtitleflex">
												<h4><a href="<?php the_permalink(); ?>"><?php echo get_the_title($conf->ID); ?></a></h4>
											</div>
											<div class="thumbfaction">														 
												<titleicon><faction class="<?php $faction = get_field('faction'); echo $faction[0]->slug;; ?>"></faction></titleicon>
											</div>									
										</thumbtitle> 
									</thumbdescription>
								<?php endforeach; ?>
							<?php endif; ?>
							<div class="chart-items">
								<?php $terms_type = get_terms('upgrade-types-tax'); ?>
										<?php foreach ( $terms_type as $term_type ) : $termnum = ''; $upgradeclass = ''; $hasupgrade = 0; ?>
											<?php if( have_rows('upgrades', $conf->ID) ): ?>
                                            	<?php while ( have_rows('upgrades', $conf->ID) ) : the_row(); ?>
                                                    
                                                    <?php $term = get_sub_field('upgrade_type');if($term_type->slug == $term->slug) { $upgradeclass = $term->slug; $termnum = intval(get_sub_field('upgrade_count')); $hasupgrade = 1; } ?>
                                        		<?php endwhile; ?>
                                   	 		<?php endif; ?>
                                            <?php if($term_type->slug == 'elite-talent') { 
                                            	if(has_term('elite-talent', 'upgrade-types-tax', get_the_ID())) {
													$hasupgrade = 1;
													$upgradeclass = 'elite-talent';
													$termnum = 1;
												}
                                            } ?>
                                            <?php if($term_type->slug == 'modification') { 
                                            	if(has_term('modification', 'upgrade-types-tax', get_the_ID())) {
													$hasupgrade = 1;
													$upgradeclass = 'modification';
													$termnum = 1;
												}
                                            } ?>
                                            <?php if($term_type->slug == 'title') { 
                                            	if(has_term('title', 'upgrade-types-tax', get_the_ID())) {
													$hasupgrade = 1;
													$upgradeclass = 'title';
													$termnum = 1;
												}
                                            } ?>
										<upgrade class="<?php echo 'upgrade-'.$upgradeclass; if($hasupgrade == 1) { echo ' haveupgrade'; } ?>">
                                            <?php if($termnum != '') { 
                                                for($xn = 1; $xn <= $termnum; $xn++) { ?>
                                                    <div class="<?php echo $upgradeclass; ?>"></div>
                                            
                                                <?php } 
                                            } ?>
                                            <?php /*?><div><p><?php if($termnum != '') { echo $termnum; } ?></p></div><?php */?>
                                        </upgrade>
								<?php endforeach; ?>
								
								
							</div>
									
									
									
									
									<?php /*?><div class="chart-items">
                                    	<?php $terms_type = get_terms('upgrade-types-tax'); ?>
										<?php foreach ( $terms_type as $term_type ) : $termnum = ''; $upgradeclass = ''; $hasupgrade = 0; ?>
											<?php if( have_rows('upgrades') ): ?>
                                            	<?php while ( have_rows('upgrades') ) : the_row(); ?>
                                                	<?php if( have_rows('upgrade_bar') ): ?>
                                                        <?php while ( have_rows('upgrade_bar') ) : the_row(); ?>
                                                        	<?php $term = get_sub_field('upgrade_type'); if($term_type->slug == $term->slug) { $upgradeclass = $term->slug; $termnum = get_sub_field('upgrade_type_number'); $hasupgrade = 1; } ?>
														<?php endwhile; ?>
                                                        
                                                	<?php endif; ?>
                                        		<?php endwhile; ?>
                                   	 		<?php endif; ?>
                                            <?php if($term_type->slug == 'elite-talent') { 
                                            	if(has_term('elite-talent', 'upgrade-types-tax', get_the_ID())) {
													$hasupgrade = 1;
													$upgradeclass = 'elite-talent';
													$termnum = 1;
												}
                                            } ?>
                                            <?php if($term_type->slug == 'modification') { 
                                            	if(has_term('modification', 'upgrade-types-tax', get_the_ID())) {
													$hasupgrade = 1;
													$upgradeclass = 'modification';
													$termnum = 1;
												}
                                            } ?>
                                            <?php if($term_type->slug == 'title') { 
                                            	if(has_term('title', 'upgrade-types-tax', get_the_ID())) {
													$hasupgrade = 1;
													$upgradeclass = 'title';
													$termnum = 1;
												}
                                            } ?>
                                            <upgrade class="<?php echo $upgradeclass; if($hasupgrade == 1) { echo ' haveupgrade'; } ?>"><div><p><?php if($termnum != '') { echo $termnum; } ?></p></div></upgrade>
										<?php endforeach; ?>
										
                                    </div>
                                	<?php */?>
					</div>

                        
                        
    
            	<?php endforeach; wp_reset_postdata(); ?>
			<?php endif; ?>                    
    
    </column>
<?php endwhile; ?>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('.chart-header upgrade').click(function() {
			if($(this).attr('showupgrade') == 'show') {
				$(this).attr('showupgrade','notshow');
			} else {
				$(this).attr('showupgrade', 'show');
			}
			
			var showupgradenum = $('.chart-header upgrade[showupgrade="show"]').size();
			
			if(showupgradenum == 0) {
				$('.chart-ship').attr('showship','yes');
				$('.chart-header upgrade').attr('showupgrade','');
				$('.chart-ship[showship="yes"]').css('display','flex');	
			} else {
				$('.chart-ship').attr('showship','yes');
				$('.chart-header upgrade').not('[showupgrade="show"]').attr('showupgrade','notshow');
				$('.chart-header upgrade[showupgrade="show"]').each(function() {
					var selectedupgrade = $(this).attr('class');
					$('.chart-ship').each(function() {
						if($(this).find('upgrade.upgrade-'+selectedupgrade).size() == 0) {
							$(this).attr('showship','no');	
						}
					});
				});
				$('.chart-ship[showship="no"]').css('display','none');
				$('.chart-ship[showship="yes"]').css('display','flex');			
			
			}
			
			
			
			
			
			
			/*var showupgrade = $(this).attr('class');
			
			$('.chart-ship upgrade.'+showupgrade+':not(.haveupgrade)').each(function() {
				$(this).parents('.chart-ship').css('display','none');
			});*/
		});
	});
</script>

<?php get_footer(); ?>