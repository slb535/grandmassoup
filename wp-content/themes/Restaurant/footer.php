
<div class="clearfix"><!----></div>	

<?php global $is_home; ?>

<?php if ( $is_home ) { ?>

<div class="container_12 footwidgets-spot">
		
	<?php if ( function_exists('dynamic_sidebar') && (is_sidebar_active(3) || is_sidebar_active(4) || is_sidebar_active(5)) ) { // Don't show on the front page ?>
    
	<!-- Bottom Front Widgets: START -->
	
	    <div id="footwidgets-front">
	
		    <div class="widget-spot grid_4">
		
			    <?php dynamic_sidebar(3); ?>
			
		    </div>
		
		    <div class="widget-spot grid_4">
		
			    <?php dynamic_sidebar(4);  ?>	
			
		    </div>

		    <div class="widget-spot grid_4">
		
			    <?php dynamic_sidebar(5);  ?>	
			
		    </div>
		
	    </div><!--/footwidgets-front -->
		
	<!-- Bottom Front Widgets: END -->
    
    <?php } ?>
	
</div><!--/container_12 -->

<?php } ?>
    
<div class="container_12">

	<!-- Footer: START -->
		
	<div id="footer" >
			
		<div class="copyright">
			
            <p class="fl">&copy; <?php the_time('Y'); ?> <?php bloginfo(); ?> |  <a href="/privacy-policy/">Privacy Policy</a> | <a href="/terms-conditions/">Terms and Conditions</a><br/>    <span class="designby"> Restaurant Theme by </span> <span class="templatic"> <a href="http://templatic.com" title="templatic.com">templatic.com</a> </span> </p>
            <p class="fl">&nbsp;</p>
            <p class="fl">&nbsp;</p>
            <!-- (c) 2005, 2012. Authorize.Net is a registered trademark of CyberSource Corporation --> <div class="AuthorizeNetSeal"> <script type="text/javascript" language="javascript">var ANS_customer_id="956c3293-131b-4d9f-82b3-c60d721cca07";</script> <script type="text/javascript" language="javascript" src="//verify.authorize.net/anetseal/seal.js" ></script> <a href="http://www.authorize.net/" id="AuthorizeNetText" target="_blank">Online Payment Service</a> </div> 
				
            <div class="fr">
			
			<?php if ( get_option('bizzthemes_footpages') <> "" ) { ?>
			
			    <?php wp_list_pages('title_li=&depth=0&include=' . get_option('bizzthemes_footpages') .'&sort_column=menu_order'); ?>
			
		    <?php } ?>
						
			</div>
			
			<div class="clearfix"></div>
		
		</div><!--/copyright -->
								
	</div><!--/footer -->
	
	<!-- Footer: END -->
	
   	<?php wp_footer(); ?>
	
	<?php if ( get_option('bizzthemes_google_analytics') <> "" ) { echo stripslashes(get_option('bizzthemes_google_analytics')); } ?>

</div><!--/container_12 -->

</body>

</html>
