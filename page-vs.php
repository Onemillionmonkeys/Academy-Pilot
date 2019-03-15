<?php
/*
* Template Name: Versus
*/
 get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>


    <titlebar>
        	<div class="h1-con">
                <h1><?php the_title(); ?></h1>
			</div>                
			<div class="clear"></div>     
		</titlebar>
    <titlebaroverlay>
	    <div class="h1-con">
            <h1><?php the_title(); ?></h1>
        </div>	
    </titlebaroverlay>
    
    <column class="col-third title-margin padding">
        <h2>Ships</h2>
        <?php 
            $num = 0;
            $posts = get_posts(array(
                'post_type' => 'ship',
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order' => 'ASC',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'size-tax',
                        'field'    => 'slug',
                        'terms'    => 'huge',
                        'operator' => 'NOT IN',
                    ),
                )					
            ));
        
        ?>
        <?php if( $posts ): ?>
    
            <div class="child-box">        			
                <?php foreach( $posts as $post ): ?>
                    <?php setup_postdata($post); ?>
                    <div class="ship-con ship-con-<?php echo ++$num; ?>">                	


                    <?php if(count( get_field('ship_statistics') ) > 1) {  ?>
						<h3><?php echo get_the_title( $ship->ID ); ?></h3>
                        <?php while ( have_rows('ship_statistics') ) : the_row(); ?>
                            <div class="ship-stats">
                                <?php $con = get_sub_field('configuration'); ?>
                                <h4 class="win-btn"><?php echo $con; ?> Configuration</h4>
                                <statpanel>
                                    <?php $value = get_sub_field('primary_weapon_value'); if( $value != '') { ?><stat class="attack <?php the_sub_field('firing_arch'); ?>-arch"><h4><?php if(get_sub_field('primary_weapon_value') >= 0) { the_sub_field('primary_weapon_value'); } else { echo '-'; } ?></h4></stat><?php } ?>
                                    <?php $value = get_sub_field('agility_value'); if( $value != '')  { ?><stat class="agility"><h4><?php if(get_sub_field('agility_value') >= 0) {the_sub_field('agility_value'); } else { echo '-'; } ?></h4></stat><?php } ?>
                                    <?php $value = get_sub_field('hull_value'); if( $value != '')  { ?><stat class="hull"><h4><?php if(get_sub_field('hull_value') >= 0) {the_sub_field('hull_value'); } else { echo '-'; } ?></h4></stat><?php } ?>
                                    <?php $value = get_sub_field('shield_value'); if($value != '') { ?><stat class="shield"><h4><?php if(get_sub_field('shield_value') >= 0) {the_sub_field('shield_value'); } else { echo '-'; } ?></h4></stat><?php } ?>                        
                                </statpanel>                                    
                                <?php if( have_rows('actions_bar', $hips->ID) ): ?>
                                    <actionbar class="actionbar-<?php echo ++$actionbar_num; ?>">
                                        <?php while ( have_rows('actions_bar', $ship->ID) ) : the_row(); ?>
                                            <a href="<?php bloginfo('url'); ?>/action-types-tax/<?php $term = get_sub_field('action_type'); echo $term->slug; ?>"><action class="<?php echo $term->slug; ?>"></action></a>
                                        <?php endwhile; ?>
                                        <div class="clear"></div>
                                    </actionbar>                            
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    
                    <?php } else { ?>
                        <?php while ( have_rows('ship_statistics') ) : the_row(); ?>

                        <div class="ship-stats">
                            <h3 class="win-btn"><?php echo get_the_title( $ship->ID ); ?></h3>
                            <statpanel>
                                <?php $value = get_sub_field('primary_weapon_value'); if( $value != '') { ?><stat class="attack <?php the_sub_field('firing_arch'); ?>-arch"><h4><?php if(get_sub_field('primary_weapon_value') >= 0) { the_sub_field('primary_weapon_value'); } else { echo '-'; } ?></h4></stat><?php } ?>
                                <?php $value = get_sub_field('agility_value'); if( $value != '')  { ?><stat class="agility"><h4><?php if(get_sub_field('agility_value') >= 0) {the_sub_field('agility_value'); } else { echo '-'; } ?></h4></stat><?php } ?>
                                <?php $value = get_sub_field('hull_value'); if( $value != '')  { ?><stat class="hull"><h4><?php if(get_sub_field('hull_value') >= 0) {the_sub_field('hull_value'); } else { echo '-'; } ?></h4></stat><?php } ?>
                                <?php $value = get_sub_field('shield_value'); if($value != '') { ?><stat class="shield"><h4><?php if(get_sub_field('shield_value') >= 0) {the_sub_field('shield_value'); } else { echo '-'; } ?></h4></stat><?php } ?>                        
                            </statpanel>
                                <?php if( have_rows('actions_bar', $hips->ID) ): ?>
                                    <actionbar class="actionbar-<?php echo ++$actionbar_num; ?>">
                                        <?php while ( have_rows('actions_bar', $ship->ID) ) : the_row(); ?>
                                            <action class="<?php $term = get_sub_field('action_type'); echo $term->slug; ?>"></action>
                                        <?php endwhile; ?>
                                        <div class="clear"></div>
                                    </actionbar>                            
                                <?php endif; ?>                                
                        </div>
                        <?php endwhile; ?>
                    <?php } ?>
                        
                        <div class="man-img">
                            <?php if(get_field('thumb')) { ?>
                                <thumbframe class="starfield">
                                    <img src="<?php $thumb = get_field('thumb'); echo $thumb[url]; ?>" />
                                </thumbframe>        
                            <?php } ?>                            
                        </div>
                        

                        <div class="clear"></div>
                    </div>
                <?php endforeach; wp_reset_postdata(); ?>
            </div>                    
        <?php endif; ?>
    </column>


        <column class="col-1 ship-action wbg">
            <h3>Actions <span class="expand-btn">+</span></h3>
            <div class="hidden">
                <div class="action-select">
                    <action class="target-lock toggleselect"></action>
                    <action class="evade toggleselect	"></action>
                    <action class="focus focus-1 toggleselect"></action>
                    <action class="focus focus-2 toggleselect"></action>
                    <action class="off-focus focus-mod"><p>&#9708;</p></action>
                    <action class="def-focus focus-mod"><p>&#9708;</p></action>                                             
                    <div class="clear"></div>               
                </div>
                <div class="extra-mods">
                	<div class="change-panel">
                        <div class="change-btn engagement-increase"><h4>+</h4></div>
                        <h3 class="engagement-number">250</h3>
                        <div class="change-btn engagement-decrease"><h4>-</h4></div>
                        <p>Number of engagements</p>                    
                    </div>
                	<div class="change-panel">
                        <div class="change-btn percent-increase"><h4><span class="tens">+</span><span class="ones">+</span></h4></div>
                        <h3 class="shot-chance"><span class="value">100</span>%</h3>
                        <div class="change-btn percent-decrease"><h4><span class="tens">-</span><span class="ones">-</span></h4></div>
                        <p>Chance of attacking each round</p>                    
                    </div>
                	<div class="change-panel">
                        <div class="change-btn percent-increase"><h4><span class="tens">+</span><span class="ones">+</span></h4></div>
                        <h3 class="no-action"><span class="value">0</span>%</h3>
                        <div class="change-btn percent-decrease"><h4><span class="tens">-</span><span class="ones">-</span></h4></div>
                        <p>Stress Chance (no actions)</p>                    
                    </div>
                	<div class="change-panel">
                        <div class="change-btn round-increase"><h4><span class="tens">+</span><span class="ones">+</span></h4></div>
                        <h3 class="round-restrict">&#8734;</h3>
                        <div class="change-btn round-decrease"><h4><span class="tens">-</span><span class="ones">-</span></h4></div>
                        <p>Max number of Rounds per Engagement</p>                    
                    </div>
                    <div class="clear"></div>                    
                </div>
            </div>        
		</column>
        
        <column class="col-1 ship-mod wbg">
            <h3>Ship Modifiers <span class="expand-btn">+</span></h3>
            <div class="hidden">
                <statpanel>
                
                    <div class="change-panel">
                        <div class="change-btn stat-increase"><h4>+</h4></div>
                        <stat class="pilotvalue"><h4>0</h4></stat>
                        <div class="change-btn stat-decrease"><h4>-</h4></div>                    
                    </div>
                                
                    <div class="change-panel">
                        <div class="change-btn stat-increase"><h4>+</h4></div>
                        <stat class="attack"><h4>0</h4></stat>
                        <div class="change-btn stat-decrease"><h4>-</h4></div>                    
                    </div>
                    <div class="change-panel">
                        <div class="change-btn stat-increase"><h4>+</h4></div>
                        <stat class="agility"><h4>0</h4></stat>
                        <div class="change-btn stat-decrease"><h4>-</h4></div>                    
                    </div>                
    
                    <div class="change-panel">
                        <div class="change-btn stat-increase"><h4>+</h4></div>
                        <stat class="hull"><h4>0</h4></stat>
                        <div class="change-btn stat-decrease"><h4>-</h4></div>                    
                    </div>                
    
                    <div class="change-panel">
                        <div class="change-btn stat-increase"><h4>+</h4></div>
                        <stat class="shield"><h4>0</h4></stat>
                        <div class="change-btn stat-decrease"><h4>-</h4></div>                    
                    </div>                
    
                    <div class="change-panel">
                        <div class="change-btn stat-increase"><h4>+</h4></div>
                        <stat class="squadcost"><h4>0</h4></stat>
                        <div class="change-btn stat-decrease"><h4>-</h4></div>                    
                    </div>                
                   
                   
                </statpanel>
                
                <h2>Initiative</h2>
                
            </div>
        </column>      
		<column class="col-twothird">
