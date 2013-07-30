<?php get_header(); ?>

	<div class="container_12 page_wrap">
    
    <h1><?php the_title(); ?></h1>
    TESTING TCP PRODUCTS ARCHIVE
    	
	    <?php if ( get_option( 'bizzthemes_breadcrumbs' )) { yoast_breadcrumb('<h1 class="breadcrumb">','</h1>'); } ?>
        
        
        	<?php
/* Run the loop to output the post.
* If you want to overload this in a child theme then include a file
* called loop-single.php and that will be used instead.
*/
get_template_part( ‘loop’, ‘tcp_product’ );
?>


        
	    	
			<?php if(have_posts()) : ?>
					
				<?php while(have_posts()) : the_post() ?>
        
                    <div id="post-<?php the_ID(); ?>" class="page">
                                     
                        <div id="content" class="grid_8">
						
                            	<?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'attachment-post-thumbnail', array('class'=> 'post_img') ); } ?>
                                
                                
                                        
                           
                            <?php the_content(); ?>
                            
                            
                           
                            
                            
                            
                        </div>
                                                                
                    </div><!--/post-->
                
                <?php endwhile; else : ?>
        
                    <div class="post box">
					
                        <div class="entry-head"><h2><?php echo get_option('bizzthemes_404error_name'); ?></h2></div>
						
                        <div class="entry-content"><p><?php echo get_option('bizzthemes_404solution_name'); ?></p></div>
						
                    </div>
        
            <?php endif; ?>

	<?php get_sidebar(); ?>
	
	</div><!--/container_12 -->

<?php get_footer(); ?>