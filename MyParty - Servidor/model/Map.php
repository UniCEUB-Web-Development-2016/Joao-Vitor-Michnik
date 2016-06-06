<?php

class Map
{
    private $id;
    private $party_name;
    private $map_long;
    private $map_lat;

    public function __construct($party_name, $map_long, $map_lat)
    {
        $this->setPartyName($party_name);
        $this->setMapLong($map_long);
        $this->setMapLat($map_lat);
    }
	public function getPartyName()
    {
        return $this->party_name;
    }
    public function setPartyName($party_name)
    {
        $this->party_name = $party_name;
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