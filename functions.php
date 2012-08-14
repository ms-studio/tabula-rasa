<?php
/**
 * @package WordPress
 * @subpackage HTML5_Boilerplate
 */
 
 
 // Post-Thumbnails Support
 // ******************************
 
 if ( function_exists( 'add_theme_support' ) ) {
	// 	add_theme_support( 'post-thumbnails' );
    // set_post_thumbnail_size( 150, 150 ); // default Post Thumbnail dimensions  
    // more info: http://codex.wordpress.org/Post_Thumbnails 
 }


// Custom image sizes
// ****************************** 
 
 if ( function_exists( 'add_image_size' ) ) { 
 	//add_image_size( 'category-thumb', 300, 9999 ); //300 pixels wide (and unlimited height)
 	//add_image_size( 'landscape', 304, 184, true ); // true = cropped
 }
 
 
 // Custom Menus
 // ****************************** 

 if ( function_exists( 'register_nav_menus' ) ) {
 	register_nav_menus(
 			array(
 				// 'main-menu' => __( 'This is the main menu' ),
 				// 'info-menu' => __( 'This is the info menu' ),
 				)
 			);
 }
 

// HTML5 Theme Functions
// ******************************

// Custom HTML5 Comment Markup
function mytheme_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li>
     <article <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
       <header class="comment-author vcard">
          <?php echo get_avatar($comment,$size='48',$default='<path_to_url>' ); ?>
          <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
          <time><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a></time>
          <?php edit_comment_link(__('(Edit)'),'  ','') ?>
       </header>
       <?php if ($comment->comment_approved == '0') : ?>
          <em><?php _e('Your comment is awaiting moderation.') ?></em>
          <br />
       <?php endif; ?>

       <?php comment_text() ?>

       <nav>
         <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
       </nav>
     </article>
    <!-- </li> is added by wordpress automatically -->
<?php
}

// Widgetized Sidebar HTML5 Markup
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'before_widget' => '<section>',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));
}

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

/**
 * remove WordPress Howdy : http://www.redbridgenet.com/?p=653
 */
function goodbye_howdy ( $wp_admin_bar ) {
    $avatar = get_avatar( get_current_user_id(), 16 );
    if ( ! $wp_admin_bar->get_node( 'my-account' ) )
        return;
    $wp_admin_bar->add_node( array(
        'id' => 'my-account',
        'title' => sprintf( '%s', wp_get_current_user()->display_name ) . $avatar,
    ) );
}
add_action( 'admin_bar_menu', 'goodbye_howdy' );

/* some cleanup 
******************************/

remove_action('wp_head', 'shortlink_wp_head');

remove_action( 'wp_head', 'feed_links' ); // not working...
remove_action( 'wp_head', 'feed_links', 2 );
remove_action('wp_head','feed_links_extra', 3);
// in order to remove the comments feed. need to add manually the main RSS feed to the header.

remove_action( 'wp_head', 'wp_generator');

// Prevents WordPress from testing ssl capability on domain.com/xmlrpc.php?rsd
remove_filter('atom_service_url','atom_service_url_filter');


// end of functions.php