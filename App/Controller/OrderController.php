<?php

namespace MintyMedia\Cancellation\Controller;



class OrderController
{
    public function init()
    {
        add_action( 'woocommerce_process_shop_order_meta', [$this, 'check_cancellation_order'], 10, 2);
    }



//Als bestelling op geannuleerd gezet wordt -> check of het gedeeltijk geannuleerd is
public function check_cancellation_order( $order_id, $order ){


	$HeleBestelling =  wc_get_order($order_id);



	//Haal nieuwe status op
	$newOrderStatus = $_POST["order_status"];
	//Check of nieuwe stts op geannuleerd staat.
	if ($newOrderStatus == 'wc-cancelled'){
		//Haal aantal items uit de bestelling op +  aantal teruggestuurde items.
		$aantalRefundItems = $HeleBestelling->get_item_count_refunded();
		$aantalItems = $HeleBestelling->get_item_count();
	}
	//if true -> status : Deels geannuleerd

	if ($aantalRefundItems != $aantalItems){

		$totaalBestelling = $HeleBestelling->get_total();
		$terugbetaald = $HeleBestelling->get_total_refunded();
		$nettoBetaling = $totaalBestelling - $terugbetaald;


		$HeleBestelling->set_total($nettoBetaling);
		$HeleBestelling->save();

		$HeleBestelling->update_status('wc-waiting-call');
        $this->get_product_net_revenue($HeleBestelling->get_id());
	}
}

//Haal de geretourneerde items op
public function get_product_net_revenue($orderId )
{
    global $wpdb;

    $order = wc_get_order( $orderId );

//Haal order_id op dmv parent_id (bij deels geannuleerde bestellingen)
    $order_id = ((float)$wpdb->get_var($wpdb->prepare("
        SELECT SUM(order_id)
        FROM {$wpdb->prefix}wc_order_stats
        WHERE parent_id = %d
    ", $orderId)));

    //CONTROLEREN OF NUM_ITEMS_SOLD = -1 AMDERS LOOPEN DOOR MEERDERE ITEMS!
    //CONTROLEREN OF NUM_ITEMS_SOLD = -1 AMDERS LOOPEN DOOR MEERDERE ITEMS!
    //CONTROLEREN OF NUM_ITEMS_SOLD = -1 AMDERS LOOPEN DOOR MEERDERE ITEMS!
    //CONTROLEREN OF NUM_ITEMS_SOLD = -1 AMDERS LOOPEN DOOR MEERDERE ITEMS!

//Haal productid op dmv order_id
$product_id = ( (float) $wpdb->get_var( $wpdb->prepare("
        SELECT SUM(product_id)
        FROM {$wpdb->prefix}wc_order_product_lookup
        WHERE order_id = %d
    ",$order_id ) ));


//Haal qty teruggestuurde items op
$qty = ( (float) $wpdb->get_var( $wpdb->prepare("
        SELECT SUM(product_qty)
        FROM {$wpdb->prefix}wc_order_product_lookup
        WHERE order_id = %d
    ",$order_id ) ));


    foreach ( $order->get_items() as $item_id => $item ) {
        if($item->get_product_id() == $product_id){

            $item->update_meta_data('ProductId', $product_id);
            $item->update_meta_data('QtyRefunded', $qty);
            $item->save();

        }
    }

var_dump("productid : ".$product_id. "...Aantal : " .  $qty);
dump($order);
dd();
}




}