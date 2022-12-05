<?php
/*
Plugin Name:  WPBeginner Plugin Tutorial
Plugin URI:   https://www.wpbeginner.com
Description:  A short little description of the plugin. It will be displayed on the Plugins page in WordPress admin area.
Version:      1.0
Author:       WPBeginner
Author URI:   https://www.wpbeginner.com
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  wpb-tutorial
Domain Path:  /languages
*/


//add_action();


//TODO: MAAKT GEBRUIK VAN CLASSES - MENEER DE HBO STUDENT neeeee ik protesteer was joke ik doe kader
// TODO: MAAK GEBRUIK VAN COMPOSER AUTOLOAD

//TODO ; een nieuwe order status aanmaken
//TODO: de status moet alleen gelden voor half geanullerde bestellingen
//TODO: woocommerce raporten goed zetten
// TODO: Aangeven in de achterkant welke producten geanuleerd zijn.

//TODO ; een nieuwe order status aanmaken -> naam : Gedeeltelijk geretourneerd'


// Register new status
function register_wait_call_order_status() {
	register_post_status( 'wc-waiting-call', array(
		'label'                     => 'Waiting call',
		'public'                    => true,
		'show_in_admin_status_list' => true,
		'show_in_admin_all_list'    => true,
		'exclude_from_search'       => false,
		'label_count'               => _n_noop( 'Waiting call (%s)', 'Waiting call (%s)' )
	) );
}
// Add custom status to order status list
function add_wait_call_to_order_statuses( $order_statuses ) {
	$new_order_statuses = array();
	foreach ( $order_statuses as $key => $status ) {
		$new_order_statuses[ $key ] = $status;
		if ( 'wc-on-hold' === $key ) {
			$new_order_statuses['wc-waiting-call'] = 'Deels geannuleerd';
		}
	}
	return $new_order_statuses;
}
add_action( 'init', 'register_wait_call_order_status' );
add_filter( 'wc_order_statuses', 'add_wait_call_to_order_statuses' );

function QuadLayers_rename_status( $order_statuses ) {
	foreach ( $order_statuses as $key => $status ) {
		if ( 'wc-processing' === $key ) {
			$order_statuses['wc-processing'] = _x( 'In progress', 'Order status', 'woocommerce' );
		}
		if ( 'wc-completed' === $key ) {
			$order_statuses['wc-completed'] = _x( 'Delivered', 'Order status', 'woocommerce' );
		}
	}
	return $order_statuses;
}
add_filter( 'wc_order_statuses', 'QuadLayers_rename_status' );









add_action( 'wc-waiting-call', 'wpdesk_set_completed_for_paid_orders' );

function wpdesk_set_completed_for_paid_orders( $order_id ) {
dd("testetstest");
	$order = wc_get_order( $order_id );
	echo "<h1> testttddddddddddddt</h1>";
	dump($order);

}

add_action('init',function(){
	$order = new WC_Order(23);

//Als de order op geannuleerd staat
	if ($order->get_status() == 'cancelled'){
		$order = wc_get_order( 23 );
		$order_refunds = $order->get_refunds();
		// Loop through the order refunds array
		foreach( $order_refunds as $refund ){
			// Loop through the order refund line items
			foreach( $refund->get_items() as $item_id => $item ){

				## --- Using WC_Order_Item_Product methods --- ##

				$refunded_quantity      = $item->get_quantity(); // Quantity: zero or negative integer
				$refunded_line_subtotal = $item->get_subtotal(); // line subtotal: zero or negative number
				$ordernaam = $item->get_name();
				dump($ordernaam);
				dump($item);
				dump($refunded_quantity);
				dump($refunded_line_subtotal);
				// ... And so on ...

				// Get the original refunded item ID
				$refunded_item_id       = $item->get_meta('_refunded_item_id'); // line subtotal: zero or negative number

				$order->update_status('wc-waiting-call');
			}
		}



		//Check of alle items gean. zijn
		//pas staus aan naar 'deels-gan. if yes'
	}

	if ($order->get_status() == 'waiting-call'){
		echo "<h1>dddhdhjgdjhgdhkdgdhgh</h1>";
	}
	else{
		echo "<h1>nenenenenenenenenenenenenenenne</h1>";
	}




//	$order->update_status('wc-waiting-call');
});

