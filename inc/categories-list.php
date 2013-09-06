<?php

	 $is_conference = 'false';
//	 $is_expo = 'false';
//	 $is_symp = 'false';
//	 $is_conf = 'false';
//	 $show_cat = 'false';
	 
	 global $categories_array;
	 $categories_array = array();
	 
	 // test for Key categories
	 // NOTE: 
	 // in_category() tests only against a post's assigned categories, not ancestors (parents) of those categories.
	 // http://codex.wordpress.org/Function_Reference/in_category#Testing_if_a_post_is_in_a_descendant_category
	 
	 if ( in_category( 'conference' )) {
	 	$is_conference = 'true';
	 	$categories_array[] = array( 
	 			"name" => 'Conférence', 
	 			"slug" => 'conference',
	 	   );
	 	$nfo_body_var.='cat-conference ';
	 }
	 
	 if ( in_category( array( 'exposition', 'diplomes', /*etc*/ ) )) {
	 	$is_expo = 'true';
	 	$categories_array[] = array( 
	 			"name" => 'Exposition', 
	 			"slug" => 'exposition',
	 	   );
	 	 $nfo_body_var.='cat-expo ';
	 }
	 
	 if ( in_category( 'publications' )) {
	 	$is_expo = 'true';
	 	$categories_array[] = array( 
	 			"name" => 'Publication', 
	 			"slug" => 'publications',
	 	   );
	 	 $nfo_body_var.='cat-publication ';
	 }
	 
	 if ( in_category( 'actualite' )) {
	 	$is_expo = 'true';
	 	$categories_array[] = array( 
	 			"name" => 'Actualité', 
	 			"slug" => 'actualite',
	 	   );
	 	 $nfo_body_var.='cat-actualite ';
	 }
	 
	 if ( in_category( 'symposium' )) {
	 	$is_symp = 'true';
	 	$categories_array[] = array( 
	 			"name" => 'Symposium', 
	 			"slug" => 'symposium',
	 	   );
	 	 $nfo_body_var.='cat-symposium ';
	 }

	 
	 
	 // will be output in
	 // categories-list-output.php
	 
?>