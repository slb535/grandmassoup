<?php
/**
 * This file is part of TheCartPress.
 * 
 * TheCartPress is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * TheCartPress is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with TheCartPress.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once( TCP_WIDGETS_FOLDER . 'TCPParentWidget.class.php' );

class CustomListWidget extends TCPParentWidget {

	function CustomListWidget( $name, $description, $title, $width = 300 ) {
		parent::__construct( $name, $description, $title, $width );
	}

	function widget( $args, $loop_args, $instance ) {
		if ( ! parent::widget( $args, $instance ) ) return;
		extract( $args );
		$order_type = isset( $instance['order_type'] ) ? $instance['order_type'] : 'date';
		$order_desc = isset( $instance['order_desc'] ) ? $instance['order_desc'] : 'asc';
		if ( $order_type == 'price' ) {
			$loop_args['orderby']	= 'meta_value_num';
			$loop_args['meta_key']	= 'tcp_price';
		} elseif ( $order_type == 'order' ) {
			$loop_args['orderby']	= 'meta_value_num';
			$loop_args['meta_key']	= 'tcp_order';
		} else {
			if ( strlen( $order_type ) > 0 ) $loop_args['orderby']	= $order_type;
		}
		if ( strlen( $order_desc ) > 0 ) $loop_args['order'] = $order_desc;
		$loop_args = apply_filters( 'tcp_sort_loop', $loop_args, $order_type, $order_desc );

		if ( isset( $loop_args['post_type'] ) && tcp_is_saleable_post_type( $loop_args['post_type'] ) ) {
			$loop_args['meta_query'][] = array(
				'key'		=> 'tcp_is_visible',
				'value'		=> 1,
				'compare'	=> '='
			);
		}
		query_posts( $loop_args );
		if ( ! have_posts() ) {
			wp_reset_query();
			return;
		}
		echo $before_widget;
		$title = apply_filters( 'widget_title', $instance['title'] );
		if ( $title ) echo $before_title, $title, $after_title;
		if ( isset( $instance['loop'] ) && strlen( $instance['loop'] ) > 0 && file_exists( $instance['loop'] ) ) {
			include( $instance['loop'] );
		} else {
			$columns = isset( $instance['columns'] ) ? (int)$instance['columns'] : 1;
			if ( $columns < 1 ) {
				$this->show_list( $instance );
			} else {
				$this->show_grid( $instance );
			}
		}
		wp_reset_postdata();
		wp_reset_query();
		echo $after_widget;
	}

	function show_list( $instance ) {
		if ( isset( $instance['pagination'] ) && $instance['pagination'] ) echo tcp_pagination_bar();
		if ( have_posts() ) while ( have_posts() ) : the_post();
			if ( isset( $instance['title_tag'] ) && $instance['title_tag'] != '' ) {
				$title_tag = '<' . $instance['title_tag'] . '>';
				$title_end_tag = '</' . $instance['title_tag'] . '>';
			} else {
				$title_tag = '';
				$title_end_tag = '';
			} ?>
			<div id="post-<?php the_ID(); ?>" class="<?php post_class(); ?>">
				<?php do_action( 'tcp_before_custom_list_widget_item', get_the_ID() );?>
				<?php if ( isset( $instance['see_title'] ) && $instance['see_title'] ) : ?>
				<div class="entry-title">
					<?php echo $title_tag;?><a href="<?php the_permalink( );?>"><?php the_title(); ?></a><?php echo $title_end_tag;?>
				</div>
				<?php endif;?>
				<?php if ( isset( $instance['see_posted_on'] ) && $instance['see_posted_on'] ) : ?>
					<div class="entry-meta">
						<?php tcp_posted_on(); ?> <?php tcp_posted_by(); ?>
					</div><!-- .entry-meta -->
				<?php endif; ?>
				<?php if ( isset( $instance['see_image'] ) && $instance['see_image'] ) : 
					$image_size = isset( $instance['image_size'] ) ? $instance['image_size'] : 'thumbnail';?>
				<div class="entry-post-<?php echo $image_size;?>">
					<a class="size-<?php echo $image_size;?>" href="<?php the_permalink(); ?>"><?php if ( function_exists( 'the_post_thumbnail' ) ) the_post_thumbnail( isset( $instance['image_size'] ) ? $instance['image_size'] : 'thumbnail' ); ?></a>
				</div><!-- .entry-post-thumbnail -->
				<?php endif; ?>
				<?php if ( isset( $instance['see_excerpt'] ) && $instance['see_excerpt'] ) : ?>
				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div>
				<?php endif;?>
				<?php if ( isset( $instance['see_price'] ) && $instance['see_price'] ) : ?>
				<div class="entry-product_custom">
					<p class="entry_tcp_price"><?php echo __( 'price', 'tcp' );?>:&nbsp;<?php tcp_the_price_label();?></p>
				</div>
				<?php endif;?>
				<?php if ( isset( $instance['see_buy_button'] ) && $instance['see_buy_button'] ) : ?>
				<div class="entry_tcp_buy_button">
					<?php tcp_the_buy_button();?>
				</div>
				<?php endif;?>
				<?php if ( isset( $instance['see_content'] ) && $instance['see_content'] ) : ?>
				<div class="entry-content">
					<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'tcp' ) ); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-link">'.__( 'Pages:', 'tcp' ), 'after' => '</div>')); ?>
				</div>
				<?php endif;?>
				<?php if ( isset( $instance['see_meta_utilities'] ) && $instance['see_meta_utilities'] ) : ?>
				<div class="entry-utility">
					<?php if ( count( get_the_category() ) ): ?>
					<span class="cat-links">
						<?php printf( __( '<span class="%1$s">Posted in</span> %2$s', 'tcp' ), 'entry-utility-prep entry-utility-prep-cat-links', get_the_category_list( ', ' ) ); ?>
					</span>
					<span class="meta-sep">|</span>
					<?php endif;
					$tags_list = get_the_tag_list( '', ', ' );
					if ( $tags_list ): ?>
					<span class="tag-links">
						<?php printf( __( '<span class="%1$s">Tagged</span> %2$s', 'tcp' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list ); ?>
					</span>
					<span class="meta-sep">|</span>
				<?php endif; ?>
				<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'tcp' ), __( '1 Comment', 'tcp' ), __( '% Comments', 'tcp' ) ); ?></span>
				<?php edit_post_link( __( 'Edit', 'tcp' ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
				<?php do_action( 'tcp_after_loop_tcp_grid_item', get_the_ID() );?>
				</div>
				<?php do_action( 'tcp_after_loop_tcp_grid' );?>
				<?php endif;?>
			</div>
		<?php endwhile;
	}

	function show_grid( $instance ) {
		if ( isset( $instance['pagination'] ) && $instance['pagination'] )
			$instance['see_pagination'] = $instance['pagination'];
		include( TCP_THEMES_TEMPLATES_FOLDER . 'tcp-twentyeleven/loop-tcp-grid.php' );
	}

	function update( $new_instance, $old_instance ) {
		$instance = parent::update( $new_instance, $old_instance );
		$instance['limit']					= (int)$new_instance['limit'];
		$instance['loop']					= $new_instance['loop'];
		$instance['columns']				= (int)$new_instance['columns'];
		$instance['see_title']				= $new_instance['see_title'] == 'yes';
		$instance['title_tag']				= $new_instance['title_tag'];
		$instance['see_image']				= $new_instance['see_image'] == 'yes';
		$instance['image_size']				= $new_instance['image_size'];
		$instance['see_content']			= $new_instance['see_content'] == 'yes';
		$instance['see_excerpt']			= $new_instance['see_excerpt'] == 'yes';
		$instance['see_author']				= $new_instance['see_author'] == 'yes';
		$instance['see_meta_data']			= $new_instance['see_meta_data'] == 'yes';
		$instance['see_price']				= $new_instance['see_price'] == 'yes';
		$instance['see_buy_button']			= $new_instance['see_buy_button'] == 'yes';
		$instance['see_first_custom_area']	= $new_instance['see_first_custom_area'] == 'yes';
		$instance['see_second_custom_area']	= $new_instance['see_second_custom_area'] == 'yes';
		$instance['see_third_custom_area']	= $new_instance['see_third_custom_area'] == 'yes';
		return $instance;
	}

	function form( $instance, $title = '' ) {
		$instance = parent::form( $instance, $title );
	}

	protected function show_post_type_form( $instance ) {
		$defaults = array(
			'limit'						=>  5,
			'loop'						=> '',
			'columns'					=> 2,
			'see_title'					=> true,
			'title_tag'					=> '',
			'see_image'					=> false,
			'image_size'				=> 'thumbnail',
			'see_content'				=> false,
			'see_excerpt'				=> false,
			'see_meta_data'				=> false,
			'see_price'					=> true,
			'see_buy_button'			=> false,
			'see_first_custom_area'		=> false,
			'see_second_custom_area'	=> false,
			'see_third_custom_area'		=> false,
		);
		$instance = wp_parse_args( ( array ) $instance, $defaults );
		$see_title				= isset( $instance['see_title'] ) ? $instance['see_title'] 	: false;
		$title_tag				= isset( $instance['title_tag'] ) ? $instance['title_tag'] : '';
		$see_image				= isset( $instance['see_image'] ) ? $instance['see_image']	: false;
		$image_size				= isset( $instance['image_size'] ) ? $instance['image_size']	: 'thumbnail';
		$see_content			= isset( $instance['see_content'] ) ? $instance['see_content']	: false;
		$see_excerpt			= isset( $instance['see_excerpt'] ) ? $instance['see_excerpt']	: false;
		$see_author				= isset( $instance['see_author'] ) ? $instance['see_author']	: false;
		$see_meta_data			= isset( $instance['see_meta_data'] ) ? $instance['see_meta_data']: false;
		$see_meta_utilities		= isset( $instance['see_meta_utilities'] ) ? $instance['see_meta_utilities'] : false;
		$see_price				= isset( $instance['see_price'] ) ? $instance['see_price']	: false;
		$see_buy_button			= isset( $instance['see_buy_button'] ) ? $instance['see_buy_button']: false;
		$use_taxonomy 			= isset( $instance['use_taxonomy'] ) ? $instance['use_taxonomy'] : false;
		$see_first_custom_area 	= isset( $instance['see_first_custom_area'] ) ? $instance['see_first_custom_area'] : false;
		$see_second_custom_area = isset( $instance['see_second_custom_area'] ) ? $instance['see_second_custom_area'] : false;
		$see_third_custom_area 	= isset( $instance['see_third_custom_area'] ) ? $instance['see_third_custom_area'] : false; ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'Limit', 'tcp' ); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" type="text" value="<?php echo $instance['limit']; ?>" size="3" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'loop' ); ?>"><?php _e( 'Loop', 'tcp' ); ?>:</label>
			&nbsp;(<?php _e( 'theme', 'tcp' );?>:&nbsp;<?php echo get_template();?>)
			<select name="<?php echo $this->get_field_name( 'loop' ); ?>" id="<?php echo $this->get_field_id( 'loop' ); ?>" class="widefat">
				<option value="" <?php selected( $instance['loop'], "" ); ?>><?php _e( 'default', 'tcp' ); ?></option>
			<?php
			$files = array();
			$folder = STYLESHEETPATH;
			if ( $handle = opendir($folder ) ) :
				while ( false !== ( $file = readdir( $handle ) ) ) :
					if ( $file != '.' && $file != '..' && strpos( $file, 'loop' ) === 0 ) : ?>
						<option value="<?php echo $folder . '/' . $file;?>" <?php selected( $instance['loop'], $folder . '/' . $file ); ?>><?php echo $file; ?></option>
						<?php $files[] = $file;
					endif;?>
				<?php endwhile; 
				closedir( $handle );
			endif;
			$folder = get_template_directory();
			if ( STYLESHEETPATH != $folder )
				if ( $handle = opendir($folder ) ) :
					while ( false !== ( $file = readdir( $handle ) ) ) :
						if ( $file != '.' && $file != '..' && strpos( $file, 'loop' ) === 0 && ! in_array( $file, $files ) ) : ?>
				<option value="<?php echo $folder . '/' . $file;?>" <?php selected( $instance['loop'], $folder . '/' . $file ); ?>>[<?php _e( 'parent', 'tcp' );?>] <?php echo $file; ?></option>
						<?php endif;?>
					<?php endwhile;
				closedir( $handle );
				endif;?>
			</select>
		</p>
		<p>
			<?php $advanced_id = 'column_advanced_' . $this->get_field_id( 'columns' );?>
			<input type="button" onclick="jQuery('#<?php echo $advanced_id; ?>').toggle();" value="<?php _e( 'show/hide advanced options', 'tcp' );?>" class="button-secondary" />
		</p>
	</div>
	<div id="<?php echo $advanced_id; ?>" style="display:none;">
		<p>
			<label for="<?php echo $this->get_field_id( 'columns' ); ?>"><?php _e( 'N<sup>o</sup> columns', 'tcp' ); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'columns' ); ?>" name="<?php echo $this->get_field_name( 'columns' ); ?>" type="text" value="<?php echo $instance['columns']; ?>" size="3" />
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'see_title' ); ?>" name="<?php echo $this->get_field_name( 'see_title' ); ?>" value="yes" <?php checked( $see_title ); ?> />
			<label for="<?php echo $this->get_field_id( 'see_title' ); ?>"><?php _e( 'Show title', 'tcp' ); ?></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'title_tag' ); ?>"><?php _e( 'Title tag', 'tcp' ); ?></label>
			<select id="<?php echo $this->get_field_id( 'title_tag' ); ?>" name="<?php echo $this->get_field_name( 'title_tag' ); ?>">
				<option value="" <?php selected( $title_tag, '' ); ?>><?php _e( 'No tag', 'tcp' );?></option>
				<option value="h2" <?php selected( $title_tag, 'h2' ); ?>>h2</option>
				<option value="h3" <?php selected( $title_tag, 'h3' ); ?>>h3</option>
				<option value="h4" <?php selected( $title_tag, 'h4' ); ?>>h4</option>
				<option value="h5" <?php selected( $title_tag, 'h5' ); ?>>h5</option>
				<option value="h6" <?php selected( $title_tag, 'h6' ); ?>>h6</option>
				<option value="p" <?php selected( $title_tag, 'p' ); ?>>p</option>
				<option value="div" <?php selected( $title_tag, 'div' ); ?>>div</option>
				<option value="span" <?php selected( $title_tag, 'span' ); ?>>span</option>
			</select>
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'see_image' ); ?>" name="<?php echo $this->get_field_name( 'see_image' ); ?>" value="yes" <?php checked( $see_image ); ?> />
			<label for="<?php echo $this->get_field_id( 'see_image' ); ?>"><?php _e( 'Show image', 'tcp' ); ?></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'image_size' ); ?>"><?php _e( 'Image size', 'tcp' ); ?></label>
			<select id="<?php echo $this->get_field_id( 'image_size' ); ?>" name="<?php echo $this->get_field_name( 'image_size' ); ?>">
			<?php $imageSizes = get_intermediate_image_sizes();
			foreach( $imageSizes as $size ) : ?>
				<option value="<?php echo $size;?>" <?php selected( $size, $image_size );?>><?php echo $size;?></option>
			<?php endforeach;?>
			</select>
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'see_content' ); ?>" name="<?php echo $this->get_field_name( 'see_content' ); ?>" value="yes" <?php checked( $see_content ); ?> />
			<label for="<?php echo $this->get_field_id( 'see_content' ); ?>"><?php _e( 'Show content', 'tcp' ); ?></label>
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'see_excerpt' ); ?>" name="<?php echo $this->get_field_name( 'see_excerpt' ); ?>" value="yes" <?php checked( $see_excerpt ); ?> />
			<label for="<?php echo $this->get_field_id( 'see_excerpt' ); ?>"><?php _e( 'Show excerpt', 'tcp' ); ?></label>
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'see_author' ); ?>" name="<?php echo $this->get_field_name( 'see_author' ); ?>" value="yes" <?php checked( $see_author ); ?> />
			<label for="<?php echo $this->get_field_id( 'see_author' ); ?>"><?php _e( 'Show author', 'tcp' ); ?></label>
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'see_meta_data' ); ?>" name="<?php echo $this->get_field_name( 'see_meta_data' ); ?>" value="yes" <?php checked( $see_meta_data ); ?> />
			<label for="<?php echo $this->get_field_id( 'see_meta_data' ); ?>"><?php _e( 'Show tags', 'tcp' ); ?></label>
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'see_price' ); ?>" name="<?php echo $this->get_field_name( 'see_price' ); ?>" value="yes" <?php checked( $see_price ); ?> />
			<label for="<?php echo $this->get_field_id( 'see_price' ); ?>"><?php _e( 'Show price', 'tcp' ); ?></label>
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'see_buy_button' ); ?>" name="<?php echo $this->get_field_name( 'see_buy_button' ); ?>" value="yes" <?php checked( $see_buy_button ); ?> />
			<label for="<?php echo $this->get_field_id( 'see_buy_button' ); ?>"><?php _e( 'Show buy button', 'tcp' ); ?></label>
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'see_meta_utilities' ); ?>" name="<?php echo $this->get_field_name( 'see_meta_utilities' ); ?>" value="yes" <?php checked( $see_meta_utilities ); ?> />
			<label for="<?php echo $this->get_field_id( 'see_meta_utilities' ); ?>"><?php _e( 'Show utilities', 'tcp' ); ?></label>
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'see_first_custom_area' ); ?>" name="<?php echo $this->get_field_name( 'see_first_custom_area' ); ?>" value="yes" <?php checked( $see_first_custom_area ); ?> />
			<label for="<?php echo $this->get_field_id( 'see_first_custom_area' ); ?>"><?php _e( 'Show first custom area', 'tcp' ); ?></label>
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'see_second_custom_area' ); ?>" name="<?php echo $this->get_field_name( 'see_second_custom_area' ); ?>" value="yes" <?php checked( $see_second_custom_area ); ?> />
			<label for="<?php echo $this->get_field_id( 'see_second_custom_area' ); ?>"><?php _e( 'Show second custom area', 'tcp' ); ?></label>
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'see_third_custom_area' ); ?>" name="<?php echo $this->get_field_name( 'see_third_custom_area' ); ?>" value="yes" <?php checked( $see_third_custom_area ); ?> />
			<label for="<?php echo $this->get_field_id( 'see_third_custom_area' ); ?>"><?php _e( 'Show third custom area', 'tcp' ); ?></label>
		</p><?php
	}
}
?>
