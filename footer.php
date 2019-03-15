		</section><!-- #main -->
		<footer role="contentinfo">
        	<column class="col-4 col-wrapper">
				<column class="col-2">
                    <h2>Navigation</h2>
                        <?php wp_nav_menu( array( 'container_class' => 'menu-footer', 'theme_location' => 'footer-menu' ) ); ?>
        
                </column>	
                <column class="col-1">
                    <h2>Search the site</h2>
                    <?php /*?><?php get_search_form(); ?><?php */?>

                </column>        
                <column class="col-1">
                <?php /*?>    
                        <!-- Begin MailChimp Signup Form -->
                        <link href="//cdn-images.mailchimp.com/embedcode/classic-081711.css" rel="stylesheet" type="text/css">
                        <div id="mc_embed_signup">
                        <form action="//onemillionmonkeys.us6.list-manage.com/subscribe/post?u=54e1e006e7daf260e48dd7f62&amp;id=c49bcba92f" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                            <h2>Sign up for our mailing list</h2>
                        <div class="mc-field-group">
                            <input type="email" placeholder="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
                        </div>
                        <div class="mc-field-group">
                            <input type="text" value="" placeholder="callsign" name="CALLSIGN" class="" id="mce-CALLSIGN">
                        </div>
                            <div id="mce-responses" class="clear">
                                <div claess="response" id="mce-error-response" style="display:none"></div>
                                <div class="response" id="mce-success-response" style="display:none"></div>
                            </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                            <div style="position: absolute; left: -5000px;"><input type="text" name="b_54e1e006e7daf260e48dd7f62_c49bcba92f" tabindex="-1" value=""></div>
                            <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
                        </form>
                        </div>
                        <script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='CALLSIGN';ftypes[1]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
                        <!--End mc_embed_signup-->             <?php */?>   
                    
                </column>            
			</column>
		</footer><!-- footer -->
        
        <div class="wookies">
        	<h3 class="close">X</h3>
            
            <div class="wookie-text"><?php the_field('cookie_text','options'); ?></div>
        
        </div>
        
<script type="text/javascript">
jQuery(document).ready(function($) {
		//var $ = jQuery.noConflict();
		
		
		if(typeof(Storage)!=="undefined") {
			  if (localStorage.lanselect != "us") {
					localStorage.lanselect = "uk";
					$('.amazon-uk').css('display','block');
					$('.amazon-us').css('display','none');
					$('span.uk').css('font-weight','700');
					$('span.us').css('font-weight','400');				  
			  } else {
					localStorage.lanselect = "us";
					$('.amazon-us').css('display','block');
					$('.amazon-uk').css('display','none');
					$('span.us').css('font-weight','700');
					$('span.uk').css('font-weight','400');					  
			  }
			  
			  if (localStorage.wookie != "n") {
				$('.wookies').css('display','block');  
			  } else {
				  
			  }
			  
		  }
		
		
		
		var ismobile = $('.menu-icon-con').css('display');

		$('.wookies .close').click( function() {
			localStorage.wookie = "n";
			$('.wookies').css('display','none'); 
		});

		
//		$('titleicon').css('height', $('titleicon').width()+'px');
//		$('.menu-icon').css('height', $('.menu-icon').width()+'px');
//		$('.menu-icon-con').css('height', $('.menu-icon').width()+'px');		

/*		if(ismobile != "none") {
			$('.header-bar').css('margin-top', $('.menu-icon').width()+'px');
			$('nav').css('top', $('.menu-icon').width()+'px');							
		}
*/
		
		$('.menu-icon').click(function() {
			$('.menu-icon').toggleClass('rotated');
			$('nav').toggleClass('shown');
		});
		
		$('span.uk').click(function() {
			$('.amazon-uk').css('display','block');
			$('.amazon-us').css('display','none');
			$('span.uk').css('font-weight','700');
			$('span.us').css('font-weight','400');			
			localStorage.lanselect = "uk";								
		});
		
		$('span.us').click(function() {
			$('.amazon-us').css('display','block');
			$('.amazon-uk').css('display','none');
			$('span.us').css('font-weight','700');
			$('span.uk').css('font-weight','400');	
			localStorage.lanselect = "us";					
		});

		
	
		
		function resizer() {
			var y_offset = parseInt($(document).scrollTop());
			var b_width = parseInt($('html').width()/75);
			$('.header-bar').css('height', 20-(y_offset/b_width)+'vw');
			var titletop = Math.max(7.25, 22.25-(y_offset/b_width*1));
			
			$('titlebar').css('top', titletop+'vw');	
			
			
		}
		
        if(ismobile == "none") {
            
            resizer();
            
            $( window ).scroll(function() {
                resizer();	
            });
            
            
        }
        
        var col_thumb_state = 0;
    
        if(ismobile != "none") {
            $('.col-thumb').click(function() {
                if(col_thumb_state == 0) {
                    $(this).addClass('col-thumb-bg');
                }
                
                if(col_thumb_state == 1) {
                    $(this).addClass('col-thumb-text');
                }
                
                if(col_thumb_state == 2) {
                    $(this).removeClass('col-thumb-bg');
                    $(this).removeClass('col-thumb-text');
                }
                
                
                col_thumb_state++;
                if(col_thumb_state > 2) { col_thumb_state = 0; }
            })
        }
    
    
		

		$('.related-div .expand-btn').click( function() {
			if($(this).parents('.related-div').find('.hidden-div').hasClass("hidden")) {
				$(this).parents('.related-div').find('.hidden-div').removeClass("hidden");
				$(this).text('-');
			} else {
				$(this).parents('.related-div').find('.hidden-div').addClass("hidden");
				$(this).text('+');				
			}
		});
		
		$('h3 .expand-btn').click( function() {
			
			if($(this).hasClass('show-rules')) {
				$(this).removeClass('show-rules');
				$(this).parents('column').find('.hidden-div').addClass("hidden");
				//$(this).parents('column').find('.expand-btn').text('-');
	
			} else {
                $(this).addClass('show-rules');
				$(this).parents('column').find('.hidden-div').removeClass("hidden");
				//$(this).parents('column').find('.expand-btn').text('+');

			}
		});
    
        $('h3 .show-img-btn').click( function() {
           if($(this).hasClass('show-thumbs')) {
				
                $(this).parents('column').find('.related-div').removeClass("show-thumb");
                $(this).removeClass('show-thumbs');
	
			} else {
				$(this).parents('column').find('.related-div').addClass("show-thumb");
                $(this).addClass('show-thumbs');
            }
        });
    

        if($('.countdown').size() > 0) {
            var cd = parseInt($('.countdown-display').text())*1000;
            var d = new Date();
            var t= d.getTime();
            var targetlines = Math.min(100,(cd-t)/100000000);

            $('.target-lines').css('width', targetlines+'%');

            var countdown=window.setInterval(function(){countdownfunc()},100);
            function countdownfunc() {
                d = new Date();
                t = d.getTime();
                t = Math.round((cd-t)/100);



                $('.countdown-display').text(t);

            }
        }
		
		
	})
</script>
        
	<?php wp_footer(); ?>
	</body>
</html>