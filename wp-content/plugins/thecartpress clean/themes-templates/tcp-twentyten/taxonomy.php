<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

		<div id="container">
			<div id="content" role="main">

				<h1 class="page-title"><?php
					printf( __( 'Category Archives: %s', 'twentyten' ), '<span>' . single_cat_title( '', false ) . '</span>' );
				?></h1>
			<?php echo do_shortcode("[shortcode]"); ?>

			</div><!-- #content -->
		</div><!-- #container -->

	<?php dynamic_sidebar ( 'Weekly Menu Sidebar'); ?>

<?php get_footer(); ?>
