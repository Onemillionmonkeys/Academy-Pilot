<?php
/*
* Template Name: Maneuvers
*/
 get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<titlebar>
        <h1><?php the_title(); ?></h1>
    </titlebar>
    
	<column class="col-1 col-wrapper">
        <column class="col-1">
    
            <div class="maneuver-select">
                <?php if( have_rows('maneuver-template') ): ?>
                    <h3><?php the_field('maneuver_select'); ?></h3>
                    
                    <maneuvertemplate>
                        <?php while ( have_rows('maneuver-template') ) : the_row(); ?>
                            <maneuverbar manspeed="<?php the_sub_field('speed'); ?>">
                                <maneuverbox class="speed speed-<?php the_sub_field('speed'); ?>"></maneuverbox>
                                <maneuverbox mantype="tallon-roll-left" class="tallon-roll-left man-diff-<?php if (get_sub_field('tallon_roll_left')) { echo '4'; } else { echo '0'; } ?>"></maneuverbox>
                                <maneuverbox mantype="segnors-loop-left" class="segnors-loop-left man-diff-<?php if (get_sub_field('segnors_loop_left')) { echo '4'; } else { echo '0'; } ?>"></maneuverbox>
                                <maneuverbox mantype="left-turn" class="left-turn man-diff-<?php if (get_sub_field('left_turn')) { echo '4'; } else { echo '0'; } ?>"></maneuverbox>
                                <maneuverbox mantype="left-bank" class="left-bank man-diff-<?php if (get_sub_field('left_bank')) { echo '4'; } else { echo '0'; } ?> <?php if(get_sub_field('speed') < 0) { echo 'reverse'; } ?>"></maneuverbox>
                                <?php if(get_sub_field('speed') == 0) { ?>
                                    <maneuverbox mantype="straight" class="stationary man-diff-<?php if (get_sub_field('straight')) { echo '4'; } else { echo '0'; } ?>"></maneuverbox>
                                <?php } else { ?>
                                    <maneuverbox mantype="straight" class="straight man-diff-<?php if (get_sub_field('straight')) { echo '4'; } else { echo '0'; } ?> <?php if(get_sub_field('speed') < 0) { echo 'reverse'; } ?>"></maneuverbox>                            
                                <?php } ?>                                
                                <maneuverbox mantype="right-bank" class="right-bank man-diff-<?php if (get_sub_field('right_bank')) { echo '4'; } else { echo '0'; } ?> <?php if(get_sub_field('speed') < 0) { echo 'reverse'; } ?>"></maneuverbox>
                                <maneuverbox mantype="right-turn" class="right-turn man-diff-<?php if (get_sub_field('right_turn')) { echo '4'; } else { echo '0'; } ?>"></maneuverbox>
								<maneuverbox mantype="segnors-loop-right" class="segnors-loop-right man-diff-<?php if (get_sub_field('segnors_loop_right')) { echo '4'; } else { echo '0'; } ?>"></maneuverbox> 
                                <maneuverbox mantype="tallon-roll-right" class="tallon-roll-right man-diff-<?php if (get_sub_field('tallon_roll_right')) { echo '4'; } else { echo '0'; } ?>"></maneuverbox>                               
                                <maneuverbox mantype="koiogran-turn" class="koiogran-turn man-diff-<?php if (get_sub_field('koiogran_turn')) { echo '4'; } else { echo '0'; } ?>"></maneuverbox>                             
                                                      
                            </maneuverbar>
                            
                        <?php endwhile; ?>
                    </maneuvertemplate>
					<div class="btn-panel">
                        <div class="diff-btns">
                            <div man-diff="0" class="btn man-diff-0 active"></div>
                            <div man-diff="3" class="btn man-diff-3"></div>
                            <div man-diff="2"class="btn man-diff-2"></div>
                            <div man-diff="1" class="btn man-diff-1"></div>
                        </div>
                        <div class="btn ship-lock"></div>
                    </div>
                   
                                        
                <?php endif; ?>                        
                
            </div>
            <?php the_field('description'); ?>    
        
        </column>
        
