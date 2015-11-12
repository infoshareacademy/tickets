<?php

namespace Tickets\Models;

class Ticket
{
    private $title;
    private $auctionUrl;
    private $description;
    private $price;
    private $type;


    public function __get($param_name){
        return $this->$param_name;
    }

    public function  __set($param_name, $param_value){
        $this->$param_name = $param_value;
    }
}
