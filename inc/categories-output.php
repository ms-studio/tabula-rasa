<?php

	
	global $categories_array;
	$has_categories = '';
	
	if (empty($categories_array)) {
	    	    	// array is empty.
	    	} else { 
	    	
	    	echo '<ul class="clean ul-horiz list-categories">';
	    	
	    	if ($has_link == 'false') {
	    		
	    		foreach ($categories_array as $key => $row){
	    		
	    			echo '<li class="li">';
	    			echo $categories_array[$key]["name"].'</li>' ;
	    			 
	    		} // end foreach
	    	
	    	} else {
	    	
	    	// default = show the link
	    	
		    	foreach ($categories_array as $key => $row){
		    	
		    		// don't display current category.
		    		
		    		if ($exlude_cat_slug == $categories_array[$key]["slug"] ) {
		    			// no output
		    		} else {
		    		
		    			echo '<li class="li"><a class="u-h" href="';
		    			echo home_url('/categorie/');
		    			echo $categories_array[$key]["slug"].'/';
		    			echo '" title="Voir les projets de la catégorie &laquo;'.$categories_array[$key]["name"].'&raquo;">'.$categories_array[$key]["name"].'</a></li>' ;
		    		
		    			$has_categories = true;
		    		}
		    	
		    		 
		    	} // end foreach
		    	
		    }
	    	
	    	echo '</ul>';
	    		    	
	    	}
	 
?>