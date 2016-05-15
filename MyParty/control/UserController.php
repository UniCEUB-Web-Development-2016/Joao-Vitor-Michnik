<?php

include_once "model/Request.php";
include_once "model/User.php";
include_once "database/DatabaseConnector.php";

class UserController
{
	public function register($request)
	{
		$params = $request->get_params();
		$user = new User($params["first_name"],
				 $params["last_name"],
				 $params["birthday"],
				 $params["email"],
				 $params["login"],
				 $params["pass"],
				 $params["relationship_status"],
				 $params["hometown"]);

		$db = new DatabaseConnector("localhost", "myparty", "mysql", "", "root", "");

		$conn = $db->getConnection();
		
		
	    return $conn->query($this->generateInsertQuery($user));	
	}

	private function generateInsertQuery($user)
	{
		$query =  "INSERT INTO user (first_name, last_name, birthday, email, login, pass, relationship_status, hometown) VALUES ('"
					.$user->getFirstName()."','".
					$user->getLastName()."','".
					$user->getBirthday()."','".
					$user->getEmail()."','".
					$user->getLogin()."','". 
					$user->getPass()."','". 
					$user->getRelationshipStatus()."','". 
					$user->getHometown()."')";

		return $query;						
	}
	public function search($request)
	{
		$params = $request->get_params();
		$crit = $this->generateCriteria($params);

		$db = new DatabaseConnector("localhost", "myparty", "mysql", "", "root", "");

		$conn = $db->getConnection();

		$result = $conn->query("SELECT first_name, last_name, email, birthday, email, login, pass, relationship_status, hometown FROM user WHERE ".$crit);

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
	public function delete($request)
	{
		$params = $request->get_params();

		$db = new DatabaseConnector("localhost", "myparty", "mysql", "", "root", "");
		$conn = $db->getConnection();

		$result = $conn->prepare("DELETE FROM user WHERE email = ?");
		$result->bindParam(1, $params['email']);
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

		$query =  "update user set ".$changes." where email = '".$params["email"]."'";

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