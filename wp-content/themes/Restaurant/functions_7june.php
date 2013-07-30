<?php 

/*************************************************************
* Do not modify unless you know what you're doing, SERIOUSLY!
*************************************************************/
error_reporting(E_ERROR);
global $blog_id;
if($blog_id)
{
	$upload_folder_path = "wp-content/blogs.dir/$blog_id/files/";
}else
{
	$upload_folder_path = "wp-content/uploads/";
}
global $blog_id;
if($blog_id){ $thumb_url = "&bid=$blog_id";}

if ( function_exists( 'add_theme_support' ) ){
	add_theme_support( 'post-thumbnails' );
	}

/* Admin framework version 2.0 by Zeljan Topic */

// Theme variables
require_once (TEMPLATEPATH . '/library/functions/theme_variables.php');

//** ADMINISTRATION FILES **//

    // Theme admin functions
    require_once ($functions_path . 'admin_functions.php');

    // Theme admin options
    require_once ($functions_path . 'admin_options.php');

    // Theme admin Settings
    require_once ($functions_path . 'admin_settings.php');

   
//** FRONT-END FILES **//

    // Widgets
    require_once ($functions_path . 'widgets_functions.php');

    // Custom
    require_once ($functions_path . 'custom_functions.php');

    // Comments
    require_once ($functions_path . 'comments_functions.php');
	
	// Yoast's plugins
    require_once ($functions_path . 'yoast-breadcrumbs.php');
	
    require_once ($functions_path . 'yoast-posts.php');
	
	require_once ($functions_path . 'yoast-canonical.php');
	
	
	//theme.php
define('THEME_DUMMY_DELETE_MESSAGE','<div class="updated fade">All Dummy data has been removed from your database successfully!</div>');

	
	if('themes.php' == basename($_SERVER['SCRIPT_FILENAME'])) 
	{
		if($_REQUEST['dummy']=='del')
		{
			delete_dummy_data();	
			echo THEME_DUMMY_DELETE_MESSAGE;
		}
		
		$post_counts = $wpdb->get_var("select count(post_id) from $wpdb->postmeta where meta_key='pt_dummy_content' and meta_value=1");
		if(($_REQUEST['template']=='' && $post_counts>0 && $_REQUEST['page']=='') || $_REQUEST['activated']=='true')
		{
			$dummy_data_msg = '<p> wish to delete the dummy data that we populated in your site? <a href="'.get_option('siteurl').'/wp-admin/themes.php?dummy=del">Yes Delete Please!</a><p>';
		}else
		{
			$dummy_data_msg = '<p>wish to insert the dummy data in your site? <a href="'.get_option('siteurl').'/wp-admin/themes.php?dummy_insert=1">Yes Insert Please!</a></p>';
		}
		define('THEME_ACTIVE_MESSAGE','<style>* html #adminmenu { float:left; margin:0; position:absolute; z-index:0; left:85px; } .wrap { widht:600px; } * html #wpbody-content { width:80% !important; } * html #footer { position:absolute; z-index:0; bottom:0; left:0; display:none; } 
.message { padding:10px; line-height:150%; border:4px solid #e74c00; background:#FFFFC6; position:absolute; z-index:0; left:180px; top:340px; _top:310px; width:75%;  }  
#current-theme { marign:1em 0 8.5em 0 !important; padding-bottom:180px !important; }  </style><div class="message" id="message2"  ><p style="line-height:160% !important; font:bold 14px arial;"><strong>Theme Activated. We also completely installed the theme and added dummy content and categories by default.  So you can start using it right away.  </strong></p>
'.$dummy_data_msg.'</div>');
		echo THEME_ACTIVE_MESSAGE;
		if($_REQUEST['dummy_insert'])
		{
			require_once (TEMPLATEPATH . '/auto_install.php');
		}
	}
	
	function delete_dummy_data()
	{
		global $wpdb;
		$productArray = array();
		$pids_sql = "select p.ID from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where meta_key='pt_dummy_content' and meta_value=1";
		$pids_info = $wpdb->get_results($pids_sql);
		foreach($pids_info as $pids_info_obj)
		{
			$productArray[] = $pids_info_obj->ID; 
		}
		if($productArray)
		{
			$product_ids = implode(',',$productArray);
			$commentsql = "delete from $wpdb->comments where comment_post_ID in ($product_ids)";
			$wpdb->query($commentsql);
			$postmetasql = "delete from $wpdb->postmeta where post_id in ($product_ids)";
			$wpdb->query($postmetasql);
			$postmetasql = "delete from $wpdb->term_relationships where object_id in ($product_ids)";
			$wpdb->query($postmetasql);
			$postmetasql = "delete from $wpdb->posts where ID in ($product_ids)";
			$wpdb->query($postmetasql);
		}
	}

?>
