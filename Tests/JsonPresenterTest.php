<?php

namespace Tickets\Presenters;

use Tickets\Models\Ticket;

class JsonPresenterTest extends \PHPUnit_Framework_TestCase
{
    public function test_shouldReturnEmptyJsonWhenEmptyArrayInInput()
    {
        $instance = new JsonPresenter();

        $tickets = array();
        $result = $instance->presentTickets($tickets);

        $this->assertEquals('[]', $result);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessageRegExp #format#
     */
    public function test_shouldThrowNewExceptionWhenWrongInput()
    {
        $instance = new JsonPresenter();

        $tickets = array('someRandomTextNotMatchingThePattern');
        $result = $instance->presentTickets($tickets);
    }

    public function test_shouldReturnArrayWithOneJsonWhenOneObjectInInput()
    {
        $instance = new JsonPresenter();

        $tickets = array();

        $oneTicket = new Ticket();
        $oneTicket->title = 'Title';
        $oneTicket->auctionUrl = 'http://fancyportalwithtickets.com';
        $oneTicket->description = 'A couple of words why this concert is such a Must Go';
        $oneTicket->price = '100PLN';
        $oneTicket->type = 'concert';

        $tickets[] = $oneTicket;

        $result = $instance->presentTickets($tickets);

        $this->assertEquals((
            '[{"title":"Title",' .
            '"auctionUrl":"http:\/\/fancyportalwithtickets.com",' .
            '"description":"A couple of words why this concert is such a Must Go",' .
            '"price":"100PLN","type":"concert"}]'
        ), $result);
    }


    public function test_shouldReturnArrayOfJsonsWhenManyObjectsInInput()
    {
        $instance = new JsonPresenter();

        $tickets = array();

        $oneTicket = new Ticket();
        $oneTicket->title = 'Title';
        $oneTicket->auctionUrl = 'http://fancyportalwithtickets.com';
        $oneTicket->description = 'A couple of words why this concert is such a Must Go';
        $oneTicket->price = '100PLN';
        $oneTicket->type = 'concert';

        $anotherTicket = new Ticket();
        $anotherTicket->title = 'different title';
        $anotherTicket->auctionUrl = 'http://ecommercewithtickets.com';
        $anotherTicket->description = 'Short text trying to convince us that this event is worth our monthly salary';
        $anotherTicket->price = '1200PLN';
        $oneTicket->type = 'sport';

        $tickets[] = $oneTicket;
        $tickets[] = $anotherTicket;

        $result = $instance->presentTickets($tickets);

        $expectedResult = '[{"title":"Title","auctionUrl":"http:\/\/fancyportalwithtickets.com","description":"A couple of words why this concert is such a Must Go","price":"100PLN","type":"sport"},{"title":"different title","auctionUrl":"http:\/\/ecommercewithtickets.com","description":"Short text trying to convince us that this event is worth our monthly salary","price":"1200PLN","type":null}]';

        $this->assertEquals($expectedResult, $result);
    }

}
