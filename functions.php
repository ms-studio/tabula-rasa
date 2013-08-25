<?php
/**
 * @package WordPress
 * @subpackage HTML5_Boilerplate
 */
 
 
require_once('functions-init.php');


/* CSS/JS Versioning
*********************/ 

// Custom Functions for CSS/Javascript Versioning
$GLOBALS["TEMPLATE_URL"] = get_bloginfo('template_url')."/";
$GLOBALS["TEMPLATE_RELATIVE_URL"] = wp_make_link_relative($GLOBALS["TEMPLATE_URL"]);

// Add ?v=[last modified time] to style sheets
function versioned_stylesheet($relative_url, $add_attributes=""){
  echo '<link rel="stylesheet" href="'.versioned_resource($relative_url).'" '.$add_attributes.'>'."\n";
}

// Add ?v=[last modified time] to javascripts
function versioned_javascript($relative_url, $add_attributes=""){
  echo '<script src="'.versioned_resource($relative_url).'" '.$add_attributes.'></script>'."\n";
}

// Add ?v=[last modified time] to a file url
function versioned_resource($relative_url){
  $file = $_SERVER["DOCUMENT_ROOT"].$relative_url;
  $file_version = "";

  if(file_exists($file)) {
    $file_version = "?v=".filemtime($file);
  }

  return $relative_url.$file_version;
}


/* login interface
******************************/

//custom Login
function custom_login() { 
echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/login/login.css" />'; 
}
add_action('login_head', 'custom_login');

// src: http://codex.wordpress.org/Customizing_the_Login_Form

// change the link values so the logo links to your WordPress site
function my_login_logo_url() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return 'Your Site Name and Info';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );


/* admin interface
******************************/

require_once('functions-admin.php');



// end of functions.php