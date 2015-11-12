<?php
/**
 * Created by PhpStorm.
 * User: paoolskoolsky
 * Date: 09.11.15
 * Time: 14:56
 */

namespace Tickets\Controllers;

use Tickets\Models\Ticket;

class TicketsControllerTest extends \PHPUnit_Framework_TestCase
{
//    private $instance;

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

    // sportowe

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
        $JsonPresenter = $this->getMock('Tickets\Presenters\JsonPresenter');
        $json = '{}';
        $JsonPresenter->expects($this->once())->method('presentTickets')->will($this->returnValue($json));
        $instance = new TicketsController(null, $JsonPresenter);

        // when
        $result = $instance->collectTickets();

        // then
        $this->assertEquals($json, $result);
    }

//     elementy muzyczne i sportowe razem zostały podane do presentera

    public function testJoinTicketsArrays()
    {
        // given
        $allegroBridge = $this->getMock('Tickets\Bridges\AllegroBridge');
        $JsonPresenter = $this->getMock('Tickets\Presenters\JsonPresenter');

        $allegroBridge->expects($this->once())->method('getConcertTickets')->will($this->returnValue($this->prepareTicketsArray(53)));
        $allegroBridge->expects($this->once())->method('getSportTickets')->will($this->returnValue($this->prepareTicketsArray(47)));

        $JsonPresenter->expects($this->once())->method('presentTickets')->will($this->returnCallback(function ($tickets){
            $this->assertEquals(100, count($tickets));
        }));

        $instance = new TicketsController($allegroBridge, $JsonPresenter);

        // when
        $instance->collectTickets();


    }

    private function prepareTicketsArray($expectedElementsCount)
    {
        $tickets = array();
        for($i=0; $i<$expectedElementsCount; $i++)
        {
            $tickets[] = new Ticket();
        }
        return $tickets;
    }

}
