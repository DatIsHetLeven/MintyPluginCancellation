<?php

namespace MintyMedia\Cancellation\Controller;



class RapportController
{
    public function init()
    {

        add_filter( 'woocommerce_reports_order_statuses', [$this, 'fc_order_status_reports'], 20, 1);
    }



    function fc_order_status_reports( $statuses ) {

        return array( 'processing', 'in-progress', 'completed', 'on-hold','waiting-call');
//        dd($statuses);
//        return $statuses;
    }
}