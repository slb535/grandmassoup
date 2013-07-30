<?php get_header(); ?>

	<div class="container_12 page_wrap">
	
 
	
	    <div id="content"  class="grid_8">
			
			<?php if(have_posts()) : ?>
					
			<?php while(have_posts()) : the_post() ?>
        
                <div id="post-<?php the_ID(); ?>" class="posts clearfix">
				
				    <div class="post_top">
					
                                                    
                        <div class="post_title">
							
                            <h3><?php the_title(); ?></h3>
                                
						<!--	<p>Published by <?php the_author_posts_link(); ?></p> -->
                                
                        </div>
						
					</div> <!-- posttop #end -->
							
				<!--	<div class="comments"><a href="#comments"><?php comments_number('0', '1', '%'); ?></a> Comments </div> -->
							
				    <div class="post_content">
                
                		<?php if ( get_post_meta($post->ID,'image', true) ) { ?>
                
                            <a title="Link to <?php the_title(); ?>" href="<?php the_permalink() ?>"><img src="<?php echo bloginfo('template_url'); ?>/thumb.php?src=<?php echo get_post_meta($post->ID, "image", $single = true); ?>&amp;h=250&amp;w=450&amp;zc=1&amp;q=80<?php echo $thumb_url;?>" alt="<?php the_title(); ?>" class="post_img" style="margin-top:5px; margin-right:10px" /></a>          	
                        							
                        <?php } ?>
                					
					    <?php the_content(); ?>
										
                    </div>
                        
                    <div class="post_bottom">
						
					 <div class="thankyou"> Thank you for choosing Grandma’s Soup.  We are honored to support you on your healthy journey.</div>

                    </div>                            
                            						
                </div><!--/posts-->  

						
	                <div class="fix"></div>
        
            
        
            <?php endwhile; ?>
        
            <?php endif; ?>
			
		</div><!--/content -->
         <BR /><BR />
         
         

	<?php dynamic_sidebar ( 'Weekly Menu Sidebar'); ?>

<?php get_footer(); ?>