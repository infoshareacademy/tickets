<?php

namespace Tickets\Controllers;


use Tickets\Bridges\AllegroBridge;
use Tickets\Presenters\JsonPresenter;

class TicketsController
{
    private $allegroBridge;
    private $JsonPresenter;

    public function __construct($allegroBridge = null, $JsonPresenter = null)
    {
        if ($allegroBridge) {
            $this->allegroBridge = $allegroBridge;
        } else {
            $this->allegroBridge = new AllegroBridge();
        }

        if ($JsonPresenter) {
            $this->JsonPresenter = $JsonPresenter;
        } else {
            $this->JsonPresenter = new JsonPresenter();
        }
    }


//    protected $tickets = array ();

    public function collectTickets()
    {
        // get concert tickets array
        $arr1 = $this->allegroBridge->getConcertTickets();
        // get sport tickets array
        $arr2 = $this->allegroBridge->getSportTickets();
        $result = array_merge((array)$arr1, (array)$arr2);


//        // convert tickets array to json
//        $this->JsonPresenter->presentTickets($result);

        // return json
        return $this->JsonPresenter->presentTickets($result);

    }

//$this-> = $ticketData['idClient'];


}


