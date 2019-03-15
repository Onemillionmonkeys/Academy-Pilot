<?php get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<?php $the_ID = get_the_id(); ?>
    <?php $wave = get_field('wave'); ?>
    <?php $product_type = get_field('product_type'); ?>
    <?php $content = array(); ?>
	<titlebar>
		<h1><?php the_title(); ?></h1>
	</titlebar>
    <?php $terms = get_field('faction');
    if( $terms ): ?>
    	<titlebar class="faction">
			<?php foreach( $terms as $term ): ?>
                <titleicon><faction class="<?php echo $term->slug; $factioncol .= $term->slug.'-colour ';?>"></faction></titleicon>
            <?php endforeach; ?>
        </titlebar>
    <?php endif; ?>
    <column class="col-2 col-thumb <?php echo $factioncol; ?>">
		<h3><?php if(get_field('call_sign')) { echo get_field('call_sign'); } else { echo get_the_title(); } ?></h3>    
        
            <thumbframe class="desaturation">
				<img src="<?php if(get_field('thumb')) { $thumb = get_field('thumb'); } else { $thumb = get_field('placeholder_pilot', 'options'); } echo $thumb[sizes][large]; ?>" alt="<?php the_title(); ?>" itemprop="image"/>
            </thumbframe>
            <div class="thumb-overlay"></div>
			<article>
                <description itemprop="description">
                    <?php if(get_field('description')) : ?>   
                        <?php the_field('description'); ?>
                        <?php if(get_field('source')) : ?>
                            <p>
                                <a class="source" href="<?php the_field('source'); ?>" rel="nofollow" target="_blank">Source</a>
                            </p>
                        <?php endif; ?>     
                    <?php else : ?>
                        <?php $meta = get_field('ship');
                        if( $meta ): ?>
                            <?php foreach( $meta as $m ): // variable must NOT be called $post (IMPORTANT) ?>
                                    <?php $metaship = $m->ID; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>        
                        <?php $metaterms = get_field('faction', $m->ID);
                        if( $metaterms ): ?>
                            <?php foreach( $metaterms as $metaterm ): ?>
                                <?php $metafaction = $metaterm->name; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>            
						<?php 
							$posts = get_field('ship_conf');
							if( $posts ): foreach( $posts as $p ): 
								$shiptitle = get_the_title($p->ID);	
							endforeach; endif; ?>
					
					
                        <p><?php the_title(); ?> is a <?php echo $term->name; ?> expansion for the X-Wing Second Edition from wave <?php echo $wave->name; ?>.</p>
                    
                    <?php endif; ?>                
                </description>  
            </article>                    
        
    </column>
    <column class="col-1">
        <h3>Technical Data</h3>
        <div class="upgrade-content">
            <h4 class="configuration-title">
                <span class="ship-type">
                    <span class="faction <?php echo $term->slug; ?>"></span> 
                    <span class="content-title"><?php the_title(); ?></span>
                </span>
            </h4>
            <rules>
                <p>
                    <strong>Wave:</strong> <?php echo $wave->name;  ?><br>
                    <strong>Product type:</strong> <?php echo $product_type->name; ?><br>
                    <strong>Product code:</strong> <?php the_field('product_code'); ?><br>
                    <?php $date = get_field('eta', false, false); $date = new DateTime($date); ?>
                    <strong>ETA:</strong> <?php the_field('eta'); ?>
                </p>
                <?php 
                    $eta = $date->getTimestamp(); 
                    $curtime = time();
                    $arrived = $curtime-$eta; 
                ?>
            </rules>
            <?php if($arrived < 0) : ?>
                <div class="countdown">
                    <div class="targeting-computer">
                        <div class="target-lines"></div>

                    </div>
                    <div class="countdown-display-con">	
                        <p class="countdown-display"><?php echo $eta; ?></p>
                    </div>
                </div>
                <p class="warning"><?php the_title(); ?> is not yet available, so be wary with the information on this page.</p>
            <?php elseif($arrived < 2000000) : ?>
                <div class="countdown">
                    <div class="targeting-computer targeted">


                    </div>
                </div>
                <p class="warning"><?php the_title(); ?><br>just left hyperspace.</p>
            <?php endif; ?>



        </div>
    </column>
        
    <?php if(!get_field('amazon_embed_uk') || get_field('amazon_embed_us')) { ?>
        <column class="col-1">
            <h3><?php the_field('shop_title','options'); ?></h3>
            <links>
                <p><?php the_field('shop_plea', 'options'); ?></p>
            </links>             
            <div class="amazon amazon-uk">
                <?php the_field('amazon_embed_uk'); ?>
            </div>

            <div class="amazon amazon-us">                            
                <?php the_field('amazon_embed_us'); ?>
            </div>
            <p class="lan-select">Change Store: <span class="uk">UK</span> | <span class="us">US</span></p>     
        </column>
    <?php } ?>                    
                  
        

    <column class="col-1">
        <h3>Ship<?php if(get_field('shipcount') != 1) { echo 's'; } ?></h3>
        <?php
            if( have_rows('ships') ):
                while ( have_rows('ships') ) : the_row();

                    $ships = get_sub_field('shiptype');
                    $count = get_sub_field('shipcount');
                    echo '<div class="column-bg">';
                    if( $ships ):
                        foreach( $ships as $p ): 
                           
                            
                            $mainships = get_field('ship', $p->ID); foreach($mainships as $mainship) { $mainshipID = $mainship->ID ; }
                            array_push($content, $mainshipID);
                    ?>
                            <thumbframe>
                                <?php if(get_field('thumb', $mainshipID)) { $thumb = get_field('thumb', $mainshipID); } else { $thumb = get_field('placeholder', 'options'); } ?>
                                <a href="<?php echo get_permalink( $mainshipID ); ?>"><img src="<?php echo $thumb[sizes][medium]; ?>" alt="<?php echo get_the_title( $mainshipID ); ?>" /></a>
                            </thumbframe>
                            <thumbdescription>
                                <thumbtitle>
                                    <div class="thumbtitleflex">
                                        <h4><a href="<?php echo get_permalink( $mainshipID ); ?>"><?php if($count > 1) echo ' <strong>['.$count.']</strong> '; ?><?php echo get_the_title( $mainshipID ); ?></a></h4>
                                        <p><?php echo get_the_title($p->ID); ?></p>
                                    </div>
                                    <?php if(get_field('faction', $p->ID)) { ?>
                                    <div class="thumbfaction">
                                        <?php 
                                            $thumbfaction = get_field('faction', $p->ID);
                                          ?>  
                                            <titleicon><faction class="<?php echo $thumbfaction->slug; ?>"></faction></titleicon>
                                        
                                    </div>
                                    <?php } ?>
                                </thumbtitle>
                            </thumbdescription>
        
        <?php
                           
                       endforeach;
                    endif;
                    echo '</div>';

                endwhile;
            endif;
        ?>

    </column>
    
                           
    <column class="col-1">
		<h3 class="expand-justify">Pilots <span class="expand-btn">+</span></h3>
		<?php if( have_rows('shippilots') ):
			while ( have_rows('shippilots') ) : the_row(); ?>

				<?php 
                $pilots = get_sub_field('pilot');
                $count = get_sub_field('pilotcount');                 
                if( $pilots ): ?>

                    <?php foreach( $pilots as $pilot):  
                        array_push($content, $pilot->ID);
                        if(is_user_logged_in()) {
                            $linked = get_field('content');
                            foreach($linked as $link) {
                                if($pilot->ID == $link) {
                                    echo 'x';
                                }        
                            } 
                        }
                        $hidden = 'hidden';  include(locate_template('pilotpanel.php'));
                        
                    endforeach; ?>
                <?php endif; ?>
         
			<?php endwhile;
        endif; ?>        
        
    
    </column>
    
    <column class="col-1 wbg">
		<h3 class="expand-justify">Upgrades <span class="expand-btn">+</span></h3>

		<?php if( have_rows('upgrades') ):
			while ( have_rows('upgrades') ) : the_row(); ?>
                <?php 
                $upgrades = get_sub_field('upgradetype');
                $count = get_sub_field('upgradecount'); 
                if( $upgrades ): ?>

                    <?php foreach( $upgrades as $upgrade):
                        array_push($content, $upgrade->ID);
                         if(is_user_logged_in()) {
                            $linked = get_field('content');
                            foreach($linked as $link) {
                                if($upgrade->ID == $link) {
                                    echo 'x';
                                }        
                            } 
                        }
                        $hidden = 'hidden'; $list = 'list'; include(locate_template('upgradepanel.php'));
                        
                    endforeach; ?>
                <?php endif; ?>

         
			<?php endwhile;
        endif; ?>        
        
	</column>            
    <column class="col-1">
        <?php include(locate_template('meta.php')); ?> 
        
        <?php if(is_user_logged_in()) {
            $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            echo '<a href="'.$actual_link.'?updatepost=1">update product</a>';
            if($_GET['updatepost'] == 1) {
                update_post_meta($post->ID, 'content', $content);
                echo '<br><strong>updated</strong>';
            }
    
            
        } ?>
        
    </column> 

    

<?php endwhile; // end of the loop. ?>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		btn_act = 0;

		$('.related-div .expand-btn').click( function() {
			if($(this).parent().parent().children('rules').hasClass("hidden")) {
				$(this).parent().parent().children('rules').removeClass("hidden");
				$(this).text('-');
			} else {
				$(this).parent().parent().children('rules').addClass("hidden");
				$(this).text('+');				
			}
		});
		
		$('h2 .expand-btn').click( function() {

			if($(this).text() == '+') {
				$(this).text('-');
				$(this).parent().parent().children('.related-div').children('rules').removeClass("hidden");
				$(this).parent().parent().children('.related-div').children('h3').children('.expand-btn').text('-');	
			} else {
				$(this).text('+');
				$(this).parent().parent().children('.related-div').children('rules').addClass("hidden");
				$(this).parent().parent().children('.related-div').children('h3').children('.expand-btn').text('+');
			}
		});
			
	});
</script>

<?php get_footer(); ?>
