<?php

include_once "model/Request.php";
include_once "model/Map.php";
include_once "database/DatabaseConnector.php";

class MapController
{
	public function register($request)
	{
		$params = $request->get_params();
		$map = new Map($params["party_name"],
				 $params["map_long"],
				 $params["map_lat"]);

		$db = new DatabaseConnector("localhost", "myparty", "mysql", "", "root", "");

		$conn = $db->getConnection();
		
		
	    return $conn->query($this->generateInsertQuery($map));	
	}

	private function generateInsertQuery($map)
	{
		$query =  "INSERT INTO map (party_name, map_long, map_lat) VALUES ('"
					.$map->getPartyName()."','".
					$map->getMapLong()."','".				
					$map->getMapLat()."')";

		return $query;						
	}
}