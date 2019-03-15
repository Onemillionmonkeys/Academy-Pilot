<h3>META</h3>
<links class="guide">
    <p>Posted on: <time itemprop="startDate" datetime="<?php the_time('Y-m-d')?>T<?php the_time('H:i'); ?>"><?php the_time('d-m Y');?></time><br>
    <?php $modtxt = get_the_modified_date('d/m/y'); if(get_the_modified_date('d/m/y') != get_the_date('d/m/y')) { ?> 
        Revised: <?php the_modified_time('d-m Y'); ?><br>
    <?php } ?>
    Submitted by: <?php the_author(); ?><br>
    <?php if(is_user_logged_in()) {
    edit_post_link();
    } ?>
    </p>
    
</links>