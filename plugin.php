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



//TODO: MAAKT GEBRUIK VAN CLASSES - MENEER DE HBO STUDENT neeeee ik protesteer was joke ik doe kader
// TODO: MAAK GEBRUIK VAN COMPOSER AUTOLOAD

//TODO ; een nieuwe order status aanmaken
//TODO ; een nieuwe order status aanmaken
//TODO: de status moet alleen gelden voor half geanullerde bestellingen
//TODO: woocommerce raporten goed zetten
// TODO: Aangeven in de achterkant welke producten geanuleerd zijn.

//TODO ; een nieuwe order status aanmaken -> naam : Gedeeltelijk geretourneerd'


require_once "vendor/autoload.php";

(new MintyMedia\Cancellation\CancellationBase());


//
//
////......................................................................................................................
//
//// Register new status
//function register_wait_call_order_status() {
//	register_post_status( 'wc-waiting-call', array(
//		'label'                     => 'Deels geannuleerd',
//		'public'                    => true,
//		'show_in_admin_status_list' => true,
//		'show_in_admin_all_list'    => true,
//		'exclude_from_search'       => false,
//		'label_count'               => _n_noop( 'Deels geannuleerd (%s)', 'Deels geannuleerd (%s)' )
//	) );
//}
//// Add custom status to order status list
//function add_wait_call_to_order_statuses( $order_statuses ) {
//	$new_order_statuses = array();
//	foreach ( $order_statuses as $key => $status ) {
//		$new_order_statuses[ $key ] = $status;
//		if ( 'wc-on-hold' === $key ) {
//			$new_order_statuses['wc-waiting-call'] = 'Deels geannuleerd';
//		}
//	}
//	return $new_order_statuses;
//}
//add_action( 'init', 'register_wait_call_order_status' );
//add_filter( 'wc_order_statuses', 'add_wait_call_to_order_statuses' );
//
//function QuadLayers_rename_status( $order_statuses ) {
//	foreach ( $order_statuses as $key => $status ) {
//		if ( 'wc-processing' === $key ) {
//			$order_statuses['wc-processing'] = _x( 'In progress', 'Order status', 'woocommerce' );
//		}
//		if ( 'wc-completed' === $key ) {
//			$order_statuses['wc-completed'] = _x( 'Delivered', 'Order status', 'woocommerce' );
//		}
//	}
//	return $order_statuses;
//}
//add_filter( 'wc_order_statuses', 'QuadLayers_rename_status' );
//
////......................................................................................................................
//
//
//
//
//
////Als bestelling op geannuleerd gezet wordt -> check of het gedeeltijk geannuleerd is
//add_action( 'woocommerce_process_shop_order_meta', 'check_cancellation_order', 1000000, 2 );
//
//function check_cancellation_order( $order_id, $order ){
//
//	$HeleBestelling = new WC_Order( $order_id );
//
//	//Haal nieuwe status op
//	$newOrderStatus = $_POST["order_status"];
//	//Check of nieuwe stts op geannuleerd staat.
//	if ($newOrderStatus == 'wc-cancelled'){
//		//Haal aantal items uit de bestelling op +  aantal teruggestuurde items.
//		$aantalRefundItems = $HeleBestelling->get_item_count_refunded();
//		$aantalItems = $HeleBestelling->get_item_count();
//	}
//	//if true -> status : Deels geannuleerd
//
//	if ($aantalRefundItems != $aantalItems){
//
//		$totaalBestelling = $HeleBestelling->get_total();
//		$terugbetaald = $HeleBestelling->get_total_refunded();
//		$nettoBetaling = $totaalBestelling - $terugbetaald;
//
//
//		$HeleBestelling->set_total($nettoBetaling);
//		$HeleBestelling->save();
//
//		$HeleBestelling->update_status('wc-waiting-call');
//
//        get_product_net_revenue($HeleBestelling->get_id());
//	}
//}
//
////......................................................................................................................
//
//add_filter( 'woocommerce_reports_order_statuses', 'fc_order_status_reports', 20, 1);
//function fc_order_status_reports( $statuses ) {
//	$statuses[] = 'waiting-call';
//
//	return $statuses;
//}
//
////......................................................................................................................
////add_filter( 'init', 'get_product_net_revenue', 20, 1);
//function get_product_net_revenue($orderId )
//{
//    global $wpdb;
//    $order = new WC_Order( $orderId );
//
////Haal order_id op dmv parent_id (bij deels geannuleerde bestellingen)
//    $order_id = ((float)$wpdb->get_var($wpdb->prepare("
//        SELECT SUM(order_id)
//        FROM {$wpdb->prefix}wc_order_stats
//        WHERE parent_id = %d
//    ", $orderId)));
//
////Haal productid op dmv order_id
//$product_id = ( (float) $wpdb->get_var( $wpdb->prepare("
//        SELECT SUM(product_id)
//        FROM {$wpdb->prefix}wc_order_product_lookup
//        WHERE order_id = %d
//    ",$order_id ) ));
//
//
////Haal qty teruggestuurde items op
//$qty = ( (float) $wpdb->get_var( $wpdb->prepare("
//        SELECT SUM(product_qty)
//        FROM {$wpdb->prefix}wc_order_product_lookup
//        WHERE order_id = %d
//    ",$order_id ) ));
//
//
//    foreach ( $order->get_items() as $item_id => $item ) {
//        if($item->get_product_id() == $product_id){
//
//            $item->update_meta_data('ProductId', $product_id);
//            $item->update_meta_data('QtyRefunded', $qty);
//            $item->save();
//            exit();
//        }
//    }
//
//
//var_dump($product_id. "....." .  $qty);
//dump($order);
//dd();
//}
//
//
//
//
//
//
//
//
//
//
//
////......................................................................................................................
//
//
//
