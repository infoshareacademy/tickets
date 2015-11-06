<?php
/**
 * Created by PhpStorm.
 * User: fiona
 * Date: 06.11.15
 * Time: 14:00
 */

namespace Tickets\Bridges;


use Tickets\Connectors\AllegroConnector;
use Tickets\Models\Ticket;

class AllegroBridge
{
    private $rawAllegroTickets;
    private $tickets = [];
    private $connector;

    public function __construct ($connector = null){
        if ($connector) {
            $this->connector = $connector;
        } else {
            $this->connector = new AllegroConnector();
        }
    }

    public function getSportTickets(){
        $query = 'getSportTickets';
        $this->rawAllegroTickets = $this->createRawAllegroTickets($query);
        if (isset($this->rawAllegroTickets['error']) === true && empty($this->rawAllegroTickets['error']) === false ) {
            return $this->tickets['error'] = 1;
        } else {
            return $this->transformToTicketObjects($this->rawAllegroTickets);
        }
    }

    public function getConcertTickets(){
        $query = 'getConcertTickets';
        $this->rawAllegroTickets = $this->createRawAllegroTickets($query);
        if (isset($this->rawAllegroTickets['error']) === true && empty($this->rawAllegroTickets['error']) === false ) {
            return $this->tickets['error'] = 1;
        } else {
            return $this->transformToTicketObjects($this->rawAllegroTickets);
        }
    }

    private function createRawAllegroTickets($params, $connector = null)
    {
        return  $this->connector->getItems($params);
    }

    private function transformToTicketObjects ($rawAllegroTicketsArr) {
        foreach ($rawAllegroTicketsArr as $rawTicket) {
            $ticket =  new Ticket();
            $ticket->title = $rawTicket['ticketTitle'];
            $ticket->auctionUrl = $rawTicket['ticketAuctionUrl'];
            $ticket->description = $rawTicket['ticketDescription'];
            $ticket->price = $rawTicket['ticketPrice'];
            $this ->tickets[] = $ticket;
        }
        return $this->tickets;
    }


}