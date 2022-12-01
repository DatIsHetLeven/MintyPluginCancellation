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
// Register New Order Statuses
function wpex_wc_register_post_statuses() {
	register_post_status( 'wc-custom-order-status', array(
		'label'						=> _x( 'Custom Order Status Name', 'WooCommerce Order status', 'text_domain' ),
		'public'					=> true,
		'exclude_from_search'		=> false,
		'show_in_admin_all_list'	=> true,
		'show_in_admin_status_list'	=> true,
		'label_count'				=> _n_noop( 'Approved (%s)', 'Approved (%s)', 'text_domain' )
	) );
}
add_filter( 'init', 'wpex_wc_register_post_statuses' );

// Add New Order Statuses to WooCommerce
function wpex_wc_add_order_statuses( $order_statuses ) {
	$order_statuses['wc-custom-order-status'] = _x( 'Custom Order Status Name', 'WooCommerce Order status', 'text_domain' );
	return $order_statuses;
}
add_filter( 'wc_order_statuses', 'wpex_wc_add_order_statuses' );

//TODO: de status moet alleen gelden voor half geanullerde bestellingen
add_action('woocommerce_order_status_changed', 'checkOrderStatus');

function checkOrderStatus(){

}



