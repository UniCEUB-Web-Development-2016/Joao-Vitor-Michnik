<?php

include_once "model/Request.php";
include_once "model/Party.php";
include_once "control/MapController.php";
include_once "database/DatabaseConnector.php";

class PartyController
{
	private $val;

	public function register($request)
	{

		(new MapController())->register($request);

		$params = $request->get_params();
		$party = new Party($params["party_name"],
				$params["description"],
				$params["max_participants"],
				$params["age_group"],
				$params["initial_date"],
				$params["final_date"],
				$params["price"],
				$params["creator"],
				$params["city"]);

		$db = new DatabaseConnector("localhost", "myparty", "mysql", "", "root", "");

		$conn = $db->getConnection();


	    return $conn->query($this->generateInsertQuery($party,$params["map_lat"],$params["map_long"]));
	}

	private function generateInsertQuery($party, $lat, $long)
	{
		$query =  "INSERT INTO party (party_name, cod_map, description, max_participants, age_group, initial_date, final_date, price, creator, city) VALUES ('"
					.$party->getName()."',
					(select cod from map where map_long = ".$long." and map_lat = ".$lat."),'".
					$party->getDescription()."','".
					$party->getMaxParticipants()."','".
					$party->getAgeGroup()."','".
					$party->getInitialDate()."','". 
					$party->getFinalDate()."','". 
					$party->getPrice()."','".
					$party->getCreator()."','".					
					$party->getCity()."')";

		return $query;						
	}
	public function search($request)
	{
		$params = $request->get_params();
		$crit = $this->generateCriteria($params);

		$db = new DatabaseConnector("localhost", "myparty", "mysql", "", "root", "");

		$conn = $db->getConnection();
		$result = $conn->prepare("SELECT p.cod, p.cod_map, p.party_name, p.description, p.max_participants, p.age_group, p.initial_date, p.final_date, p.price, p.creator, p.city, m.map_lat, m.map_long FROM party as p, map as m WHERE p.cod_map = m.cod and ".$crit);
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
			if($key != "cod"){
			if($key != 1){
				$criteria = $criteria.$key." LIKE '%".$value."%' OR ";
				return substr($criteria, 0, -4);
			}else{
				$criteria = 1;
				return $criteria;
			}
			}else{
				$criteria = "p.cod = ".$value;
				return $criteria;
			}
		}

	}
	public function delete($request)
	{
		$params = $request->get_params();

		$db = new DatabaseConnector("localhost", "myparty", "mysql", "", "root", "");
		$conn = $db->getConnection();
		$result = $conn->prepare("DELETE FROM party WHERE cod = ?");
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

		$query =  "update party set ". $changes." where party_name = '".$params["party_name"]."'";

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