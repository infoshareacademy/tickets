<?php
/**
 * Created by PhpStorm.
 * User: fiona
 * Date: 06.11.15
 * Time: 13:58
 */

namespace Tickets\Routers;

use Symfony\Component\HttpFoundation\Response;
use Tickets\Controllers\TicketsController;

class CollectorRouter
{
    public function getTickets(){
        try {
            $call = new TicketsController();
            $tickets = $call->collectTickets();

            return new Response($tickets);
        } catch (\Exception $e) {

        }
    }
}