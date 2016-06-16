<?php

include_once "model/Request.php";
include_once "model/Participants.php";
include_once "control/MapController.php";
include_once "database/DatabaseConnector.php";

class ParticipantsController
{
	private $val;

	public function register($request)
	{

		$params = $request->get_params();
		$Participants = new Participants($params["cod_party"],
				$_SESSION["id"]);

		$db = new DatabaseConnector("localhost", "myparty", "mysql", "", "root", "");

		$conn = $db->getConnection();


	    return $conn->query($this->generateInsertQuery($Participants));
	}

	private function generateInsertQuery($Participants)
	{
		$query =  "INSERT INTO participant_party(cod_party, cod_user) VALUES ('"
					.$Participants->getParty()."','".$Participants->getUser()."')";

		return $query;						
	}
	public function search($request)
	{
		$params = $request->get_params();
		$crit = $this->generateCriteria($params);

		$db = new DatabaseConnector("localhost", "myparty", "mysql", "", "root", "");

		$conn = $db->getConnection();
		$result = $conn->prepare("SELECT cod_party, cod_user FROM participant_party WHERE ".$crit);
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
				$criteria = $criteria.$key." = '".$value."' and ";
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
		$result = $conn->prepare("DELETE FROM participant_party WHERE cod_user = ".$_SESSION["id"]." and cod_party = ".$params['cod_party']);
		$result->bindParam(1, $params['cod_party']);
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