<?php
/**
 * This file is part of TheCartPress.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

class TCPBuddyPress {

	function __construct() {
//		add_action( 'tcp_load_custom_post_types', array( &$this, 'tcp_load_custom_post_types' ), 10, 2 );
		add_filter( 'bp_blogs_record_post_post_types', array( &$this, 'bp_blogs_record_post_post_types' ) );
		add_filter( 'bp_blogs_record_comment_post_types', array( &$this, 'bp_blogs_record_post_post_types' ) );
	}

//	function tcp_load_custom_post_types( $post_type, $post_type_args ) {
//		add_filter( 'bp_blogs_record_post_post_types', function( $posts ) { $posts[] = $post_type; return $posts; } );
//	}
	
	function bp_blogs_record_post_post_types( $posts ) {
		$posts[] = 'tcp_product';
		return $posts;
	}
}

new TCPBuddyPress();
?>
