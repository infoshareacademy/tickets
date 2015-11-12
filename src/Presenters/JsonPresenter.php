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
        $result = json_encode($tickets);

        return $result;
    }
}