<?php /*?>            <div class="vs"><h2>VS</h2></div><?php */?>
            <column class="col-full">
	            <column class="col-half ship-vs-con-1 padding"></column>

	            <column class="col-half ship-vs-con-2 padding"></column>        
			</column>
    	<div class="simulate">

			<h1 class="fight">Simulate Dogfight</h1>
        </div>
        

        <div class="combat-stats">
            <div class="combat-stat-bar stat-win">
                <div class="ship-1-bar orange-stat-left"></div>
                <div class="ship-2-bar orange-stat-right"></div>
                <p class="ship-1-result"></p>
                <p class="ship-2-result"></p>
                <h3>Wins</h3>
            </div>
            <div class="combat-stat-bar stat-draw">
                <div class="ship-1-bar orange-stat-left"></div>
                <div class="ship-2-bar orange-stat-right"></div>
                <p class="ship-1-result"></p>
                <p class="ship-2-result"></p>
                <h3>Draws</h3>
            </div>
            <div class="combat-stat-bar stat-shots">
                <div class="ship-1-bar red-stat-left"></div>
                <div class="ship-2-bar red-stat-right"></div>
                <p class="ship-1-result"></p>
                <p class="ship-2-result"></p>
                <h3>Shots fired per engagement</h3>
            </div>
            <div class="combat-stat-bar stat-shots-hits">
                <div class="ship-1-bar red-stat-left"></div>
                <div class="ship-2-bar red-stat-right"></div>
                <p class="ship-1-result"></p>
                <p class="ship-2-result"></p>
                <h3>Shots hits</h3>
            </div>
            <div class="combat-stat-bar stat-damage-shot">
                <div class="ship-1-bar blue-stat-left"></div>
                <div class="ship-2-bar blue-stat-right"></div>
                <p class="ship-1-result"></p>
                <p class="ship-2-result"></p>
                <h3>Damage dealt per shot</h3>
            </div>
            <div class="combat-stat-bar stat-damage-hit">
                <div class="ship-1-bar blue-stat-left"></div>
                <div class="ship-2-bar blue-stat-right"></div>
                <p class="ship-1-result"></p>
                <p class="ship-2-result"></p>
                <h3>Damage dealt per hit</h3>
            </div>                
            <div class="combat-stat-bar stat-complete-evades">
                <div class="ship-1-bar green-stat-left"></div>
                <div class="ship-2-bar green-stat-right"></div>
                <p class="ship-1-result"></p>
                <p class="ship-2-result"></p>
                <h3>Shots evaded</h3>
            </div>
            <div class="combat-stat-bar stat-over-evades">
                <div class="ship-1-bar green-stat-left"></div>
                <div class="ship-2-bar green-stat-right"></div>
                <p class="ship-1-result"></p>
                <p class="ship-2-result"></p>
                <h3>Shots evaded with leftover evades</h3>
            </div>        
            <div class="combat-stat-bar stat-crits-suffered">
                <div class="ship-1-bar yellow-stat-left"></div>
                <div class="ship-2-bar yellow-stat-right"></div>
                <p class="ship-1-result"></p>
                <p class="ship-2-result"></p>
                <h3>Criticals suffered per engagement</h3>
            </div> 
            <div class="combat-stat-bar stat-direct-hits">
                <div class="ship-1-bar yellow-stat-left"></div>
                <div class="ship-2-bar yellow-stat-right"></div>
                <p class="ship-1-result"></p>
                <p class="ship-2-result"></p>
                <h3>Direct Hits suffered per engagement</h3>
            </div>
            <div class="combat-stat-bar stat-fastest-kill">
                <div class="ship-1-bar orange-stat-left"></div>
                <div class="ship-2-bar orange-stat-right"></div>
                <p class="ship-1-result"></p>
                <p class="ship-2-result"></p>
                <h3>Fastest Victory</h3>
            </div>
            <div class="combat-stat-bar stat-slowest-kill">
                <div class="ship-1-bar orange-stat-left"></div>
                <div class="ship-2-bar orange-stat-right"></div>
                <p class="ship-1-result"></p>
                <p class="ship-2-result"></p>
                <h3>Slowest Victory</h3>
            </div>
            <div class="combat-stat-bar stat-hull-left">
                <div class="ship-1-bar blue-stat-left"></div>
                <div class="ship-2-bar blue-stat-right"></div>
                <p class="ship-1-result"></p>
                <p class="ship-2-result"></p>
                <h3>Ship condition on victory</h3>
            </div>        
        </div>
	</column>
