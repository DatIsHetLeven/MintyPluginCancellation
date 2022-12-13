<?php

namespace mintymedia\Cancellation;


use MintyMedia\BolConnector\Core\Controllers\Controller;
use MintyMedia\Cancellation\Controller\OrderController;
use MintyMedia\Cancellation\Controller\RapportController;
use MintyMedia\Cancellation\Controller\StatusController;

class CancellationBase
{

    /** @var Controller[] $migration */
    private array $controllers = [
        StatusController::class,
        OrderController::class,
//        RapportController::class,
    ];

    public function __construct () {
        $StatusController = new StatusController();
        foreach ( $this->controllers as $controller ) {
//            if ( !class_exists( $controller ) ) {
            (new $controller($StatusController))->init();
//            } else {
//                echo 'not running';
//            }
        }
    }
}
