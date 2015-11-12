<?php
/**
 * Created by PhpStorm.
 * User: fiona
 * Date: 06.11.15
 * Time: 14:03
 */

namespace Tickets\Presenters;


use Exception;
use Tickets\Models\Ticket;

class JsonPresenter
{
    public function presentTickets(array $tickets){
        $result = array();

        foreach ($tickets as $ticket) {
            $item = json_encode($ticket);
            $result[] = $item;
        }

        return $result;
    }
}