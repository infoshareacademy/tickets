<?php


namespace Tickets\Tests;


use Tickets\Models\Ticket;
use Tickets\Presenters\JsonPresenter;

class JsonPresenterTest extends \PHPUnit_Framework_TestCase
{
    public function testIfEmpty(){
        $instance = new JsonPresenter();

        $tickets = array();
        $result = $instance->presentTickets($tickets);

        $this->assertEquals('Sorry, there is no tickets matching your request', $result);
    }

    public function testIfWrongFormat(){
        $instance = new JsonPresenter();

        $tickets = 'someRandomTextNotMatchingThePattern';
        $result = $instance->presentTickets($tickets);

        $this->assertEquals('Sorry, something went wrong. Please try again or contact the Administrator', $result);

    }

    public function testIfOneTicket(){
        $instance = new JsonPresenter();

        $tickets = array();
        $ticket = new Ticket();
        $ticket->title = 'Title';
        $ticket->auctionUrl = 'http://fancyportalwithtickets.com';
        $ticket->description = 'A couple of words why this concert is such a Must Go';
        $ticket->price = '100PLN';
        $result = $instance->presentTickets($tickets);

        $this->assertEquals({
        "title" : "Title",
        "auctionUrl" : "http://fancyportalwithtickets.com",
        "description" : "A couple of words why this concert is such a Must Go",
        "price" : "100PLN"}, $result);

    }

    public function testIfManyTickets(){
        $instance = new JsonPresenter();

        $tickets =
        $result = $instance->presentTickets($tickets);

        $this->assertEquals('Sorry, there is no tickets matching your request', $result);

    }

    public function testIfWrongProperties(){
        $instance = new JsonPresenter();

        $tickets =
        $result = $instance->presentTickets($tickets);

        $this->assertEquals('Sorry, there is no tickets matching your request', $result);
    }

}
