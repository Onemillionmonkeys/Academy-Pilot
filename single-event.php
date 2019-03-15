<?php get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<?php 
        $the_ID = get_the_id(); 
        $evtype = get_field('event_type');
        $calpoint = get_field('start_date', false, false);
        $calpoint = new DateTime($calpoint);
        $endcalpoint = get_field('end_date', false, false);
        $endcalpoint = new DateTime($endcalpoint);
        $location = get_field('map');
    ?>
	
	<titlebar>
        <h1><?php the_title(); ?></h1>
    </titlebar>
	
 
    <column class="col-4 col-wrapper">
     <?php 
        if(get_field('thumb')) : 
            $thumb = get_field('thumb');
        else :
            $blur = '';
            $thumb = get_field('placeholder_pilot', 'options');
            $shipimgs = get_field('ship_conf');
            foreach($shipimgs as $shipimg) :
                $shimgs = get_field('ship', $shipimg->ID);
                foreach($shimgs as $shimg) :
                    if(get_field('thumb', $shimg->ID)) { $thumb = get_field('thumb', $shimg); $blur = 'blurred'; }
                endforeach;
            endforeach;
        endif; 
        ?>
    <column class="col-2 col-thumb <?php echo $factioncol.' '.$blur; ?>">
		<h3><?php echo $evtype->name; ?></h3>    
        
            <thumbframe class="desaturation">
               
                
				<img class="<?php echo $blur; ?>" src="<? echo $thumb[url]; ?>" alt="<?php the_title(); ?>" itemprop="image"/>
            </thumbframe>
            <div class="thumb-overlay"></div>
			<article>
                <description itemprop="description">
                    <?php
                        $description = $evtype->name.' for X-wing Second Edition the '.$calpoint->format('j').$calpoint->format('S'). ' of '.$calpoint->format('F').' '.$calpoint->format('Y'). ' at '.$location['address'];
                        echo '<p>'.$description.'</p>';
                    
                    ?>
                </description>  
            </article>                    
        
    </column>
    <column class="col-2 col-wrapper">
        <column class="col-1">
            <h3>Date &amp; Place</h3>
            <?php 
                 
            ?>
            <div class="main-datebox <?php if(get_field('end_date')) { echo 'multidates'; } ?>">
                <div class="datebox">
                    <p class="month"><?php echo $calpoint->format('F'); ?></p>
                    <p class="day"><?php echo $calpoint->format('j').$calpoint->format('S'); ?></p>
                    <p class="year"><?php echo $calpoint->format('Y'); ?></p>
                </div>
                <?php if(get_field('end_date') && get_field('multi_date_event')) { ?>
                    <p>to</p>
                    <div class="datebox">
                        <p class="month"><?php echo $endcalpoint->format('F'); ?></p>
                        <p class="day"><?php echo $endcalpoint->format('j').$endcalpoint->format('S'); ?></p>
                        <p class="year"><?php echo $endcalpoint->format('Y'); ?></p>
                    </div>
    
                <?php } ?>
                <div class="datedetails <?php if(get_field('end_date')) { echo 'fullwidthdetails'; } ?>">
                    <h4><?php echo get_the_title(); ?></h4>
                    <p class="event-type"><?php echo $evtype->name; ?></p>
                </div>
            </div>
                            
            
                            <p class="address"><?php echo $location['address']; ?></p>
        </column>
        
        
        <column class="col-1">
            <h3 class="nmb">Location</h3>
            <div class="acf-map">
                <?php 
                    
                 
                    

                   

                   



                    ?>
                        <div class="marker <?php echo $evtype->slug; ?>" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>">
                            <h4><?php echo get_the_title(); ?></h4>
                            <p class="event-type"><?php echo $evtype->name; ?></p>
                            <p class="date"><?php echo $calpoint->format('j').$calpoint->format('S'). ' of '.$calpoint->format('F').' '.$calpoint->format('Y'); ?></p>
                            <p class="address"><?php echo $location['address']; ?></p>
                        </div> 
            </div>
        </column>
    </column>
   
<column class="col-1">
                <?php include(locate_template('meta.php')); ?>    	
            </column>
    
    
   
        
        
                   
        
<?php echo '        
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Event",
  "name": "'.get_the_title().'",
  "startDate": "'.$calpoint->format('Y').'-'.$calpoint->format('m').'-'.$calpoint->format('d').'T19:30-08:00",
  "location": {
    "@type": "Place",
    "name": "'.$location['address'].'",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "'.get_field('street').'",
      "addressLocality": "'.get_field('city').'",
      "postalCode": "'.get_field('postal_code').'",';
      if($country[value] == 'US') { echo '"addressRegion": "CA",'; }
      echo '"addressCountry": "'.$country[value].'"
    }
  },
  "image": [
    "'.$thumb[sizes][pilotthumblarge].'"
   ],
  "description": "'.$description.'",
  "endDate": "2017-04-24T23:00-08:00",';
        if(get_field('tickets')) :
            echo '"offers": {
                "@type": "Offer",
                "url": "'.get_field('ticket_seller_link').'",
                "price": "'.get_field('ticket_price').'",
                "priceCurrency": "'.get_field('currency').'",';
                if(get_field('event_sold_out')) {
                    echo '"availability": "http://schema.org/OutOfStock",';
                } else { 
                    echo '"availability": "http://schema.org/InStock",';
                }
                echo '"validFrom": "2017-01-20T16:20-08:00"
              },';
        endif;
 echo '"performer": {
    "@type": "PerformingGroup",
    "name": "Darth Vader"
  }
}
</script>'
?>
	

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
				$(this).text('-')
				$('.related-div rules').removeClass("hidden");
				$('.related-div .expand-btn').text('-');	
			} else {
				$(this).text('+')
				$('.related-div rules').addClass("hidden");
				$('.related-div .expand-btn').text('+');
			}
		});
			
	});
</script>

<?php get_footer(); ?>
<?php include('mapscript.php'); ?>