<?php endwhile; ?>

<script type="text/javascript">
	jQuery(document).ready(function(){
		var $ = jQuery.noConflict();
		var shipshown = 0;
		
				
		
	


	
		var number_of_engagements = 0; // Number of engagements
		var attackrounds = 0; // Length of current engagement
		var engagement_select = [1,5,10,25,42,50,100,125,250,500,1000];
		var engagement_select_number = 8;
		var max_number_of_engagements = 250;
		var max_number_of_rounds = 50; 
		
		var hit = 0; // temporary # hit
		var crit = 0; // temporary # crits
		var off_focus = 0; // temporary offensive focus
		var off_blank = 0; // temporary offensive blanks
		
		var evade = 0; // temporary defensive evade
		var def_focus = 0; // temporary defensive focus
		var def_blank = 0; // temporary defensive blanks
		
		var attack = []; // base attack
		var agility = []; // base agility
		var hull = []; // base hull
		var shield = []; // base shield
		var ps = [0,0]; // base pilotskill		
		var initiative = 0; // Initiative at equal ps

		var focus_select = [0,0]; // focus action selected
		var targetlock_select = [0,0]; // target lock selected
		var evade_select = [0,0]; // evade selected
		
		var stress = [0,0]; // Chance of being stressed
		var noaction = [0,0]; // Indication of no action this turn;
		
		var attack_chance = [0,0]; // Chance of not being able to attack;		
		var noattack = [0,0]; // Indication of no attack this turn;		
		
		var cur_focus = [0,0]; // Current round focus

		var off_focus_restrict = [0,0]; // Minimum focus needed to use focus offensively
		var def_focus_restrict = [0,0]; // Minimum focus needed to use focus offensively		

		var off_focus_used = [0,0]; // Number of focus used offensively;
		var def_focus_used = [0,0]; // Number of focus used defensively;

		var attacker = 0; // ship # current attacker
		var defender = 0; // ship # current defender

		var critcards = 0; // number of damage cards to be drawn		
		var winner = 0; // Declaration of winner
		
		var cur_crits = [0,0]; // Number of current crits suffered
		var cur_hits = [0,0]; // Number of current hits suffered		
		var complete_evades = [0,0]; // Number of total evades
		// STATS

		var shots_fired = [0,0]; // Number of shots fired
		var shots_hit = [0,0]; // Number of shots hit
		var damage_dealt = [0,0]; // Total damage dealt
		var over_evade = [0,0]; // Number of evades with one or more evades left;
			 
		var wins = [0,0]; // Number of wins		
		var defeats = [0,0]; // Number of losses
		var draws = [0,0]; // Number of draws

		var crit_deck = [0,0]; // Damage Deck
		var direct_hits = [0,0]; // Direct Hits suffered
		
		var fastest_kill = [0,0]; // Shortest time for victory
		var slowest_kill = [0,0]; // Longest survival
		
		var hull_left = [0,0]; // Hull left on victory
		
		var test = 0;
		
		$('.fight').click( function() {
			$('.combat-stats').css('display','block');
			number_of_engagements = 0;
			max_number_of_engagements = engagement_select[engagement_select_number];
			wins = [0,0];
			defeats = [0,0];
			draws = [0,0];
			shots_fired = [0,0]; 	
			complete_evades = [0,0];	
			cur_crits = [0,0];
			direct_hits = [0,0];
			fastest_kill = [0,0];		
			slowest_kill = [0,0];
			hull_left = [0,0];
			shots_hit = [0,0];
			damage_dealt = [0,0];
			over_evade = [0,0];	
			focus_select = [0,0];
			targetlock_select = [0,0];
			evade_select = [0,0];
			off_focus_restrict = [0,0];
			def_focus_restrict = [0,0];
			off_focus_used = [0,0];
			def_focus_used = [0,0];
						
									
			crit_deck[0] = [1,1,1,1,1,1,1,2,2,3,3,4,4,5,5,6,6,7,7,8,8,9,9,10,10,11,11,12,12,13,13,14,14];	
			crit_deck[1] = [1,1,1,1,1,1,1,2,2,3,3,4,4,5,5,6,6,7,7,8,8,9,9,10,10,11,11,12,12,13,13,14,14];				
			roundstart();
			
		});

		
		
		function roundstart() {
			number_of_engagements++;
			attackrounds = 0;	
			winner = 0;
			
			for(x = 0; x <= 1; x++) {
				attack[x] = parseInt($('.ship-vs-'+(x+1)+' stat.attack h4').text())+parseInt($('.ship-'+(x+1)+'-mod stat.attack h4').text());
				agility[x] = parseInt($('.ship-vs-'+(x+1)+' stat.agility h4').text())+parseInt($('.ship-'+(x+1)+'-mod stat.agility h4').text());
				hull[x] = parseInt($('.ship-vs-'+(x+1)+' stat.hull h4').text())+parseInt($('.ship-'+(x+1)+'-mod stat.hull h4').text());
				shield[x] = parseInt($('.ship-vs-'+(x+1)+' stat.shield h4').text())+parseInt($('.ship-'+(x+1)+'-mod stat.shield h4').text());
				ps[x] = parseInt($('.ship-'+(x+1)+'-mod stat.pilotvalue h4').text());

				focus_select[x] = 0;
				
				if($('.ship-'+(x+1)+'-action .action-select .focus-1').hasClass('selected')) {
					focus_select[x]++;
				}
				
				if($('.ship-'+(x+1)+'-action .action-select .focus-2').hasClass('selected')) {
					focus_select[x]++;

				}				
				if($('.ship-'+(x+1)+'-action .target-lock').hasClass('selected')) {
					targetlock_select[x] = 1;
				}
				if($('.ship-'+(x+1)+'-action .evade').hasClass('selected')) {
					evade_select[x] = 1;
				}
				
				stress[x] = parseInt($('.ship-'+(x+1)+'-action .no-action .value').text());
				attack_chance[x] = parseInt($('.ship-'+(x+1)+'-action .shot-chance .value').text());				
				
				off_focus_restrict[x] = parseInt($('.ship-'+(x+1)+'-action .off-focus p').text().length);
				def_focus_restrict[x] = parseInt($('.ship-'+(x+1)+'-action .def-focus p').text().length);

												
			}

			combatround();
			
		};
		
		function combatround() {
			attackrounds++;

			if(stress[0] >= Math.ceil(Math.random()*100)) { noaction[0] = 1; } else { noaction[0] = 0; }
			if(stress[1] >= Math.ceil(Math.random()*100)) { noaction[1] = 1; } else { noaction[1] = 0; }			

			if(attack_chance[0] >= Math.ceil(Math.random()*100)) { noattack[0] = 0; } else { noattack[0] = 1; }
			if(attack_chance[1] >= Math.ceil(Math.random()*100)) { noattack[1] = 0; } else { noattack[1] = 1; }			

			cur_focus[0] = focus_select[0];
			cur_focus[1] = focus_select[1];			 
			
			if(ps[0] > ps[1] ) {
				attacker = 0;
				defender = 1;
				if(noattack[attacker] == 0) { shoot(); }
				wintest();
				if(winner == 0) {
					attacker = 1;
					defender = 0;
					if(noattack[attacker] == 0) { shoot(); }
					wintest();					
				}
				

			}
			
			if(ps[0] < ps[1] ) {
				attacker = 1;
				defender = 0;
				if(noattack[attacker] == 0) { shoot(); }
				wintest();
				if(winner == 0) {
					attacker = 0;
					defender = 1;
					if(noattack[attacker] == 0) { shoot(); }			
					wintest();
				}
				
			}
			
			if(ps[0] == ps[1]) {
				if(initiative == 0) {
					attacker = 0;
					defender = 1;
					if(noattack[attacker] == 0) { shoot(); }
					attacker = 1;
					defender = 0;
					if(noattack[attacker] == 0) { shoot(); }

				} else {
					attacker = 1;
					defender = 0;
					if(noattack[attacker] == 0) { shoot(); }
					attacker = 0;
					defender = 1;
					if(noattack[attacker] == 0) { shoot(); }
				}
				
				wintest();
			}
	
			if(winner == 0) {
				if(attackrounds < max_number_of_rounds) {
					combatround();	
				}  else {
					draws[0]++;
					draws[1]++;
					bookkeeping();
				}
			} else {
				bookkeeping();
			}
		}
	
		function shoot() {

			off_blank = off_focus = hit = crit = 0;
			evade = def_focus = def_blank = 0;
			shots_fired[attacker]++;
			attackrolls(attack[attacker]);
			
			function attackrolls(a) {
				for(i = 0; i < a; i++) {
					die = Math.ceil(Math.random()*8);
					
					if(die <= 2) {
						off_blank++;	
					}
	
					if(die >= 3 && die <= 4) {
						off_focus++;	
					}
					
					if(die >= 5 && die <= 7) {
						hit++;	
					}
					
					if(die == 8) {
						crit++;	
					}
					
				}
			}
			
			if(targetlock_select[attacker] > 0 && noaction[attacker] == 0) {
				if( cur_focus[attacker] > 0) {
					newattack = off_blank;
					off_blank = 0;
				} else {
					newattack = off_blank + off_focus;
					off_blank = off_focus = 0;
				}
				
				if(newattack > 0) {
					attackrolls(newattack);
				}
			}
			
			
			if ( cur_focus[attacker] > 0 && off_focus > 0 && off_focus >= off_focus_restrict[attacker] && noaction[attacker] == 0 ) {
				hit += off_focus;
				off_focus = 0;
				cur_focus[attacker]--;
				off_focus_used[attacker]++;
			}
			
			//$('p.a_result').text('blank:'+(off_blank)+' focus:'+ (off_focus)+' hit:'+(hit)+' crit:'+(crit));
			
			defencerolls(agility[defender]);
			
			function defencerolls(a) {
				for(i = 0; i < a; i++) {
					die = Math.ceil(Math.random()*8);
					
					if(die <= 3) {
						def_blank++;	
					}
	
					if(die >= 4 && die <= 5) {
						def_focus++;	
					}
					
					if(die >= 6) {
						evade++;	
					}
				}
			}
			
			if ( evade_select[defender] > 0 && noaction[defender] == 0) {
				evade++;
			}
			
			if(cur_focus[defender] > 0 && def_focus >= def_focus_restrict[defender] && def_focus > 0 && hit+crit > evade && noaction[defender] == 0) {
				evade += def_focus;
				def_focus = 0;
				cur_focus[defender]--;
				def_focus_used[defender]++;				
			}
			
			//$('p.d_result').text('blank:'+(def_blank)+' focus:'+ (def_focus)+' evade:'+(evade));			
			
			if(evade >= hit + crit) {
				complete_evades[defender]++;	
			} else {
				shots_hit[attacker]++;
				damage_dealt[attacker] += hit+crit-evade;	
			}
			
			if((evade-hit-crit) > 0) {
				over_evade[defender]++;	
			}
			
			final_hits = hit - evade;
			
			if(final_hits < 0) {
				final_hits = 0;
				evade -= hit;	
			} else {
				evade = 0;
			}
			
			final_crits = crit - evade;
			
			if(final_crits < 0) {
				evade -= crit;
				final_crits = 0;
			} else {
				evade = 0;
			}
			
			shield[defender] -= final_hits;
			if(shield[defender] < 0) {
				hull[defender] += shield[defender];
				shield[defender] = 0;	
			}
			
			shield[defender] -= final_crits;
			critcards = 0;
			if(shield[defender] < 0) {
				hull[defender] += shield[defender];
				critcards  = shield[defender] * -1
				cur_crits[defender] += (shield[defender] * -1);
				shield[defender] = 0;	
			}
			
			if(critcards > 0) {
				for(i = 1; i <= critcards; i++) {
					dam = 0;
					do {
						critdraw = Math.ceil(Math.random()*crit_deck[defender].length)-1;
						dam = crit_deck[defender][critdraw];
					} while ( dam == 0);
					crit_deck[defender][dam] = 0;

					
					if(dam == 1) {
						direct_hits[defender]++;
						hull[defender]--;
					}
				}
			}
			
			
		} //function shoot
	
		function wintest() {
			for(x=0;x<=1;x++) {
				if(hull[(1-x)] <= 0) {
					winner++;
					wins[x] += 1;
	
					if(fastest_kill[x] == 0) {
						fastest_kill[x] = attackrounds;
	
					} else {
						fastest_kill[x] = Math.min(fastest_kill[x],attackrounds);
					}
					
					hull_left[x] += (shield[x] + hull[x]);
					
					slowest_kill[x] = Math.max(slowest_kill[x],attackrounds);
					
					defeats[(1-x)] += 1;
	
				}
			}
			
			if(winner > 1) {
				wins[0]--;
				wins[1]--;
				defeats[0]--;
				defeats[1]--;
				draws[0]++;
				draws[1]++;	
				
			}
		}
		
		function bookkeeping() {
			if(number_of_engagements < max_number_of_engagements) {

				roundstart();			
			} else {
								
				if(wins[0] + wins[1] > 0) {
					sf1 = Math.round(wins[0]/number_of_engagements*10000)/100;
					sf2 = Math.round(wins[1]/number_of_engagements*10000)/100;
				} else {
					sf1 = sf2 = 0;	
				}
				statbar('win',sf1,sf2,'%');

				sf1 = Math.round(draws[0]/number_of_engagements*10000)/100;
				sf2 = Math.round(draws[1]/number_of_engagements*10000)/100;				
				statbar('draw',sf1,sf2,'%');	
	
				
				sf1 = Math.round(shots_fired[0]/number_of_engagements*100)/100;
				sf2 = Math.round(shots_fired[1]/number_of_engagements*100)/100;				
				statbar('shots',sf1,sf2,' shots');
				
				sf1 = Math.round(shots_hit[0]/shots_fired[0]*10000)/100;
				sf2 = Math.round(shots_hit[1]/shots_fired[1]*10000)/100;
				statbar('shots-hits',sf1,sf2,'%');				

				sf1 = Math.round(damage_dealt[0]/shots_fired[0]*100)/100;
				sf2 = Math.round(damage_dealt[1]/shots_fired[1]*100)/100;
				statbar('damage-shot',sf1,sf2,' damage');
				
				sf1 = Math.round(damage_dealt[0]/shots_hit[0]*100)/100;
				sf2 = Math.round(damage_dealt[1]/shots_hit[1]*100)/100;
				statbar('damage-hit',sf1,sf2,' damage');

				sf1 = Math.round(complete_evades[0]/shots_fired[1]*10000)/100;
				sf2 = Math.round(complete_evades[1]/shots_fired[0]*10000)/100;		
							
				statbar('complete-evades',sf1,sf2,'%');
				
				sf1 = Math.round(over_evade[0]/shots_fired[1]*10000)/100;
				sf2 = Math.round(over_evade[1]/shots_fired[0]*10000)/100;		
				statbar('over-evades',sf1,sf2,'%');				
				
				sf1 = Math.round(cur_crits[0]/number_of_engagements*100)/100;
				sf2 = Math.round(cur_crits[1]/number_of_engagements*100)/100;				
				statbar('crits-suffered',sf1,sf2,'');
				
				sf1 = Math.round(direct_hits[0]/number_of_engagements*100)/100;
				sf2 = Math.round(direct_hits[1]/number_of_engagements*100)/100;								
				statbar('direct-hits',sf1,sf2,'');	
				
				sf1 = fastest_kill[0];
				sf2 = fastest_kill[1];
				statbar('fastest-kill',sf1,sf2,' rounds');
				
				sf1 = slowest_kill[0];
				sf2 = slowest_kill[1];
				statbar('slowest-kill',sf1,sf2,' rounds');
				
				if(wins[0] != 0) {
					sf1 = Math.round(hull_left[0] / wins[0] * 100)/100;
				} else {
					sf1 = 0;
				}
				if(wins[1] != 0) {
					sf2 = Math.round(hull_left[1] / wins[1] * 100)/100;				
				} else {
					sf2 = 0;				
				}
				statbar('hull-left',sf1,sf2,' hull & shield');				
				
//				alert(crit_deck[1]);
			}
		}
	
		function statbar(stattitle, result1, result2, extra) {
			
			$('.combat-stats .stat-'+stattitle + ' p.ship-1-result').text(result1+extra);
			$('.combat-stats .stat-'+stattitle + ' p.ship-2-result').text(result2+extra);
			result1 = Math.max(result1, 0);
			result2 = Math.max(result2, 0);			
			if(extra != '%') {
				if(result1 == 0 && result2 == 0) {
					$('.combat-stats .stat-'+stattitle + ' .ship-1-bar').animate({'width':'0%'}, 500);	
					$('.combat-stats .stat-'+stattitle + ' .ship-2-bar').animate({'width':'0%'}, 500);	
				} else {
					$('.combat-stats .stat-'+stattitle + ' .ship-1-bar').animate({'width':((result1/((result1+result2)))*50)+'%'}, 500);	
					$('.combat-stats .stat-'+stattitle + ' .ship-2-bar').animate({'width':((result2/((result1+result2)))*50)+'%'}, 500);	
				}
			} else {
				$('.combat-stats .stat-'+stattitle + ' .ship-1-bar').animate({'width':(result1/100*50)+'%'}, 500);	
				$('.combat-stats .stat-'+stattitle + ' .ship-2-bar').animate({'width':(result2/100*50)+'%'}, 500);	
			}
		}
	

		
		$('.win-btn').click( function() {
			shipshown++;

			if(shipshown > 1) {
				/*if( shipshown > 2) {
				$('.ship-vs-2').remove();
				}*/
				$('.ship-vs-con-2').html($('.ship-vs-con-1').html());
				$('.ship-vs-con-2 .ship-vs-1').removeClass('ship-vs-1').addClass('ship-vs-2');
				$('.ship-vs-con-2 .ship-1-action').removeClass('ship-1-action').addClass('ship-2-action');
				$('.ship-vs-con-2 .ship-1-mod').removeClass('ship-1-mod').addClass('ship-2-mod');								
				$('.ship-vs-con-1').remove();
				$('.ship-vs-con-2').before('<column class="col-half ship-vs-con-1 padding"></column>');
				$('.simulate').css('display','block');
				$('.simulate h1').css('margin-left', ($('.simulate h1').width()/-2)+'px');
				
			} 
			var shipimg = $(this).parent().parent().children('.man-img').html();
			var statpanel = $(this).parent().children('statpanel').html();
			var actionpanel = $(this).parent().children('actionbar').html();	
			var shipname = $(this).text();
			var actionbox = $('.ship-action').html();
			var modifierbox = $('.ship-mod').html();					

			$('.ship-vs-con-1').append('<column class="col-full ship-vs-1 wbg">'+shipimg + '<h3>'+shipname+'</h3><statpanel>'+statpanel+'</statpanel><actionbar>'+actionpanel+'</actionbar></column>');
			$('.ship-vs-con-1').append('<column class="col-full ship-1-action wbg">'+actionbox+'</column>');
			$('.ship-vs-con-1').append('<column class="col-full ship-mod-select ship-1-mod wbg">'+modifierbox+'</column>');						
			
			$('.engagement-number').text(engagement_select[engagement_select_number]);
			
			
			$('.engagement-increase').click( function() {
				engagement_select_number++;
				if(engagement_select_number > engagement_select.length) {
					engagement_select_number = engagement_select.length;
				}

				$('.engagement-number').text(engagement_select[engagement_select_number]);					
			});
			
			$('.engagement-decrease').click( function() {
				engagement_select_number--;
				if(engagement_select_number < 0) {
					engagement_select_number = 0;
				}
				$('.engagement-number').text(engagement_select[engagement_select_number]);					
			});			
			
			$('.round-increase .ones').click( function() {
				max_number_of_rounds++;
				roundchange();					
			});
			
			$('.round-increase .tens').click( function() {
				max_number_of_rounds += 10;
				roundchange();					
			});

			$('.round-decrease .ones').click( function() {
				max_number_of_rounds--;
				roundchange();					
			});
			
			$('.round-decrease .tens').click( function() {
				max_number_of_rounds-= 10;
				roundchange();					
			});
			
			$('.percent-increase .tens').click( function() {
				np = parseInt($(this).parent().parent().parent().children('h3').children('.value').text());
				np += 10;
				np = Math.min(100,np);
				$(this).parent().parent().parent().children('h3').children('.value').text(np)
			});
			
			$('.percent-increase .ones').click( function() {
				np = parseInt($(this).parent().parent().parent().children('h3').children('.value').text());
				np++;
				np = Math.min(100,np);
				$(this).parent().parent().parent().children('h3').children('.value').text(np)
			});						

			$('.percent-decrease .tens').click( function() {
				np = parseInt($(this).parent().parent().parent().children('h3').children('.value').text());
				np -= 10;
				np = Math.max(0,np);
				$(this).parent().parent().parent().children('h3').children('.value').text(np)
			});			
			
			$('.percent-decrease .ones').click( function() {
				np = parseInt($(this).parent().parent().parent().children('h3').children('.value').text());
				np--;
				np = Math.max(0,np);
				$(this).parent().parent().parent().children('h3').children('.value').text(np)
			});						
			
			
			
			function roundchange() {
				max_number_of_rounds = Math.max(max_number_of_rounds,1);
				max_number_of_rounds = Math.min(max_number_of_rounds,50);
				if(max_number_of_rounds >= 50) {
					$('h3.round-restrict').html('&#8734;');
				} else {
					$('h3.round-restrict').text(max_number_of_rounds);
				}
			}
		
			$('.ship-mod-select .stat-increase').click( function() {
				v = parseInt($(this).parent().children('stat').children('h4').text());
				v++;
				$(this).parent().children('stat').children('h4').text(v)			
			});
			
			$('.ship-mod-select .stat-decrease').click( function() {
				v = parseInt($(this).parent().children('stat').children('h4').text());
				v--;
				$(this).parent().children('stat').children('h4').text(v)			
			});
			
			$('.action-select action.toggleselect').click( function() {
				$( this ).toggleClass( "selected" );
			});
			
			$('.action-select action.focus-mod').click( function() {
				
				cl = $( this ).children('p').text().length;
				
				cl++;
				if(cl > 4) { 
					cl = 1 
					$( this ).removeClass( "selected" );
				} else {
					$( this ).addClass( "selected" );	
				};
				nt = '';
				for(n=1;n<=cl;n++) {
					nt += '&#9708;';				
				}
				

				$( this ).children('p').html(nt)
				
			});
			
			$('.expand-btn').click( function() {
				$( this ).parent().parent().children('div').toggleClass('hidden');	
			});
		});	
		

	});
</script>

<?php get_footer(); ?>