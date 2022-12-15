<?php

namespace MintyMedia\Cancellation\Controller;



class OrderController
{
    public function init()
    {
        add_action('woocommerce_process_shop_order_meta', [$this, 'check_cancellation_order'], 10, 2);
    }


//Als bestelling op geannuleerd gezet wordt -> check of het gedeeltijk geannuleerd is
    public function check_cancellation_order($order_id, $order)
    {

        //Haal de gehele order op
        $HeleBestelling = wc_get_order($order_id);


        //Haal nieuwe status op
        $newOrderStatus = $_POST["order_status"];
        //Check of nieuwe stts op geannuleerd staat.
        if ($newOrderStatus == 'wc-cancelled') {
            //Haal aantal items uit de bestelling op +  aantal teruggestuurde items.
            $aantalRefundItems = $HeleBestelling->get_item_count_refunded();
            $aantalItems = $HeleBestelling->get_item_count();
        }
        //if true -> status : Deels geannuleerd
        if ($aantalRefundItems != $aantalItems) {



            //
//            $order_refunds = $HeleBestelling->get_refunds();
//            foreach( $order_refunds as $refund )
//            {
//                foreach ( $refund->get_items() as $item_id => $item )
//                {
//                    dump($item->get_total());
//                    dump($item);
//                    dump($item->set_total(0));
//                    dump($item);
//                    $item->save();
//
//                    dd($item->get_total());
//                }
//            }



            //Haal totaalbedrag op van teruggestuurde items
            $order_refunds = $HeleBestelling->get_refunds();
            $totalRefund = 0;
            foreach( $order_refunds as $refund )
            {
                foreach( $refund->get_items() as $item_id => $item )
                {
                    $refunded_line_subtotal = $item->get_subtotal(); // line subtotal: zero or negative number
                    $totalRefund = $totalRefund + ($refunded_line_subtotal);
                }
            }

            //Bereken de waarde van de gehele bestelling
            $totaalBedragBestelling = 0 ;
            foreach ( $HeleBestelling->get_items() as $item_id => $item )
            {
                $subtotal = $item->get_subtotal();
                $totaalBedragBestelling = $totaalBedragBestelling + $subtotal;
            }
            $newAmount = ($totaalBedragBestelling +($totalRefund));

            dump($totaalBedragBestelling);
            dump($HeleBestelling->get_total());
            dump($newAmount);
            dump($totalRefund);
//            dd();

            $HeleBestelling->set_total($newAmount);
            $HeleBestelling->save();


            $HeleBestelling->update_status('waiting-call');
            $this->get_product_net_revenue($HeleBestelling->get_id());


        }
    }

//Haal de geretourneerde items op
    public function get_product_net_revenue($orderId)
    {

        global $wpdb;
        $order = wc_get_order($orderId);

//Haal order_id op dmv parent_id (bij deels geannuleerde bestellingen)
        $order_id = ((float)$wpdb->get_var($wpdb->prepare("
        SELECT SUM(order_id)
        FROM {$wpdb->prefix}wc_order_stats
        WHERE parent_id = %d
    ", $orderId)));

        //Haal alle proudct gegevens op van de geretourneerde items!
        $sql = "SELECT * FROM `wp_wc_order_product_lookup` WHERE `order_id` = '$order_id'";
        $result = $wpdb->get_results($sql);

        $ArrayRefund = array();
        if (count($result) > 0)
        {
            for ($x = 0; $x < count($result); $x++)
            {
                $ArrayRefund[] = $result[$x]->product_id;
            }
            //dd($ArrayRefund);
            //Update meta data
            for ($x = 0; $x < count($result); $x++)
            {

                foreach ($order->get_items() as $item_id => $item)
                {
                    if (in_array($item->get_product_id(), $ArrayRefund))
                    {
                        $item->update_meta_data('ProductId', $result[$x]->product_id);

                        $item->update_meta_data('QtyRefunded', $result[$x]->product_qty);
                        $item->save();
                        $x++;

                    }
                }
            }
            dd();
        }
    }
}