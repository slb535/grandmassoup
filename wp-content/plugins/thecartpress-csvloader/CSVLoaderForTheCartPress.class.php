<?php
/*
Plugin Name: TheCartPress CSV Loader
Plugin URI: http://extend.thecartpress.com/ecommerce-plugins/csv-loader/
Description: CSV loader for TheCartPress
Version: 1.2
Author: TheCartPress team
Author URI: http://thecartpress.com
License: GPL
parent: thecartpress
*/

/**
 * This file is part of TheCartPress-csvloader.
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

class CSVLoaderForTheCartPress {
	function __construct() {
		add_action( 'init', array( $this, 'init' ) );
		if ( is_admin() ) {
			add_action( 'admin_menu', array( $this, 'admin_menu' ), 99 );
		}
	}

	function init() {
		if ( function_exists( 'load_plugin_textdomain' ) )
			load_plugin_textdomain( 'tcp_csvl', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	function admin_menu() {
		$base = dirname( dirname( __FILE__ ) ) . '/thecartpress/admin/ShortCodeGenerator.php';
		add_submenu_page( $base, __( 'CSV Loader', 'tcp_csvl' ), __( 'CSV Loader', 'tcp_csvl' ), 'tcp_edit_product', dirname( __FILE__ ) . '/admin/CSVLoader.php' );
		//add_submenu_page( $base, __( 'Dyn CSV Loader', 'tcp_csvl' ), __( 'Dyn CSV Loader', 'tcp_csvl' ), 'tcp_edit_products', dirname( __FILE__ ) . '/admin/DynCSVLoader.php' );
	}
}

new CSVLoaderForTheCartPress();
?>
