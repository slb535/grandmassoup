<?php
  $post = $wp_query->post;
  if (in_category('fundraising')) {
      include(TEMPLATEPATH.'/single_fundraising.php');
  }  elseif (in_category('znosidebar')) {
       include(TEMPLATEPATH.'/single_nosidebar.php');
 }  elseif (in_category('chefskitchen')) {
       include(TEMPLATEPATH.'/single_chefskitchen.php');	
	    }  elseif (in_category('catalog')) {
       include('/home/content/44/9185344/html/wp-content/plugins/thecartpress/themes-templates/tcp-twentyeleven/taxonomy.php');	
  } else{
      include(TEMPLATEPATH.'/single_default.php');
  }
?>