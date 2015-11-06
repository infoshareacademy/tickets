<?php

use Tickets\Controllers\TicketsController;

class TicketsControllerTest extends PHPUnit_Framework_TestCase
{

    private $instance;

    //koncerty

    public function testCollectedConcertTickets()
    {
        // given
        $allegroBridge = $this->getMock('Tickets\Bridges\AllegroBridge');
        $allegroBridge->expects($this->once())->method('getConcertTickets');
        $instance = new TicketsController($allegroBridge);

        // when
        $instance->collectTickets();

    }

    // sprtowe

    public function testCollectedSportTickets()
    {
        // given
        $allegroBridge = $this->getMock('Tickets\Bridges\AllegroBridge');
        $allegroBridge->expects($this->once())->method('getSportTickets');
        $instance = new TicketsController($allegroBridge);

        // when
        $instance->collectTickets();

    }

    // został wywołany presenter, i jego wynik został zwrócony przez controller
    public function testJsonPresenter()
    {
        // given
        $ticketsPresenter = $this->getMock('Tickets\Presenter\JsonPresenter');
        $json = 'test tickets json';
        $ticketsPresenter->expects($this->once())->method('presentTickets')->will($this->returnValue($json));
        $instance = new TicketsController($ticketsPresenter);

        // when
        $result = $instance->collectTickets();

        // then
        $this->assertEquals($json, $result);
    }

    // elementy muzyczne i sportowe razem zostały podane do presentera

}

