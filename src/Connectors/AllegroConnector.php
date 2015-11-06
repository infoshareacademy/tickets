<?php
/**
 * Created by PhpStorm.
 * User: fiona
 * Date: 06.11.15
 * Time: 14:01
 */

namespace Tickets\Connectors;


class AllegroConnector
{
    public function call($methodName, $params);

    private function login();
    private function getApiSession();
}