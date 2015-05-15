<?php


// Admin Interface improvement


function custom_admin_head() {
	echo versioned_stylesheet( $GLOBALS["TEMPLATE_RELATIVE_URL"] . "admin/admin.css" );
}

add_action( 'admin_head', 'custom_admin_head' );


/**
 * remove WordPress Howdy
 * http://www.redbridgenet.com/?p=653
 ******************************/
function goodbye_howdy( $wp_admin_bar ) {
	$avatar = get_avatar( get_current_user_id(), 16 );
	if ( ! $wp_admin_bar->get_node( 'my-account' ) ) {
		return;
	}
	$wp_admin_bar->add_node( array(
			'id'    => 'my-account',
			'title' => sprintf( '%s', wp_get_current_user()->display_name ) . $avatar,
	) );
}

add_action( 'admin_bar_menu', 'goodbye_howdy' );


/**
 * force a color scheme - by Ipstenu (Mika Epstein)
 * http://halfelf.org/2013/mp6uccess-tips-and-tricks/
 *
 * Note: this leaves no choice, the color scheme is mandatory.
 *
 ******************************/
 
//add_filter('get_user_option_admin_color', 'change_admin_color');
//function change_admin_color($result) {
//    return 'ectoplasm';
//} 
 
 
/**
	* set default color scheme - by Andrew S Freeman
	* https://gist.github.com/andrewsfreeman/8062263
	*
	* forked from Till Krss
	* https://gist.github.com/tillkruess/6401453
	*
	* Note: this replaces the default ('classic' or 'fresh') color scheme, 
	* so this scheme isn't available anymore.
	*
	******************************/
 
//add_filter( 'get_user_option_admin_color', function( $color_scheme ) {
//
//	global $_wp_admin_css_colors;
//
//	if ( 'classic' == $color_scheme || 'fresh' == $color_scheme ) {
//		$color_scheme = 'ectoplasm';
//	}
//	return $color_scheme;
//
//}, 5 );


/**
	* define default color scheme for new users:
	*
	* http://llocally.com/?p=5251
	*
	* Note: this simply sets a default scheme at user creation.
	* The user is allowed to change afterwards.
	*
	******************************/

add_action( 'user_register', function($userid) {
 update_user_option( $userid, 'admin_color', 'ectoplasm');
});



/**
 * Modify the admin footer text
 * http://www.rvamedia.com/wordpress/how-to-white-label-wordpress
 ******************************/

function modify_footer_admin() {
	echo '<span id="footer-thankyou">&nbsp;</span>';
}

add_filter( 'admin_footer_text', 'modify_footer_admin' );


/* Edit screen improvements
******************************/

function remove_edit_fields() {

	/* Slug meta box. */
//	remove_meta_box( 'slugdiv', 'post', 'normal' );
	// remove comments status
	remove_meta_box( 'commentstatusdiv', 'post', 'normal' );
	// remove comments
	remove_meta_box( 'commentsdiv', 'post', 'normal' );
	// remove author 
	remove_meta_box( 'authordiv', 'post', 'normal' );
	/* Post format meta box. */
	remove_meta_box( 'formatdiv', 'post', 'normal' );
	/* Trackbacks meta box. */
	remove_meta_box( 'trackbacksdiv', 'post', 'normal' );
	/* Custom fields meta box. */
	remove_meta_box( 'postcustom', 'post', 'normal' );

}

add_action( 'add_meta_boxes', 'remove_edit_fields' );

// src: http://codex.wordpress.org/Function_Reference/remove_meta_box
// http://justintadlock.com/archives/2011/04/13/uncluttering-the-post-editing-screen-in-wordpress


/* Dashboard improvement
******************************/

// http://wp.tutsplus.com/tutorials/customizing-wordpress-for-your-clients/
// http://www.wpbeginner.com/wp-tutorials/how-to-remove-wordpress-dashboard-widgets/

function tabula_remove_dashboard_widgets() {
	// Globalize the metaboxes array, this holds all the widgets for wp-admin
	global $wp_meta_boxes;
	
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press'] );

	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity'] );

	// RSS feeds:
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_primary'] );

}
add_action( 'wp_dashboard_setup', 'tabula_remove_dashboard_widgets' );

/**
 * Show recent posts :
 * https://gist.github.com/ms-studio/6069116
 */
 
// source: https://snipt.net/dnnsldr/add-a-custom-meta-box-to-wordpress-dashboard/
//adds a custom meta box in the dashboard of WordPress
//this one is for a simple "Contact Your Web Designer" but can be anything

//add to functions.php file in WP
//add an metabox for support into the dashboard and remove default meta boxes
    
function tr_dashboard_help() {
    ?>
    <ul>
    	<li><a href="<?php echo admin_url(); ?>post-new.php" class="button-primary">Ajouter une News</a></li>
    	<li><a href="<?php echo admin_url(); ?>edit.php" class="button-secondary">Gérer les News</a></li>
    	
    	<li><a href="<?php echo admin_url(); ?>edit.php?post_type=membres" class="button-primary">Gérer les pages Membres</a></li>
    	<li><a href="<?php echo admin_url(); ?>edit-tags.php?taxonomy=locaux&post_type=membres" class="button-primary">Gérer les Locaux</a></li>
    	<li><a href="<?php echo admin_url(); ?>admin.php?page=options-velodrome" class="button-primary">Les images par défaut</a></li>
    	
    	<hr class="custom-dash-divider" />
    	<li><a href="https://docs.example.com" class="site-documentation" target="_blank">Documentation Site</a></li>
    	<li><a href="mailto:site@example.org?subject=Site%20Vélodrome" class="site-documentation site-contact" target="_blank">Contact Webmaster</a></li>
    	
    </ul>
    <style>
    	.custom-dash-divider {
    		margin-top: 1em;
    	}
    	#dashboard-widgets .site-documentation:before {
    			font: 400 20px/1 dashicons;
    			content: "\f348";
    			color: #aaa;
    			speak: none;
    			display: block;
    			float: left;
    			margin: 0 5px 0 0;
    			padding: 0;
    			text-indent: 0;
    			text-align: center;
    			position: relative;
    			-webkit-font-smoothing: antialiased;
    			text-decoration: none!important;
    	}
    	#dashboard-widgets .site-contact:before {
    		content: "\f465";
    	}
    </style>
    <?php
}
 

function tr_dashboard_recent_posts() {
	?>
	<ul style="list-style-type: disc;padding-left: 1.5em;">
		<?php
		global $post;
		$args = array( 'numberposts' => 5 );
		$myposts = get_posts( $args );
		foreach ( $myposts as $post ) :  setup_postdata( $post ); ?>
			<li> <? the_time( 'j F Y' ); ?> 
				<a href="<?php echo admin_url(); ?>post.php?post=<?php the_ID(); ?>&action=edit"><?php the_title(); ?></a> (<a href="<?php the_permalink(); ?>">visiter</a>)
			</li>
		<?php endforeach; ?>
	</ul>
<?php
}

function tr_custom_dashboard_widgets() {
	global $wp_meta_boxes; // necessary ?
	wp_add_dashboard_widget( 'tr_dashboard_recent_posts', __( 'Recent Posts' ), 'tr_dashboard_recent_posts' );
	wp_add_dashboard_widget('tr_dashboard_help', __( 'Actions fréquentes' ), 'tr_dashboard_help');
}

add_action( 'wp_dashboard_setup', 'tr_custom_dashboard_widgets' );

/**
 * end of functions-admin.php
 */
