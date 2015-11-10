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
        $result = [];

        // get concert tickets array
        $result[] = $this->allegroBridge->getConcertTickets();
        // get sport tickets array
        $result[] = $this->allegroBridge->getSportTickets();

        // convert tickets array to json
        $this->JsonPresenter->presentTickets($result);

        // return json
        return true;

    }

//$this-> = $ticketData['idClient'];


}


