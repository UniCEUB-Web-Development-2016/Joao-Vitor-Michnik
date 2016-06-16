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
				 $params["hometown"],
				 $params["gender"]);

		$db = new DatabaseConnector("localhost", "myparty", "mysql", "", "root", "");

		$conn = $db->getConnection();
		
		
	    return $conn->query($this->generateInsertQuery($user));	
	}

	private function generateInsertQuery($user)
	{
		$query =  "INSERT INTO user (first_name, last_name, birthday, email, login, pass, relationship_status, gender, hometown) VALUES ('"
					.$user->getFirstName()."','".
					$user->getLastName()."','".
					$user->getBirthday()."','".
					$user->getEmail()."','".
					$user->getLogin()."','". 
					$user->getPass()."','". 
					$user->getRelationshipStatus()."','". 
					$user->getGender()."','". 
					$user->getHometown()."')";

		return $query;						
	}
	public function search($request)
	{
		$params = $request->get_params();
		$critLogin = $this->generateLogin($params);
		$crit = $this->generateCriteria($params);
		if($critLogin == ""){
			$crit = $this->generateCriteria($params);
		}else{
			$crit = "";
		}

		$db = new DatabaseConnector("localhost", "myparty", "mysql", "", "root", "");

		$conn = $db->getConnection();

		$result = $conn->prepare("SELECT cod, first_name, last_name, email, birthday, email, login,relationship_status, hometown, gender FROM user WHERE ".$crit.$critLogin);
		//$result->bindParam(1, $crit);
		$result->execute();
		//foreach($result as $row)
		$fetch = $result->fetchAll(PDO::FETCH_ASSOC);
		if(empty($fetch) || isset($params["session_broke"])){ 
		}else{
			if(isset($params["login"]) && isset($params["pass"])){
				$this->createSession($fetch[0]["cod"]);
			}
		}
		return $fetch;

	}
	private function generateLogin($params)
	{

		$criteria = "";
			if(isset($params['login']) and isset($params['pass'])) {
				$criteria = "login = '" . $params['login'] . "' and pass = '".$params['pass']."'";
			}else{
				return $criteria;
			}
			return $criteria;

	}
	private function generateCriteria($params)
	{
			
		$criteria = "";
		foreach($params as $key => $value)
		{
			if($key != 1) {
				$criteria = $criteria . $key . " LIKE '%" . $value . "%' OR ";			
			}else{
				$criteria = 1;
				return $criteria;
			}
		}
		if(isset($params['login']) or isset($params['pass'])) {
			return $criteria = "";
		}else{
			return substr($criteria, 0, -4);
		}
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
	private function createSession($params){
		$_SESSION["id"] = $params;
		return $_SESSION["id"];
	}
	private function generateUpdateQuery($params)
	{
		$changes = $this->generateCriteriaUpdate($params);
		$query =  "update user set ".$changes." where cod = '".$_SESSION["id"]."'";

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