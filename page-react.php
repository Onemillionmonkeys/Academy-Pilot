<?php 

/*
* Template Name: React
*/
get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <titlebar>
        <h1><?php the_title(); ?></h1>
    </titlebar>
	<column class="col-2">
         <div id="output"></div>
<!-- Load Babel -->
<script src="https://unpkg.com/babel-standalone@6/babel.min.js"></script>
<!-- Your custom script here -->

    </column>

	
           
            
    

<?php endwhile; ?>
<script src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/react.js"></script>
    <?php /*?><script src="https://unpkg.com/react@16/umd/react.development.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@16/umd/react-dom.development.js" crossorigin></script>
    <script src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/react.js"></script><?php */?>
<?php get_footer(); ?>