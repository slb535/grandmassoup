<?php
require_once( TCP_DAOS_FOLDER . 'Orders.class.php' );
require_once( TCP_DAOS_FOLDER . 'OrdersDetails.class.php' );
require_once( TCP_DAOS_FOLDER . 'OrdersCosts.class.php' );

require_once( TCP_CLASSES_FOLDER . 'OrderPage.class.php' );

class AddressesListTable extends WP_List_Table {

	private $admin_path = false;
	
	function __construct() {
		parent::__construct( array(
			'plural' => 'Addresses',
		) );
		if ( is_admin() ) $this->admin_path = TCP_ADMIN_PATH . 'AddressEdit.php';
		else $this->admin_path = get_permalink( get_option( 'tcp_address_edit_page_id' ) );
	}

	function ajax_user_can() {
		return false;
	}

	function no_items() {
		_e( 'No Addresses found.', 'tcp' );
	}

	function prepare_items() {
		if ( ! is_user_logged_in() ) return;
		$type = isset( $_REQUEST['type'] ) ? $_REQUEST['type'] : '';
		$search_by = isset( $_REQUEST['search_by'] ) ? $_REQUEST['search_by'] : '';
		$per_page = apply_filters( 'tcp_addresses_per_page', 15 );
		$paged = $this->get_pagenum();
		if ( current_user_can( 'tcp_edit_addresses' ) ) {
			//$search_by //TODO
			if ( $type == 'billing') $this->items = Addresses::getCustomerDefaultBillingAddresses();
			elseif ( $type == 'shipping') $this->items = Addresses::getCustomerDefaultShippingAddresses();
			else $this->items = Addresses::getCustomerAddresses();
		} else {
			global $current_user;
			get_currentuserinfo();
			//$search_by //TODO
			if ( $type == 'billing') $this->items = Addresses::getCustomerDefaultBillingAddresses( $current_user->ID );
			elseif ( $type == 'shipping') $this->items = Addresses::getCustomerDefaultShippingAddresses( $current_user->ID );
			else $this->items = Addresses::getCustomerAddresses( $current_user->ID );
		}
		$total_items = count( $this->items );
		$total_pages = $total_items / $per_page;
		if ( $total_pages > (int)$total_pages ) {
			$total_pages = (int)$total_pages;
			$total_pages++;
		}
		$this->set_pagination_args( array(
			'total_items'	=> $total_items,
			'per_page'		=> $per_page,
			'total_pages'	=> $total_pages,
		) );
	}

	function get_table_classes() {
		return array( 'widefat', 'fixed', 'pages', 'tcp_orders'  );
	}

	function get_column_info() {
		$columns = array();
		//$orders_columns['cb'] = '<input type="checkbox" />';
		$columns['adress_name'] = _x( 'Address', 'column name', 'tcp' );
		$columns['name'] = _x( 'Name', 'column name', 'tcp' );
		$columns['street'] = _x( 'Street', 'column name', 'tcp' );
		$columns['default_billing'] = _x( 'Default', 'column name', 'tcp' );
		$columns = apply_filters( 'tcp_manage_addresses_columns', $columns );
		return array( $columns, array(), array() );
	}

	function column_cb( $item ) {
		?><input type="checkbox" name="address[]" value="<?php echo $item->address_id; ?>" /><?php
	}

