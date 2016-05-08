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
	public function search($request)
	{
		$params = $request->get_params();
		$crit = $this->generateCriteria($params);

		$db = new DatabaseConnector("localhost", "myparty", "mysql", "", "root", "");

		$conn = $db->getConnection();

		$result = $conn->query("SELECT party_name, map_long, map_lat FROM map WHERE ".$crit);

		//foreach($result as $row)

		return $result->fetchAll(PDO::FETCH_ASSOC);

	}

	private function generateCriteria($params)
	{
		$criteria = "";
		foreach($params as $key => $value)
		{
			$criteria = $criteria.$key." LIKE '%".$value."%' OR ";
		}

		return substr($criteria, 0, -4);
	}
}