<?php

function my_scripts_method() {
    wp_enqueue_script( 'jquery' );
/*    wp_enqueue_script( 'jquery-ui', get_template_directory_uri() . '/js/JQueryUI.js' );
    wp_enqueue_script( 'slider', get_template_directory_uri() . '/js/slider.js' );
    wp_enqueue_script( 'gallery', get_template_directory_uri() . '/js/gallery.js' );
	*/
}

function cc_mime_types( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

add_action( 'wp_enqueue_scripts', 'my_scripts_method' );

add_action( 'init', 'create_ship' );
add_action( 'init', 'create_ship_configuration' );
add_action( 'init', 'create_pilot' );
add_action( 'init', 'create_upgrade' );
add_action( 'init', 'create_product' );
add_action( 'init', 'create_event' );

add_action( 'init', 'create_size_tax' );
add_action( 'init', 'create_faction_tax' );
add_action( 'init', 'create_upgrade_types_tax' );
add_action( 'init', 'create_action_types_tax' );
add_action( 'init', 'create_firing_arcs_tax' );
add_action( 'init', 'create_wave_tax' );
add_action( 'init', 'create_product_type_tax' );
add_action( 'init', 'create_guide_type_tax' );
add_action( 'init', 'create_event_type_tax' );

function create_ship() {
  $labels = array(
    'name' => _x('Ship', 'post type general name'),
    'singular_name' => _x('Ship', 'post type singular name'),
    'add_new' => _x('Add new Ship', 'Event'),
    'add_new_item' => __('Add new Ship'),
    'edit_item' => __('Edit Ship'),
    'new_item' => __('New Ship'),
    'view_item' => __('View Ship'),
    'search_items' => __('Search Ships'),
    'not_found' =>  __('No Ship found'),
    'not_found_in_trash' => __('No Ships in Trash'),
    'parent_item_colon' => ''
  );

  $supports = array('title', 'thumbnail');

  register_post_type( 'ship',
    array(
      'labels' => $labels,
      'public' => true,
      'supports' => $supports,
	  'menu_position' => 5
    )
  );
}

function create_ship_configuration() {
  $labels = array(
    'name' => _x('Ship configuration', 'post type general name'),
    'singular_name' => _x('Ship configuration', 'post type singular name'),
    'add_new' => _x('Add new Ship configuration', 'Event'),
    'add_new_item' => __('Add new Ship configuration'),
    'edit_item' => __('Edit Ship configuration'),
    'new_item' => __('New Ship configuration'),
    'view_item' => __('View Ship configuration'),
    'search_items' => __('Search Ship configurations'),
    'not_found' =>  __('No Ship configuration found'),
    'not_found_in_trash' => __('No Ship configurations in Trash'),
    'parent_item_colon' => ''
  );

  $supports = array('title', 'thumbnail');

  register_post_type( 'ship-configuration',
    array(
      'labels' => $labels,
      'public' => true,
      'supports' => $supports,
	  'menu_position' => 5
    )
  );
}

function create_pilot() {
  $labels = array(
    'name' => _x('Pilot', 'post type general name'),
    'singular_name' => _x('Pilot', 'post type singular name'),
    'add_new' => _x('Add new Pilot', 'Event'),
    'add_new_item' => __('Add new Pilot'),
    'edit_item' => __('Edit Pilot'),
    'new_item' => __('New Pilot'),
    'view_item' => __('View Pilot'),
    'search_items' => __('Search Pilots'),
    'not_found' =>  __('No Pilot found'),
    'not_found_in_trash' => __('No Pilots in Trash'),
    'parent_item_colon' => ''
  );

  $supports = array('title', 'thumbnail');

  register_post_type( 'pilot',
    array(
      'labels' => $labels,
      'public' => true,
      'supports' => $supports,
	  'menu_position' => 5
    )
  );
}

function create_upgrade() {
  $labels = array(
    'name' => _x('Upgrade', 'post type general name'),
    'singular_name' => _x('Upgrade', 'post type singular name'),
    'add_new' => _x('Add new Upgrade', 'Event'),
    'add_new_item' => __('Add new Upgrade'),
    'edit_item' => __('Edit Upgrade'),
    'new_item' => __('New Upgrade'),
    'view_item' => __('View Upgrade'),
    'search_items' => __('Search Upgrades'),
    'not_found' =>  __('No Upgrade found'),
    'not_found_in_trash' => __('No Upgrades in Trash'),
    'parent_item_colon' => ''
  );

  $supports = array('title', 'thumbnail');

  register_post_type( 'upgrade',
    array(
      'labels' => $labels,
      'public' => true,
      'supports' => $supports,
	  'menu_position' => 5
    )
  );
}

function create_product() {
  $labels = array(
    'name' => _x('Product', 'post type general name'),
    'singular_name' => _x('Product', 'post type singular name'),
    'add_new' => _x('Add new Product', 'Event'),
    'add_new_item' => __('Add new Product'),
    'edit_item' => __('Edit Product'),
    'new_item' => __('New Product'),
    'view_item' => __('View Product'),
    'search_items' => __('Search Products'),
    'not_found' =>  __('No Product found'),
    'not_found_in_trash' => __('No Products in Trash'),
    'parent_item_colon' => ''
  );

  $supports = array('title', 'thumbnail');

  register_post_type( 'product',
    array(
      'labels' => $labels,
      'public' => true,
      'supports' => $supports,
	  'menu_position' => 5
    )
  );
}


function create_event() {
  $labels = array(
    'name' => _x('Event', 'post type general name'),
    'singular_name' => _x('Event', 'post type singular name'),
    'add_new' => _x('Add new Event', 'Event'),
    'add_new_item' => __('Add new Event'),
    'edit_item' => __('Edit Event'),
    'new_item' => __('New Event'),
    'view_item' => __('View Event'),
    'search_items' => __('Search Events'),
    'not_found' =>  __('No Event found'),
    'not_found_in_trash' => __('No Events in Trash'),
    'parent_item_colon' => ''
  );

  $supports = array('title', 'author');

  register_post_type( 'event',
    array(
      'labels' => $labels,
      'public' => true,
      'supports' => $supports,
	  'menu_position' => 5
    )
  );
}






function create_size_tax() {
 $labels = array(
    'name' => _x( 'Size', 'taxonomy general name' ),
    'singular_name' => _x( 'Selected Size', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Sizes' ),
    'all_items' => __( 'All Sizes' ),
    'parent_item' => __( 'Parent Size' ),
    'parent_item_colon' => __( 'Parent Size:' ),
    'edit_item' => __( 'Edit Size' ),
    'update_item' => __( 'Update Size' ),
    'add_new_item' => __( 'Add Size' ),
    'new_item_name' => __( 'New Size name' ),
  ); 	

  register_taxonomy('size-tax',array('ship', 'ship-configuration'),array(
    'hierarchical' => true,
    'labels' => $labels
  ));
}

function create_faction_tax() {
 $labels = array(
    'name' => _x( 'Faction', 'taxonomy general name' ),
    'singular_name' => _x( 'Selected Faction', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Factions' ),
    'all_items' => __( 'All Factions' ),
    'parent_item' => __( 'Parent Faction' ),
    'parent_item_colon' => __( 'Parent Faction:' ),
    'edit_item' => __( 'Edit Faction' ),
    'update_item' => __( 'Update Faction' ),
    'add_new_item' => __( 'Add Faction' ),
    'new_item_name' => __( 'New Faction name' ),
  ); 	

  register_taxonomy('faction-tax',array('ship','ship-configuration','pilot','product'),array(
    'hierarchical' => true,
    'labels' => $labels
  ));
}

function create_upgrade_types_tax() {
 $labels = array(
    'name' => _x( 'Upgrade Type', 'taxonomy general name' ),
    'singular_name' => _x( 'Selected Upgrade Type', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Upgrade Types' ),
    'all_items' => __( 'All Upgrade Types' ),
    'parent_item' => __( 'Parent Upgrade Type' ),
    'parent_item_colon' => __( 'Parent Upgrade Type:' ),
    'edit_item' => __( 'Edit Upgrade Type' ),
    'update_item' => __( 'Update Upgrade Type' ),
    'add_new_item' => __( 'Add Upgrade Type' ),
    'new_item_name' => __( 'New Upgrade Type name' ),
  ); 	

  register_taxonomy('upgrade-types-tax',array('upgrade','ship-configuration','ship'),array(
    'hierarchical' => true,
    'labels' => $labels
  ));
}

function create_action_types_tax() {
 $labels = array(
    'name' => _x( 'Action Type', 'taxonomy general name' ),
    'singular_name' => _x( 'Selected Action Type', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Action Types' ),
    'all_items' => __( 'All Action Types' ),
    'parent_item' => __( 'Parent Action Type' ),
    'parent_item_colon' => __( 'Parent Action Type:' ),
    'edit_item' => __( 'Edit Action Type' ),
    'update_item' => __( 'Update Action Type' ),
    'add_new_item' => __( 'Add Action Type' ),
    'new_item_name' => __( 'New Action Type name' ),
  ); 	

  register_taxonomy('action-types-tax',array('ship', 'ship-configuration'),array(
    'hierarchical' => true,
    'labels' => $labels
  ));
}

function create_firing_arcs_tax() {
 $labels = array(
    'name' => _x( 'Firing Arc', 'taxonomy general name' ),
    'singular_name' => _x( 'Selected Firing Arc', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Firing Arcs' ),
    'all_items' => __( 'All Firing Arcs' ),
    'parent_item' => __( 'Parent Firing Arc' ),
    'parent_item_colon' => __( 'Parent Firing Arc:' ),
    'edit_item' => __( 'Edit Firing Arc' ),
    'update_item' => __( 'Update Firing Arc' ),
    'add_new_item' => __( 'Add Firing Arc' ),
    'new_item_name' => __( 'New Firing Arc name' ),
  ); 	

  register_taxonomy('firing-arcs-tax',array('ship','ship-configuration'),array(
    'hierarchical' => true,
    'labels' => $labels
  ));
}

function create_wave_tax() {
 $labels = array(
    'name' => _x( 'Wave', 'taxonomy general name' ),
    'singular_name' => _x( 'Selected Wave', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Waves' ),
    'all_items' => __( 'All Waves' ),
    'parent_item' => __( 'Parent Wave' ),
    'parent_item_colon' => __( 'Parent Wave:' ),
    'edit_item' => __( 'Edit Wave' ),
    'update_item' => __( 'Update Wave' ),
    'add_new_item' => __( 'Add Wave' ),
    'new_item_name' => __( 'New Wave name' ),
  ); 	

  register_taxonomy('wave-tax',array('product'),array(
    'hierarchical' => true,
    'labels' => $labels
  ));
}

function create_product_type_tax() {
 $labels = array(
    'name' => _x( 'Product Type', 'taxonomy general name' ),
    'singular_name' => _x( 'Selected Product Type', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Product Types' ),
    'all_items' => __( 'All Product Types' ),
    'parent_item' => __( 'Parent Product Type' ),
    'parent_item_colon' => __( 'Parent Product Type:' ),
    'edit_item' => __( 'Edit Product Type' ),
    'update_item' => __( 'Update Product Type' ),
    'add_new_item' => __( 'Add Product Type' ),
    'new_item_name' => __( 'New Product Type name' ),
  ); 	

  register_taxonomy('product-type-tax',array('product'),array(
    'hierarchical' => true,
    'labels' => $labels
  ));
}

function create_guide_type_tax() {
 $labels = array(
    'name' => _x( 'Guide Type', 'taxonomy general name' ),
    'singular_name' => _x( 'Selected Guide Type', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Guide Types' ),
    'all_items' => __( 'All Guide Types' ),
    'parent_item' => __( 'Parent Guide Type' ),
    'parent_item_colon' => __( 'Parent Guide Type:' ),
    'edit_item' => __( 'Edit Guide Type' ),
    'update_item' => __( 'Update Guide Type' ),
    'add_new_item' => __( 'Add Guide Type' ),
    'new_item_name' => __( 'New Guide Type name' ),
  ); 	

  register_taxonomy('guide-type',array('post'),array(
    'hierarchical' => true,
    'labels' => $labels
  ));
}

function create_event_type_tax() {
 $labels = array(
    'name' => _x( 'Event Type', 'taxonomy general name' ),
    'singular_name' => _x( 'Selected Event Type', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Event Types' ),
    'all_items' => __( 'All Event Types' ),
    'parent_item' => __( 'Parent Event Type' ),
    'parent_item_colon' => __( 'Parent Event Type:' ),
    'edit_item' => __( 'Edit Event Type' ),
    'update_item' => __( 'Update Event Type' ),
    'add_new_item' => __( 'Add Event Type' ),
    'new_item_name' => __( 'New Event Type name' ),
  ); 	

  register_taxonomy('event-type', array('event'), array(
    'hierarchical' => true,
    'labels' => $labels
  ));
}

add_filter( 'mce_buttons_2', 'my_mce_buttons_2' );

function my_mce_buttons_2( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}

add_filter( 'tiny_mce_before_init', 'my_mce_before_init' );

function my_mce_before_init( $settings ) {

    $style_formats = array(
    	array(
        	'title' => 'Quoter',
			'classes' => 'quoter',
        	'inline' => 'span'
        )
    );

    $settings['style_formats'] = json_encode( $style_formats );

    return $settings;

}

add_action( 'admin_init', 'add_my_editor_style' );

function add_my_editor_style() {
	add_editor_style();
}

function my_search_form( $form ) {

    $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >


		<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="..." />
		<input id="searchsubmit" type="submit" value="Search">		
	
    </form>';

    return $form;
}

add_filter( 'get_search_form', 'my_search_form' );


register_nav_menus(
array(
  'primary' => __( 'Main Menu', 'academypilot'),

  'footer-menu' => __( 'Bottom Menu', 'academypilot'),

)
);

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page();
	
}

function my_acf_admin_head() {
	?>
	<style type="text/css">
		.acf-repeater > table > tbody > tr.acf-row > td.acf-fields {		
			border-top: .5vw #d44040 solid;
		}
		
        .acf-flexible-content > .acf-actions > .acf-button {
            background: #d44040;
            border: none;
            box-shadow: 0 0 0;
            border-radius: 0;
            text-shadow: 0 0 0;
        }
        
        .widefat {
            background: red;
        }
		
	</style>

	
	<?php
}

add_action('acf/input/admin_head', 'my_acf_admin_head');

add_action('admin_head', 'my_custom_fonts');

function my_custom_fonts() {
  echo '<style>
    td[data-colname="Ratings"] .rating-image img, img.post-ratings-image {
        width:1vw;
        height: 1vw;
        
        padding: .25vw;
    }
  </style>';
}

function custom_rating_image_extension() {
    return 'png';
}
add_filter( 'wp_postratings_image_extension', 'custom_rating_image_extension' );

add_image_size( 'toolthumb', 300, 200, true );
add_image_size( 'toolthumblarge', 900, 600, true );
add_image_size( 'pilotthumblarge', 1364, 580, true );
add_image_size( 'samethumb',  369, 155, true );
add_image_size( 'shipthumb',  600, 600, true );


function my_acf_init() {
	
	acf_update_setting('google_api_key', 'AIzaSyCifTOCz5OCACGbUpEiVLZRpCS7_5BphKY');
}

add_action('acf/init', 'my_acf_init');

add_action( 'admin_init', 'blockusers_init' );

function blockusers_init() {
    if ( is_admin() && ! current_user_can( 'administrator' ) && 
       ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
        wp_redirect( 'https://academy-pilot.com/create-event/' );
        exit;
    }
	
  	if ( ! current_user_can( 'publish_posts' )  && $_SERVER['PHP_SELF'] != '/wp-admin/admin-ajax.php' ) {
        wp_redirect('https://academy-pilot.com/create-event/');
    }	
	/*if(! current_user_can('edit_posts')) {
		wp_redirect( home_url() );
        exit;	
	}*/
}

add_action('after_setup_theme', 'remove_admin_bar');
	function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}

add_filter('register','no_register_link');
function no_register_link($url){
    return '';
}

?>