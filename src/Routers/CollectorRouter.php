<?php
/**
 * Created by PhpStorm.
 * User: fiona
 * Date: 06.11.15
 * Time: 13:58
 */

namespace Tickets\Routers;

use Tickets\Controllers\TicketsController;

class CollectorRouter
{
    public function getTickets(){
        $call = new TicketsController();
        $tickets = $call->collectTickets();

        return $tickets;
    }
}