<?php


namespace Tickets\Tests;


use Tickets\Models\Ticket;

class JsonPresenterTest extends \PHPUnit_Framework_TestCase
{
    public function testIfEmpty(){
        $ticket = $this->getMockBuilder('Ticket')
                           ->getMock;
        $ticket->method('present');
    }
}
