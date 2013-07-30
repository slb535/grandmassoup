<?php get_header(); ?>

	<div class="container_12 page_wrap">
    
    	 <h1>404 Page</h1>
	    
		<?php if ( get_option( 'bizzthemes_breadcrumbs' )) { yoast_breadcrumb('<div id="breadcrumb"><p>','</p></div>'); } ?>
	
		<div class="pagespot">

			<div class="post archive-spot">
				    						                        
                <h2><?php echo get_option('bizzthemes_404error_name'); ?></h2>
				
				<div class="cat-spot"><p><?php echo get_option('bizzthemes_404solution_name'); ?></p></div>

                <div class="fix"></div>
						
            </div><!--/post-->  

		</div><!--/pagespot -->
		
</div><!--/container_12 -->

<?php get_footer(); ?>