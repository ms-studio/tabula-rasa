<?php  

// Initialize Theme

/* 1. Register CSS and JS
 * 2. Define theme support, menus, image sizes
 * 3. Custom post types and Taxonomies
 * 4. Date variables for MEM plugin
 * 5. 
**************/

  // Unregister jQuery 
  // (we call it in the footer)
  // ****************************
   
function custom_register_styles() {
	if ( !is_admin() ) {
	
//				wp_dequeue_style( 'thematic_style' );
				// the MAIN stylesheet
				wp_enqueue_style( 
						'main_css_style', 
						get_stylesheet_directory_uri() . '/css/main.css', // main.css
						false, // dependencies
						null // version
				); 
				
//				wp_enqueue_style( 
//						'webink_css', 
//						'Custom Google Fonts or WebInk CSS url',
//						false,
//						null
//				); 
				
				
				// remove some plugin CSS
//	      wp_dequeue_style( 'mailchimpSF_main_css' );
	      // src: http://c-sideprod.ch/?mcsf_action=main_css&#038;ver=3.6
	   }
}
add_action( 'wp_print_styles', 'custom_register_styles', 100 );


/**
 * Check to see if the current page is the login/register page
 * Use this in conjunction with is_admin() to separate the front-end from the back-end of your theme
 * @return bool
 * Src: http://stackoverflow.com/questions/5266945/
 */
if ( ! function_exists( 'is_login_page' ) ) {
  function is_login_page() {
    return in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) );
  }
}

function custom_register_javascript() {
	if ( !is_admin() && !is_login_page() ) {

				wp_dequeue_script('devicepx'); // some Jetpack stuff...
	      
	      wp_enqueue_script( 
	      		'modernizer_js', // handle
	      		get_stylesheet_directory_uri() . '/js/libs/modernizr.custom.14446.min.js', //src
	      		false, // dependencies
	      		null, // version
	      		false // in_footer
	      );
	      
	      wp_deregister_script('jquery');
	     	wp_register_script(
	     		'jquery', 
	     		get_site_url() . '/wp-includes/js/jquery/jquery.js', 
	     		false, // dep
	     		'1.10.2', // jquery version
	     		true // load in footer !!!
	     	);
	     	wp_enqueue_script('jquery');
	      
	      wp_enqueue_script( 
	      // the MAIN JavaScript file 
	      		'main_js', // handle
	      		get_stylesheet_directory_uri() . '/js/script.js', // scripts.js
	      		array('jquery'), // dependencies
	      		null, // version
	      		true // in_footer
	      );
	   }
}
add_action( 'wp_print_scripts', 'custom_register_javascript', 100 ); 

/* Some header cleanup 
******************************/

remove_action('wp_head', 'shortlink_wp_head');

remove_action('wp_head', 'feed_links' ); // not working...
remove_action('wp_head', 'feed_links', 2 );
remove_action('wp_head', 'feed_links_extra', 3);
// in order to remove the comments feed. need to add manually the main RSS feed to the header.

remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');

// Prevents WordPress from testing ssl capability on domain.com/xmlrpc.php?rsd
remove_filter('atom_service_url','atom_service_url_filter'); 

 
/* Post-Thumbnails Support
******************************/
 
 if ( function_exists( 'add_theme_support' ) ) {
	 	add_theme_support( 'post-thumbnails' );
//     set_post_thumbnail_size( 150, 150 ); // default Post Thumbnail dimensions  
    // more info: http://codex.wordpress.org/Post_Thumbnails 
 }


/* Custom image sizes
******************************/ 
 
 if ( function_exists( 'add_image_size' ) ) { 
 	//add_image_size( 'category-thumb', 300, 9999 ); //300 pixels wide (and unlimited height)
 	//add_image_size( 'landscape', 304, 184, true ); // true = cropped
 }
 
 /* Custom Menus
 ******************************/ 
 
  if ( function_exists( 'register_nav_menus' ) ) {
  	register_nav_menus(
  			array(
  				 'main-menu' => __( 'Menu N°1' ),
  				 'second-menu' => __( 'Menu N°2' ),
  				 'third-menu' => __( 'Menu N°3' ),
  				)
  			);
  }
  
  

/*
 * Global Date Variables
*/
// The current year variable
// ******************************
// loaded in the header.php

function mem_date_of_today() {
    
   global $mem_today_now;
   $mem_today_now = date_i18n( "j F Y - H:i:s"); 
       
   global $mem_today;
   $mem_today = date_i18n( "j F Y");
   
   global $mem_today_short;
   $mem_today_short = date_i18n( "Y-m-d");
   
   global $mem_isoweek;
   $mem_isoweek = date_i18n( "W");
   
   global $mem_unix_now;
   $mem_unix_now = strtotime( $mem_today_short );
   
   // current year info
   
   global $mem_current_year;
   $mem_current_year = date_i18n( "Y");
   
   global $mem_current_year_string;
   $mem_current_year_string = $mem_current_year . "-01-01";
   
   global $mem_current_year_end;
   $mem_current_year_end = $mem_current_year . "-12-31 23:59";
   
   // current categories
   
//   global $mem_visible_categories;
//   $mem_visible_categories = 'expo,conference,evenement,workshop,symposium,voyage';
   // used in: home.php, date.php
   // remove: seminaire
   
}










