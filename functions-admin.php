<?php  


// Admin Interface improvement


function custom_admin_head() {
        echo versioned_stylesheet($GLOBALS["TEMPLATE_RELATIVE_URL"]."admin/admin.css");
}
add_action('admin_head', 'custom_admin_head');



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


/* Edit screen improvements
******************************/

function remove_edit_fields() {
	
	/* Slug meta box. */
//	remove_meta_box( 'slugdiv', 'post', 'normal' );
	// remove comments status
	remove_meta_box( 'commentstatusdiv' , 'post' , 'normal' ); 
	// remove comments
	remove_meta_box( 'commentsdiv' , 'post' , 'normal' ); 
	// remove author 
	remove_meta_box( 'authordiv' , 'post' , 'normal' ); 
	/* Post format meta box. */
	remove_meta_box( 'formatdiv', 'post', 'normal' );
	/* Trackbacks meta box. */
	remove_meta_box( 'trackbacksdiv', 'post', 'normal' );
	/* Custom fields meta box. */
	remove_meta_box( 'postcustom', 'post', 'normal' );
	
}
add_action( 'add_meta_boxes' , 'remove_edit_fields' );

// src: http://codex.wordpress.org/Function_Reference/remove_meta_box
// http://justintadlock.com/archives/2011/04/13/uncluttering-the-post-editing-screen-in-wordpress


/* Dashboard improvement
******************************/

// http://wp.tutsplus.com/tutorials/customizing-wordpress-for-your-clients/
// http://www.wpbeginner.com/wp-tutorials/how-to-remove-wordpress-dashboard-widgets/

function tabula_remove_dashboard_widgets()
{
	// Globalize the metaboxes array, this holds all the widgets for wp-admin
	global $wp_meta_boxes;
	
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
		
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	// RSS feeds:
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
	
}
add_action('wp_dashboard_setup', 'tabula_remove_dashboard_widgets' );

/**
 * Show recent posts : 
 * https://gist.github.com/ms-studio/6069116
 */

function wps_recent_posts_dw() {
?>
   <ol>
     <?php
          global $post;
          $args = array( 'numberposts' => 5 );
          $myposts = get_posts( $args );
                foreach( $myposts as $post ) :  setup_postdata($post); ?>
                    <li> <? the_time('j F Y'); ?> – <a href="<?php echo admin_url(); ?>post.php?post=<?php the_ID(); ?>&action=edit"><?php the_title(); ?></a> (<a href="<?php the_permalink(); ?>">visiter</a>)</li>
          <?php endforeach; ?>
   </ol>
<?php
}
function add_wps_recent_posts_dw() {
       wp_add_dashboard_widget( 'wps_recent_posts_dw', __( 'Recent Posts' ), 'wps_recent_posts_dw' );
}
add_action('wp_dashboard_setup', 'add_wps_recent_posts_dw' );

/**
 * end of functions-admin.php
 */
