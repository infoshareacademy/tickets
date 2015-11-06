<?php
/**
 * Created by PhpStorm.
 * User: fiona
 * Date: 06.11.15
 * Time: 14:00
 */

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
        $tickets = '';

        $this->allegroBridge->getConcertTickets();
        $this->allegroBridge->getSportTickets();
        $this->JsonPresenter->presentTickets($tickets);

    }

//$this-> = $ticketData['idClient'];


}