	function column_adress_name( $item ) {
		echo $item->address_id, ' ', $item->name; ?>
		<div><a href="<?php echo add_query_arg( 'address_id', $item->address_id, $this->admin_path ); ?>"><?php _e( 'edit', 'tcp' ); ?></a> | <a href="#" onclick="jQuery('.delete_address').hide();jQuery('#delete_<?php echo $item->address_id; ?>').show();return false;" class="delete"><?php _e( 'delete', 'tcp' ); ?></a></div>
		<div id="delete_<?php echo $item->address_id; ?>" class="delete_address" style="display:none; border: 1px dotted orange; padding: 2px">
			<form method="post" name="frm_delete_<?php echo $item->address_id; ?>">
			<input type="hidden" name="address_id" value="<?php echo $item->address_id; ?>" />
			<input type="hidden" name="tcp_delete_address" value="y" />
			<p><?php _e( 'Do you really want to delete this address?', 'tcp' ); ?></p>
			<a href="javascript:document.frm_delete_<?php echo $item->address_id; ?>.submit();" class="delete"><?php _e( 'Yes' , 'tcp' ); ?></a> |
			<a href="#" onclick="jQuery('#delete_<?php echo $item->address_id; ?>').hide();return false;"><?php _e( 'No, I don\'t' , 'tcp' ); ?></a>
			</form>
		</div><?php
	}

	function column_name( $item ) {
		echo $item->firstname, ' ', $item->lastname;
	}

	function column_street( $item ) {
		echo $item->street . ' ' . $item->city . '<br/>' . $item->region . ' '. $item->postcode ;
	}
	
	function column_default_billing( $item ) {
		$add_separator = false;
		if ( $item->default_billing ) {
			_e( 'Billing', 'tcp' );
			$add_separator = true;
		}
		if ( $item->default_shipping ) echo ( $add_separator ? ' | ' : '' ) . __( 'Shipping', 'tcp' );
	}

	function column_default( $item, $column_name ) {
		$out = isset( $item->$column_name ) ?  strip_tags( $item->$column_name ) : '???';
		$out = apply_filters( 'tcp_address_list_columns', $out, $item, $column_name );
		echo $out;
	}
	
	function extra_tablenav( $which ) {
		if ( 'top' != $which ) return;
		$type = isset( $_REQUEST['type'] ) ? $_REQUEST['type'] : ''; ?>
		<label for="type"><?php _e( 'Type', 'tcp' );?>:</label>
		<select class="postform" id="type" name="type">
			<option value="" <?php selected( '', $type );?>><?php _e( 'all', 'tcp' );?></option>
			<option value="billing" <?php selected( 'billing', $type );?>><?php _e( 'Billing', 'tcp' ); ?></option>
			<option value="shipping" <?php selected( 'shipping', $type );?>><?php _e( 'Shipping', 'tcp' ); ?></option>
		</select>
		<?php $search_by = isset( $_REQUEST['search_by'] ) ? $_REQUEST['search_by'] : ''; ?>
		<!--<label><?php _e( 'Search by', 'tcp' ); ?>:<input type="text" name="search_by" value="<?php echo $search_by; ?>"/></label>-->
		<?php do_action( 'tcp_restrict_manage_addresses' );
		submit_button( __( 'Filter' ), 'secondary', false, false, array( 'id' => 'address-query-submit' ) );
	}

	private function get_inline_data( $order_id ) { ?>
		<div class="hidden" id="inline_<?php echo $order_id; ?>">
		<?php $out = OrderPage::show( $order_id );
		echo apply_filters( 'tcp_orders_list_get_inline_data', $out, $order_id ); ?>
		</div><?php
 	}
}

class TCPAddressesList {
	function show( $echo = true ) {
		$admin_path = TCP_ADMIN_PATH . 'AddressEdit.php';
		ob_start();
		$listTable = new AddressesListTable();
		$listTable->prepare_items(); ?>
<form id="posts-filter" method="get" action="">
<input type="hidden" name="page" value="<?php echo isset( $_REQUEST['page'] ) ? $_REQUEST['page'] : 0; ?>" />
<div class="wrap">
	<h2><?php _e( 'Addresses', 'tcp' );?></h2>
	<p><a href="<?php echo $admin_path; ?>"><?php _e( 'Create new address', 'tcp' ); ?></a></p>
	<div class="clear"></div>
	<?php //$listTable->search_box( __( 'Search Orders', 'tcp' ), 'order' ); ?>
	<?php $listTable->display(); ?>
</div>
</form>
		<?php $out = ob_get_clean();
		if ( $echo ) echo $out;
		return $out;
	}
}
?>
