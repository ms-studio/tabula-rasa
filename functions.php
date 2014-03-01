<?php
/**
 * @package    WordPress
 * @subpackage HTML5_Boilerplate
 */


require_once( 'functions-init.php' );


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

if ( is_user_logged_in() ) {
		require_once('functions-admin.php');
}


/* Jetpack
 * Enable only specific modules
 * See http://wp.me/p3Bu3Z-Gt
************************************/

//function jeherve_only_stats ( $modules ) {
//    $return = array();
//    $return['stats'] = $modules['stats'];
//    return $return;
//}
//add_filter( 'jetpack_get_available_modules', 'jeherve_only_stats' );



// end of functions.php