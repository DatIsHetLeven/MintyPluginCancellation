<?php

namespace MintyMedia\Cancellation\Controller;



class StatusController
{
    public function init()
    {
        add_action('init', [$this, 'register_wait_call_order_status']);
        add_filter('wc_order_statuses', [$this, 'add_wait_call_to_order_statuses']);
        add_filter('wc_order_statuses', [$this, 'QuadLayers_rename_status']);
    }


// Register new status
    public function register_wait_call_order_status()
    {
        register_post_status('wc-waiting-call', array(
            'label' => 'Deels geannuleerd',
            'public' => true,
            'show_in_admin_status_list' => true,
            'show_in_admin_all_list' => true,
            'exclude_from_search' => false,
            'label_count' => _n_noop('Deels geannuleerd (%s)', 'Deels geannuleerd (%s)')
        ));
    }

// Add custom status to order status list
    public function add_wait_call_to_order_statuses($order_statuses)
    {
        $new_order_statuses = array();
        foreach ($order_statuses as $key => $status) {
            $new_order_statuses[$key] = $status;
            if ('wc-on-hold' === $key) {
                $new_order_statuses['wc-waiting-call'] = 'Deels geannuleerd';
            }
        }
        return $new_order_statuses;
    }


    public function QuadLayers_rename_status($order_statuses)
    {
        foreach ($order_statuses as $key => $status) {
            if ('wc-processing' === $key) {
                $order_statuses['wc-processing'] = _x('In progress', 'Order status', 'woocommerce');
            }
            if ('wc-completed' === $key) {
                $order_statuses['wc-completed'] = _x('Delivered', 'Order status', 'woocommerce');
            }
        }
        return $order_statuses;
    }


//......................................................................................................................
}