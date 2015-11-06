<?php

namespace Tickets\Controllers;


use Tickets\Bridges\AllegroBridge;

class TicketsController
{
    private $allegroBridge;

    public function __construct($allegroBridge = null)
    {
        if($allegroBridge) {
            $this->allegroBridge = $allegroBridge;
        } else {
            $this->allegroBridge = new AllegroBridge();
        }
    }

//    protected $tickets = array[];

public function collectTickets(){
    $this->allegroBridge->getConcertTickers();

}

//$this-> = $ticketData['idClient'];




}


