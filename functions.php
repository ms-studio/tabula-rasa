<?php
/**
 * @package    WordPress
 * @subpackage HTML5_Boilerplate
 */


require_once( 'functions-init.php' );


/* Allow Automatic Updates
 ******************************
 * http://codex.wordpress.org/Configuring_Automatic_Background_Updates
 */

add_filter( 'auto_update_plugin', '__return_true' );
add_filter( 'auto_update_theme', '__return_true' );
add_filter( 'allow_major_auto_core_updates', '__return_true' );

/* login interface
******************************/

//custom Login
function custom_login() {
	echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo( 'template_directory' ) . '/login/login.css" />';
}

add_action( 'login_head', 'custom_login' );

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

require_once( 'functions-admin.php' );



// end of functions.php