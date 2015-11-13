<?php


namespace Tickets\Routers;


class CollectorRouterTest extends \PHPUnit_Framework_TestCase
{
    public function test_shouldThrowNewExceptionWhenEmptyInput(){
        $instance = new CollectorRouter();

        $tickets = '';
        $result = $instance->getTickets();

    }
}
