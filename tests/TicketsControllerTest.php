<?php

require __DIR__ . '/../vendor/autoload.php';
require_once "../src/Controllers/TicketsController.php";
require_once "../src/Bridges/AllegroBridge.php";

use Tickets\Controllers\TicketsController;

class TicketsControllerTest extends PHPUnit_Framework_TestCase
{

    private $instance;

    public function testCollectedMusicTickets()
    {
        // given
        $allegroBridge = $this->getMock('Tickets\Bridges\AllegroBridge');
        $allegroBridge->expects($this->once())->method('getConcertTickers');
        $instance = new TicketsController($allegroBridge);

        // when
        $instance->collectTickets();

    }

    // sprtowe

    // został wywołany presenter, i jego wynik został zwrócony przez controller
    public function testCollectedMusicTickets1()
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

