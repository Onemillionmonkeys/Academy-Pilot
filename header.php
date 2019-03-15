<!DOCTYPE html>

<html dir="<?php bloginfo('text_direction'); ?>" <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">                
		<title><?php wp_title( '|', true, 'right' ); ?></title>
        <link href="<?php echo get_the_permalink(); ?>" rel="canonical" />
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        
		<script src="<?php echo bloginfo('url'); ?>/wp-includes/js/jquery/jquery.js" type="text/javascript"></script>
                
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#21211d">
        <meta name="msapplication-TileColor" content="#21211d">
        <meta name="theme-color" content="#ffffff">


		<link rel="stylesheet" href="https://use.typekit.net/wfs3rql.css">
        <?php 
            if(is_front_page()) {
                $title = get_bloginfo('name');
                $url = get_bloginfo('url');
                $image = get_field('og_image', 'options');
                $description = get_field('meta_description', 'options');
                $keys = 'wikis, guides, strategies';
            } else {
                $title = get_the_title().' | Academy Pilot';
                $url = get_the_permalink();
                
                $metaterms = get_field('faction');
                if( $metaterms ):
                    foreach( $metaterms as $metaterm ):
                        $metafaction[] = $metaterm->name;
                    endforeach;
                endif;
                
                if(get_field('thumb')) {
                    $image = get_field('thumb');
                } else {
                    $image = get_field('og_image', 'options');
                }
                if(get_post_type() == "ship") :
                    
                    $description = get_the_title().' is one of the '.$metafaction[0];
                    if ($metafaction[1] != null) : $description .= ' or ' . $metafaction[1]; endif;
                    $description .= ' ships from the Star Wars X-Wing Second Edition.';    
                    $keys = 'ship, '.$metafaction[0];
                    if ($metafaction[1] != null) : $keys .= ', '.$metafaction[1]; endif;
                    
                
                
                elseif(get_post_type() == "pilot") :
                    $meta = get_field('ship');
                    foreach( $meta as $m ): 
                        $metaship = $m->ID;
                    endforeach;
                    $shipconfs = get_field('ship_conf');
                    if( $shipconfs ): foreach( $shipconfs as $p ): 
                        $shiptitle = get_the_title($p->ID);	
                    endforeach; endif;
                
                    $description = get_the_title().' is one of the '.$metafaction[0].' '.$shiptitle.' pilots from the Star Wars X-Wing Second Edition.';
                    if(get_field('rules')) :
                        $description .= ' Pilot ability: '.strip_tags(get_field('rules'));    
                    endif;
                    $keys = get_the_title().', pilot, '.$metafaction[0].', '.$shiptitle;
                
                
                elseif(get_post_type() == "upgrade") :
                    $uterms = get_field('upgrade_type'); 
                    if( $uterms ): foreach( $uterms as $uterm ): $upgradetitle = $uterm->name;  endforeach; endif;
                    $description = get_the_title().' is one of the '.$upgradetitle. ' upgrade from the Star Wars X-Wing Second Edition.';
                    if( have_rows('rules_repeater') ): $mnum = 0;
                        while ( have_rows('rules_repeater') ) : the_row();
                            if(get_sub_field('text') && ++$mnum <= 1) :
                                $description .= ' Rules: '.strip_tags(get_sub_field('text'));
                            endif;
                        endwhile;
                    endif;
                    echo '<meta property="og:image:width" content="592" /><meta property="og:image:height" content="297" />';
                elseif(get_post_type() == "product") :
                    $wave = get_field('wave');
                    $description = get_the_title().' is a '.$wave->name;
                    $description .= ' product for X-Wing Second Edition, released: '.get_field('eta');
                    
                    $description .= $wave->name;
                elseif(get_post_type() == "event") :
                    $evtype = get_field('event_type');
                    $calpoint = get_field('start_date', false, false);
                    $calpoint = new DateTime($calpoint);
                    $location = get_field('map');
                    $description = $evtype->name.' for X-wing Second Edition the '.$calpoint->format('j').$calpoint->format('S'). ' of '.$calpoint->format('F').' '.$calpoint->format('Y'). ' at '.$location['address'];
                endif;
                
            }
        ?>
        
        <meta name="description" content="<?php echo $description; ?>"/>
        <meta content="X-Wing Second Edition, <?php echo $keys; ?>" itemprop="keywords" name="keywords">
        
        
        <meta property="og:title" content="<?php echo $title; ?>" />
        <meta property="og:url" content="<?php echo $url; ?>" />
        <meta property="og:image" content="<?php echo $image[sizes][large]; ?>" />
        <meta property="og:description" content="<?php echo $description; ?>" />
        <meta property="og:site_name" content="Academy Pilot" />
        <meta property="og:type" content="article" />
        <meta property="og:locale" content="en_US" />
        <meta property="fb:app_id" content="942633402575892"/>
        
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:description" content="<?php echo $description; ?>" />
        <meta name="twitter:title" content="<?php echo $title; ?>" />
        
        
        


		
		
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-53689602-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-53689602-1');
		</script>
        <?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
    	<div class="header-bar">
			<header role="banner">
                <h1><a href="<?php bloginfo('url'); ?>" rel="canonical"><?php bloginfo('title'); ?></a></h1>
            </header>
            <h3><?php bloginfo('description'); ?></h3>
                
		</div>
        <div class="menu-icon-con">
            <div class="menu-icon">
            
            </div>
        </div>
            <nav id="access" role="navigation">
                <?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>

                    <div class="searches">
                        <?php echo do_shortcode('[wpdreams_ajaxsearchlite]'); ?>
                        <stat class="target-lock"></stat>
                    </div>

            </nav><!-- #access -->
	
	
		<section id="content" role="main">
