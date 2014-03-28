<?php

// Initialize Theme

/* 1. Register CSS and JS
 * 2. Define theme support, menus, image sizes
 * 3. Custom post types and Taxonomies
 * 4. Date variables for MEM plugin
 * 5. 
**************/


/* Allow Automatic Updates
 ******************************
 * http://codex.wordpress.org/Configuring_Automatic_Background_Updates
 */

add_filter( 'auto_update_plugin', '__return_true' );
add_filter( 'auto_update_theme', '__return_true' );
add_filter( 'allow_major_auto_core_updates', '__return_true' );


/* CSS/JS Versioning
*********************/

// Custom Functions for CSS/Javascript Versioning
$GLOBALS["TEMPLATE_URL"]          = get_bloginfo( 'template_url' ) . "/";
$GLOBALS["TEMPLATE_RELATIVE_URL"] = wp_make_link_relative( $GLOBALS["TEMPLATE_URL"] );

// Add ?v=[last modified time] to style sheets
function versioned_stylesheet( $relative_url, $add_attributes = "" ) {
	echo '<link rel="stylesheet" href="' . versioned_resource( $relative_url ) . '" ' . $add_attributes . '>' . "\n";
}

// Add ?v=[last modified time] to javascripts
function versioned_javascript( $relative_url, $add_attributes = "" ) {
	echo '<script src="' . versioned_resource( $relative_url ) . '" ' . $add_attributes . '></script>' . "\n";
}

// Add ?v=[last modified time] to a file url
function versioned_resource( $relative_url ) {
	$file         = $_SERVER["DOCUMENT_ROOT"] . $relative_url;
	$file_version = "";

	if ( file_exists( $file ) ) {
		$file_version = "?v=" . filemtime( $file );
	}

	return $relative_url . $file_version;
}


// Unregister jQuery
// (then re-register it in the footer)
// ****************************

function custom_register_styles() {

	/**
	 * Custom CSS
	 */

	// the MAIN stylesheet
	wp_enqueue_style(
			'main_css_style',
			get_stylesheet_directory_uri() . '/css/00-main.css', // main.css
			false, // dependencies
			null // version
	);

	// remove some plugin CSS:
	// wp_dequeue_style( 'mailchimpSF_main_css' );


	/**
	 * Custom JavaScript
	 */

	wp_dequeue_script( 'devicepx' ); 
	// some Jetpack stuff - 
	// "That file is used to optionally load retina/HiDPI versions of files (Gravatars etc) which are known to support it, for devices that run at a higher resolution."
	// info: http://wordpress.org/support/topic/plugin-jetpack-by-wordpresscom-unnecessary-java-script-call

	wp_enqueue_script(
			'modernizer_js', // handle
			get_stylesheet_directory_uri() . '/js/libs/modernizr.custom.14446.min.js', //src
			false, // dependencies
			null, // version
			false // in_footer
	);

	wp_deregister_script( 'jquery' );
	wp_register_script(
			'jquery',
			get_site_url() . '/wp-includes/js/jquery/jquery.js',
			false, // dep
			'1.10.2', // jquery version
			true // load in footer !!!
	);
	wp_enqueue_script( 'jquery' );

	wp_enqueue_script(
	// the MAIN JavaScript file
			'main_js', // handle
			get_stylesheet_directory_uri() . '/js/script.js', // scripts.js
			array( 'jquery' ), // dependencies
			null, // version
			true // in_footer
	);

}

add_action( 'wp_enqueue_scripts', 'custom_register_styles', 10 );


/* Some header cleanup
******************************/

remove_action( 'wp_head', 'shortlink_wp_head' );

remove_action( 'wp_head', 'feed_links' ); // not working...
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );
// in order to remove the comments feed. need to add manually the main RSS feed to the header.

remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_generator' );

// Prevents WordPress from testing ssl capability on domain.com/xmlrpc.php?rsd
remove_filter( 'atom_service_url', 'atom_service_url_filter' );


/* Post-Thumbnails Support
******************************/

if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
//     set_post_thumbnail_size( 150, 150 ); // default Post Thumbnail dimensions  
	// more info: http://codex.wordpress.org/Post_Thumbnails
}


/* Give an Excerpt to Pages - better for SEO!
***************************************************/

add_post_type_support( 'page', 'excerpt');


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
					'primary'   => __( 'Menu N°1' ),
//					'secondary' => __( 'Menu N°2' ),
//					'third'  => __( 'Menu N°3' ),
			)
	);
}

/* Widget Area
******************************/

register_sidebar( array(
		'name'          => 'Primary Sidebar',
		'id'            => 'sidebar-1',
		'description'   => 'Main sidebar.',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
) );


/* Allowed FileTypes
 ********************
 * method based on 
 * http://howto.blbosti.com/?p=329
 * List of defaults: https://core.trac.wordpress.org/browser/tags/3.8.1/src/wp-includes/functions.php#L1948
*/
add_filter('upload_mimes', 'custom_upload_mimes');
function custom_upload_mimes ( $existing_mimes=array() ) {

		// add an extension to the array
		$existing_mimes['svg'] = 'image/svg+xml';
		$existing_mimes['epub'] = 'application/epub+zip';

		// remove existing file types
		unset( $existing_mimes['bmp'] );
		unset( $existing_mimes['tif|tiff'] );

		// and return the new full result
		return $existing_mimes;
}



/*
 * File Upload Sanitization
 
 * Sources: 
 * http://www.geekpress.fr/wordpress/astuce/suppression-accents-media-1903/
 * https://gist.github.com/herewithme/7704370
 
 * See also Ticket #22363
 * https://core.trac.wordpress.org/ticket/22363
 * and #24661 - remove_accents is not removing combining accents
 * https://core.trac.wordpress.org/ticket/24661
*/ 

add_filter( 'sanitize_file_name', 'remove_accents', 10, 1 );
add_filter( 'sanitize_file_name_chars', 'sanitize_file_name_chars', 10, 1 );
 
function sanitize_file_name_chars( $special_chars = array() ) {
	$special_chars = array_merge( array( '’', '‘', '“', '”', '«', '»', '‹', '›', '—', 'æ', 'œ', '€','é','à','ç','ä','ö','ü','ï','û','ô','è' ), $special_chars );
	return $special_chars;
}
  
  
/*
 * Global Date Variables
*/
// The current year variable
// ******************************
// loaded in the header.php

function mem_date_of_today() {

	global $mem_today_now;
	$mem_today_now = date_i18n( "j F Y - H:i:s" );

	global $mem_today;
	$mem_today = date_i18n( "j F Y" );

	global $mem_today_short;
	$mem_today_short = date_i18n( "Y-m-d" );

	global $mem_isoweek;
	$mem_isoweek = date_i18n( "W" );

	global $mem_unix_now;
	$mem_unix_now = strtotime( $mem_today_short );

	// current year info

	global $mem_current_year;
	$mem_current_year = date_i18n( "Y" );

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

function my_mem_settings() {
	mem_plugin_settings( array( 'post', 'publications' ), 'full' );
}

add_action( 'mem_init', 'my_mem_settings' );


