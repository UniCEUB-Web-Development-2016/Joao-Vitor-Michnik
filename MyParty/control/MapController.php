<?php

include_once "model/Request.php";
include_once "model/Map.php";
include_once "database/DatabaseConnector.php";

class MapController
{
	public function register($request)
	{
		$params = $request->get_params();
		$map = new Map($params["map_long"],
				 $params["map_lat"]);

		$db = new DatabaseConnector("localhost", "myparty", "mysql", "", "root", "");

		$conn = $db->getConnection();
		
		
	    return $conn->query($this->generateInsertQuery($map));	
	}

	private function generateInsertQuery($map)
	{
		$query =  "INSERT INTO map (map_long, map_lat) VALUES ('"
					.$map->getMapLong()."','".				
					$map->getMapLat()."')";

		return $query;						
	}
	public function search($request)
	{
		$params = $request->get_params();
		$crit = $this->generateCriteria($params);

		$db = new DatabaseConnector("localhost", "myparty", "mysql", "", "root", "");

		$conn = $db->getConnection();

		$result = $conn->prepare("select p.cod, p.party_name, m.map_long, m.map_lat from map as m, party as p where ".$crit." and p.cod_map = m.cod");
		//$result->bindParam(1, $crit);
		$result->execute();
		//foreach($result as $row)

		return $result->fetchAll(PDO::FETCH_ASSOC);

	}

	private function generateCriteria($params)
	{
		$criteria = "";
		foreach($params as $key => $value)
		{
			if($key != 1) {
			$criteria = $criteria.$key." LIKE '%".$value."%' OR ";
				return substr($criteria, 0, -4);
			}else{
				$criteria = 1;
				return $criteria;
			}
		}

	}
	public function delete($request)
	{
		$params = $request->get_params();

		$db = new DatabaseConnector("localhost", "myparty", "mysql", "", "root", "");
		$conn = $db->getConnection();

		$result = $conn->prepare("DELETE FROM map WHERE cod = ?");
		$result->bindParam(1, $params['cod']);
		$result->execute();

		return $result;

	}
	public function update($request)
	{
		$params = $request->get_params();

		$db = new DatabaseConnector("localhost", "myparty", "mysql", "", "root", "");
		$conn = $db->getConnection();

		return $conn->query($this->generateUpdateQuery($params));

	}
	private function generateUpdateQuery($params)
	{
		$changes = $this->generateCriteriaUpdate($params);

		$query =  "update map set ". $changes." where cod = '".$params["cod"]."'";

		return $query;
	}
	private function generateCriteriaUpdate($params)
	{
		$criteria = "";
		foreach($params as $key => $value)
		{
			$criteria = $criteria.$key." = '".$value."' ,";
		}

		return substr($criteria, 0, -2);
	}
}