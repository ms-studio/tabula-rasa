<?php
/**
 * @package WordPress
 * @subpackage HTML5_Boilerplate
 */
?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
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
  	?> </title>
  
  <?php // ** DESCRIPTION v.0.1 **
  if (is_single() || is_page() ) : if ( have_posts() ) : while ( have_posts() ) : the_post(); 
  ?><meta name="description" content="<?php  
  // the_excerpt_rss(); is problematic : can contain "" characters that break the syntax. 
  // better to use...
  	$str = get_the_content();
  	$str2 = strip_tags($str);
  	$str3 = htmlentities($str2, ENT_COMPAT);
  	//echo trim($str3); trims only beginning and end of string ...
  	//echo php_strip_whitespace($str3); works only for PHP ...
  	$text = preg_replace( '/\r\n/', ' ', trim($str3) ); 	
  	// Change to the number of characters you want to display
  	        $chars = 150;
  	        $text = $text." ";
  	        $text = substr($text,0,$chars);
  	        $text = substr($text,0,strrpos($text,' '));
  	        $text = $text."...";
  	 echo $text;
  ?>" />
  <?php endwhile; endif; elseif(is_home()) : 
  ?><meta name="description" content="Place your custom description for HOME here." />
  <?php endif; ?>
 
  <meta name="author" content="">
  
  <?php // ** SEO OPTIMIZATION v.0.1 **
  	if(is_single() || is_page() || is_home()) { 
  	?><meta name="robots" content="all,index,follow" /><?php 
  	} elseif (is_category() || is_archive()) { 
  	?><meta name="robots" content="noindex,follow" /><?php } 
  	?>
  	  
  <!-- Mobile viewport optimized: h5bp.com/viewport -->
  <meta name="viewport" content="width=device-width">

  <!-- Place favicon.ico and apple-touch-icon.png in the root of your domain and delete these references : mathiasbynens.be/notes/touch-icons -->
  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">
  
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

  <?php wp_head(); ?>

</head>
<body>

  <div id="container" class="container">
    <header role="banner" class="header">
      <h1 class="h1"><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
      <p class="description"><?php bloginfo('description'); ?></p>
    </header>

