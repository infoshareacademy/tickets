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
        $query = 'sport';
        $this->rawAllegroTickets = $this->createRawAllegroTickets($query);
        if (isset($this->rawAllegroTickets['error']) === true && empty($this->rawAllegroTickets['error']) === false ) {
            return $this->tickets = ['error' => 1];
        } else if (empty($this->rawAllegroTickets) === true ) {
            return null;
        } else {
            return $this->transformToTicketObjects($this->rawAllegroTickets, $query);
        }
    }

    public function getConcertTickets(){
        $query = 'music';
        $this->rawAllegroTickets = $this->createRawAllegroTickets($query);
        if (isset($this->rawAllegroTickets['error']) === true && empty($this->rawAllegroTickets['error']) === false ) {
            return $this->tickets = ['error' => 1];
        } else if (empty($this->rawAllegroTickets) === true ) {
            return null;
        } else {
            return $this->transformToTicketObjects($this->rawAllegroTickets, $query);
        }
    }

    private function createRawAllegroTickets($params, $connector = null)
    {
            try {
                return $this->connector->getItems($params);
            } catch (\Exception $e){
                throw new \ErrorException ($e->getMessage());
            }
    }

    private function transformToTicketObjects ($rawAllegroTicketsArr, $type = '') {
        $rawAllegroTicketsArr = json_decode(json_encode($rawAllegroTicketsArr),true);
        foreach ($rawAllegroTicketsArr as $rawTicket) {
            $ticket =  new Ticket();
            $ticket->title = $rawTicket['itemInfo']['itName'];
            $ticket->auctionUrl = 'http://allegro.pl/show_item.php?item=' .$rawTicket['itemInfo']['itId'];
            $ticket->description = $rawTicket['itemInfo']['itDescription'];
            //
            $itBuyNow = $rawTicket['itemInfo']['itBuyNowActive'];
            $itBuyNow ? $priceBuyNow = $rawTicket['itemInfo']['itBuyNowPrice'] : $priceBuyNow = null;
            if($priceBuyNow) {
                $ticket->price = $rawTicket['itemInfo']['itPrice'] . ' ('. $priceBuyNow.')';
            }
            else {
                $ticket->price = $rawTicket['itemInfo']['itPrice'];
            }
            $ticket->type = $type;
            $this ->tickets[] = $ticket;
        }

        return $this->tickets;
    }

}

