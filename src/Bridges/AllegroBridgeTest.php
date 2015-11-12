<?php
/**
 * Created by PhpStorm.
 * User: krasai
 * Date: 09.11.15
 * Time: 14:55
 */

namespace Tickets\Bridges;
use Tickets\Models\Ticket;

class AllegroBridgeTest extends \PHPUnit_Framework_TestCase
{

    public function testGetSportTickets()
    {
        // given

        $ticketMock[] =
            array( 'itemInfo' =>
                array(
                        'itId' => 5762155520,
                        'itName' => 'Bilety Polska Czechy Bilet Wrocław TANIO HIT',
                        'itPrice' => 15,
                        'itDescription' => 'description',
                        'auctionUrl' => '',
                )
            );
        $ticketMock[] =
            array( 'itemInfo' =>
                array(
                        'itId' => 5762155520,
                        'itName' => 'TANIO HIT',
                        'itPrice' => 231,
                        'itDescription' => 'description',
                        'auctionUrl' => 'http://allegro.pl',
                )
            );

        $connector = $this->getMock('Tickets\Connectors\AllegroConnector');
        $connector->expects($this->any())->method('getItems')->will($this->returnValue($ticketMock));
        $instance = new AllegroBridge($connector);



        // when
        $result = $instance->getSportTickets();
        $ticket = new Ticket();
        $ticket->title = 'Bilety Polska Czechy Bilet Wrocław TANIO HIT';
        $ticket->description = 'description';
        $ticket->price = 15;
        $ticket->auctionUrl = 'http://allegro.pl/show_item.php?item=5762155520';

        // then
        $this->assertEquals($ticket, $result[0]);
    }

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
        $connector->expects($this->any())->method('getItems')->will($this->returnValue(null));
        $instance = new AllegroBridge($connector);

        // when
        $result = $instance->getSportTickets();

        // then
        $this->assertNull($result);
    }


    public function testGetConcertTickets()
    {
        // given

        $ticketMock[] =
            array( 'itemInfo' =>
                array(
                        'itId' => 5781922684,
                        'itName' => 'Bilety Polska Czechy Bilet Wrocław TANIO HIT',
                        'itPrice' => 0,
                        'itDescription' => 'description',
                        'auctionUrl' => '',
                )
            );
        $ticketMock[] =
            array( 'itemInfo' =>
                array(
                    'itId' => 5780806569,
                    'itName' => 'TANIO HIT',
                    'itPrice' => 231,
                    'itDescription' => 'description',
                    'auctionUrl' => 'http://allegro.pl',
                )
            );

        $connector = $this->getMock('Tickets\Connectors\AllegroConnector');
        $connector->expects($this->any())->method('getItems')->will($this->returnValue($ticketMock));
        $instance = new AllegroBridge($connector);



        // when
        $result = $instance->getConcertTickets();
        $ticket = new Ticket();
        $ticket->title = 'Bilety Polska Czechy Bilet Wrocław TANIO HIT';
        $ticket->description = 'description';
        $ticket->price = 0;
        $ticket->auctionUrl = 'http://allegro.pl/show_item.php?item=5781922684';

        // then
        $this->assertEquals($ticket, $result[0]);
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
        $connector->expects($this->any())->method('getItems')->will($this->returnValue(null));
        $instance = new AllegroBridge($connector);

        // when
        $result = $instance->getConcertTickets();

        // then
        $this->assertNull($result);
    }
}
