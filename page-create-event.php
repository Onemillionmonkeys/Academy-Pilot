<?php acf_form_head(); ?>
<?php 
/*
* Template Name: Create Event
*/
get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

     <titlebar>
    
            <h1><?php the_title(); ?></h1>
    
    </titlebar>
    <?php if ( is_user_logged_in() ) : ?>
            
                    <?php if(!$_GET['eventid'] && $_GET['updated'] == 'true') { ?>
                        <column class="col-3 col-wrapper">
                            <h3 class="full-title">Your Events</h3>
                    <?php } else { ?>    
                        <column class="col-3">
                
                            <?php 
                                if($_GET['eventid'] == null) {
                                    $pid = 'new_post';
                                    echo '<h3>Create New Event</h3>';
                                    $subvalue = 'Create a new event';
                                } else {
                                    $pid = $_GET['eventid'];
                                    echo '<h3>Edit: '.get_the_title($pid).'</h3>';
                                    $subvalue = 'Update event';
                                }
                                acf_form(array(
                                'post_id'		=> $pid,
                                'post_title' => true,
                                'new_post'		=> array(
                                    'post_type'		=> 'event',
                                    'post_status'		=> 'publish'
                                ),
                                'submit_value'		=> $subvalue
                                )); 
                            ?>
                        </column>
                    <?php } ?>

        <?php else : ?>
                <column class="col-3">
                    <h3>Login to create an event</h3>
                </column>
        <?php endif; ?>
        <column class="col-1 col-wrapper">
            
            <?php 
            if ( is_user_logged_in() ) : 
                $user_ID = get_current_user_id(); 
                $user_info = get_userdata($user_ID);
            ?>
                <column class="col-1">
                    <?php
                        $eventargs = array (
                            'post_type' => 'event',
                            'author' => $user_ID,
                         );
                                              
                        $events = get_posts($eventargs);
                        if($events) :
                            echo '<h3>Events by: '.$user_info->user_login.'</h3>';
                            foreach($events as $event) :
                                $calpoint = get_field('start_date', $event->ID, false, false);
                                $calpoint = new DateTime($calpoint);
                                echo '<p><a href="https://academy-pilot.com/create-event/?eventid='.$event->ID.'">'.get_the_title($event->ID).' '.$calpoint->format('j-n-Y').'</a></p>';
                            endforeach;
                        endif;
                    ?>
                    
                </column>
                <column class="col-1">
                    <h3>Log out</h3>
                    <?php echo do_shortcode('[wppb-logout]'); ?>
                    <h3>Edit Profile</h3>
                    <?php echo do_shortcode('[wppb-edit-profile]'); ?>
                    
                </column>
            
            
            
            
            <?php else : ?>
                <column class="col-1">
                    <h3>Log In</h3>
                    <?php echo do_shortcode('[wppb-login]'); ?>
                    <h3>Create New User</h3>
                    <?php echo do_shortcode('[wppb-register role="author"]'); ?>
                </column>
            <?php endif; ?>
        </column>            
            
        
            
            <?php /*?><?php 
             $user_ID = get_current_user_id();
            
            if ( is_user_logged_in() ) :
                $user_ID = get_current_user_id();
            ?>
             
                <column class="col-1">
                    <h3>Profile</h3>
                    <?php echo do_shortcode('[wppb-edit-profile]'); ?>
                    <a href="<?php echo wp_logout_url('https://academy-pilot.com/create-event/'); ?>">Log Out</a>
                </column>
                <column class="col-1">
                    <?php
                        $eventargs = array (
                            'post_type' => 'event',
                            'author' => $user_ID,
                         );
                                              
                        $events = get_posts($eventargs);
                        if($events) :
                            echo '<h3>Your Events</h3>';
                            foreach($events as $event) :
                                echo get_the_title($event->ID);
                            endforeach;
                        endif;
                    ?>
                </column>
            
            <?php else : ?>
                <column class="col-1">
                    <h3>Log In</h3>
                    <?php echo do_shortcode('[wppb-login]'); ?>
                </column>
                <column class="col-1">
                    <h3>Create New User</h3>
                    <?php echo do_shortcode('[wppb-register role="author"]'); ?>'   
                </column>
            <?php endif; ?>
        </column><?php */?>
    
    
        
           <?php /*?> <?php if ( is_user_logged_in() ) { ?>
                <column class="col-2">
                    <h3>Create New Event</h3>
                    <?php 
                    if($_GET['eventtitle'] != null) {
                        $postarr = array(
                            'post_title' => wp_strip_all_tags( $_GET['eventtitle'] ),
                            'post_type' => 'event'
                        );
                        $eventID = wp_insert_post($postarr);
                        acf_form(
                            array(
                                'post_id'	=> $eventID,
                                'post_title'	=> false,
                                'submit_value'	=> 'Update the post!'
                            )
                        );
                    } else { ?>
                    <form id="newevent" method="get" action>
                        <input type="text" name="eventtitle">
                        <input type="submit" value="sub">
                    </form>
                   <?php } ?>         
                    
                </column>
        <?php } ?><?php */?>
            
           
        
<?php endwhile; ?>
<?php get_footer(); ?>