<?php /*?>		<column class="col-1">
            <?php the_field('description'); ?>
        </column><?php */?>
                
        
        <column class="col-1">
            <h3>Ships</h3>
            <?php 
                $num = 0;
                $posts = get_posts(array(
                    'post_type' => 'ship',
                    'posts_per_page' => -1,
                    'orderby' => 'title',
                    'order' => 'ASC',
                    'meta_query' => array(
                        array(
                            'key' => 'second_edition',
                            'compare' => '==',
                            'value' => '1'
                        )
                    )
                ));
            
            ?>
            <?php if( $posts ): ?>
        
				<div class="child-box">        			
                    <?php foreach( $posts as $post ): ?>
                        <?php setup_postdata($post); ?>
                        <div class="ship-con" ship-con="<?php echo ++$num; ?>">                	
                            <div class="man-icon"></div>
                            <div class="man-img">
								
                                <thumbframe>
                                    <a href="<?php echo get_the_permalink($hip->ID); ?>">
                                        <img src="<?php if(get_field('thumb', $ship->ID)) { $thumb = get_field('thumb', $ship->ID); } else { $thumb = get_field('placeholder', 'options'); } echo $thumb[sizes][large]; ?>" alt="<?php echo get_the_title( $ship->ID ); ?>" />
                                    </a>
                                </thumbframe>        
                                
                            </div>
                            <h4>
                                <?php if(get_field('faction')) { ?>
                                    <div class="thumbfaction">
                                        <?php 
                                            $thumbfactions = get_field('faction');
                                            foreach($thumbfactions as $thumbfaction) 
                                        { ?>  
                                            <titleicon><faction class="<?php echo $thumbfaction->slug; ?>"></faction></titleicon>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                                <?php echo get_the_title( $ship->ID ); ?>
                            </h4>
                            <div class="maneuver-con">
                                <?php $man_ID = $ship->ID; include(locate_template('maneuverpanel.php')); ?>                
                            </div>
                            
                        </div>
                    <?php endforeach; wp_reset_postdata(); ?>
				</div>                    
            <?php endif; ?>
        
        </column>
      
	</column>
    <column class="col-3 col-wrapper stm"><h3 class="full-title">Selected ships</h3><div class="ship-man"></div></column>
	
<?php endwhile; ?>


<script type="text/javascript">
    jQuery(document).ready(function($) {
        
        var mantype;
        var manspeed;
        var mandiff;
        var manobj;
        var objdiff;
        var thisdiff;
        var thisid;
        var difflimit;
        
        
        function iconset(o) {
            thisid = o.parents('.ship-con').attr('ship-con');
            o.parents('.child-box .ship-con').addClass('selected');
            thisdiff = o.attr('mandiff');
            o.parents('.ship-con').clone().appendTo('.ship-man');
            $('.ship-man [ship-con="'+thisid+'"] .man-icon').attr('man-diff', thisdiff);
            $('.ship-man [ship-con="'+thisid+'"] .man-icon').attr('man-type', mantype);
            $('.ship-man [ship-con="'+thisid+'"] .man-icon').attr('man-speed', manspeed);
            
        }
        
        function shipselect() {
            $('.ship-con [manspeed="'+manspeed+'"] [mantype="'+mantype+'"]').each(function() {

                
                if(difflimit > 0) {
                    if(parseInt($(this).attr('mandiff')) == difflimit ) {
                        iconset($(this));
                    } 
                } else {
                    if(parseInt($(this).attr('mandiff')) != 0 ) {
                        iconset($(this));
                    }
                }
               
            }); 
        }
        
        
        $('.maneuver-select maneuverbox:not(.speed):not(.man-diff-0)').click(function() {
            
            $('.ship-man .ship-con').removeClass('no-move');
            
            $('maneuverbox').removeClass('manboxselected');
            $(this).addClass('manboxselected');
            if($('.maneuver-select').hasClass('locked')) {
                var hovertype = $(this).attr('mantype');
                var hoverspeed = $(this).parents('maneuverbar').attr('manspeed');
                if(hovertype == 'straight' && hoverspeed == '0') {
                    hovertype = 'stationary';
                }
                $('.ship-man .ship-con').each(function() {
                    var hoverdiff = parseInt($(this).find('maneuverbar[manspeed="'+hoverspeed+'"]').find('maneuverbox[mantype="'+hovertype+'"]').attr('mandiff'));
                    if(isNaN(hoverdiff)) { console.log(hoverdiff);  hoverdiff = 0; }
                    
                    if(hoverdiff == 0) { 
                        $(this).addClass('no-move');
                    }
                    
                    $(this).find('.man-icon').attr('man-diff', hoverdiff).attr('man-type', hovertype).attr('man-speed', hoverspeed);
                    
                });
            } else {
                $('.ship-man .ship-con').remove();
                $('.child-box .ship-con').removeClass('selected');
                mantype = $(this).attr('mantype');
                manspeed = $(this).parents('maneuverbar').attr('manspeed');

                if(mantype == 'straight' && manspeed == '0') {
                    mantype = 'stationary';
                }
                shipselect();
            }
            
            
        });
        
        
        $('.diff-btns .btn').click(function() {
            $('.btn-panel .btn').removeClass('active');
            $(this).addClass('active');
            difflimit = parseInt($(this).attr('man-diff'));
            $('.maneuver-select').attr('man-diff', difflimit);
        });
        
        $('.ship-lock').click(function() {
            $(this).toggleClass('selected');
            $('.maneuver-select').toggleClass('locked');
            $('.ship-man').toggleClass('locked');
            
        });
        
        $('.child-box .ship-con').click(function() {
            if($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                var removeID = parseInt($(this).attr('ship-con'));
                $('.ship-man .ship-con[ship-con="'+removeID+'"]').remove();
                
            } else {
                $(this).addClass('selected');
                $(this).clone().appendTo('.ship-man');
            }
            
            
        });
        
        
        
        
    });
</script>



<?php /*?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		var $ = jQuery.noConflict();
		shiptotal = $('.ship-con').size();
		speedtotal = $('.maneuver-select maneuverbar').size()-1;
		mandiffselect = 0;
		mantypes = ['','left-turn','left-bank','straight','right-bank','right-turn','koiogran-turn','stationary'];
		manspecs = 0;
		colsizetype = ['col-half','col-quarter'];
		colsize = 0;
		
		$('.mag').click(function() {
			$('.ship-man column').removeClass(colsizetype[colsize]);	
			colsize = 1 - colsize;
			$('.ship-man column').addClass(colsizetype[colsize]);			
			if(colsize == 1) {
				$(this).addClass("zoomin");
			} else {
				$(this).removeClass("zoomin");
			}				
		
		});
		
		$('.child-box .btn').click(function() {
			$('.child-box .man-diff-'+mandiffselect).removeClass("active");
			
			mandiffselect = $(this).index();
			
			$('.child-box .man-diff-'+mandiffselect).addClass("active");
				
		});
		
		$('.maneuver-select maneuverbox').click(function() {
			$('.ship-con').removeClass("active-ship");
			selectspeed = (speedtotal-$(this).parent().index()).toString();
			selectman = mantypes[$(this).index()];
			selectman = $(this).attr('mantype');
			console.log(selectman);
			if(selectspeed == 0 && selectman == "straight") {
				selectman = "stationary";	
			}
			$('.ship-man').empty();
			for(d=3; d >= 1; d--) {
				if(mandiffselect == 0 || d == mandiffselect) {	
					for(i = 1; i <= shiptotal; i++) {
						if($('.ship-con-'+i+' .man-bar-'+selectspeed+' .'+selectman).hasClass('man-diff-'+d)) {
							$('.ship-con-'+i).addClass("active-ship");
							var shipname = $('.ship-con-'+i+' h2').text();			
							var shipimg = $('.ship-con-'+i+' .man-img').html();						
							$('.ship-man').append('<column class="'+colsizetype[colsize]+' ship-'+i+'"><man-show class="'+selectman+'-'+selectspeed+' man-diff-'+d+'"></man-show>'+shipimg+'<h2>'+shipname+'</h2><p class="ship-id">'+i+'</p>');
						}
					}
				}
			}
			$('.ship-man column').click( function() {
				manspecfunc($(this).children('p').text().toString());
			});			
		});
		
		
		$('.ship-con').click( function() {
			var shipnum = $(this).index()+1;
			if($('.ship-man .ship-'+shipnum).size() > 0) {
				$('.ship-man .ship-'+shipnum).remove();
				$(this).removeClass('active-ship');
			} else {
				$(this).addClass('active-ship');				
				var shipname = $(this).children('h2').text();			
				var shipimg = $(this).children('.man-img').html();
				$('.ship-man').append('<column class="'+colsizetype[colsize]+' ship-'+shipnum+'"><man-show class="no-man"></man-show>'+shipimg+'<h2>'+shipname+'</h2><p class="ship-id">'+shipnum+'</p>');
				$('.ship-man column').click( function() {
					manspecfunc($(this).children('p').text().toString());
				});
			}
		});
		
		function manspecfunc(curid) {
			manspecs = 1;

			for(i = 0; i <= speedtotal; i++) {
				for(x = 1; x <= 7; x++) {
					mantype = mantypes[x]
					if(!$('.maneuver-select .man-bar-'+i+' .'+mantype).hasClass('man-diff-0')) {
						$('.maneuver-select .man-bar-'+i+' .'+mantype).removeClass().addClass(mantype);
					}
					
					if(!$('.ship-con-'+curid+' .man-bar-'+i+' .'+mantype).hasClass('man-diff-0') && $('.ship-con-'+curid+' .man-bar-'+i).size() > 0 ) {
						if($('.ship-con-'+curid+' .man-bar-'+i+' .'+mantype).hasClass('man-diff-1')) { diff = 1; }
						if($('.ship-con-'+curid+' .man-bar-'+i+' .'+mantype).hasClass('man-diff-2')) { diff = 2; }
						if($('.ship-con-'+curid+' .man-bar-'+i+' .'+mantype).hasClass('man-diff-3')) { diff = 3; }	
						$('.maneuver-select .man-bar-'+i+' .'+mantype).addClass("man-diff-"+diff);
					}

					
				}
				
			}			
		}
		
		
		$('.maneuver-select').mouseover(function() {
			if(manspecs == 1) {
				manspecs = 0;
				for(i = 0; i <= speedtotal; i++) {
					for(x = 1; x <= 7; x++) {
						mantype = mantypes[x]
						if(!$('.maneuver-select .man-bar-'+i+' .'+mantype).hasClass('man-diff-0')) {
							$('.maneuver-select .man-bar-'+i+' .'+mantype).removeClass().addClass(mantype+' man-diff-4');
						}
					}
				}
			}
		});
		
		
		$('.maneuver-select maneuverbox').mouseover(function() {
			if(!$(this).hasClass('man-diff-0') && !$(this).hasClass('speed')) {
				curmanspeed = (speedtotal-$(this).parent().index()).toString();
				curmandir = $(this).index();
				if(curmanspeed == 0 && curmandir == 3) {
					curmandir = 7;
				}
				for(i = 1; i<= shiptotal; i++) {
					diff = 0;
					$('.ship-man .ship-'+i + ' man-show').removeClass();

					if($('.ship-man .ship-'+i).size() > 0 && $('.ship-con-'+i+' .man-bar-'+curmanspeed).size() > 0 ) {
						
						if($('.ship-con-'+i+' .man-bar-'+curmanspeed+' .'+mantypes[curmandir]).hasClass('man-diff-1')) { diff = 1; }
						if($('.ship-con-'+i+' .man-bar-'+curmanspeed+' .'+mantypes[curmandir]).hasClass('man-diff-2')) { diff = 2; }
						if($('.ship-con-'+i+' .man-bar-'+curmanspeed+' .'+mantypes[curmandir]).hasClass('man-diff-3')) { diff = 3; }																		
						if(diff != 0) { 

								$('.ship-man .ship-'+i + ' man-show').addClass(mantypes[curmandir]+'-'+curmanspeed+" man-diff-"+diff); 
	
						} else {
							$('.ship-man .ship-'+i + ' man-show').addClass("no-man");
						}
					} else if($('.ship-man .ship-'+i).size() > 0 && $('.ship-con-'+i+' .man-bar-'+curmanspeed).size() == 0 ) {
						$('.ship-man .ship-'+i + ' man-show').addClass("no-man");
					}
				}
			} 
		});		
	});
</script>
<?php */?>
<?php get_footer(); ?>