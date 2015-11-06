<?php
/**
 * Created by PhpStorm.
 * User: paoolskoolsky
 * Date: 06.11.15
 * Time: 15:06
 */

namespace Tickets\Controllers;

require_once __DIR__ . 'TicketsController.php.php';


class TicketsControllerTests extends PHPUnit_Framework_TestCase
{
    private $instance;

    public function testOneTicket()
    {
        // given
        $instance = new TicketsController();
        $title = 'abc';
        $auctionUrl = 'http://allegro.pl/bilety-miller-mozdzer-namyslowski-nospr-katowice-i5777180565.html';
        $description = 'szakalaka';
        $price = 10;

        // when
        $instance->collectTickets($ticketData);

        // then
        $this->assertEquals($instance->get($title), 'abc');


    }
}