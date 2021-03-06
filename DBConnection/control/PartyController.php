<?php

include_once "model/Request.php";
include_once "model/Party.php";
include_once "database/DatabaseConnector.php";

class PartyController
{
	public function register($request)
	{
		$params = $request->get_params();
		$party = new Party($params["name"],
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
		
		
	    return $conn->query($this->generateInsertQuery($party));	
	}

	private function generateInsertQuery($party)
	{
		$query =  "INSERT INTO party (name, description, max_participants, age_group, initial_date, final_date, price, creator, city) VALUES ('"
					.$party->getName()."','".
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
}