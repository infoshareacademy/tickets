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
        foreach ($tickets as $singleTicket) {
            $this->checkIfCorrectFormat($singleTicket);
        }

        $result = json_encode($tickets);

        return $result;
    }

    private function checkIfCorrectFormat ($item) {
        if ($item instanceof Ticket) {
            return true;
        } else {
            throw new Exception('Sorry, invalid format of input. Please contact the Administrator');
        }
    }
}