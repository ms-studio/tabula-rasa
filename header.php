<?php
/**
 * @package WordPress
 * @subpackage Tabula_Rasa
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="utf-8">

  <!-- Use the .htaccess and remove these lines to avoid edge case issues.
         More info: h5bp.com/i/378 -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
 
  <title><?php if(is_front_page()){
  	bloginfo('name');} 
  	else {
  	wp_title('&mdash;',true,'right'); 
  	bloginfo('name');
  	}	
  	?></title>
  
  <?php // ** DESCRIPTION v.0.3 **
  if (is_single() || is_page() ) : if ( have_posts() ) : while ( have_posts() ) : the_post(); 
  ?><meta name="description" content="<?php  
  	$descr = get_the_excerpt();
  	$text = str_replace( '/\r\n/', ', ', trim($descr) ); 
  	echo esc_attr($text);
  ?>" />
  <?php endwhile; endif; elseif(is_home()) : 
  ?><meta name="description" content="<?php bloginfo('description'); ?>" />
  <?php endif; ?>
 
  <meta name="author" content="">
  
  <?php // ** SEO OPTIMIZATION v.0.2 **
  if ( is_attachment() ) {
  ?><meta name="robots" content="noindex,follow" /><?php
  } else if( is_single() || is_page() || is_home() ) { 
  ?><meta name="robots" content="all,index,follow" /><?php 
  } else if ( is_category() || is_archive() ) { 
  ?><meta name="robots" content="noindex,follow" /><?php } 
  ?>
  	  
  <!-- Mobile viewport optimized: h5bp.com/viewport -->
  <meta name="viewport" content="width=device-width">

  <!-- Place favicon.ico and apple-touch-icon.png in the root of your domain and delete these references : mathiasbynens.be/notes/touch-icons -->
  <link rel="shortcut icon" href="<?php echo $GLOBALS["TEMPLATE_RELATIVE_URL"] ?>img/icons/favicon.ico">
  
  <!-- For third-generation iPad with high-resolution Retina display: -->
  <link rel="apple-touch-icon" sizes="144x144" href="<?php echo $GLOBALS["TEMPLATE_RELATIVE_URL"] ?>img/icons/apple-touch-icon-144x144.png">
  <!-- For iPhone with high-resolution Retina display: -->
  <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $GLOBALS["TEMPLATE_RELATIVE_URL"] ?>img/icons/apple-touch-icon-114x114.png">
  <!-- For first- and second-generation iPad: -->
  <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $GLOBALS["TEMPLATE_RELATIVE_URL"] ?>img/icons/apple-touch-icon-72x72.png">
  <!-- For non-Retina iPhone, iPod Touch, and Android 2.1+ devices: -->
  <link rel="apple-touch-icon" href="<?php echo $GLOBALS["TEMPLATE_RELATIVE_URL"] ?>img/icons/apple-touch-icon.png">
  
  <style>.hidden {display: none;}</style>
  <!-- we want this to be hidden immediately before the rest of CSS loads -->
  
  <!-- CSS concatenated and minified via ant build script-->
  <link rel="stylesheet" href="<?php echo $GLOBALS["TEMPLATE_RELATIVE_URL"] ?>css/main.css" media="all">
  <!-- end CSS-->
  
  <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
  
  <script src="<?php echo $GLOBALS["TEMPLATE_RELATIVE_URL"] ?>js/libs/modernizr.custom.14446.min.js" ></script> 

  <!-- Wordpress Head Items -->
  <link rel="alternate" type="application/rss+xml" title="RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
  <!--[if lt IE 9]>
  <script src="<?php echo $GLOBALS["TEMPLATE_RELATIVE_URL"]; ?>js/html5.js" type="text/javascript"></script>
  <![endif]-->

  <?php wp_head(); ?>

</head>
<body <?php 
if ( in_category( 'whatever' ) && is_single() ) {
	body_class('whatever no-js');
} elseif ( in_category( 'whatnot' ) && is_single() ) {
	body_class('whatnot no-js');
} else {
	body_class('no-js');
	}  ?>>

  <div id="container" class="container">
    <header role="banner" class="header">
      <h1 class="h1"><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
      <p class="description"><?php bloginfo('description'); ?></p>
    </header>

	<?php wp_nav_menu( array(
		 'theme_location' => 'main-menu',
		 'container'       => 'nav',
		 'container_class'       => 'clearfix main-menu default-menu horiz-list small-font',
		 'depth'           => 0,
		 //'link_after'       => '&nbsp;',
		 ) ); ?>