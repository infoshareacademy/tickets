<?php
/**
 * Created by PhpStorm.
 * User: krasai
 * Date: 09.11.15
 * Time: 14:55
 */

namespace Tickets\Bridges;


class AllegroBridgeTest extends \PHPUnit_Framework_TestCase
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
