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

    public function getSportTickers(){
        $query = 'getSportTickets';
        $this->rawAllegroTickets = $this->createRawAllegroTickets($query);
        return $this->transformToTicketObjects($this->rawAllegroTickets);
    }

    public function getConcertTickers(){
        $query = 'getConcertTickets';
        $this->rawAllegroTickets = $this->createRawAllegroTickets($query);
        return $this->transformToTicketObjects($this->rawAllegroTickets);
    }

    private function createRawAllegroTickets($params){
        $allegroConnect =  new AllegroConnector();
        return $allegroConnect->call('GET', $params);
    }

    private function transformToTicketObjects ($rawAllegroTickets) {
        foreach ($rawAllegroTickets as $rawTicket) {
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