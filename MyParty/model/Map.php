<?php

class Map
{
    private $id;
    private $map_long;
    private $map_lat;

    public function __construct($map_long, $map_lat)
    {
        $this->setMapLong($map_long);
        $this->setMapLat($map_lat);
    }
    public function getMapLong()
    {
        return $this->map_long;
    }
    public function setMapLong($map_long)
    {
        $this->map_long = $map_long;
    }
    public function getMapLat()
    {
        return $this->map_lat;
    }
    public function setMapLat($map_lat)
    {
        $this->map_lat = $map_lat;
    }
}