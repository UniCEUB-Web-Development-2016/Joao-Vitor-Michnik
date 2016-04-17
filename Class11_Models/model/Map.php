<?php

class Map
{
    private $id;
    private $party_name;
    private $map_long;
    private $map_lat;

    public function __construct($party_name, $map_long, $map_lat)
    {
        $this->set_first_name($party_name);
        $this->set_last_name($map_long);
        $this->set_birthday($map_lat);
    }
}