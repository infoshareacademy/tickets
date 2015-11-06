<?php
namespace Tickets\Bridges;

class allegroBridgeTest extends PHPUnit_Framework_TestCase
{

    public function testGetSportTicketsWhenConnectionFailed()
    {
        // given
        $connector = $this->getMock('Tickets\Connectors\AllegroConnector');
        $connector->expects($this->any())->method('getItems')->will($this->returnValue(['error'=> 1]));
        $instance = new AllegroBridge($connector);

        // when
        $result = $instance->getSportTickets();

        // then
        $this->assertEquals(['error'=> 1], $result);
    }

    public function testGetSportTicketsWhenThereIsNoTickets()
    {
        // given
        $connector = $this->getMock('Tickets\Connectors\AllegroConnector');
        $connector->expects($this->any())->method('getItems')->will($this->returnValue([]));
        $instance = new AllegroBridge($connector);

        // when
        $result = $instance->getSportTickets();

        // then
        $this->assertNull($result);
    }

    public function testGetConcertTicketsWhenConnectionFailed()
    {
        // given
        $connector = $this->getMock('Tickets\Connectors\AllegroConnector');
        $connector->expects($this->any())->method('getItems')->will($this->returnValue(['error'=> 1]));
        $instance = new AllegroBridge($connector);

        // when
        $result = $instance->getConcertTickets();

        // then
        $this->assertEquals(['error'=> 1], $result);
    }

    public function testGetConcertTicketsWhenThereIsNoTickets()
    {
        // given
        $connector = $this->getMock('Tickets\Connectors\AllegroConnector');
        $connector->expects($this->any())->method('getItems')->will($this->returnValue([]));
        $instance = new AllegroBridge($connector);

        // when
        $result = $instance->getConcertTickets();

        // then
        $this->assertNull($result);
    }
}