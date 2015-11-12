<?php

namespace Tickets\Presenters;

use Tickets\Models\Ticket;

class JsonPresenterTest extends \PHPUnit_Framework_TestCase
{
    public function test_shouldReturnEmptyArrayWhenEmptyArrayInInput()
    {
        $instance = new JsonPresenter();

        $tickets = array();
        $result = $instance->presentTickets($tickets);

        $this->assertEquals(array(), $result);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessageRegExp #empty#
     */
    public function _test_shouldThrowNewExceptionWhenWrongInput()
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

        $this->assertEquals(array(
            '{"title":"Title",' .
            '"auctionUrl":"http:\/\/fancyportalwithtickets.com",' .
            '"description":"A couple of words why this concert is such a Must Go",' .
            '"price":"100PLN","type":"concert"}'
        ), $result);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessageRegExp #invalid.*#
     */
    public function _test_shouldThrowNewExceptionWhenWrongTicketObject()
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
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessageRegExp #missing.*#
     */

    public function _test_shouldThrowNewExceptionWhenMissingDataInObject()
    {
        $instance = new JsonPresenter();

        $tickets = array();

        $oneTicket = new Ticket();
        $oneTicket->title = 'Title';
        $oneTicket->auctionUrl = 'http://fancyportalwithtickets.com';
        $oneTicket->description = 'A couple of words why this concert is such a Must Go';

        $tickets[] = $oneTicket;

        $result = $instance->presentTickets($tickets);
    }

    public function _test_shouldReturnArrayOfJsonsWhenManyObjectsInInput()
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

        $expectedResult = '[{
            "title" : "Title",
        "auctionUrl" : "http://fancyportalwithtickets.com",
        "description" : "A couple of words why this concert is such a Must Go",
        "price" : "100PLN"},{
            "title" : "Title",
        "auctionUrl" : "http://fancyportalwithtickets.com",
        "description" : "A couple of words why this concert is such a Must Go",
        "price" : "100PLN"}]';

        $this->assertEquals($expectedResult, $result);
    }

}
